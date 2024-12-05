<?php

namespace App\Http\Controllers;

use App\Models\Timings;
use Illuminate\Http\Request;
use Auth;

class TimingsController extends Controller
{
    public function timings_list()
    {
        $data = Timings::latest()->get();
        return view('pages.miscellaneous.timings.timings-list', compact('data'));
    }

    public function timeslot()
    {
        $data = Timings::max('id');
        return $data ? $data + 1 : 1;
    }


    // Add
    public function add_timings(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'time_slot' => 'required',
        ]);

        // Save the data
        $save = Timings::create([
            'timing_id' => 'TID' . date('dmy') . $this->timeslot() + 1,
            'time_slot' => $request->time_slot,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', value: 'Time Slot Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }

    // edit
    public function edit_timings($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_timing = Timings::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_timing) {
            return redirect()->route('timings.list')->with('success', 'Location Update.');
        }

        return view('pages.miscellaneous.timings.edit-timings', compact('edit_timing',));
    }


    // update
    public function update_timings(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'time_slot' => 'required',
        ]);

        $check = Timings::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = Timings::where('id', $request->id)->update([
                'date' => date('Y-m-d'),
                'status' => $request->status,
                'time_slot' => $request->time_slot,

            ]);
            if ($updated) {
                return redirect()->route('timings.list')->withSuccess('Time Slot Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_timings(Request $request)
    {
        $data = Timings::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
