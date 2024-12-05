<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Auth;

class RoomController extends Controller
{
    public function room_list()
    {

        $data = Room::latest()->get();
        return view('pages.miscellaneous.rooms.room-list', compact('data'));
    }

    // Default
    public function room()
    {
        $data = Room::max('id');
        return $data ? $data + 1 : 1;
    }

    // Add
    public function add_room(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'room_type' => 'required',
            // 'room_fees' => 'required',
        ]);

        // Save the data
        $save = Room::create([
            'room_id' => 'RMID' . date('dmy') . $this->room() + 1,
            'room_type' => $request->room_type,
            // 'room_fees' => $request->room_fees,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', 'Room Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // edit
    public function edit_room($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_room = Room::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_room) {
            return redirect()->route('room.list')->with('success', 'Location Update.');
        }

        return view('pages.miscellaneous.rooms.edit-room', compact('edit_room',));
    }

    // update
    public function update_room(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'room_type' => 'required',
            // 'room_fees' => 'required',
        ]);

        $check = Room::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = Room::where('id', $request->id)->update([
                'date' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'room_type' => $request->room_type,
                // 'room_fees' => $request->room_fees,

            ]);
            if ($updated) {
                return redirect()->route('room.list')->withSuccess('Room Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_room(Request $request)
    {
        $data = Room::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
