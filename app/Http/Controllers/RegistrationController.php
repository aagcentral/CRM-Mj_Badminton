<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use App\Models\Registration;
use App\Models\LeadSource;
use App\Models\Package;
use App\Models\TrainingProgram;
use App\Models\PaymentModule;
use App\Models\Psession;
use App\Models\PackageUpdateTrack;
use App\Models\PaymentDetails;
use App\Models\RegisterStatusTracker;
use App\Models\Meal;
use App\Models\Room;
use App\Models\User;
use App\Models\Timings;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class RegistrationController extends Controller
{

    public function registration_list(Request $request)
    {
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $session = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();
        $rooms = Room::where('status', '0')->orderBy('room_type', 'asc')->get();
        $meals = Meal::where('status', '0')->orderBy('meal_type', 'asc')->get();
        $pmodules = PaymentModule::where('status', '0')->orderBy('module', 'asc')->get();
        $query = Registration::with(['PaymentDetail']);

        if ($request->has('month') && $request->month !== null) {
            $query->whereMonth('created_at', date('m', strtotime($request->month)));
        }

        // Map gender IDs to their corresponding names

        if ($request->has('training_program') && $request->training_program !== null) {
            $query->where('training_program', $request->training_program);
        }
        if ($request->has('package') && $request->package !== null) {
            $query->where('package', $request->package);
        }

        if ($request->has('year') && $request->year !== null) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->has('payment_status') && $request->payment_status !== null) {
            $query->whereHas('PaymentDetail', function ($paymentQuery) use ($request) {
                $paymentQuery->where('payment_status', $request->payment_status);
            });
        }

        $data = $query->latest()->get();
        // dd($data);
        return view('pages.registration.registration-list', compact('data', 'pmodules', 'Packages', 'Training', 'session', 'Timing',));
    }

    public function registration_form(Request $request, $enquiryId = null)
    {
        $enquiry = $enquiryId ? Enquiry::findOrFail($enquiryId) : null;

        $states = DB::table('states')->orderBy('name')->get();
        $leads = LeadSource::where('status', '0')->orderBy('leadsource', 'asc')->get();
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $session = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();
        $rooms = Room::where('status', '0')->orderBy('room_type', 'asc')->get();
        $meals = Meal::where('status', '0')->orderBy('meal_type', 'asc')->get();
        $pmodules = PaymentModule::where('status', '0')->orderBy('module', 'asc')->get();
        return view('pages.registration.registration', compact('enquiry', 'pmodules', 'states', 'leads', 'Packages', 'Training', 'session', 'Timing', 'rooms', 'meals'));
    }

    public function registration_details($registration_no)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $viewdata = Registration::with([
            'leads',
            'Packages',
            'userPackageTracker.Traintype',
            'userPackageTracker.Trackersession',
            'userPackageTracker.Trackerslot',

        ])->where('registration_no', $registration_no)->where('locationID', $locationID)->first();
        if (!$viewdata) {
            return redirect()->route('registration.list')->with('success', 'Location Update.');
        }
        // dd($viewdata);
        // dd($viewdata->registerStatusTracker);
        $viewpayment = PaymentDetails::with(['paymentmodule'])->where('registration_no', $registration_no)->first();
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $UserPackages = PackageUpdateTrack::with('registration')->where('registration_no', $registration_no)->where('locationID', $locationID)->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $sessions = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();

        return view('pages.registration.registration-details', compact('viewdata', 'sessions', 'Timing', 'viewpayment', 'UserPackages'));
    }


    // !*********************************************** Add Registration Form************************************************************
    public function add_registration(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'father' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:registrations,email',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required|digits:6',
            'package' => 'required',
            'payment_status' => 'required',
            'payment_method' => 'required',
            'registration_fees' => 'required|numeric|min:0',
            'submitted_amt' => 'required|numeric|min:0',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'email.unique' => 'This email address is already registered. Please use a different one.',
            'image.mimes' => 'Only jpg, jpeg, and png images are allowed.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

        try {
            DB::beginTransaction();

            // Check and Update Enquiry Status
            if ($request->input('enquiry_id')) {
                Enquiry::where('id', $request->input('enquiry_id'))->update(['lead_status' => 3]);
            }

            // Generate Registration Number
            $locationID = Auth::user()->locationID ?? 'DEFAULT';
            $lastNumber = Registration::where('locationID', $locationID)
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->value('registration_no');

            $nextNumber = 1;
            if ($lastNumber) {
                preg_match('/RID(\d+)$/', $lastNumber, $matches);
                $nextNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
            }
            $newRegistrationNo = strtoupper($locationID) . '-RID' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Generate Unique Payment ID
            $newPaymentID = 'MJPID' . date('dmy') . uniqid();

            // Handle Image Upload
            $filename = null;
            if ($request->hasFile('image')) {
                $filename = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('player'), $filename);
            }

            // Save Registration
            $playerData = [
                'registration_no' => $newRegistrationNo,
                'name' => ucwords(strtolower($request->input('name'))),
                'father' => $request->input('father'),
                'gender' => $request->input('gender'),
                'image' => $filename,
                'dob' => $request->input('dob'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'pincode' => $request->input('pincode'),
                'address' => $request->input('address'),
                'package' => $request->input('package'),
                'training_program' => $request->input('training_program'),
                'session' => $request->input('session'),
                'time_slot' => $request->input('time_slot'),
                'lead_source' => $request->input('lead_source'),
                'registration_fee' => $request->input('registration_fees'),
                'room_allotment' => $request->input('room_allotment'),
                'room_type' => $request->input('room_type'),
                'meal_subscription' => $request->input('meal_subscription'),
                'meal_type' => $request->input('meal_type'),
                'checking_date' => $request->input('checking_date'),
                'checkout_date' => $request->input('checkout_date'),
                'notes' => $request->input('notes'),
                'date' => $request->input('date'),
                'locationID' => $locationID,
            ];

            $player = Registration::create($playerData);

            // Save Payment Details
            $paymentData = [
                'payment_id' => $newPaymentID,
                'registration_no' => $newRegistrationNo,
                'registration_fees' => $request->input('registration_fees'),
                'program_fee' => $request->input('program_fee'),
                'rooms_fees' => $request->input('rooms_fees'),
                'meals_fees' => $request->input('meals_fees'),
                'utr_no' => $request->input('utr_no'),
                'payment_module' => $request->input('payment_module'),
                'payment_date' => $request->input('payment_date'),
                'upcoming_date' => $request->input('upcoming_date'),
                'payment_method' => $request->input('payment_method'),
                'payment_status' => $request->input('payment_status'),
                'payment_notes' => $request->input('payment_notes'),
                'total_amt' => $request->input('total_amt'),
                'submitted_amt' => $request->input('submitted_amt'),
                'pending_amt' => $request->input('pending_amt'),
                'date' => date('Y-m-d'),
            ];

            $payment = PaymentDetails::create($paymentData);

            // Save Package Details
            $packageData = [
                'registration_no' => $newRegistrationNo,
                'package' => $request->input('package'),
                'training_program' => $request->input('training_program'),
                'session' => $request->input('session'),
                'time_slot' => $request->input('time_slot'),
                'package_fee' => $payment->program_fee,
                'package_notes' => $payment->payment_notes,
                'date' => date('Y-m-d'),
                'locationID' => $locationID,
            ];

            PackageUpdateTrack::create($packageData);

            // Save Status Tracker
            $trackData = [
                'registration_no' => $newRegistrationNo,
                'upcoming_date' => $request->input('upcoming_date'),
                'payment_method' => $request->input('payment_method'),
                'total_amt' => $request->input('total_amt'),
                'submitted_amt' => $request->input('submitted_amt'),
                'pending_amt' => $request->input('pending_amt'),
                'payment_status' => $request->input('payment_status'),
                'payment_notes' => $request->input('payment_notes'),
                'locationID' => $locationID,
            ];

            RegisterStatusTracker::create($trackData);

            DB::commit();

            return back()->with('success', 'Registration and payment successfully saved!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function edit_registration($registration_no)
    {

        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_registration = Registration::where('registration_no', $registration_no)->where('locationID', $locationID)->first();
        if (!$edit_registration) {
            return redirect()->route('registration.list')->with('success', 'Location Update.');
        }
        // $edit_registration = Registration::where('registration_no', $registration_no)->first();
        $edit_payment = PaymentDetails::where('id', $registration_no)->first();
        $states = DB::table('states')->orderBy('name')->get();
        $leads = LeadSource::where('status', '0')->orderBy('leadsource', 'asc')->get();
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $session = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();
        $rooms = Room::where('status', '0')->orderBy('room_type', 'asc')->get();
        $meals = Meal::where('status', '0')->orderBy('meal_type', 'asc')->get();
        $pmodules = PaymentModule::where('status', '0')->orderBy('module', 'asc')->get();
        if (!$edit_registration) {
            return redirect()->back()->with('error', 'Registration not found.');
        }

        $edit_payment = PaymentDetails::where('registration_no', $registration_no)->first();
        return view('pages.registration.edit-registration', compact('pmodules', 'edit_registration', 'edit_payment', 'states', 'leads', 'Packages', 'Training', 'session', 'Timing', 'rooms', 'meals'));
    }


    // update profile
    public function update_registration(Request $request)
    {
        DB::beginTransaction();
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'father' => 'required|string|max:255',
            // 'dob' => 'required|date',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required|digits:6',
            'package' => 'required',
        ]);
        $registration_no = $request->input('registration_no');
        $registration = Registration::where('registration_no', $registration_no)->first();
        // Handle Image Upload
        if ($request->hasFile('image')) {
            if ($registration->image && file_exists(public_path('player/' . $registration->image))) {
                unlink(public_path('player/' . $registration->image)); // Delete the old file
            }
            // Store the new image
            $filename = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('player'), $filename);

            // Update the image in the database
            $registration->image = $filename;
        }
        if ($request->input('remove_image') == '1') {

            if ($registration->image && file_exists(public_path('player/' . $registration->image))) {
                unlink(public_path('player/' . $registration->image)); // Delete the file
            }
            $registration->image = null;
        }

        try {
            // Update registration details
            $registration->update([
                'name' => $request->input('name'),
                'father' => $request->input('father'),
                'dob' => $request->input('dob'),
                'gender' => $request->input('gender'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'pincode' => $request->input('pincode'),
                'address' => $request->input('address'),
                'package' => $request->input('package'),
                'training_program' => $request->input('training_program'),
                'session' => $request->input('session'),
                'time_slot' => $request->input('time_slot'),
                'lead_source' => $request->input('lead_source'),
                'registration_fee' => $request->input('registration_fee'),
                'room_allotment' => $request->input('room_allotment'),
                'room_type' => $request->input('room_type'),
                'meal_subscription' => $request->input('meal_subscription'),
                'meal_type' => $request->input('meal_type'),
                'checking_date' => $request->input('checking_date'),
                'checkout_date' => $request->input('checkout_date'),
                'notes' => $request->input('notes'),
            ]);
            $payment = PaymentDetails::where('registration_no', $registration_no)->firstOrFail();

            // Handle UTR number logic
            if ($request->input('payment_method') == '0') { // Offline
                $payment->utr_no = null; // Remove UTR number for offline
            } else { // Online
                $payment->utr_no = $request->input('utr_no'); // Set UTR number for online
            }

            $payment->update([
                // 'registration_fees' => $request->input('registration_fees'),
                // 'program_fee' => $request->input('program_fee'),
                'rooms_fees' => $request->input('rooms_fees'),
                'meals_fees' => $request->input('meals_fees'),
                // 'utr_no' => $request->input('utr_no'),
                // 'payment_module' => $request->input('payment_module'),
                // 'payment_date' => $request->input('payment_date'),
                // 'upcoming_date' => $request->input('upcoming_date'),
                // 'payment_method' => $request->input('payment_method'),
                // 'payment_status' => $request->input('payment_status'),
                // 'payment_notes' => $request->input('payment_notes'),
                // 'total_amt' => $request->input('total_amt'),
            ]);

            // Commit transaction if both updates are successful
            DB::commit();
            // Save Package Details
            $packageData = [
                'registration_no' => $registration_no,
                'package' => $request->input('package'),
                'training_program' => $request->input('training_program'),
                'session' => $request->input('session'),
                'time_slot' => $request->input('time_slot'),
                'package_fee' => $payment->program_fee,
                'package_notes' => $payment->payment_notes,

            ];

            PackageUpdateTrack::create($packageData);

            // Track updated data in RegisterStatusTracker
            // $trackData = [
            //     'registration_no' => $registration_no,
            //     'upcoming_date' => $request->input('upcoming_date'),
            //     'payment_method' => $request->input('payment_method'),
            //     'total_amt' => $request->input('total_amt'),
            //     'submitted_amt' => $request->input('submitted_amt'),
            //     'pending_amt' => $request->input('pending_amt'),
            //     'payment_status' => $request->input('payment_status'),
            //     'payment_notes' => $request->input('payment_notes'),
            // ];

            // RegisterStatusTracker::create($trackData);
            return redirect()->route('registration.list')->with('success', 'Registration updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update registration.');
        }
    }

    // delete
    public function destroy_registration(Request $request)
    {
        $data = Registration::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }



    // <!*********************************************************************************************>

    public function prefill(Enquiry $enquiry)
    {
        // Check if the enquiry exists and lead_status is "Converted"
        if ($enquiry->lead_status != 3) {
            return redirect()->route('enquiry.list')->with('error', 'Only converted leads can be registered.');
        }

        // Pass the enquiry to the view
        return view('registrations.prefill', compact('enquiry'));
    }


    // <!***************************************update package******************************************************>


    // edit package
    public function edit_userpackage($registration_no)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_userpackage = Registration::where('registration_no', $registration_no)->where('locationID', $locationID)->first();
        if (!$edit_userpackage) {
            return redirect()->route('registration.list')->with('success', 'Location Update.');
        }
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $session = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();

        if (!$edit_userpackage) {
            return redirect()->back()->with('error', 'Registration not found.');
        }

        $edit_userpayment = PaymentDetails::where('registration_no', $registration_no)->first();
        return view('pages.registration.edit-userpackage', compact('edit_userpayment', 'session', 'edit_userpackage', 'Packages', 'Training', 'Timing'));
    }

    //Update package
    public function updateuser_package(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'registration_no' => 'required|exists:registrations,registration_no',
            'package' => 'required|string|max:255',
            'training_program' => 'nullable|string|max:255',
            'session' => 'nullable|string|max:255',
            'time_slot' => 'nullable|string|max:255',
            'program_fee' => 'required|numeric|min:0',
            'payment_notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Find the registration record
            $updatePackage = Registration::where('registration_no', $request->input('registration_no'))->first();

            if (!$updatePackage) {
                return redirect()->back()->with('error', 'Registration record not found.');
            }

            // Update the package in the registration table
            $updatePackage->update([
                'package' => $request->input('package'),
                'training_program' => $request->input('training_program'),
                'session' => $request->input('session'),
                'time_slot' => $request->input('time_slot'),
            ]);

            // Retrieve the payment details associated with this registration
            $payment = PaymentDetails::where('registration_no', $request->input('registration_no'))->latest()->first();

            if (!$payment) {
                return redirect()->back()->with('error', 'Payment details not found for the given registration number.');
            }

            // Update payment details (package fee and payment notes)
            $payment->update([
                'program_fee' => $request->input('program_fee'),
                'payment_notes' => $request->input('payment_notes'),
            ]);

            // Save package update to the PackageUpdateTrack table
            $packageData = [
                'registration_no' => $request->input('registration_no'),
                'package' => $request->input('package'),
                'training_program' => $request->input('training_program'),
                'session' => $request->input('session'),
                'time_slot' => $request->input('time_slot'),
                'package_fee' => $request->input('program_fee'),
                'package_notes' => $request->input('payment_notes'),
                'date' => date('Y-m-d'),
                'locationID' => $updatePackage->locationID,
            ];

            PackageUpdateTrack::create($packageData);

            DB::commit();

            return redirect()->back()->with('success', 'Package updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    // <!***************************************update payment******************************************************>
    // update payment or pending payment
    public function updatePayment(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'registration_no' => 'required|exists:payment_details,registration_no',
            'submitted_amt' => 'required|numeric|min:0',
        ]);

        // Fetch the payment record
        $payment = PaymentDetails::where('registration_no', $request->registration_no)->first();

        if ($payment) {
            // Calculate the new submitted amount
            $newSubmittedAmt = $request->submitted_amt;
            $submittedAmt = $payment->submitted_amt + $newSubmittedAmt;

            // Ensure the submitted amount does not exceed the total amount
            if ($submittedAmt > $payment->total_amt) {
                return redirect()->back()->with(
                    'error',
                    'The total submitted amount cannot exceed the total fee.'
                );
            }

            // Calculate pending amount and determine payment status
            $pendingAmt = max(0, $payment->total_amt - $submittedAmt);


            // Update the PaymentDetails record
            $payment->update([
                'submitted_amt' => $submittedAmt,
                'upcoming_date' => $request->upcoming_date,
                'pending_amt' => $pendingAmt,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,
                'payment_notes' => $request->payment_notes,
            ]);
        } else {
            // If no payment record is found, return with an error
            return redirect()->back()->with(
                'error',
                'Payment record not found for the given registration number.'
            );
        }

        // Create a new entry in the RegisterStatusTracker
        $trackData = [
            'registration_no' => $request->registration_no,
            'upcoming_date' => $request->upcoming_date,
            'payment_method' => $request->input('payment_method'),
            'total_amt' => $payment->total_amt,
            'submitted_amt' => $submittedAmt,
            'pending_amt' => $pendingAmt,
            'payment_status' => $request->payment_status,
            'payment_notes' => $request->payment_notes,
        ];
        RegisterStatusTracker::create($trackData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Payment updated successfully!');
    }
}
