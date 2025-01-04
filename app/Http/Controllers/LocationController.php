<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function location_list()
    {
        $data = Location::all();
        return view('pages.settings.location.location-list', compact('data'));
    }

    public function addlocation()
    {
        $data = Location::all();
        return view('pages.settings.location.list', compact('data'));
    }

    public function location()
    {
        $data = Location::max('id');
        return $data ? $data + 1 : 1;
    }
    // Add
    public function add_location(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([

            'location' => 'required',
        ]);

        // Save the data
        $save = Location::create([
            'location_id' => 'MJID' . date('dmy') . $this->location() + 1,
            'location' => $request->location,
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', 'Location Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // edit
    public function edit_location($id)
    {
        $edit_location = Location::where('id', $id)->first();
        return view('pages.settings.location.edit-location', compact('edit_location',));
    }

    // update
    public function update_location(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'location' => 'required',

        ]);

        $check = Location::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = Location::where('id', $request->id)->update([

                'status' => $request->status,
                'location' => $request->location,

            ]);
            if ($updated) {
                return redirect()->route('location.list')->withSuccess('Location Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_location(Request $request)
    {
        $data = Location::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
