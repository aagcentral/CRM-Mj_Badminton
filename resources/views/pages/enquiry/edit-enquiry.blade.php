@extends('pages.layouts.app')
@section('title')
Edit Enquiry
@endsection

@section('css')

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
    <div class="card  overflow-auto" @if (!$errors->any()) @endif>

        <div class="card-body">
            <div class="row">
                <form action="{{route('enquiry.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $edit_enquiry->id }}" id="">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control quantity" name="name" value="{{ $edit_enquiry->name }}" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Email </label>
                                <input type="text" class="form-control quantity" name="email" value="{{ $edit_enquiry->email }}" placeholder="Enter Email">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Phone No. <span class="text-danger">*</span></label>
                                <input type="text" class="form-control quantity" name="mobile" value="{{ $edit_enquiry->mobile }}" placeholder="Enter Phone No.">
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Lead Source </label>
                                <select name="lead_source" class="form-select">
                                    <option value="" disabled selected>Select Lead Source</option>
                                    @foreach ($leads as $lead)
                                    <option value="{{ $lead->leadsource_id }}"
                                        @if ($edit_enquiry->lead_source == $lead->leadsource_id) selected @endif>{{ $lead->leadsource }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="package">Category </label>
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
                        <!-- make sure add Training Program -->
                        <div id="trainingProgramContainer" class="col-md-4 col-sm-12" style="display: none;">
                            <div class="form-group">
                                <label for="training_program">Training Program </label>
                                <select name="training_program" class="form-select">
                                    <option value="" disabled selected>Select Training Program</option>
                                    @foreach ($Training as $Trng)
                                    <option value="{{ $Trng->program_id }}"
                                        @if ($edit_enquiry->training_program == $Trng->program_id) selected @endif>{{ $Trng->add_program }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Session </label>
                                <select name="session" class="form-select">
                                    <option value="" disabled selected>Select Session</option>
                                    @foreach ($session as $sesion)
                                    <option value="{{ $sesion->session_id }}"
                                        @if ($edit_enquiry->session == $sesion->session_id) selected @endif>{{ $sesion->session }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="time_slot">Time Slot </label>
                                <select name="time_slot" class="form-select">
                                    <option value="" disabled>Select Time Slot</option>
                                    @foreach ($Timing as $Time)
                                    <option value="{{ $Time->timing_id }}"
                                        @if ($edit_enquiry->time_slot == $sesion->timing_id) selected @endif> {{ $Time->time_slot }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Enquiry Date <span class="text-danger">*</span></label>
                                <input type="Date" class="form-control quantity" name="enquiry_date" value="{{ $edit_enquiry->enquiry_date }}" placeholder="Enter Followup Date">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Followup Date <span class="text-danger">*</span></label>
                                <input type="Date" class="form-control quantity" name="followup_date" value="{{ $edit_enquiry->followup_date }}" placeholder="Enter Followup Date">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="lead_status">Lead Status <span class="text-danger">*</span></label>
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
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="interested_branch">Interested Branch</label>
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

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="name">Address</label>
                                <textarea type="text" class="form-control" name="address" value="" placeholder="Write Address here...">{{ $edit_enquiry->address}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="name">Notes</label>
                                <textarea type="text" class="form-control" name="notes" value="" placeholder="Write notes here...">{{ $edit_enquiry->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-between align-items-center mt-4 w-100">
                        <div class="">
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="0" {{ old('status', $edit_enquiry->status) == '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="1" {{ old('status', $edit_enquiry->status) == '1' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger" for="danger-outlined">Inactive</label>
                        </div>
                        <div>
                            <button class="btn btn-info btn-md mb-2" type="submit">Submit</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>


</div>


@endsection

@section('js')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const packageSelect = document.getElementById("package");
        const trainingProgramContainer = document.getElementById("trainingProgramContainer");

        // Function to toggle the visibility of the training program container
        function toggleTrainingProgramContainer() {
            const selectedText = packageSelect.options[packageSelect.selectedIndex].text.trim();

            // Show the container if "Training Program" is selected, otherwise hide it
            if (selectedText === "Training Program") {
                trainingProgramContainer.style.display = "block";
            } else {
                trainingProgramContainer.style.display = "none";
            }
        }

        // Check the selected package on page load
        toggleTrainingProgramContainer();

        // Add event listener to package select to handle changes
        packageSelect.addEventListener("change", function() {
            toggleTrainingProgramContainer();
        });
    });
</script>
@endsection