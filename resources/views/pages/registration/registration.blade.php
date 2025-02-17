@extends('pages.layouts.app')
@section('title')
Registration
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
                <h3>Create New Registration</h3>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('registration.list'))
                    <li class="breadcrumb-item"><a href="{{route('registration.list')}}">Registration List</a></li>
                    @endif
                    <li class="breadcrumb-item active">Registration</li>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10">
                <!-- {{-- Main Header --}} -->
                <div class="panel-heading mb-5">
                    <h3 class="panel-title">
                        Application for Registration to the
                        <font color="blue">Mj Badminton Academy</font>
                        for the
                        <font color="blue">{{ date('Y') }}-{{ date('Y', strtotime('+1 year')) }} Academic Year
                        </font>
                    </h3>
                </div>
                <!-- {{-- ! Main Header --}} -->

                <form class="form-horizontal row" action="{{route('registration.add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Hidden field to track enquiry ID -->
                    @if ($enquiry)
                    <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
                    @endif
                    <!-- {{-- Personal Details --}} -->
                    <div class="panel-body ">
                        <fieldset>
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="panel panel-default shadow">
                                        <div class="panel-heading">
                                            <h5 class="panel-title fw-bold">Personal Details</h5>
                                        </div>
                                        <div class="panel-body p-5">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2"> Name <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="name" value="{{ old('name', $enquiry->name ?? '') }}">
                                                </div>

                                                <label class="control-label col-sm-2">Father Name <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="father" value="{{ old('father', $enquiry->father ?? '') }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Date Of Birth </label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" name="dob" value="{{ old('dob', $enquiry->dob ?? '') }}" id="dobInput" max="">
                                                </div>

                                                <label class="control-label col-sm-2">Gender <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <select name="gender" class="form-select form-control">
                                                        <option selected disabled>Select Gender</option>
                                                        <option value="0" {{ old('gender', $enquiry->gender ?? '') == '0' ? 'selected' : '' }}>Male</option>
                                                        <option value="1" {{ old('gender', $enquiry->gender ?? '') == '1' ? 'selected' : '' }}>Female</option>
                                                        <option value="2" {{ old('gender', $enquiry->gender ?? '') == '2' ? 'selected' : '' }}>Other</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Upload Image</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="file" name="image" id="image" accept=".jpg,.jpeg,.png">
                                                    <!-- <input class="form-control" type="file" id="formFile" name="image" value="{{ old('image', $enquiry->image ?? '') }}"> -->
                                                    @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="panel panel-default shadow card h-100">
                                        <div class="panel-heading">
                                            <h5 class="panel-title fw-bold">Contact Details</h5>
                                        </div>
                                        <div class="panel-body p-5">
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Phone Number<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control contactInput"
                                                        name="phone" value="{{ old('phone', $enquiry->mobile ?? '') }}" maxlength="10" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Email <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="email" class="form-control" name="email" value="{{ old('email', $enquiry->email ?? '') }}">
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4">State <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="state" id="state">
                                                        <option value="">Select State</option>
                                                        @foreach ($states as $state)
                                                        <option value="{{ $state->id }}" {{ old('state') == $state->id ? 'selected' : '' }}>
                                                            {{ $state->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4">City <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="city" id="city">
                                                        <option value="">Select City</option>
                                                        <!-- {{-- The options for the city dropdown should be dynamically populated based on the selected state --}} -->
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Pincode <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control contactInput" name="pincode" value="{{ old('pincode', $enquiry->city ?? '') }}" maxlength="6" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Address</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" rows="3" name="address">{{ old('address', $enquiry->address ?? '') }}</textarea>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="panel panel-default shadow card h-100">
                                        <div class="panel-heading">
                                            <h5 class="panel-title fw-bold">Training Details</h5>
                                        </div>
                                        <div class="panel-body p-5">

                                            <div class="form-group">
                                                <label class="form-label col-sm-4">Category <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select name="package" id="package" class="form-select">
                                                        <option value="" disabled selected>Select Category</option>
                                                        @foreach ($Packages as $Packag)
                                                        <option value="{{ $Packag->package_id }}"
                                                            @if (old('package')==$Packag->package_id || (isset($enquiry) && $enquiry->package == $Packag->package_id)) selected @endif> {{ $Packag->package }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="trainingProgramContainer" style="display: none;">
                                                <div class="form-group">
                                                    <label class="form-label col-sm-4">Training Type</label>
                                                    <div class="col-sm-8">
                                                        <select name="training_program" id="training_program" class="form-select">
                                                            <option value="" disabled selected>Select Training Type</option>
                                                            @foreach ($Training as $Trng)
                                                            <option value="{{ $Trng->program_id }}"
                                                                data-program-name="{{ $Trng->add_program }}"
                                                                @if (old('training_program')==$Trng->program_id || (isset($enquiry) && $enquiry->training_program == $Trng->program_id)) selected @endif> {{ $Trng->add_program }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label col-sm-4">Session</label>
                                                <div class="col-sm-8">
                                                    <select name="session" class="form-select">
                                                        <option value="" disabled selected>Select Session</option>
                                                        @foreach ($session as $sesion)
                                                        <option value="{{ $sesion->session_id }}"
                                                            @if (old('session')==$sesion->session_id || (isset($enquiry) && $enquiry->session == $sesion->session_id)) selected @endif> {{ $sesion->session }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label col-sm-4">Time Slot</label>
                                                <div class="col-sm-8">
                                                    <select name="time_slot" class="form-select">
                                                        <option value="" disabled selected>Select Time Slot</option>
                                                        @foreach ($Timing as $Time)
                                                        <option value="{{ $Time->timing_id }}"
                                                            @if (old('time_slot')==$Time->timing_id || (isset($enquiry) && $enquiry->time_slot == $Time->timing_id)) selected @endif> {{ $Time->time_slot }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label col-sm-4">Lead Source</label>
                                                <div class="col-sm-8">
                                                    <select name="lead_source" class="form-select">
                                                        <option value="" disabled selected>Select Lead Source</option>
                                                        @foreach ($leads as $lead)
                                                        <option value="{{ $lead->leadsource_id }}"
                                                            @if (old('lead_source')==$lead->leadsource_id || (isset($enquiry) && $enquiry->lead_source == $lead->leadsource_id)) selected @endif> {{ $lead->leadsource }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Register Date </label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                        </fieldset>
                        <fieldset>

                            <!-- ************ Start of hostel Details************** -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default shadow" id="hostel_allotment_panel" style="display: none;">
                                        <div class="panel-heading">
                                            <h5 class="panel-title fw-bold">Hostel Allotment Details</h5>
                                        </div>
                                        <div class="panel-body">
                                            <!-- Hostel Allotment Form -->
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Hostel Allotment</label>
                                                <div class="col-sm-10">
                                                    <select class="form-select form-control" name="room_allotment" id="room_allotment">
                                                        <option value="" disabled>Select Allotment</option>
                                                        <option value="0" {{ old('room_allotment', $enquiry->room_allotment ?? '') == '0' ? 'selected' : '' }}>Yes</option>
                                                        <option value="1" {{ old('room_allotment', $enquiry->room_allotment ?? '') == '1' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="" id="room_type_container" style="display: none;">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-2">Room Type</label>
                                                    <div class="col-sm-4">
                                                        <select name="room_type" class="form-select">
                                                            <option value="" disabled selected>Select Room Type</option>
                                                            @foreach ($rooms as $room)
                                                            <option value="{{ $room->room_id }}" {{ old('room_type') == $room->room_id ? 'selected' : '' }}>
                                                                {{ $room->room_type }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                    <label class="control-label col-sm-2">Room Fee ₹</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="room_fee" name="rooms_fees" value="{{ old('rooms_fees') }}" oninput="validateDecimal(this); calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Meal Subscription</label>
                                                <div class="col-sm-10">
                                                    <select class="form-select form-control" name="meal_subscription" id="meal_subscription">
                                                        <option value="" disabled selected>Select Subscription</option>
                                                        <option value="0" {{ old('meal_subscription') == '0' ? 'selected' : '' }}>Yes</option>
                                                        <option value="1" {{ old('meal_subscription') == '1' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="" id="meal_type_container" style="display: none;">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-2">Meal Type</label>
                                                    <div class="col-sm-4">
                                                        <select name="meal_type" class="form-select">
                                                            <option value="" disabled selected>Select Meal Type</option>
                                                            @foreach ($meals as $meal)
                                                            <option value="{{ $meal->meal_id }}" {{ old('meal_type') == $meal->meal_id ? 'selected' : '' }}>
                                                                {{ $meal->meal_type }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <label class="control-label col-sm-2">Meal Fee ₹</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="meal_fee" name="meals_fees" value="{{ old('meals_fees') }}" oninput="validateDecimal(this); calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Checking Date</label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control decimal-input" name="checking_date" value="{{ old('checking_date') }}">
                                                </div>
                                                <label class="control-label col-sm-2">Checkout Date</label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control decimal-input" name="checkout_date" value="{{ old('checkout_date') }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2 ">Notes</label>
                                                <div class="col-sm-10">
                                                    <textarea type="text" class="form-control" name="notes" value="{{ old('notes') }}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ************ End of hostel Details************** -->
                            <!-- ************ Start of Payment Details************** -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default shadow">
                                        <div class="panel-heading">
                                            <h5 class="panel-title fw-bold">Payment Details</h5>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Payment Module</label>
                                                <div class="col-sm-4">
                                                    <select name="payment_module" id="payment_module" class="form-select">
                                                        <option value="" disabled selected>Select Payment Module</option>
                                                        @foreach ($pmodules as $pmodule)
                                                        <option value="{{ $pmodule->module_id }}" data-interval="{{ $pmodule->module }}"> {{ $pmodule->module }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label class="control-label col-sm-2">Payment Date</label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ old('payment_date') }}">
                                                </div>


                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Next Payment Date</label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" id="next_payment_date" name="upcoming_date" value="{{ old('upcoming_date') }}" readonly>
                                                </div>
                                                <label class="control-label col-sm-2">Payment Status <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <select name="payment_status" class="form-select">
                                                        <option value="" disabled selected>Select Payment Status</option>
                                                        <option value="0" {{ old('payment_status') == '0' ? 'selected' : '' }}>Success</option>
                                                        <option value="1" {{ old('payment_status') == '1' ? 'selected' : '' }}>Due</option>
                                                        <option value="2" {{ old('payment_status') == '2' ? 'selected' : '' }}>Pending</option>
                                                        <option value="3" {{ old('payment_status') == '3' ? 'selected' : '' }}>Failed</option>
                                                        <option value="4" {{ old('payment_status') == '4' ? 'selected' : '' }}>Refunded</option>
                                                        <option value="5" {{ old('payment_status') == '5' ? 'selected' : '' }}>Cancelled</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Payment Method <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <select class="form-select form-control" name="payment_method" id="payment_method">
                                                        <option value="" disabled selected>Select Payment Method </option>
                                                        <option value="0" {{ old('payment_method') == '0' ? 'selected' : '' }}>Offline</option>
                                                        <option value="1" {{ old('payment_method') == '1' ? 'selected' : '' }}>Online</option>
                                                    </select>
                                                </div>

                                                <div class="" id="utr_no_group" style="display: none;">
                                                    <label class="control-label col-sm-2">UTR No.</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control decimal-input numericInput" name="utr_no" value="{{ old('utr_no') }}">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Registration Fee ₹<span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="registration_fee" name="registration_fees" value="{{ old('registration_fees') }}" oninput="validateDecimal(this); calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                                </div>
                                                <label class="control-label col-sm-2">Package Fee ₹</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="program_fee" name="program_fee" value="{{ old('program_fee') }}" oninput="validateDecimal(this); calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Total Amount ₹</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="total_amount" name="total_amt" value="{{ old('total_amt') }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Paid Amount ₹ <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="submitted_amt" name="submitted_amt" value="{{ old('submitted_amt') }}" oninput="calculatePendingAmount()">
                                                </div>
                                                <label class="control-label col-sm-2">Pending Amount₹</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="pending_amt" name="pending_amt" value="{{ old('pending_amt') }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Notes </label>
                                                <div class="col-sm-10">
                                                    <textarea type="text" class="form-control" name="payment_notes">{{ old('payment_notes', $enquiry->payment_notes ?? '') }} </textarea>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-dark" type="submit">Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')

<!-- get state and city dependent list -->
<script>
    $(document).ready(function() {

        var oldStateValue = "{{ old('state') }}";
        var oldCityValue = "{{ old('city') }}";
        // If the old state is set, fetch cities for that state
        if (oldStateValue) {
            populateCities(oldStateValue, oldCityValue);
        }

        // Step 2: Listen for changes in the state dropdown to dynamically fetch cities
        $('#state').on('change', function() {
            var stateId = $(this).val();
            if (stateId) {
                populateCities(stateId); // Fetch cities based on the selected state
            } else {
                // If no state is selected, clear the city dropdown
                $('#city').empty();
                $('#city').append('<option value="" disabled selected>Select City</option>');
            }
        });
    });

    // Function to populate cities based on the selected state
    function populateCities(stateId, selectedCity = null) {
        $.ajax({
            url: "{{ route('get.city') }}", // Ensure this route is correct
            type: "POST",
            dataType: "json",
            data: {
                state_id: stateId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Empty the city dropdown
                $('#city').empty();
                $('#city').append('<option value="" disabled selected>Select City</option>');

                // Populate city options dynamically
                $.each(data, function(key, value) {
                    // Mark the old city as selected if it matches
                    var selected = (selectedCity == value.id) ? 'selected' : '';
                    $('#city').append('<option value="' + value.id + '" ' + selected + '>' + value.city + '</option>');
                });
            }
        });
    }
</script>

<!-- for hide hostel panel if training program beginners -->
<script>
    $(document).ready(function() {
        var validTrainingPrograms = ['Beginners', 'beginners', 'BEGINNERS', 'Beginner', 'beginner'];
        var options = {
            includeScore: true,
            threshold: 0.3,
        };
        var fuse = new Fuse(validTrainingPrograms, options);

        $('#training_program').on('change', function() {
            var selectedOption = $('#training_program option:selected').data('program-name').trim();

            var result = fuse.search(selectedOption);
            var showHostel = true;

            if (result.length > 0 && result[0].score <= 0.3) {
                showHostel = false;
            }

            if (showHostel) {
                $('#hostel_allotment_panel').show();
            } else {
                $('#hostel_allotment_panel').hide();
            }
        });
    });
</script>
<script>
    var oldCityValue = "{{ old('city') }}";
</script>
<!-- phone no validation -->
<script>
    $(document).ready(function() {
        $('.contactInput').on('input', function() {
            var value = $(this).val().replace(/\D/g, '').substring(0, 10);
            $(this).val(value);
        });
    });
    // date of birth not select in future date
    document.getElementById('dobInput').max = new Date().toISOString().split("T")[0];
</script>
<!-- utr no show and hide based on payment method -->
<script>
    $(document).ready(function() {
        $('#payment_method').on('change', function() {
            var paymentMethod = $(this).val();
            if (paymentMethod === '1') {
                $('#utr_no_group').show();
            } else {
                $('#utr_no_group').hide();
            }
        });
    });
</script>

<!-- show training type container if package training program -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const packageSelect = document.getElementById("package");
        const trainingProgramContainer = document.getElementById("trainingProgramContainer");
        const knownPackages = ['Training Program', 'TrainingProgram', 'training program', 'training-program', 'Training Programme', 'Training programme',
            'trainingprogram', 'Training-Program'
        ];
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

<!-- show hostel details if package training program -->
<script>
    $(document).ready(function() {
        var validPackages = ['Training Program'];
        var options = {
            includeScore: true,
            threshold: 0.3,
        };
        var fuse = new Fuse(validPackages, options);
        $('#hostel_allotment_panel').hide();
        $('#package').on('change', function() {
            var selectedPackageName = $('#package option:selected').text().trim();
            var result = fuse.search(selectedPackageName);
            if (result.length > 0 && result[0].score <= 0.3) {
                $('#hostel_allotment_panel').show();
            } else {
                $('#hostel_allotment_panel').hide();
            }
        });
    });
</script>

<!-- hostel and room hide/show -->
<script>
    document.getElementById('room_allotment').addEventListener('change', function() {
        const roomTypeContainer = document.getElementById('room_type_container');
        roomTypeContainer.style.display = this.value === '0' ? 'block' : 'none';
    });
    document.getElementById('meal_subscription').addEventListener('change', function() {
        const mealTypeContainer = document.getElementById('meal_type_container');
        mealTypeContainer.style.display = this.value === '0' ? 'block' : 'none';
    });
    document.getElementById('room_allotment').dispatchEvent(new Event('change'));
    document.getElementById('meal_subscription').dispatchEvent(new Event('change'));
</script>

<!-- next payment date prediction-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const paymentModule = document.getElementById("payment_module");
        const paymentDate = document.getElementById("payment_date");
        const nextPaymentDate = document.getElementById("next_payment_date");

        const validIntervals = [
            'monthly', 'month', 'every month', 'monthly payment', 'monthly subscription',
            'quarterly', 'quarter', 'every quarter', 'quarterly payment', 'quarterly subscription',
            'half-yearly', 'half yearly', 'Half yearly', 'every half year', 'half yearly payment', 'half yearly subscription',
            'annual', 'annually', 'yearly', 'every year', 'annual payment', 'annual subscription', 'yearly payment'
        ];

        // Fuse.js options for fuzzy matching
        const fuse = new Fuse(validIntervals, {
            includeScore: true,
            threshold: 0.3, // Adjust the threshold as needed
        });

        // Event listener for changes to the payment module or payment date
        paymentModule.addEventListener("change", calculateNextPaymentDate);
        paymentDate.addEventListener("change", calculateNextPaymentDate);

        // Function to calculate the next payment date based on the selected module and payment date
        function calculateNextPaymentDate() {
            const selectedModule = paymentModule.options[paymentModule.selectedIndex];
            const paymentInterval = selectedModule.getAttribute("data-interval");
            const paymentDateValue = paymentDate.value;
            const date = new Date(paymentDateValue);

            if (paymentDateValue && paymentInterval) {
                // Perform Fuse.js search to handle fuzzy matching for the payment interval
                const result = fuse.search(paymentInterval);
                const matchedInterval = result.length > 0 ? result[0].item : paymentInterval; // Best match from Fuse.js

                // Perform date calculation based on the matched interval
                switch (matchedInterval.toLowerCase()) {
                    // Monthly variations
                    case 'monthly':
                    case 'month':
                    case 'every month':
                    case 'monthly payment':
                    case 'monthly subscription':
                        date.setMonth(date.getMonth() + 1);
                        break;

                        // Quarterly variations
                    case 'quarterly':
                    case 'Quarterly':
                    case 'quarter':
                    case 'quarter':
                    case 'every quarter':
                    case 'quarterly payment':
                    case 'quarterly subscription':
                    case '3 months':
                    case 'three months':
                        date.setMonth(date.getMonth() + 3);
                        break;

                        // Half-Yearly variations
                    case 'half-yearly':
                    case 'Half-yearly':
                    case 'half yearly':
                    case 'Half Yearly':
                    case 'Half yearly':
                    case 'half-year':
                    case 'every half year':
                    case 'half yearly payment':
                    case 'half yearly subscription':
                    case '6 months':
                    case 'six months':
                        date.setMonth(date.getMonth() + 6);
                        break;

                        // Yearly variations
                    case 'annual':
                    case 'annually':
                    case 'Annually':
                    case 'yearly':
                    case 'Yearly':
                    case 'every year':
                    case 'annual payment':
                    case 'annual subscription':
                    case 'yearly payment':
                    case '12 months':
                    case 'twelve months':
                    case 'Twelve Months':
                    case '1 year':
                    case 'one year':
                    case 'One Year':
                        date.setFullYear(date.getFullYear() + 1);
                        break;

                        // Default case to handle unrecognized intervals
                    default:
                        console.error(`Unrecognized interval: ${matchedInterval}`);
                        return; // Exit the function if no match is found
                }

                // Set the next payment date in the input field
                nextPaymentDate.value = date.toISOString().split("T")[0];
            }
        }
    });
</script>
<!-- total amount -->
<!-- <script>
    function calculateTotal() {
        // Get the values for all fees and treat null or empty as 0
        let registrationFee = parseFloat(document.getElementById('registration_fee').value) || 0;
        let programFee = parseFloat(document.getElementById('program_fee').value) || 0;
        let mealFee = parseFloat(document.getElementById('meal_fee').value) || 0; // Handle meal_fee as 0 if null or empty
        let roomFee = parseFloat(document.getElementById('room_fee').value) || 0; // Handle room_fee as 0 if null or empty

        // Calculate total amount
        let totalAmount = registrationFee + programFee + mealFee + roomFee;

        // Set the total amount in the input field
        document.getElementById('total_amount').value = totalAmount.toFixed(2);

        // Recalculate pending amount every time total changes
        calculatePendingAmount();
    }

    function calculatePendingAmount() {
        const totalAmount = parseFloat(document.getElementById('total_amount').value) || 0; // Ensure total_amount is correctly populated
        const paidAmount = parseFloat(document.getElementById('submitted_amt').value) || 0; // Get the paid amount

        // Calculate pending amount (total - paid)
        const pendingAmount = totalAmount - paidAmount;

        // Set the value of the pending amount field
        document.getElementById('pending_amt').value = pendingAmount >= 0 ? pendingAmount.toFixed(2) : 0;
    }

    // Function to validate decimal input
    function validateDecimal(input) {
        let value = input.value;
        let regex = /^\d*(\.\d{0,2})?$/;

        if (!regex.test(value)) {
            input.value = value.slice(0, -1); // Remove invalid character
        }
    }

    // Initialize pending amount and total amount when the page loads
    window.onload = function() {
        calculateTotal(); // Initialize total amount when page loads
        calculatePendingAmount(); // Initialize pending amount based on any pre-filled values
    };
</script> -->



<script>
    function calculateTotal() {
        let registrationFee = parseFloat(document.getElementById('registration_fee').value) || 0;
        let programFee = parseFloat(document.getElementById('program_fee').value) || 0;
        let mealFee = parseFloat(document.getElementById('meal_fee').value) || 0;
        let roomFee = parseFloat(document.getElementById('room_fee').value) || 0;

        let baseTotal = programFee + mealFee + roomFee; // Excludes registration fee initially

        const paymentModule = document.getElementById("payment_module");
        const selectedModule = paymentModule.options[paymentModule.selectedIndex];
        const paymentInterval = selectedModule.getAttribute("data-interval");

        let multiplier = 1; // Default multiplier for calculation

        if (paymentInterval) {
            switch (paymentInterval.toLowerCase()) {
                case 'monthly':
                case 'month':
                case 'every month':
                case 'monthly payment':
                case 'monthly subscription':
                    multiplier = 1;
                    break;

                case 'quarterly':
                case 'quarter':
                case 'every quarter':
                case 'quarterly payment':
                case 'quarterly subscription':
                    multiplier = 3;
                    break;

                case 'half-yearly':
                case 'half yearly':
                case 'every half year':
                case 'half yearly payment':
                case 'half yearly subscription':
                    multiplier = 6;
                    break;

                case 'annual':
                case 'annually':
                case 'yearly':
                case 'every year':
                case 'annual payment':
                case 'annual subscription':
                    multiplier = 12;
                    break;

                default:
                    console.error(`Unrecognized interval: ${paymentInterval}`);
                    return;
            }
        }

        let totalAmount = baseTotal * multiplier + registrationFee; // Add registration fee only once

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        calculatePendingAmount(); // Update pending amount
    }

    function calculatePendingAmount() {
        const totalAmount = parseFloat(document.getElementById('total_amount').value) || 0;
        const paidAmount = parseFloat(document.getElementById('submitted_amt').value) || 0;
        const pendingAmount = totalAmount - paidAmount;

        document.getElementById('pending_amt').value = pendingAmount >= 0 ? pendingAmount.toFixed(2) : 0;
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("payment_module").addEventListener("change", calculateTotal);
        document.getElementById("registration_fee").addEventListener("input", calculateTotal);
        document.getElementById("program_fee").addEventListener("input", calculateTotal);
        document.getElementById("meal_fee").addEventListener("input", calculateTotal);
        document.getElementById("room_fee").addEventListener("input", calculateTotal);
        document.getElementById("submitted_amt").addEventListener("input", calculatePendingAmount);

        calculateTotal();
    });
</script>

@endsection