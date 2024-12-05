<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use Illuminate\Http\Request;
use Auth;

class LeadSourceController extends Controller
{
    public function leadsource_list()
    {
        $data = LeadSource::latest()->get();
        return view('pages.miscellaneous.leadsource.leadsource-list', compact('data'));
    }


    public function leadsource()
    {
        $data = LeadSource::max('id');
        return $data ? $data + 1 : 1;
    }

    // Add
    public function add_leadsource(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'leadsource' => 'required',
        ]);

        // Save the data
        $save = LeadSource::create([
            'leadsource_id' => 'LID' . date('dmy') . $this->leadsource() + 1,
            'leadsource' => $request->leadsource,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', value: 'Lead Source Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }

    // edit
    public function edit_leadsource($id)
    {
        // $edit_leadsource = LeadSource::where('id', $id)->first();
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_leadsource = LeadSource::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_leadsource) {
            return redirect()->route('leadsource.list')->with('success', 'Location Update.');
        }
        return view('pages.miscellaneous.leadsource.edit-leadsource', compact('edit_leadsource',));
    }

    // update
    public function update_leadsource(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'leadsource' => 'required',
        ]);
        $check = LeadSource::where('id', $request->id)->whereNull('deleted_at')->first();
        if ($check) {
            $updated = LeadSource::where('id', $request->id)->update([
                'date' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'leadsource' => $request->leadsource,
            ]);
            if ($updated) {
                return redirect()->route('leadsource.list')->withSuccess('Lead Source Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_leadsource(Request $request)
    {
        $data = LeadSource::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
