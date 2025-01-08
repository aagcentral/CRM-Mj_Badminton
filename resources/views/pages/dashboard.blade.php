@extends('pages.layouts.app')
@section('title','Dashboard')
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
@section('content')
<div class="container-fluid py-3">
    <h3 class="my-4"> Dashboard</h3>
    <div class="row">

        <div class="col-sm-3">
            <div class="card text-center shadow-sm p-3 mb-3">
                <a href="#" class="text-decoration-none">
                    <div class="name mb-2">
                        <strong class="text-danger">Total Players</strong>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="icon rounded-circle bg-light p-3 me-3">
                            <i class="bi bi-people fs-4 text-danger"></i>
                        </div>
                        <div class="count-number employee-count fs-4 text-danger">
                            {{ $totalregistration }}
                        </div>
                    </div>
                </a>
            </div>
        </div>



        <div class="col-sm-3">
            <div class="card text-center shadow-sm p-3">
                <a href="#" class="text-decoration-none">
                    <div class="name mb-2">
                        <strong class="text-success">Total Lead</strong>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="icon rounded-circle bg-light p-3 me-3 text-success">
                            <i class="fa-solid fa-headset fs-4"></i>
                        </div>
                        <div class="text-success employee-count fs-4">
                            {{ $totallead }}
                        </div>
                    </div>
                </a>

            </div>
        </div>

        <div class="col-sm-3">
            <div class="card text-center shadow-sm p-3">
                <a href="#" class="text-decoration-none">
                    <div class="name mb-2">
                        <strong class="text-dark">All Registration</strong>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="icon rounded-circle bg-light p-3 me-3">
                            <i class="bi bi-person-check text-dark fs-4"></i>
                        </div>
                        <div class="text-dark employee-count fs-4">
                            {{ $totalregistration }}
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card text-center shadow-sm p-3">
                <a href="#" class="text-decoration-none">
                    <div class="name mb-2">
                        <strong class="text-primary">Total Product</strong>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="icon rounded-circle bg-light p-3 me-3">
                            <i class="bi bi-box text-primary fs-4"></i>
                        </div>
                        <div class="text-primary employee-count fs-4">
                            {{ $totalproduct }}
                        </div>
                    </div>
                </a>
            </div>
        </div>


    </div>

    <div class="row mt-3">

        <div class="col-md-9 col-sm-12">
            <div class="card">


                <!-- <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title mb-0">
                        <i class="ion ion-clipboard mr-2"></i>Product List
                    </h3>

                </div> -->
                <div class="card-body">
                    <h5 class="card-title p-2">Product List <span>| Today's</span></h5>
                    <table id="example1" class="table">
                        <thead>
                            <tr class="">
                                <th>Category</th>
                                <th>Product </th>
                                <th>Status</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr class="">
                                <td>{{ $row->categories != null ? $row->categories->category : '' }}</td>
                                <td>{{ $row->product}}</td>
                                <td>
                                    <span class="badge {{ $row->status == '0' ? 'bg-success' : 'bg-danger' }}"> {{ $row->status == '0' ? 'Active' : 'Inactive' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 row-reverse">
            <div class="col-sm-12">
                <div class="card text-center shadow-sm p-3">
                    <a href="#" class="text-decoration-none">
                        <div class="name mb-1">
                            <strong class="text-warning">Total Stock</strong>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="icon rounded-circle bg-light p-3 me-3">
                                <i class="bi bi-cart text-warning fs-4"></i>
                            </div>
                            <div class="text-warning employee-count fs-4">
                                {{ $totalstock }}
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            <div class="col-sm-12">
                <div class="card text-center shadow-sm p-3">

                    <a href="#" class="text-decoration-none">
                        <div class="name mb-1">
                            <strong class="text-success">Total Category</strong>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="icon rounded-circle bg-light p-3 me-3">
                                <i class="bi bi-tags text-success fs-4"></i>
                            </div>
                            <div class="text-success employee-count fs-4">
                                {{ $totalCategory }}
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
        <!-- <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title p-2">Latest Enquiry <span>| Today's</span></h5>
                    <table id="example1" class="table">
                        <thead>
                            <tr class="">
                                <th>Name</th>
                                <th>Package</th>
                                <th>Date & Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sdata as $row)
                            <tr class="small">
                                <td>
                                    <strong>Name:</strong> {{ $row->name }}<br>
                                    <strong>Email:</strong> {{ $row->email }}<br>
                                    <strong>Phone:</strong> {{ $row->mobile }}<br>
                                    <strong>Lead Source:</strong> {{ $row->leads!=null ? $row->leads->leadsource : '' }} <br>
                                </td>

                                <td>
                                    <strong>Package:</strong> {{ $row->Package!=null ? $row->Package->package : '' }} <br>
                                    <strong>Session:</strong> {{ $row->sesion!=null ? $row->sesion->session : '' }} <br>
                                    <strong>Time Slot:</strong> {{ $row->Time!=null ? $row->Time->time_slot : '' }}<br>
                                    <strong>Training Program:</strong> {{ $row->TrainedP!=null ? $row->TrainedP->add_program : '' }}
                                </td>

                                <td>
                                    <strong>Enquiry Date:</strong> {{ $row->enquiry_date }}<br>
                                    <strong> Followup Date:</strong> {{ $row->followup_date }}<br>
                                    <strong>Lead Status:</strong>
                                    <span class="badge  
                                        {{ $row->lead_status == '0' ? 'bg-primary' : 
                                            ($row->lead_status == '1' ? 'bg-info' : 
                                            ($row->lead_status == '2' ? 'bg-warning' : 
                                            ($row->lead_status == '3' ? 'bg-success' :                                                
                                            ($row->lead_status == '4' ? 'bg-dark' : 'bg-secondary'))))
                                        }}">
                                        {{ $row->lead_status == '0' ? 'New' : 
                                            ($row->lead_status == '1' ? 'Assigned' : 
                                            ($row->lead_status == '2' ? 'Inprocess' : 
                                            ($row->lead_status == '3' ? 'Converted' : 
                                            ($row->lead_status == '4' ? 'Dead' : 'Recycle'))))
                                        }}
                                    </span>
                                    <br>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
    </div>

</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toastElements = document.querySelectorAll('.toast');
        toastElements.forEach(toastElement => {
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        });
    });
</script>