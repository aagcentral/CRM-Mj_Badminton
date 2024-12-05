<?php

namespace App\Http\Controllers\Panel\CallLeads;
use App\Models\callleads;
use App\Models\CallLeadStatusTracker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CallLeadsController extends Controller
{
    public function index()
    {
        $data = callleads::latest()->get();
        return view('pages.call-lead.call_lead',compact('data'));
    }

    public function view_call_leads($id)
    {
        $viewdata = callleads::where('lead_id', $id)->first();
        return view('pages.call-lead.view_more',compact('viewdata'));
    }
    public function lead_id_generator()
    {
        $data = callleads::latest()->first('id');
        return $data->id ?? 1;
    }

    public function save_callleads(Request $request)
    {
        // return $request->all();
        $data = $request->validate([
            'lead_id' => '',
            'date' => 'd-m-y',
            // 'status' => 'nullable',
            'added_by' => 'nullable',     
            'name' => 'nullable',  
            'email' => 'nullable|email',   
            'phone' => 'nullable|numeric',   
            'college' => 'nullable',   
            'course' => 'nullable',     
            'training_type' => 'nullable',   
            'lead_source' => 'nullable',   
            'enquiry_date' => 'nullable',                        
            'follow_date' => 'nullable',                        
            'notes' => 'nullable',                        
            'year' => 'nullable',                        
        ]);

         
        // $form = callleads::latest()->first();
        // $id = 'HLP-CL0'.$form->id + 1;
        $lead_id = 'HLP' . date('dmy') . $this->lead_id_generator() + 1;
        $save = callleads::create([
            'lead_id' => $lead_id, 
            'date' => date('Y-m-d'),
            'status' => '0',
            'added_by' => $request->added_by ,   
            'name' => $request->name,    
            'email' => $request->email ,        
            'phone' => $request->phone ,     
            'college' => $request->college ,      
            'course' => $request->course,       
            'training_type' => $request->training_type,   
            'lead_source' => $request->lead_source,   
            'enquiry_date' => $request->enquiry_date,                        
            'follow_date' => $request->follow_date,                        
            'notes' => $request->notes,                        
            'year' => $request->year,    
            
        ]);


        if ($save) {   
            $this->call_lead_status_tracker($lead_id,'0',$request->notes);         
             return back()->with('success', 'Form Added Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }



    // edit leads
    public function edit_callleads($id)
    {
        $edit_lead = callleads::where('lead_id', $id)->first();
        return view('pages.call-lead.edit-call-leads', compact('edit_lead'));
    }


    // update category
    public function update_callleads(Request $request)
    {


        // return $request->all();
        $data = $request->validate([
 
            // 'lead_id'=> 'required',
            // 'date'  => 'required',
            'status'  => 'required',
            // 'added_by'  => 'required', 
            'name'   => 'required',
            'email'  => 'required',
            'phone' => 'required',
            'college'  => 'required',
            'course'  => 'required',   
            'training_type' => 'required',
            'lead_source' => 'required',
            'enquiry_date' => 'required',                     
            'follow_date' => 'required',                     
            'notes' => 'required',                     
            'year'  => 'required',
        ]);

       

        $save = callleads::where('lead_id', $request->lead_id)->update([

            // 'lead_id' => $request-> lead_id,
            'date' => date('Y-m-d'),
            'status' => $request->status,
            'added_by' => '',   // Auth::user()->user_id  
            'name' => $request->name,    
            'email' => $request->email ,        
            'phone' => $request->phone ,     
            'college' => $request->college ,      
            'course' => $request->course,       
            'training_type' => $request->training_type,   
            'lead_source' => $request->lead_source,   
            'enquiry_date' => $request->enquiry_date,                        
            'follow_date' => $request->follow_date,                        
            'notes' => $request->notes,                        
            'year' => $request->year, 
        ]);

        if ($save) {
            $this->call_lead_status_tracker($request->lead_id,$request-> status,$request->notes);
            return redirect()->route('Callleads.show')->withSuccess('Call Leads Updated Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    static function call_lead_status_tracker($lead_id,$status,$notes){
        $check = callleads::where('lead_id',$lead_id)->whereNull('deleted_at')->first();
        if($check){
            $updateLead = $check->where('lead_id',$lead_id)->update([
                'status' => $status,
                'notes' => $notes
            ]);

            $insertLead = CallLeadStatusTracker::insert([
                'lead_id' => $lead_id,
                'date' => date('Y-m-d'),
                'lead_status' => $status,
                'lead_notes' => $notes,
                'added_by' => ''  // Auth::user()->user_id 
            ]);
            return 200;
        }
        return 404;
    }



}
