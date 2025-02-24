@extends('pages.layouts.app')
@section('title')
Edit Enquiry
@endsection

@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/fuse.js@6.4.6/dist/fuse.min.js"></script>
<style>
    .form-horizontal .control-label {
        text-align: left !important;
        margin-bottom: 0;
        padding-top: 7px;
    }

    .form-select {
        padding: 7px;
        height: auto;
        min-height: 35px;
        font-size: 14px;

    }
</style>
@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Edit Enquiry </h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('enquiry.list'))
                    <li class="breadcrumb-item"><a href="{{route('enquiry.list')}}">Enquiry</a></li>
                    @endif
                    <li class="breadcrumb-item active">Edit Enquiry </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
    <div class="row mt-4">

        @if ($errors->any())
        <div class="text-danger small">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mb-5">
                <form class="form-horizontal row" action="{{ route('enquiry.update', $edit_enquiry->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $edit_enquiry->id }}" id="">
                    <div class="panel-body ">
                        <fieldset>
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="panel panel-default shadow">
                                        <div class="panel-heading">
                                            <h5 class="panel-title fw-bold">Leads & Enquiry Form</h5>
                                        </div>
                                        <div class="panel-body p-5">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2"> Name <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control quantity" name="name" value="{{ $edit_enquiry->name }}" placeholder="Enter Name">
                                                </div>
                                                <label class="control-label col-sm-2">Phone Number <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="mobile" value="{{ $edit_enquiry->mobile }}" placeholder="Enter Phone No.">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Email </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control quantity" name="email" value="{{ $edit_enquiry->email }}" placeholder="Enter Email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Lead Status <span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="lead_status">
                                                        <option value="" disabled selected>Select Lead Status</option>
                                                        <option value="0" @if($edit_enquiry->lead_status=='0') selected @endif>New</option>
                                                        <option value="1" @if($edit_enquiry->lead_status=='1') selected @endif>Assigned</option>
                                                        <option value="2" @if($edit_enquiry->lead_status=='2') selected @endif>In Process</option>
                                                        <option value="3" @if($edit_enquiry->lead_status=='3') selected @endif>Converted</option>
                                                        <option value="4" @if($edit_enquiry->lead_status=='4') selected @endif>Dead</option>
                                                        <option value="5" @if($edit_enquiry->lead_status=='5') selected @endif>Recycle</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Enquiry Date <span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="Date" class="form-control quantity" name="enquiry_date" value="{{ $edit_enquiry->enquiry_date }}" placeholder="Enter Followup Date">
                                                </div>
                                                <label class="control-label col-sm-2">Followup Date <span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="Date" class="form-control quantity" name="followup_date" value="{{ $edit_enquiry->followup_date }}" placeholder="Enter Followup Date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Category </label>
                                                <div class="col-sm-4">
                                                    <select name="package" id="package" class="form-select">
                                                        <option value="" disabled selected>Select Category</option>
                                                        @foreach ($Packages as $Packag)
                                                        <option value="{{ $Packag->package_id }}"
                                                            @if ($edit_enquiry->package == $Packag->package_id) selected @endif>{{ $Packag->package }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="trainingProgramContainer" style="display: none;">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-2">Training Program Type </label>
                                                    <div class="col-sm-4">
                                                        <select name="training_program" class="form-select">
                                                            <option value="" disabled selected>Select Training Program</option>
                                                            @foreach ($Training as $Trng)
                                                            <option value="{{ $Trng->program_id }}"
                                                                @if ($edit_enquiry->training_program == $Trng->program_id) selected @endif>{{ $Trng->add_program }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <label class="control-label col-sm-2">Transport</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="transport">
                                                            <option value="" disabled selected>Select Transport</option>
                                                            <option value="0" @if($edit_enquiry->transport=='0') selected @endif>No</option>
                                                            <option value="1" @if($edit_enquiry->transport=='1') selected @endif>Yes</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-2">Hostel</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="hostel">
                                                            <option value="" disabled selected>Select Hostel</option>
                                                            <option value="0" @if($edit_enquiry->hostel=='0') selected @endif>No</option>
                                                            <option value="1" @if($edit_enquiry->hostel=='1') selected @endif>Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Session </label>
                                                <div class="col-sm-4">
                                                    <select name="session" class="form-select">
                                                        <option value="" disabled selected>Select Session</option>
                                                        @foreach ($session as $sesion)
                                                        <option value="{{ $sesion->session_id }}"
                                                            @if ($edit_enquiry->session == $sesion->session_id) selected @endif>{{ $sesion->session }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <label class="control-label col-sm-2">Time Slot </label>
                                                <div class="col-sm-4">
                                                    <select name="time_slot" class="form-select">
                                                        <option value="" disabled>Select Time Slot</option>
                                                        @foreach ($Timing as $Time)
                                                        <option value="{{ $Time->timing_id }}"
                                                            @if (isset($edit_enquiry->time_slot) && $edit_enquiry->time_slot == $Time->timing_id) selected @endif>
                                                            {{ $Time->time_slot }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Lead Source </label>
                                                <div class="col-sm-4">
                                                    <select name="lead_source" class="form-select">
                                                        <option value="" disabled selected>Select Lead Source</option>
                                                        @foreach ($leads as $lead)
                                                        <option value="{{ $lead->leadsource_id }}"
                                                            @if ($edit_enquiry->lead_source == $lead->leadsource_id) selected @endif>{{ $lead->leadsource }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label class="control-label col-sm-2">Interested Branch</label>
                                                <div class="col-md-4">
                                                    <select name="interested_branch" id="interested_branch" class="form-select">
                                                        <option value="" disabled selected>Select Branch</option>
                                                        @foreach ($location as $locate)
                                                        <option value="{{ $locate->location_id }}"
                                                            @if (isset($edit_enquiry) && $edit_enquiry->interested_branch == $locate->location_id) selected @endif>
                                                            {{ $locate->location }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Address</label>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" name="address" placeholder="Write Address here...">{{ $edit_enquiry->address}}</textarea>
                                                </div>
                                                <label class="control-label col-sm-2">Notes</label>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" name="notes" placeholder="Write notes here...">{{ $edit_enquiry->notes}}</textarea>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-dark" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

    @section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const packageSelect = document.getElementById("package");
            const trainingProgramContainer = document.getElementById("trainingProgramContainer");
            const knownPackages = ['Training Program', 'TrainingProgram', 'training program', 'training-program', 'Training Programme', 'Training programme',
                'trainingprogram', 'Training-Program'
            ];
            // Fuse.js options
            const options = {
                includeScore: true,
                threshold: 0.3,
            };
            const fuse = new Fuse(knownPackages, options);
            packageSelect.addEventListener("change", function() {
                const selectedText = packageSelect.options[packageSelect.selectedIndex].text.trim();
                const result = fuse.search(selectedText);
                let showTrainingProgram = false;
                for (let i = 0; i < result.length; i++) {
                    if (result[i].item.toLowerCase() === 'training program') {
                        showTrainingProgram = true;
                        break;
                    }
                }
                if (showTrainingProgram) {
                    trainingProgramContainer.style.display = "block";
                } else {
                    trainingProgramContainer.style.display = "none";
                }
            });
        });
    </script>
    @endsection