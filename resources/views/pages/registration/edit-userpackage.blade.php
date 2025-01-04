@extends('pages.layouts.app')
@section('title')
Fee Management
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

    .image-container {
        position: relative;
        display: inline-block;
    }

    .remove-image-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(255, 255, 255, 0.7);
        border: none;
        color: red;
        font-weight: 900;
        font-size: 18px;
        cursor: pointer;
        z-index: 10;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h3>Update Package</h3>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('registration.list'))
                    <li class="breadcrumb-item"><a href="{{route('registration.list')}}">RegistrationL List</a></li>
                    @endif
                    <li class="breadcrumb-item active">Update Package</li>
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

        <div class="col-lg-12">
            <form class="form-horizontal row" action="{{ route('registration.updateuserpackage',$edit_userpackage->registration_no) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="registration_no" value="{{ $edit_userpackage->registration_no }}" id="">

                <div class="panel-body ">

                    <fieldset>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default shadow">
                                    <div class="panel-heading">
                                        <h5 class="panel-title fw-bold">Package Details</h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2"> Name <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="name" value="{{ $edit_userpackage->name }}" readonly="">
                                            </div>
                                            <label class="form-label col-sm-2">Package <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <select name="package" id="package" class="form-select">
                                                    <option value="" disabled selected>Select Package</option>
                                                    @foreach ($Packages as $Packag)
                                                    <option value="{{ $Packag->package_id }}"
                                                        @if ($edit_userpackage->package == $Packag->package_id) selected @endif>{{ $Packag->package }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div id="training_program_field" class="form-group" style="display: none;">
                                            <label class="form-label col-sm-2">Training Program</label>
                                            <div class="col-sm-10">
                                                <select name="training_program" id="training_program" class="form-select">
                                                    <option value="" disabled selected>Select Training Program</option>
                                                    @foreach ($Training as $Trng)
                                                    <option value="{{ $Trng->program_id }}" data-program-name="{{ $Trng->add_program }}"
                                                        @if ($edit_userpackage->training_program == $Trng->program_id) selected @endif> {{ $Trng->add_program }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label col-sm-2">Session</label>
                                            <div class="col-sm-4">
                                                <select name="session" class="form-select">
                                                    <option value="" disabled selected>Select Session</option>
                                                    @foreach ($session as $sesion)
                                                    <option value="{{ $sesion->session_id }}"
                                                        @if ($edit_userpackage->session == $sesion->session_id) selected @endif>{{ $sesion->session}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <label class="form-label col-sm-2">Time Slot</label>
                                            <div class="col-sm-4">
                                                <select name="time_slot" class="form-select">
                                                    <option value="" disabled selected>Select Time Slot</option>
                                                    @foreach ($Timing as $Time)
                                                    <option value="{{ $Time->timing_id }}"
                                                        @if ($edit_userpackage->time_slot == $Time->timing_id) selected @endif>{{ $Time->time_slot}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2">Package Fee ₹</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="program_fee" name="program_fee" value="{{ $edit_userpayment->program_fee}}" oninput="validateDecimal(this); calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2">Notes</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="payment_notes">{{ $edit_payment->payment_notes  ?? '' }}</textarea>
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


@endsection

@section('js')
<!-- get state and city dependent dynamic -->
<script>
    $(document).ready(function() {
        $('#state').on('change', function() {
            var stateId = $(this).val();
            if (stateId) {
                $.ajax({
                    url: "{{ route('get.city') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        state_id: stateId
                    },

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#city').empty();
                        $('#city').append(
                            '<option value="" disabled selected>Select City</option>');
                        $.each(data, function(key, value) {
                            $('#city').append('<option value="' + value.id + '">' +
                                value.city + '</option>');
                        });

                    }
                });
            }
        });
    });
</script>
<!-- validation for phone and dob -->
<script>
    $(document).ready(function() {
        $('.contactInput').on('input', function() {
            var value = $(this).val().replace(/\D/g, '').substring(0, 10);
            $(this).val(value);
        });
    });
    // registrict future select date
    document.getElementById('dobInput').max = new Date().toISOString().split("T")[0];
</script>

<!-- show hide payment fee and utr -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethod = document.getElementById('payment_method');
        const utrFieldGroup = document.getElementById('utr_no_group');
        const utrField = document.querySelector('input[name="utr_no"]');
        paymentMethod.addEventListener('change', function() {
            if (this.value === '0') {
                utrFieldGroup.style.display = 'none';
                utrField.value = '';
            } else if (this.value === '1') {
                utrFieldGroup.style.display = 'block';
            }
        });
        paymentMethod.dispatchEvent(new Event('change'));
    });
</script>
<!-- i package training program show training type field -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const packageSelect = document.getElementById("package");
        const trainingProgramField = document.getElementById("training_program_field");
        const knownPackages = ['Training Program', 'TrainingProgram', 'training program', 'training-program', 'Training Programme', 'Training programme', 'trainingprogram', 'Training-Program'];

        // Fuse.js options
        const options = {
            includeScore: true,
            threshold: 0.3,
        };
        const fuse = new Fuse(knownPackages, options);

        // Check the pre-selected value on page load
        const selectedText = packageSelect.options[packageSelect.selectedIndex].text.trim();
        const result = fuse.search(selectedText);
        let showTrainingProgram = false;
        for (let i = 0; i < result.length; i++) {
            if (result[i].item.toLowerCase() === 'training program') {
                showTrainingProgram = true;
                break;
            }
        }
        // Show or hide the Training Program field based on the selection
        if (showTrainingProgram) {
            trainingProgramField.style.display = "block";
        } else {
            trainingProgramField.style.display = "none";
        }

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
                trainingProgramField.style.display = "block";
            } else {
                trainingProgramField.style.display = "none";
            }
        });
    });
</script>

<!-- if package trraining program show hostel details -->
<script>
    $(document).ready(function() {

        var validPackages = ['Training Program'];
        // Fuse.js configuration
        var options = {
            includeScore: true,
            threshold: 0.3,
        };
        var fuse = new Fuse(validPackages, options);
        // Function to toggle the hostel allotment panel
        function toggleHostelAllotmentPanel() {
            var selectedPackageName = $('#package option:selected').text().trim();
            var result = fuse.search(selectedPackageName);

            if (result.length > 0 && result[0].score <= 0.3) {
                $('#hostel_allotment_panel').show();
            } else {
                $('#hostel_allotment_panel').hide();
            }
        }
        toggleHostelAllotmentPanel();

        $('#package').on('change', function() {
            toggleHostelAllotmentPanel();
        });

        $('#room_allotment').on('change', function() {
            if ($(this).val() === '0') {
                $('#room_type_container').show();
            } else {
                $('#room_type_container').hide();
            }
        }).trigger('change');

        // Additional logic to handle meal type visibility
        $('#meal_subscription').on('change', function() {
            if ($(this).val() === '0') {
                $('#meal_type_container').show();
            } else {
                $('#meal_type_container').hide();
            }
        }).trigger('change');
    });
</script>

<!-- remove profile image -->
<script>
    function removeImage() {
        document.getElementById('remove_image').value = '1';
        document.querySelector('.mt-2').style.display = 'none';
    }
</script>
<!-- calculate next payment date based payment module -->
<script>
    $(document).ready(function() {
        // Initialize Fuse.js with possible variations for each payment module (monthly, quarterly, half-yearly, annually, etc.)
        var validIntervals = [
            'Monthly', 'monthly', 'Month', 'month', 'Every Month', 'Every month', // Monthly variations
            'Quarterly', 'quarterly', 'Quarter', 'quarter', 'Every Quarter', 'Every quarter', // Quarterly variations
            'Half-Yearly', 'half-yearly', 'Half Yearly', 'half yearly', 'Every Half Year', 'every half year', // Half-Yearly variations
            'Annually', 'annually', 'Annual', 'annual', 'Yearly', 'yearly', 'Every Year', 'every year' // Annual variations
        ]; // Add more variations if needed

        var options = {
            includeScore: true,
            threshold: 0.3,
        };

        var fuse = new Fuse(validIntervals, options);
        // Listen for changes in the payment module dropdown
        $('#payment_module').on('change', function() {
            var selectedOption = $('#payment_module option:selected');
            var interval = selectedOption.data('interval');
            var paymentDate = $('#payment_date').val();
            // If payment date is not selected, return
            if (!paymentDate) {
                return;
            }
            // Perform Fuse.js search for the interval to handle variations like "Yearly" and "Annually"
            var result = fuse.search(interval);
            var matchedInterval = result.length > 0 ? result[0].item : interval;

            // Calculate the next payment date based on the selected (or matched) interval
            var nextPaymentDate = calculateNextPaymentDate(paymentDate, matchedInterval);

            // Set the next payment date in the input field
            $('#next_payment_date').val(nextPaymentDate);
        });

        // Function to calculate the next payment date based on the interval
        function calculateNextPaymentDate(paymentDate, interval) {
            var paymentDateObj = new Date(paymentDate);
            var nextPaymentDate = new Date(paymentDateObj);
            switch (interval.toLowerCase()) {
                case 'monthly':
                case 'month':
                case 'every month':
                    nextPaymentDate.setMonth(paymentDateObj.getMonth() + 1);
                    break;
                case 'quarterly':
                case 'quarter':
                case 'every quarter':
                    nextPaymentDate.setMonth(paymentDateObj.getMonth() + 3);
                    break;
                case 'half-yearly':
                case 'half yearly':
                case 'every half year':
                    nextPaymentDate.setMonth(paymentDateObj.getMonth() + 6);
                    break;
                case 'annually':
                case 'annual':
                case 'yearly':
                case 'every year':
                    nextPaymentDate.setFullYear(paymentDateObj.getFullYear() + 1);
                    break;
                default:
                    break;
            }

            // Return the next payment date in YYYY-MM-DD format
            return nextPaymentDate.toISOString().split('T')[0];
        }
        // Trigger change on page load to initialize the next payment date
        $('#payment_module').trigger('change');
    });
</script>

<script>
    // Function to calculate the total amount
    function calculateTotal() {
        // Retrieve fee values, default to 0 if empty or invalid
        const registrationFee = parseFloat(document.getElementById('registration_fee').value) || 0;
        const programFee = parseFloat(document.getElementById('program_fee').value) || 0;
        const mealFee = parseFloat(document.getElementById('meal_fee').value) || 0;
        const roomFee = parseFloat(document.getElementById('room_fee').value) || 0;

        // Calculate total
        const totalAmount = registrationFee + programFee + mealFee + roomFee;

        // Update total amount input field with 2 decimal places
        document.getElementById('total_amount').value = totalAmount.toFixed(2);
    }

    // Function to validate decimal input
    function validateDecimal(input) {
        const value = input.value;
        const regex = /^\d*(\.\d{0,2})?$/;

        // Remove the last character if it doesn't match the regex
        if (!regex.test(value)) {
            input.value = value.slice(0, -1);
        }
    }

    // Event listeners for real-time calculation and validation
    document.addEventListener('DOMContentLoaded', function() {
        // Input fields
        const fields = ['registration_fee', 'program_fee', 'meal_fee', 'room_fee'];

        // Calculate total on page load (for prefilled fields)
        calculateTotal();

        // Add event listeners for keyup and input events
        fields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                // Calculate total on input
                element.addEventListener('input', calculateTotal);

                // Validate decimal input on input
                element.addEventListener('input', function() {
                    validateDecimal(element);
                });
            }
        });
    });
</script>
<!-- hide hostel details based on training type Beginners -->
<script>
    $(document).ready(function() {
        var validTrainingPrograms = ['Beginners', 'beginners', 'BEGINNERS', 'Beginner', 'beginner'];
        var options = {
            includeScore: true,
            threshold: 0.3,
        };
        var fuse = new Fuse(validTrainingPrograms, options);
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


@endsection