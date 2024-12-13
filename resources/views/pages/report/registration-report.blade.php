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

@section('content')


<div class="container-fluid py-3">
    <h3 class="my-4">Registration Report</h3>

    <div class="row mt-4">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title mb-0">
                        <i class="ion ion-clipboard mr-2"></i>Registration Report
                    </h3>

                </div>
                <div class="card-body">
                    <table id="example1" class="table dataTable table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Package</th>
                                <th>Payment Status</th>
                                <th>Payment Method</th>
                                <th>Registration Fee</th>
                                <th>Utr No</th>
                                <th>Created Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr class="">
                                <th>{{ $loop->iteration }}</th>

                                <td>
                                    <div class="d-flex">
                                        <div class="mr-2">
                                            <img src="{{ $row->image && file_exists(public_path('player/' . $row->image)) ? asset('player/' . $row->image) : asset('assets/images/noimages.png') }}" class="rounded-circle" style="height:35px;width:35px">

                                        </div>
                                        <div>
                                            <span><a href="#" class="d-block text-bold" style="color:#24ABF2">{{$row->name}}</a></span>
                                            <span>Reg.No. {{$row->registration_no}}</span><br>

                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span>Package: {{$row->Packages!=null ? $row->Packages->package : '' }} </span><br>

                                    </div>
                                </td>

                                <td>
                                    @php
                                    $statusLabels = [
                                    '0' => ['Success', 'badge-success'],
                                    '1' => ['Due', 'badge-warning'],
                                    '2' => ['Pending', 'badge-info'],
                                    '3' => ['Failed', 'badge-danger'],
                                    '4' => ['Refunded', 'badge-secondary'],
                                    '5' => ['Cancelled', 'badge-dark'],
                                    ];
                                    $status = $row->PaymentDetail->payment_status ?? null;
                                    @endphp
                                    <span class="badge {{ $statusLabels[$status][1] ?? 'badge-light' }}">
                                        {{ $statusLabels[$status][0] ?? 'Unknown' }}
                                    </span>
                                </td>

                                <td>
                                    @php
                                    $statusLabels = [
                                    '0' => ['Offline', 'badge-info'], // Offline Payment
                                    '1' => ['Online', 'badge-success'], // Online Payment
                                    'unknown' => ['Unknown', 'badge-light'], // Default for unknown
                                    ];
                                    $paymentMethod = $row->PaymentDetail->payment_method ?? 'unknown'; // Default to 'unknown'
                                    @endphp
                                    <span class="badge {{ $statusLabels[$paymentMethod][1] ?? 'badge-light' }}">
                                        {{ $statusLabels[$paymentMethod][0] ?? 'Unknown' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $row->PaymentDetail->registration_fees}}
                                </td>
                                <td>
                                    {{ $row->PaymentDetail->utr_no}}
                                </td>
                                <td>
                                    {{ $row->PaymentDetail->date}}
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

@endsection