@extends('pages.layouts.app')
@section('title')
Edit Call Leads
@endsection

@section('css')
   
@endsection

@section('content')
    <div class="container py-3">
        <div class="row my-4">
            <h3>Edit Call Leads</h3>
        </div>
        

        {{-- Edit Category form  --}}
        <div class="card">
            <div class="card-header dark">
                <h3 class="card-title text-white">Edit Call Leads</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="text-danger small">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <div class="row">
                    <form action="{{ route('Callleads.update') }}"  method="POST">
                        @csrf
                        {{-- <input type="text" name="lead_id" value="{{ $edit_lead->lead_id }}">
                        <input type="text" name="date" value="{{ date('Y-m-d') }}"> --}}
                        <div class="row">
                            {{-- <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Added By </label>
                                    <input type="text" class="form-control" name="added_by" value="{{ $edit_lead->added_by }}" placeholder="">
                                </div>
                            </div> --}}
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Name </label>
                                    <input type="text" class="form-control" name="name" value="{{$edit_lead->name}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Email </label>
                                    <input type="text" class="form-control" name="email" value="{{$edit_lead->email}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Phone </label>
                                    <input type="text" class="form-control" name="phone" value="{{$edit_lead->phone}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">College </label>
                                    <input type="text" class="form-control" name="college" value="{{$edit_lead->college}}" placeholder="">
                                </div>
                            </div>


                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Course </label>
                                    <select class="form-select" name="course" value="{{$edit_lead->course}}" selected>
                                        <option selected disabled>Select Courses</option>
                                        <option value="B.Tech">B.Tech</option>
                                        <option value="B.C.A">B.C.A</option>
                                        <option value="M.C.A">M.C.A</option>
                                        <option value="Diploma (CS)">Diploma (CS)</option>
                                        <option value="Diploma(IT)">Diploma(IT)</option>
                                        <option value="PGDCA">PGDCA</option>
                                        <option value="Others">Others</option>
                                        
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Training Type </label>
                                    <select class="form-select" name="training_type" value="{{$edit_lead->training_type}}" aria-label="Default select example">
                                        <option selected disabled>Select Training Type</option>
                                        <option value="Php Summer Training">Php Summer Training</option>
                                        <option value="Php Apperenticeship Training">Php Apperenticeship Training</option>
                                        <option value="Flutter Summer Training">Flutter Summer Training</option>
                                        <option value="Flutter Apperenticeship Training">Flutter Apperenticeship Training</option>
                                        <option value="Job Oriented Training">Job Oriented Training</option>
                                        <option value="UI/UX Training">UI/UX Training</option>                                       
                                        <option value="Others">Others</option>
                                        
                                    </select>
                                    
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Lead Source </label>
                                    <select class="form-select" name="lead_source" value="{{$edit_lead->lead_source}}" aria-label="Default select example">
                                        <option selected disabled>Select Lead Source</option>
                                        <option value="Self Motivated">Self Motivated</option>
                                        <option value="Family & Friends">Family & Friends</option>
                                        <option value="Students Referal">Students Referal</option>
                                        <option value="Office Employees">Office Employees</option> 
                                        <option value="Others">Others</option>
                                        
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Enquiry Date </label>
                                    <input type="text" class="form-control" name="enquiry_date" value="{{$edit_lead->enquiry_date}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Follow Date </label>
                                    <input type="text" class="form-control" name="follow_date" value="{{$edit_lead->follow_date}}" placeholder="">
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Year </label>
                                    <select class="form-select" name="year" value="{{$edit_lead->year}}" aria-label="Default select example">
                                        <option selected disabled>Select Year</option>
                                        <option value="First Year">First Year</option>
                                        <option value="Second Year">Second Year</option>
                                        <option value="Third Year">Third Year</option>
                                        <option value="Fourth Year">Fourth Year</option>                                      
                                        <option value="Others">Others</option>
                                        
                                    </select>
                                     
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Notes </label>
                                    <textarea type="text" class="form-control" name="notes" value="{{$edit_lead->notes}}" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Status<span class="text-danger">*</span></label>
                                     <select class="form-select" name="status" id="category" aria-label="Default select example">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="0" @if($edit_lead->status=='0') selected @endif>Received</option>
                                        <option value="1" @if($edit_lead->status=='1') selected @endif>Not Recieved</option>
                                        <option value="2" @if($edit_lead->status=='2') selected @endif>Followup Date </option>
                                        <option value="3" @if($edit_lead->status=='3') selected @endif>Enrolled</option>
                                        <option value="4" @if($edit_lead->status=='4') selected @endif>Not Interested</option>
                                        <option value="5" @if($edit_lead->status=='5') selected @endif>Fail</option>
                                        <option value="6" @if($edit_lead->status=='6') selected @endif>Brochure Sent</option>
                                        <option value="7" @if($edit_lead->status=='7') selected @endif>Insititute Visit</option>
                                        <option value="8" @if($edit_lead->status=='8') selected @endif>Invalid</option>
                                        <option value="9" @if($edit_lead->status=='9') selected @endif>Rejected</option>
                                       
                                 
                                    </select> 
                                </div>
                            </div>
                            
                        </div>
                             
                         
                        <div class="col-md-12 d-flex justify-content-end">
                            <button class="btn btn-dark  my-3 ml-1" type="submit">Submit</button>
                        </div>
                           
                    </form>
                    
                </div>
            </div>
        </div>
         
    </div>
 
@endsection

@section('js')

 
@endsection
