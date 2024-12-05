<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Auth;

class TrainingProgramController extends Controller
{
    public function training_list()
    {
        $data = TrainingProgram::latest()->get();
        return view('pages.miscellaneous.training-program.training-program-list', compact('data'));
    }

    public function training()
    {
        $data = TrainingProgram::max('id');
        return $data ? $data + 1 : 1;
    }

    // Add
    public function add_TrainingProgram(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'add_program' => 'required',
            // 'fees' => 'required',

        ]);

        // Save the data
        $save = TrainingProgram::create([
            'program_id' => 'PID' . date('dmy') . $this->training() + 1,
            'add_program' => $request->add_program,
            // 'fees' => $request->fees,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', 'Program Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }

    // edit
    public function edit_TrainingProgram($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_training = TrainingProgram::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_training) {
            return redirect()->route('training.list')->with('success', 'Location Update.');
        }


        return view('pages.miscellaneous.training-program.edit-training-program', compact('edit_training',));
    }

    // update
    public function update_training_programs(Request $request)
    {
        $data = $request->validate([

            'status' => 'required',
            'add_program' => 'required',
            // 'fees' => 'required',
        ]);

        $check = TrainingProgram::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = TrainingProgram::where('id', $request->id)->update([
                'date' => date('Y-m-d'),
                'status' => $request->status,
                'add_program' => $request->add_program,
                // 'fees' => $request->fees,
            ]);
            if ($updated) {
                return redirect()->route('training.list')->withSuccess('Program Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_training_programs(Request $request)
    {
        $data = TrainingProgram::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
