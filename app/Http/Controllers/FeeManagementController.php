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



    public function getUserDetails($registration_no)
    {
        // Fetch user details
        $user = Registration::where('registration_no', $registration_no)->first();
        $payment = PaymentDetails::where('registration_no', $registration_no)->first();

        if ($user) {
            // Get dynamic lists for packages and training programs
            $packages = Package::all();  // Assuming Package is the model for your packages
            $trainingPrograms = TrainingProgram::all();  // Assuming TrainingProgram is the model for training programs
            $payment = PaymentDetails::where('registration_no', $registration_no)->first();

            return response()->json([
                'user' => $user,
                'payment' => $payment,
                'packages' => $packages,
                'trainingPrograms' => $trainingPrograms
            ]);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function updateUserFee(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'registration_no' => 'required|string',
            'package' => 'nullable|string',
            'training_program' => 'nullable|string',
            'submitted_amt' => 'nullable|numeric',
        ]);

        // Check if the registration exists
        $registration = Registration::where('registration_no', $request->registration_no)->first();

        if ($registration) {
            // Update package and training_program if provided
            $registration->update([
                'package' => $request->package ?? $registration->package,
                'training_program' => $request->training_program ?? $registration->training_program,
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Registration number not found'], 404);
        }

        // Handle payment details
        $payment = PaymentDetails::where('registration_no', $request->registration_no)->first();

        if ($payment) {
            $submittedAmt = $request->submitted_amt;

            // If a new submitted_amt is provided, increment the previous submitted_amt
            if (!is_null($submittedAmt)) {
                $submittedAmt += $payment->submitted_amt; // Add the new submission to the previous one
            } else {
                $submittedAmt = $payment->submitted_amt; // If no new amount, keep the previous submission
            }

            // Calculate pending_amt based on the total_amt and the new cumulative submitted_amt
            $pendingAmt = $payment->total_amt - $submittedAmt;

            // Ensure pending_amt is not negative
            $pendingAmt = max(0, $pendingAmt);

            // Update payment details
            $payment->update([
                'submitted_amt' => $submittedAmt, // Update cumulative submitted amount
                'pending_amt' => $pendingAmt,     // Adjust pending amount
            ]);
        } else {
            // If no payment record exists, create a new one with submitted_amt and pending_amt
            $submittedAmt = $request->submitted_amt ?? 0;
            $pendingAmt = $submittedAmt > 0 ? $registration->total_amt - $submittedAmt : $registration->total_amt;

            PaymentDetails::create([
                'registration_no' => $request->registration_no,
                'submitted_amt' => $submittedAmt,
                'pending_amt' => $pendingAmt,
                'total_amt' => $registration->total_amt, // Assuming total_amt is in Registration table
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Fee details updated successfully']);
    }
}
