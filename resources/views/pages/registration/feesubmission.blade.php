@extends('pages.layouts.app')
@section('title')
Submit Fees
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
                <h3>Fee Submission</h3>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('registration.list'))
                    <li class="breadcrumb-item"><a href="{{route('registration.list')}}">RegistrationL List</a></li>
                    @endif
                    <li class="breadcrumb-item active">Fee Submit</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">

    <div class="container-fluid py-3">
        <div class="row mt-4">
            <div class="col-lg-12">
                <form class="form-horizontal row" action="{{ route('registration.update.feesubmission',$submit_fee->registration_no) }}" method="POST">
                    @csrf
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
                    <input type="hidden" name="registration_no" value="{{ $submit_fee->registration_no }}" id="">
                    <div class="panel-body ">
                        <fieldset>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default shadow">
                                        <div class="panel-heading">
                                            <h5 class="panel-title fw-bold">Payment Details</h5>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-sm-2"> Name <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="name" value="{{ $submit_fee->name}}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Payment Module</label>
                                                <div class="col-sm-4">
                                                    <select name="payment_module" id="payment_module" class="form-select">
                                                        <option value="" selected disabled>Select Payment Module</option>
                                                        @foreach ($pmodules as $pmodule)
                                                        <option value="{{ $pmodule->module_id }}"
                                                            data-interval="{{ $pmodule->module }}"
                                                            {{ old('payment_module') == $pmodule->module_id ? 'selected' : '' }}>
                                                            {{ $pmodule->module }}
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
                                                        <option value="" disabled selected>Select Payment Method</option>
                                                        <option value="0" {{ old('payment_method') == '0' ? 'selected' : '' }}>Offline</option>
                                                        <option value="1" {{ old('payment_method') == '1' ? 'selected' : '' }}>Online</option>
                                                    </select>
                                                </div>

                                                <div id="utr_no_group" style="display: none;">
                                                    <label class="control-label col-sm-2">UTR No.</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control numericInput" name="utr_no" value="{{ old('utr_no') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fees Fields -->
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Transport Fee ₹</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="transport_fees" name="transport_fees" value="{{ old('transport_fees') }}"
                                                        oninput="calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                                </div>

                                                <label class="control-label col-sm-2">Hostel Fee ₹ </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="rooms_fees" name="rooms_fees" value="{{ old('rooms_fees') }}"
                                                        oninput="calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Meal Fee ₹ </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="meals_fees" name="meals_fees" value="{{ old('meals_fees') }}"
                                                        oninput="calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                                </div>

                                                <label class="control-label col-sm-2">Category Fee ₹</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="program_fee" name="program_fee" value="{{ old('program_fee') }}"
                                                        oninput="calculateTotal()" pattern="^\d*(\.\d{0,2})?$">
                                                </div>
                                            </div>

                                            <!-- Total Calculation -->
                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Total Amount ₹ <span class="text-danger">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="total_amount" name="total_amt" value="{{ old('total_amt') }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Paid Amount ₹ <span class="text-danger">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="submitted_amt" name="submitted_amt" value="{{ old('submitted_amt') }}"
                                                        oninput="calculatePendingAmount()">
                                                </div>

                                                <label class="control-label col-sm-2">Pending Amount ₹</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="pending_amt" name="pending_amt" value="{{ old('pending_amt') }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2">Notes </label>
                                                <div class="col-sm-10">
                                                    <textarea type="text" class="form-control" name="payment_notes">{{ old('payment_notes') }}</textarea>
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
<script>
    function calculateTotal() {
        let programFee = parseFloat(document.getElementById('program_fee').value) || 0;
        let mealFee = parseFloat(document.getElementById('meals_fees').value) || 0;
        let roomFee = parseFloat(document.getElementById('rooms_fees').value) || 0;
        let transportFee = parseFloat(document.getElementById('transport_fees').value) || 0;

        // Get selected payment module interval
        const paymentModule = document.getElementById("payment_module");
        const selectedModule = paymentModule.options[paymentModule.selectedIndex];
        const paymentInterval = selectedModule ? selectedModule.getAttribute("data-interval") : "monthly";

        let multiplier = 1; // Default is monthly (1 month)

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
                case 'halfyearly':
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
                    console.warn(`Unknown interval: ${paymentInterval}`);
                    multiplier = 1;
            }
        }

        // Multiply ALL fees by the payment module interval
        let totalAmount = (programFee + mealFee + roomFee + transportFee) * multiplier;

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        calculatePendingAmount(); // Update pending amount
    }

    function calculatePendingAmount() {
        const totalAmount = parseFloat(document.getElementById('total_amount').value) || 0;
        const paidAmount = parseFloat(document.getElementById('submitted_amt').value) || 0;
        const pendingAmount = totalAmount - paidAmount;

        document.getElementById('pending_amt').value = pendingAmount >= 0 ? pendingAmount.toFixed(2) : "0.00";
    }

    document.addEventListener("DOMContentLoaded", function() {
        calculateTotal(); // Initial calculation
        document.getElementById("payment_module").addEventListener("change", calculateTotal);
        document.getElementById("program_fee").addEventListener("input", calculateTotal);
        document.getElementById("meals_fees").addEventListener("input", calculateTotal);
        document.getElementById("rooms_fees").addEventListener("input", calculateTotal);
        document.getElementById("transport_fees").addEventListener("input", calculateTotal);
        document.getElementById("submitted_amt").addEventListener("input", calculatePendingAmount);
    });
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
<!-- next payment date prediction-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const paymentModule = document.getElementById("payment_module");
        const paymentDate = document.getElementById("payment_date");
        const nextPaymentDate = document.getElementById("next_payment_date");


        const validIntervals = [
            'monthly', 'month', 'every month', 'monthly payment', 'monthly subscription',
            'quarterly', 'quarter', 'every quarter', 'quarterly payment', 'quarterly subscription',
            'half-yearly', 'half yearly', 'every half year', 'half yearly payment', 'half yearly subscription',
            'annual', 'annually', 'yearly', 'every year', 'annual payment', 'annual subscription', 'yearly payment'
        ];

        const fuse = new Fuse(validIntervals, {
            includeScore: true,
            threshold: 0.3,
        });

        function calculateNextPaymentDate() {
            const selectedModule = paymentModule.options[paymentModule.selectedIndex];
            const paymentInterval = selectedModule.getAttribute("data-interval");
            const paymentDateValue = paymentDate.value;

            if (!paymentDateValue || !paymentInterval) {
                console.warn("Payment date or interval is missing");
                return;
            }

            let date = new Date(paymentDateValue);
            if (isNaN(date.getTime())) {
                return;
            }

            const result = fuse.search(paymentInterval);
            const matchedInterval = result.length > 0 ? result[0].item.toLowerCase() : paymentInterval.toLowerCase();

            switch (matchedInterval) {
                case 'monthly':
                case 'month':
                case 'every month':
                case 'monthly payment':
                case 'monthly subscription':
                    date.setMonth(date.getMonth() + 1);
                    break;

                case 'quarterly':
                case 'quarter':
                case 'every quarter':
                case 'quarterly payment':
                case 'quarterly subscription':
                case '3 months':
                case 'three months':
                    date.setMonth(date.getMonth() + 3);
                    break;

                case 'half-yearly':
                case 'half yearly':
                case 'halfyearly':
                case 'every half year':
                case 'half yearly payment':
                case 'half yearly subscription':
                case '6 months':
                case 'six months':
                    date.setMonth(date.getMonth() + 6);
                    break;

                case 'annual':
                case 'annually':
                case 'yearly':
                case 'every year':
                case 'annual payment':
                case 'annual subscription':
                case 'yearly payment':
                case '12 months':
                case 'twelve months':
                case '1 year':
                case 'one year':
                    date.setFullYear(date.getFullYear() + 1);
                    break;

                default:
                    console.error(`Unrecognized interval: ${matchedInterval}`);
                    return;
            }

            const formattedDate = date.toISOString().split("T")[0];
            console.log("Next Payment Date:", formattedDate);
            nextPaymentDate.value = formattedDate;
        }

        paymentModule.addEventListener("change", calculateNextPaymentDate);
        paymentDate.addEventListener("change", calculateNextPaymentDate);
    });
</script>
@endsection