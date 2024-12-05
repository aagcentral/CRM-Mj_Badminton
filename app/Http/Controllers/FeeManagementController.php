<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Package;
use App\Models\TrainingProgram;
use App\Models\PaymentModule;
use App\Models\Psession;
use App\Models\PaymentDetails;
use Illuminate\Http\Request;

class FeeManagementController extends Controller
{
    public function feemanagement_list()
    {
        $viewpusers = Registration::with('PaymentDetail')->get();

        return view('pages.feemanagement.feemanagement', compact('viewpusers'));
    }

    public function getDetails($registration_no)
    {
        $user = Registration::where('registration_no', $registration_no)->first();

        if ($user) {
            return response()->json([
                'name' => $user->name,
                'registration_no' => $user->registration_no,
                'email' => $user->email,
                'father_name' => $user->father_name, // Include father's name
            ]);
        }

        return response()->json(['error' => 'User not found'], 404);
    }


    // public function edit_fee_management($registration_no)
    // {

    //     $edit_registration = Registration::where('registration_no', $registration_no)->first();
    //     return view('pages.feemanagement.feemanagement', compact('pmodules', 'edit_registration', 'edit_payment', 'states', 'leads', 'Packages', 'Training', 'session', 'Timing', 'rooms', 'meals'));
    // }
}
