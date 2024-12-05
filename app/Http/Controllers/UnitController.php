<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function unit_list()
    {
        $data = Unit::all();
        return view('pages.miscellaneous.unit.unit-list', compact('data'));
    }

    public function unit()
    {
        $data = Unit::max('id');
        return $data ? $data + 1 : 1;
    }


    // Add
    public function add_unit(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'unit' => 'required',
        ]);

        // Save the data
        $save = Unit::create([
            'unit_id' => 'UID' . date('dmy') . $this->unit() + 1,
            'unit' => $request->unit,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', value: 'Unit Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }

    // edit
    public function edit_unit($id)
    {
        $edit_unit = Unit::where('id', $id)->first();
        return view('pages.miscellaneous.unit.edit-unit', compact('edit_unit',));
    }


    // update
    public function update_unit(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'unit' => 'required',
        ]);

        $check = Unit::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = Unit::where('id', $request->id)->update([
                'date' => date('Y-m-d'),
                'status' => $request->status,
                'unit' => $request->unit,

            ]);
            if ($updated) {
                return redirect()->route('unit.list')->withSuccess('Unit Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_unit(Request $request)
    {
        $data = Unit::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
