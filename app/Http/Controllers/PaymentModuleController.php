<?php

namespace App\Http\Controllers;

use App\Models\PaymentModule;
use Illuminate\Http\Request;
use Auth;

class PaymentModuleController extends Controller
{
    public function payment_module()
    {
        $data = PaymentModule::latest()->get();
        return view('pages.miscellaneous.paymentmodule.payment-module', compact('data'));
    }


    // Default
    public function PaymentModule()
    {
        $data = PaymentModule::max('id');
        return $data ? $data + 1 : 1;
    }


    // Add
    public function add_paymentmodule(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'module' => 'required',
        ]);

        // Save the data
        $save = PaymentModule::create([
            'module_id' => 'PMID' . date('dmy') . $this->PaymentModule() + 1,
            'module' => $request->module,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', 'PaymentModule Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // edit
    public function edit_paymentmodule($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_module = PaymentModule::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_module) {
            return redirect()->route('paymentmodule.list')->with('success', 'Location Update.');
        }


        return view('pages.miscellaneous.paymentmodule.edit-module', compact('edit_module',));
    }

    // update
    public function update_paymentmodule(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'module' => 'required',
        ]);

        $check = PaymentModule::where('id', $request->id)->whereNull('deleted_at')->first();

        if ($check) {
            $updated = PaymentModule::where('id', $request->id)->update([
                'date' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'module' => $request->module,
            ]);
            if ($updated) {
                return redirect()->route('paymentmodule.list')->withSuccess('PaymentModule Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_paymentmodule(Request $request)
    {
        $data = PaymentModule::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
