<?php

namespace App\Http\Controllers;

use App\Models\Psession;
use Illuminate\Http\Request;
use Auth;

class SessionController extends Controller
{
    public function session_list()
    {
        $data = Psession::latest()->get();
        return view('pages.miscellaneous.session.session-list', compact('data'));
    }

    public function Sessions()
    {
        $data = Psession::max('id');
        return $data ? $data + 1 : 1;
    }

    // Add
    public function add_session(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([

            'session' => 'required',

        ]);

        // Save the data
        $save = Psession::create([
            'session_id' => 'SID' . date('dmy') . $this->Sessions() + 1,
            'session' => $request->session,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', value: 'Session Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // edit
    public function edit_session($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_session = Psession::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_session) {
            return redirect()->route('session.list')->with('success', 'Location Update.');
        }


        return view('pages.miscellaneous.session.edit-session', compact('edit_session',));
    }

    // update
    public function update_session(Request $request)
    {
        $data = $request->validate([

            'status' => 'required',
            'session' => 'required',

        ]);

        $check = Psession::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = Psession::where('id', $request->id)->update([
                'date' => date('Y-m-d'),
                'status' => $request->status,
                'session' => $request->session,

            ]);
            if ($updated) {
                return redirect()->route('session.list')->withSuccess('Session Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_session(Request $request)
    {
        $data = Psession::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
