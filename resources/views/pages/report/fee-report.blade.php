@extends('pages.layouts.app')
@section('title')
Dashboard
@endsection

@section('css')
<style>
    .count-title {
        background: #FFF;
        border-radius: 5px;
        box-shadow: 0 1px 2px rgba(154, 161, 171, .25);
        padding: 20px 10px;
    }

    .count-title .count-number {
        font-size: 1.5em;
        margin-top: 17px;
    }

    a {
        color: #7c5cc4;
        text-decoration: none;
    }
</style>

@endsection
@php
use Carbon\Carbon;

// Create an array with all months
$months = [];
for ($i = 1; $i <= 12; $i++) {
    $months[]=Carbon::create()->month($i)->format('F');
    }

    @endphp
    @section('content')

    <div class="container-fluid ">
        <h3 class="my-4">Fee Report</h3>
        <div class="row ">
            <div class="col-md-12 col-sm-12">
                <div class="card" id="filterForm">
                    <div class="card-header bg-light p-1">
                        <h6 class="fw-blod mt-2"> Search Fee Report Collection</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group mb-3">
                                        <select id="applyFor" name="registration_no" class="form-select form-control" aria-label="Default select example">
                                            <option selected disabled>Filter by Registration No</option>
                                            @foreach ($registrations as $registration)
                                            <option value="{{ $registration->registration_no }}"
                                                @if (old('registration_no')==$registration->registration_no || request()->get('registration_no') == $registration->registration_no) selected @endif>
                                                {{ $registration->registration_no }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group mb-3">
                                        <select id="applyFor" name="registration_no" class="form-select form-control" aria-label="Default select example">
                                            <option selected disabled>Filter by User Name</option>
                                            @foreach ($registrations as $registration)
                                            <option value="{{ $registration->registration_no }}"
                                                @if (old('registration_no')==$registration->registration_no) selected @endif>
                                                {{ $registration->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group mb-3">
                                        <select name="month" class="form-select form-control">
                                            <option value="" disabled selected>Filter by Month</option>
                                            @foreach ($months as $month)
                                            <option value="{{ $month }}" @if(request()->get('month') == $month) selected @endif>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group mb-3">
                                        <select name="year" class="form-select form-control">
                                            <option value="" disabled selected>Filter by Year</option>
                                            @for ($year = 2024; $year <= date('Y') + 1; $year++)
                                                <option value="{{ $year }}" @if(request()->get('year') == $year) selected @endif>{{ $year }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group mb-3">
                                        <select id="paymentStatus" name="payment_status" class="form-select form-control">
                                            <option value="" disabled selected>Filter by Payment Status</option>
                                            <option value="0" @if(request()->get('payment_status') === '0') selected @endif>Success</option>
                                            <option value="1" @if(request()->get('payment_status') === '1') selected @endif>Due</option>
                                            <option value="2" @if(request()->get('payment_status') === '2') selected @endif>Pending</option>
                                            <option value="3" @if(request()->get('payment_status') === '3') selected @endif>Failed</option>
                                            <option value="4" @if(request()->get('payment_status') === '4') selected @endif>Refunded</option>
                                            <option value="5" @if(request()->get('payment_status') === '5') selected @endif>Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 justify-content-end">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    </div>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='{{ route('report.feecollection') }}'">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <table id="example1" class="table dataTable table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reg.No.</th>
                                    <th>Name</th>
                                    <th>Total Amount</th>
                                    <th>paid</th>
                                    <th>Pending</th>
                                    <th>Status</th>
                                    <!-- <th>Method</th> -->
                                    <th>Mobile</th>
                                    <th>Due Date</th>
                                    <th>Upcoming Date</th>
                                    <th>Joining Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                <tr class="">
                                    <th>{{ $loop->iteration }}</th>

                                    <td>
                                        {{ $row->registration_no}}
                                    </td>
                                    <td>
                                        {{ $row->Registration->name ?? '' }}
                                    </td>
                                    <td>
                                        <div>{{$row->total_amt}} </div>
                                    </td>
                                    <td>
                                        <div>{{$row->submitted_amt}} </div>
                                    </td>
                                    <td>
                                        <div>{{$row->pending_amt}} </div>
                                    </td>

                                    <td>
                                        @php
                                        $statusMap = [
                                        '0' => 'Success',
                                        '1' => 'Due',
                                        '2' => 'Pending',
                                        '3' => 'Failed',
                                        '4' => 'Refunded',
                                        '5' => 'Cancelled',
                                        ];

                                        $status = $row->payment_status ?? null; // Ensure payment_status is available
                                        @endphp

                                        {{ $statusMap[$status] ?? 'Unknown' }}
                                    </td>
                                    <!-- <td>
                                        @php
                                        $methodMap = [
                                        '0' => 'Offline',
                                        '1' => 'Online',
                                        ];

                                        $method = $row->payment_method ?? null; // Ensure payment_method is available
                                        @endphp

                                        {{ $methodMap[$method] ?? 'Unknown' }}
                                    </td> -->
                                    <td>
                                        <div>{{$row->Registration->phone}} </div>
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($row->updated_at)->format('d/m/y') }}</div>
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($row->upcoming_date)->format('d/m/y') }}</div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ optional($row->Registration)->date ? \Carbon\Carbon::parse($row->Registration->date)->format('d/m/y') : 'N/A' }}
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @section('js')
    <script>
        document.querySelector('.toggle-form').addEventListener('click', function(e) {
            e.preventDefault();

            var formSection = document.getElementById('filterForm');

            if (formSection.style.display === 'none' || formSection.style.display === '') {
                formSection.style.display = 'block';
            } else {
                formSection.style.display = 'none';
            }
        });
    </script>
    @endsection