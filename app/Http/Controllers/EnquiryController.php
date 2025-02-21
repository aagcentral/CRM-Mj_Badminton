<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\LeadSource;
use App\Models\Package;
use App\Models\TrainingProgram;
use App\Models\LeadStatusTracker;
use App\Models\Psession;
use App\Models\Enquiry;
use App\Models\Location;
use App\Models\User;
use App\Models\Timings;
use Illuminate\Http\Request;
use App\Notifications\LeadNotification;
use Auth;

class EnquiryController extends Controller
{
    public function enquiry_list(Request $request)
    {
        // Initialize the query builder for the Enquiry model
        $query = Enquiry::with(['leads', 'interestedlocation'])->latest();

        // Retrieve necessary data for dropdowns
        $leads = LeadSource::where('status', '0')->orderBy('leadsource', 'asc')->get();
        $location = Location::where('status', '0')->orderBy('location', 'asc')->get();
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $session = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();

        // Apply filters if they are provided in the request
        if ($request->has('month') && $request->month !== null) {
            $query->whereMonth('created_at', date('m', strtotime($request->month)));
        }

        if ($request->has('lead_status') && $request->lead_status !== null) {
            $query->where('lead_status', $request->lead_status);
        }
        if ($request->has('year') && $request->year !== null) {
            $query->whereYear('created_at', $request->year);
        }

        // Filter by Enquiry Date (exact date)
        if ($request->has('enquiry_date') && !is_null($request->enquiry_date)) {
            $enquiryDate = $request->enquiry_date;  // Get the selected enquiry date
            $query->whereDate('enquiry_date', '=', $enquiryDate);
        }

        // Filter by Follow-up Date (exact date)
        if ($request->has('followup_date') && !is_null($request->followup_date)) {
            $followupDate = $request->followup_date;
            $query->whereDate('followup_date', '=', $followupDate);
        }
        // Filter by Follow-up Date (Range)
        if ($request->has('from_date') && $request->has('to_date') && !is_null($request->from_date) && !is_null($request->to_date)) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;

            $query->whereBetween('followup_date', [$fromDate, $toDate]);
        }
        if ($request->has('hostel') && $request->hostel !== null) {
            $query->where('hostel', $request->hostel);
        }
        if ($request->has('transport') && $request->transport !== null) {
            $query->where('transport', $request->transport);
        }
        if ($request->has('package') && $request->package !== null) {
            $query->where('package', $request->package);
        }
        // Get the filtered data
        $data = $query->get();

        // Pass the data and other necessary variables to the view
        return view('pages.enquiry.enquiry-list', compact('data', 'leads', 'Packages', 'Training', 'session', 'Timing', 'location'));
    }


    public function enquiry_form(Request $request)
    {
        $leads = LeadSource::where('status', '0')->orderBy('leadsource', 'asc')->get();
        $location = Location::where('status', '0')->orderBy('location', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $session = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();
        return view('pages.enquiry.enquiry', compact('Packages', 'Training', 'session', 'Timing', 'leads', 'location', 'users'));
    }


    public function enquiry()
    {
        $locationID = Auth::user()->locationID ?? 'Default';
        // Fetch the last enquiry for the specific location
        $lastEnquiry = Enquiry::where('locationID', $locationID)
            ->orderByDesc('id')
            ->first();
        // Extract the last sequence number from the `enquiry_Id`
        if ($lastEnquiry) {
            // Match the last 3 digits in the `enquiry_Id`
            preg_match('/(\d{3})$/', $lastEnquiry->enquiry_Id, $matches);
            $lastNumber = isset($matches[1]) ? (int)$matches[1] : 0;
        } else {
            $lastNumber = 0;
        }
        return $lastNumber;
    }

    //  add
    public function add_enquiry(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'name' => 'required',
            'mobile' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                'unique:enquiries,mobile'
            ],
            'enquiry_date' => 'required|date',
            'followup_date' => 'required|date|after_or_equal:enquiry_date',
            'lead_status' => 'required',
        ], [
            'mobile.unique' => 'This Phone Number is already registered. Please use a different one.',
            'mobile.regex' => 'Please enter a valid 10-digit mobile number.',
            'followup_date.after_or_equal' => 'Follow-up date must be on or after the enquiry date.',
        ]);

        // Dynamically get the current user's locationID
        $locationID = Auth::user()->locationID ?? 'Default';

        // Generate the enquiry ID with the locationID, current date, and sequence number
        $datePart = date('dmy');
        $nextNumber = str_pad(($this->enquiry() + 1), 3, '0', STR_PAD_LEFT);
        $enquiry_Id = 'ENQID' . strtoupper($locationID) . $datePart . $nextNumber;

        // Convert name to proper case
        $name = ucwords(strtolower($request->name));

        // Save the data
        $save = Enquiry::create([
            'enquiry_Id' =>  $enquiry_Id,
            'name' => $name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'lead_source' => $request->lead_source,
            'package' => $request->package,
            'training_program' => $request->training_program,
            'session' => $request->session,
            'time_slot' => $request->time_slot,
            'enquiry_date' => $request->enquiry_date,
            'followup_date' => $request->followup_date,
            'lead_status' => $request->lead_status,
            'interested_branch' => $request->interested_branch,
            'transport' => $request->transport,
            'hostel' => $request->hostel,
            // 'is_converted' => 1,
            'address' => $request->address,
            'notes' => $request->notes,
            'date' => date('Y-m-d H:i:s'),
            'locationID' => $locationID,
        ]);

        if ($save) {
            // Track the lead status
            $this->lead_status_tracker($enquiry_Id, $request->lead_status, $request->notes);
            // Return success message
            return back()->with('success', 'Enquiry Added Successfully');
        } else {
            // Handle the case where saving the enquiry fails
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }

    // edit
    public function edit_enquiry($enquiry_Id)
    {
        // $edit_enquiry = Enquiry::where('id', $id)->first();
        $leads = LeadSource::where('status', '0')->orderBy('leadsource', 'asc')->get();
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $location = Location::where('status', '0')->orderBy('location', 'asc')->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $session = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();
        $location = Location::where('status', '0')->orderBy('location', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_enquiry = Enquiry::where('enquiry_Id', $enquiry_Id)->where('locationID', $locationID)->first();
        if (!$edit_enquiry) {
            return redirect()->route('enquiry.list')->with('success', 'Location Update.');
        }
        return view('pages.enquiry.edit-enquiry', compact('location', 'edit_enquiry', 'leads', 'Packages', 'Training', 'session', 'Timing', 'location', 'users'));
    }

    // update
    public function update_enquiry(Request $request)
    {
        $data = $request->validate([
            // 'status' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'enquiry_date' => 'required',
            'followup_date' => 'required',
            'lead_status' => 'required',
        ]);
        $check = Enquiry::where('id', $request->id)->whereNull('deleted_at')->first();
        if ($check) {
            $updated = Enquiry::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'lead_source' => $request->lead_source,
                'package' => $request->package,
                'training_program' => $request->training_program,
                'session' => $request->session,
                'time_slot' => $request->time_slot,
                'enquiry_date' => $request->enquiry_date,
                'followup_date' => $request->followup_date,
                'lead_status' => $request->lead_status,
                'interested_branch' => $request->interested_branch,
                'transport' => $request->transport,
                'hostel' => $request->hostel,
                // 'assigned' => $request->assigned,
                'address' => $request->address,
                'notes' => $request->notes,
                'date' => date('Y-m-d H:i:s'),
                'status' =>  $request->status
            ]);
            if ($updated) {
                if ($check->lead_status != $request->lead_status || $check->notes != $request->notes) {
                    $this->lead_status_tracker($request->enquiry_Id, $request->lead_status, $request->notes);
                }
                return redirect()->route('enquiry.list')->withSuccess('Enquiry Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_enquiry(Request $request)
    {
        $data = Enquiry::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }

    // <!*********************************************************************************************>


    // status tracker
    public function view_status($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $data = Enquiry::with('LeadStatusTrackers')->where('enquiry_Id', $id)->where('locationID', $locationID)->first();
        // dd($data);
        if (!$data) {
            return redirect()->route('enquiry.list')->with('success', 'Location Update.');
        }
        return view('pages.enquiry.view-status', compact('data'));
    }

    // common function for update status
    public static function lead_status_tracker($enquiry_Id, $lead_status, $notes)
    {
        $enquiry = Enquiry::where('enquiry_Id', $enquiry_Id)->whereNull('deleted_at')->first();
        if ($enquiry) {
            $enquiry->update([
                'lead_status' => $lead_status,
                'notes' => $notes
            ]);
            LeadStatusTracker::create([
                'enquiry_Id' => $enquiry_Id,
                'date' => now()->format('Y-m-d'),
                'leads_status' => $lead_status,
                'leads_notes' => $notes,
            ]);
            return 200;
        }
        return 404;
    }



    public function updateStatus(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'enquiry_Id' => 'required|exists:enquiries,enquiry_Id',
            'lead_status' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        // Find the enquiry by ID
        $enquiry = Enquiry::where('enquiry_Id', $request->enquiry_Id)->first();

        if ($enquiry) {
            // Update the enquiry's lead status and notes
            $enquiry->update([
                'lead_status' => $request->lead_status,
                'notes' => $request->notes,
                'followup_date' => $request->followup_date,
            ]);

            // Log the status change in the LeadStatusTracker
            LeadStatusTracker::create([
                'enquiry_Id' => $request->enquiry_Id,
                'leads_status' => $request->lead_status,
                'leads_notes' => $request->notes,
                'date' => now()->format('Y-m-d'),
            ]);

            return redirect()->route('enquiry.list')->with('success', 'Status updated successfully!');
        }

        return redirect()->route('enquiry.list')->with('error', 'Enquiry not found!');
    }





    // share location
    public function moveLocation(Request $request, $id)
    {
        $request->validate([
            'locationID' => 'required|exists:locations,location_id', // Validate input
        ]);

        $enquiry = Enquiry::withoutGlobalScope('locationID')->findOrFail($id);
        $enquiry->locationID = $request->locationID;
        $enquiry->save();

        return redirect()->back()->with('success', 'Location updated successfully.');
    }
}
