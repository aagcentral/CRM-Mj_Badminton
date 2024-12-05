<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    public function category_list()
    {
        $data = Category::latest()->get();
        return view('pages.stock-management.category.category-list', compact('data'));
    }


    public function Category()
    {
        $data = Category::max('id');
        return $data ? $data + 1 : 1;
    }

    // Add
    public function add_category(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'category' => 'required',
        ]);

        // Save the data
        $save = Category::create([
            'category_id' => 'CID' . date('dmy') . $this->Category() + 1,
            'category' => $request->category,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', value: 'Category Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }

    // edit
    public function edit_category($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_categry = Category::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_categry) {
            return redirect()->route('category.list')->with('success', 'Location Update.');
        }
        return view('pages.stock-management.category.edit-category', compact('edit_categry'));
    }

    // update
    public function update_category(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'category' => 'required',
        ]);
        $check = Category::where('id', $request->id)->whereNull('deleted_at')->first();
        if ($check) {
            $updated = Category::where('id', $request->id)->update([
                'date' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'category' => $request->category,
            ]);
            if ($updated) {
                return redirect()->route('category.list')->withSuccess('Category Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    // public function destroy_category(Request $request)
    // {
    //     $data = Category::where('id', $request->id)->first();
    //     $data->delete();
    //     return response()->json(['message' => 'data deleted successfully.']);
    // }
    public function destroy_category(Request $request)
    {
        // Find the category by ID
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }
        // Check if the category has associated products
        if ($category->products()->exists()) {
            return response()->json(['message' => 'Cannot delete category with associated products.'], 400);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}
