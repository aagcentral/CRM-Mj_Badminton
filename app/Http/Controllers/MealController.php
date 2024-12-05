<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Auth;

class MealController extends Controller
{

    public function meal_list()
    {
        $data = Meal::latest()->get();
        return view('pages.miscellaneous.meal.meal-list', compact('data'));
    }

    // Default
    public function Meal()
    {
        $data = Meal::max('id');
        return $data ? $data + 1 : 1;
    }

    // Add
    public function add_meal(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'meal_type' => 'required',
            // 'meal_fees' => 'required',
        ]);

        // Save the data
        $save = Meal::create([
            'meal_id' => 'MLID' . date('dmy') . $this->Meal() + 1,
            'meal_type' => $request->meal_type,
            // 'meal_fees' => $request->meal_fees,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', 'Meal Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // edit
    public function edit_meal($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_meal = Meal::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_meal) {
            return redirect()->route('meal.list')->with('success', 'Location Update.');
        }

        return view('pages.miscellaneous.meal.edit-meal', compact('edit_meal',));
    }

    // update
    public function update_meal(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'meal_type' => 'required',
            // 'meal_fees' => 'required',
        ]);

        $check = Meal::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = Meal::where('id', $request->id)->update([
                'date' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'meal_type' => $request->meal_type,
                // 'meal_fees' => $request->meal_fees,

            ]);
            if ($updated) {
                return redirect()->route('meal.list')->withSuccess('Meal Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_meal(Request $request)
    {
        $data = Meal::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
