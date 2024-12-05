<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Stock;
use Auth;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product_list()
    {

        $data = Product::with(['categories'])->latest()->get();
        // dd($data);
        $units = Unit::all();
        $Category = Category::all();
        return view('pages.stock-management.product.product-list', compact('data', 'units', 'Category'));
    }


    // Default
    public function product()
    {
        // Retrieve the latest ID and add 1, or return 1 if no products exist
        $latestId = Product::max('id');
        return $latestId ? $latestId + 1 : 1;
    }

    // Add
    public function add_product(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'category' => 'required',
            'product' => 'required',

        ]);
        $cat = Product::where('category_id', $request->category)->first();
        $category_id = $cat->id ?? '';

        // Save the data
        $save = Product::create([
            'product_id' => 'PID' . date('dmy') . $this->product() + 1,
            'category_id' => $category_id,
            'category' => $request->category,
            'product' => $request->product,
            'notes' => $request->notes,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', 'Product Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // edit
    public function edit_product($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_prdct = Product::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_prdct) {
            return redirect()->route('product.list')->with('success', 'Location Update.');
        }

        $Category = Category::all();
        return view('pages.stock-management.product.edit-product', compact('edit_prdct', 'Category'));
    }

    // update
    public function update_product(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'category' => 'required',
            'product' => 'required',
        ]);

        $check = Product::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = Product::where('id', $request->id)->update([
                'date' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'category' => $request->category,
                'product' => $request->product,
                'notes' => $request->notes,

            ]);
            if ($updated) {
                return redirect()->route('product.list')->withSuccess('Product Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }




    public function destroy_product(Request $request)
    {
        // Find the product by ID
        $product = Product::find($request->id);

        // Check if the product exists
        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        // Check if the product has associated stock using the relationship
        $stock = $product->stock;  // Access the related stock using the defined relationship

        // If stock exists, prevent deletion
        if ($stock) {
            return response()->json(['message' => 'Cannot delete product with available stock. Please check inventory.'], 400);
        }

        // Delete the product if no stock exists
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }



    // delete
    // public function destroy_product(Request $request)
    // {
    //     $product = Product::where('id', $request->id)->first();

    //     if (!$product) {
    //         return response()->json(['message' => 'Product not found.'], 404);
    //     }

    //     // Check if the product has any stock records associated with it
    //     $stock = Stock::where('product_id', $request->id)->sum('quantity'); // Sum all quantities in stock for this product

    //     // Block deletion if stock quantity is greater than 0
    //     if ($stock > 0) {
    //         return response()->json(['message' => 'Cannot delete product with stock available.'], 400);
    //     }

    //     // Proceed with deletion if no stock or stock is 0
    //     $product->delete();
    // }
}
