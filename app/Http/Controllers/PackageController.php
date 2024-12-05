<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Auth;

class PackageController extends Controller
{
    public function package_list()
    {
        $data = Package::latest()->get();
        return view('pages.miscellaneous.package.package-list', compact('data'));
    }


    // Default
    public function package()
    {
        $data = Package::max('id');
        return $data ? $data + 1 : 1;
    }




    // Add
    public function add_package(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'package' => 'required',
            // 'fees' => 'required',
        ]);

        // Save the data
        $save = Package::create([
            'package_id' => 'PKGID' . date('dmy') . $this->package() + 1,
            'package' => $request->package,
            // 'fees' => $request->fees,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', 'Package Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // edit
    public function edit_package($id)
    {

        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_package = Package::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_package) {
            return redirect()->route('package.list')->with('success', 'Location Update.');
        }
        return view('pages.miscellaneous.package.edit-package-list', compact('edit_package',));
    }

    // update
    public function update_package(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'package' => 'required',
            // 'fees' => 'required',
        ]);

        $check = Package::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = Package::where('id', $request->id)->update([
                'date' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'package' => $request->package,
                // 'fees' => $request->fees,

            ]);
            if ($updated) {
                return redirect()->route('package.list')->withSuccess('Package Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_package(Request $request)
    {
        $data = Package::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
