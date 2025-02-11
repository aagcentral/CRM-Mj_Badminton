@extends('pages.layouts.app')
@section('title')
Profile
@endsection

@section('css')
<style>
    .not-available {
        color: red;
    }
</style>
@endsection

@section('content')

<div class="container-fluid py-3">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-12">
                    <h4>Registration Details</h4>
                </div>
                <div class="col-md-6 col-sm-12">
                    <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                        @if(havePermission('registration.list'))
                        <li class="breadcrumb-item"><a href="{{route('registration.list')}}">Registration List</a></li>
                        @endif
                        <li class="breadcrumb-item active">Registration Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card h-100 mb-3">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <div class="text-center">
                            <img class="rounded-circle border img-fluid" src="{{ $viewdata->image && file_exists(public_path('player/' . $viewdata->image)) ? asset('player/' . $viewdata->image) : asset('assets/images/noimages.png') }}">
                        </div>

                        <h3 class="profile-username text-center mt-2 m-0 p-0">
                            {{ isset($viewdata) && $viewdata->name ? $viewdata->name : 'N/A' }}
                        </h3>

                        <p class="text-muted text-center m-0 p-0">
                            @if($viewdata->gender === '0') Male
                            @elseif($viewdata->gender === '1') Female
                            @elseif($viewdata->gender === '2') Other
                            @else N/A
                            @endif
                        </p>

                        <table class="table table-sm mt-3">
                            <tbody>
                                <tr>
                                    <td>Phone No</td>
                                    <td>{{$viewdata->phone}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{$viewdata->email}}</td>
                                </tr>
                                <tr>
                                    <td>Category </td>
                                    <td>{{$viewdata->Packages!=null ? $viewdata->Packages->package : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Time Slot</td>
                                    <td>{{ $viewdata->Time!=null ? $viewdata->Time->time_slot : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Joining Date</td>
                                    <td>{{ $viewdata->date }} </td>
                                </tr>


                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

            <div class="col-xl-8">

                <div class="card h-100 mb-3">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">Personal Details</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" tabindex="-1" role="tab"> Category Details</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings" aria-selected="false" tabindex="-1" role="tab">Hostel Details</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" aria-selected="false" tabindex="-1" role="tab">Payment Details</button>
                            </li>

                        </ul>
                        <div class="tab-content p-3">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div></br>
                                    <div class="col-lg-9 col-md-8"> {{$viewdata->name}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">DOB</div>
                                    <div class="col-lg-9 col-md-8"> {{ $viewdata->dob }} </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Gender</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if($viewdata->gender === '0') Male
                                        @elseif($viewdata->gender === '1') Female
                                        @elseif($viewdata->gender === '2') Other
                                        @else N/A
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone Number</div>
                                    <div class="col-lg-9 col-md-8">{{$viewdata->phone}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{$viewdata->email}} </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">State</div>
                                    <div class="col-lg-9 col-md-8">{{getStateName($viewdata->state)}} </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">City</div>
                                    <div class="col-lg-9 col-md-8">{{ getCityName($viewdata->city) }} </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Pincode</div>
                                    <div class="col-lg-9 col-md-8">{{$viewdata->pincode}} </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">{{ $viewdata->address}}, {{ getCityName($viewdata->city)}}, {{ getStateName($viewdata->state)}}, {{ $viewdata->pincode}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Lead Source</div>
                                    <div class="col-lg-9 col-md-8">{{$viewdata->leads!=null ? $viewdata->leads->leadsource : '' }}</div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">
                                <div class="col-md-12 col-sm-12 m-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="example1" class="table dataTable table-hover">
                                                <thead>
                                                    <tr class="">
                                                        <th>Category</th>
                                                        <th>Training Type</th>
                                                        <th>Session</th>
                                                        <th>Time Slot</th>
                                                        <th>Fee</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($UserPackages as $row)
                                                    <tr>
                                                        <td>{{$row->Trackerpackage!=null ? $row->Trackerpackage->package : '' }}</td>
                                                        <td> {!! $row->Traintype != null ? $row->Traintype->add_program : '<span class="text-danger">N/A</span>' !!}</td>
                                                        <td>{{ $row->Trackersession!=null ? $row->Trackersession->session : 'N/A' }}</td>
                                                        <td>{{ $row->Trackerslot!=null ? $row->Trackerslot->time_slot : 'N/A' }}</td>
                                                        <td>{{ $row->package_fee }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($row->date)->format('d/m/y') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade pt-3" id="profile-settings" role="tabpanel">


                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label ">Hostel Allotment</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if($viewdata->room_allotment === '0') Yes
                                        @elseif($viewdata->room_allotment === '1') No
                                        @else N/A
                                        @endif
                                    </div>
                                </div>


                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Room Type</div>
                                    <div class="col-lg-9 col-md-8">{{ $viewdata->rooms!=null ? $viewdata->rooms->room_type : 'N/A' }} </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Room Fee</div>
                                    <div class="col-lg-9 col-md-8">
                                        {!! $viewpayment->rooms_fees ?? '<span class="text-danger">N/A</span>' !!}
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Meal Subscription</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if($viewdata->meal_subscription === '0') Yes
                                        @elseif($viewdata->meal_subscription === '1') No
                                        @else N/A
                                        @endif

                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Meal Type</div>
                                    <div class="col-lg-9 col-md-8">{{ $viewdata->meals!=null ? $viewdata->meals->meal_type : 'N/A' }} </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Meal Fee</div>
                                    <div class="col-lg-9 col-md-8">
                                        {!! $viewpayment->meals_fees ?? '<span class="text-danger">N/A</span>' !!}
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Checking Date</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ $viewdata->checking_date ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Checkout Date</div>
                                    <div class="col-lg-9 col-md-8">

                                        {{ $viewdata->checkout_date ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Notes</div>
                                    <div class="col-lg-9 col-md-8">{{$viewdata->notes ?? 'N/A'}}</div>
                                </div>

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Payment Method</div>
                                    <div class="col-lg-3 col-md-8">

                                        @if($viewpayment)
                                        @if($viewpayment->payment_method === '0') Offline
                                        @elseif($viewpayment->payment_method === '1') Online
                                        @else N/A @endif
                                        @else Payment information N/A @endif

                                    </div>

                                    <div class="col-lg-3 col-md-4 label">Registration Fee</div>
                                    <div class="col-lg-3 col-md-8">
                                        {{ $viewpayment?->registration_fees ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Payment Status</div>
                                    <div class="col-lg-3 col-md-8">
                                        @if(optional($viewpayment)->payment_status === '0')
                                        <span style="color: green;">Success</span>
                                        @elseif(optional($viewpayment)->payment_status === '1')
                                        <span style="color: orange;">Due</span>
                                        @elseif(optional($viewpayment)->payment_status === '2')
                                        <span style="color: blue;">Pending</span>
                                        @elseif(optional($viewpayment)->payment_status === '3')
                                        <span style="color: red;">Failed</span>
                                        @elseif(optional($viewpayment)->payment_status === '4')
                                        <span style="color: purple;">Refunded</span>
                                        @elseif(optional($viewpayment)->payment_status === '5')
                                        <span style="color: gray;">Cancelled</span>
                                        @else
                                        <span style="color: black;">N/A</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-3 col-md-4 label">Category Fee</div>
                                    <div class="col-lg-3 col-md-8">
                                        {{ $viewpayment?->program_fee ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Payment Module</div>
                                    <div class="col-lg-3 col-md-8"> {{$viewpayment->paymentmodule!=null ? $viewpayment->paymentmodule->module : 'N/A' }}</div>
                                    <div class="col-lg-3 col-md-4 label">Total Amount</div>
                                    <div class="col-lg-3 col-md-8">
                                        {{ $viewpayment?->total_amt ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Payment Date</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ $viewdata->payment_date ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Next Payment Date</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ $viewdata->upcoming_date ?? 'N/A' }}
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">UTR No</div>
                                    <div class="col-lg-9 col-md-8">{{$viewpayment->utr_no ?? 'N/A' }} </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Notes</div>
                                    <div class="col-lg-9 col-md-8">{{$viewpayment->payment_notes ?? 'N/A' }} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">

            <div class="col-md-12 col-sm-12 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mt-2 text-dark">Player Payment Activity</h6>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table dataTable table-hover">
                            <thead>
                                <tr class="">
                                    <th>Name</th>
                                    <th>Payment Method</th>
                                    <th>Due Date</th>
                                    <th>Upcoming Date</th>
                                    <th>Total Amount</th>
                                    <th>Submitted</th>
                                    <th>Pending</th>
                                    <th>Payment status</th>

                                </tr>

                            </thead>
                            <tbody>

                                @forelse($viewdata->registerStatusTracker as $row)

                                <tr class="">
                                    <td>{{$row->registration->name}}</td>
                                    <td>
                                        @if($row)
                                        @if($row->payment_method === '0') Offline
                                        @elseif($row->payment_method === '1') Online
                                        @else N/A @endif
                                        @else Payment information N/A @endif
                                    </td>
                                    <td>{{\Carbon\Carbon::parse($row->updated_at)->format('d/m/y') ?? 'N/A'}} </td>
                                    <td>{{\Carbon\Carbon::parse($row->upcoming_date)->format('d/m/y') ?? 'N/A'}} </td>
                                    <td>{{ $row->total_amt }} </td>
                                    <td>{{ $row->submitted_amt }}</td>
                                    <td>{{ $row->pending_amt }}</td>
                                    <td>
                                        @if(optional($row)->payment_status === '0')
                                        <span style="color: green;">Success</span>
                                        @elseif(optional($row)->payment_status === '1')
                                        <span style="color: orange;">Due</span>
                                        @elseif(optional($row)->payment_status === '2')
                                        <span style="color: blue;">Pending</span>
                                        @elseif(optional($row)->payment_status === '3')
                                        <span style="color: red;">Failed</span>
                                        @elseif(optional($row)->payment_status === '4')
                                        <span style="color: purple;">Refunded</span>
                                        @elseif(optional($row)->payment_status === '5')
                                        <span style="color: gray;">Cancelled</span>
                                        @else
                                        <span style="color: black;">N/A</span>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@section('js')
@endsection