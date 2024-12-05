<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\LeadSource;
use App\Models\Package;
use App\Models\TrainingProgram;
use App\Models\LeadStatusTracker;
use App\Models\Psession;
use App\Models\Enquiry;
use App\Models\Timings;
use Illuminate\Http\Request;
use Auth;

class EnquiryController extends Controller
{
    public function enquiry_list(Request $request)
    {
        // Initialize the query builder for the Enquiry model
        $query = Enquiry::with(['leads'])->latest();  // Applying latest() here to the query builder

        // Retrieve necessary data for dropdowns
        $leads = LeadSource::where('status', '0')->orderBy('leadsource', 'asc')->get();
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

        // Get the filtered data
        $data = $query->get();

        // Pass the data and other necessary variables to the view
        return view('pages.enquiry.enquiry-list', compact('data', 'leads', 'Packages', 'Training', 'session', 'Timing'));
    }




    public function enquiry()
    {
        $data = Enquiry::max('id');
        return $data ? $data + 1 : 1;
    }

    // Add
    public function add_enquiry(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:enquiries,email',
            'mobile' => 'required',
            'lead_source' => 'required',
            'package' => 'required',
            'training_program' => 'nullable',
            'session' => 'required',
            'time_slot' => 'required',
            'enquiry_date' => 'required',
            'followup_date' => 'required',
            'lead_status' => 'required',

        ], [
            'email.unique' => 'This email address is already registered. Please use a different one.',
        ]);

        $enquiry_Id = 'ENQID' . date('dmy') . ($this->enquiry() + 1);
        // Save the data
        $save = Enquiry::create([
            'enquiry_Id' =>  $enquiry_Id,
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
            'notes' => $request->notes,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            $this->lead_status_tracker($enquiry_Id, $request->lead_status, $request->notes);
            return back()->with('success', 'Enquiry & Lead Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }

    // edit
    public function edit_enquiry($id)
    {
        // $edit_enquiry = Enquiry::where('id', $id)->first();
        $leads = LeadSource::where('status', '0')->orderBy('leadsource', 'asc')->get();
        $Packages = Package::where('status', '0')->orderBy('package', 'asc')->get();
        $Training = TrainingProgram::where('status', '0')->orderBy('add_program', 'asc')->get();
        $session = Psession::where('status', '0')->orderBy('session', 'asc')->get();
        $Timing = Timings::where('status', '0')->orderBy('time_slot', 'asc')->get();
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_enquiry = Enquiry::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_enquiry) {
            return redirect()->route('enquiry.list')->with('success', 'Location Update.');
        }
        return view('pages.enquiry.edit-enquiry', compact('edit_enquiry', 'leads', 'Packages', 'Training', 'session', 'Timing'));
    }

    // update
    public function update_enquiry(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'lead_source' => 'required',
            'package' => 'required',
            'training_program' => 'nullable',
            'session' => 'required',
            'time_slot' => 'required',
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
                'followup_date' => $request->followup_date, // Optional, if you're updating the follow-up date
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
}
