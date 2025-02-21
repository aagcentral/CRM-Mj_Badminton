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

    .info-box {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        border-radius: .25rem;
        background-color: #fff;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        width: 100%;
    }

    .info-box .info-box-icon {
        border-radius: .25rem;
        -ms-flex-align: center;
        align-items: center;
        display: -ms-flexbox;
        display: flex;
        font-size: 1.875rem;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 70px;
    }

    .info-box .info-box-content {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        line-height: 1.8;
        -ms-flex: 1;
        flex: 1;
        padding: 0 10px;
        overflow: hidden;
    }

    .info-box .info-box-text,
    .info-box .progress-description {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        /* text-align: center; */
    }

    .info-box .info-box-number {
        display: block;
        margin-top: .25rem;
        font-weight: 700;
        font-size: 20px;
        /* text-align: center; */
    }
</style>
@section('content')
<div class="container-fluid py-3">
    <!-- <h3 class="my-4"> Dashboard</h3> -->
    <div class="row">

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-success bg-success bg-opacity-25"> <i class="fa-solid fa-headset "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Lead</span>
                    <span class="info-box-number"> {{ $totallead }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-info bg-info bg-opacity-25"><i class="fa-solid fa-users-gear"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Converted Leads</span>
                    <span class="info-box-number"> {{ $convertedLeads }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-danger bg-danger bg-opacity-25"><i class="bi bi-person-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Registration</span>
                    <span class="info-box-number"> {{ $totalregistration }}</span>
                </div>
            </div>
        </div>



        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-primary bg-primary bg-opacity-25"><i class="fa-solid fa-chalkboard-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Training Users</span>
                    <span class="info-box-number"> {{ $trainingProgramCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon" style="background-color:rgba(123, 92, 196, 0.46); color: #7c5cc4;"><i class="fa-solid fa-users-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Membership</span>
                    <span class="info-box-number"> {{ $totalproduct }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-danger bg-danger bg-opacity-25">
                    <i class="fa-solid fa-gamepad"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pay & Play Users</span>
                    <span class="info-box-number">{{ $payAndPlayCount  }} </span>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-info bg-info bg-opacity-25"><i class="bi bi-box"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Product</span>
                    <span class="info-box-number"> {{ $totalproduct }}</span>
                </div>
            </div>
        </div> -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-warning bg-warning bg-opacity-25"><i class="bi bi-cart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Stock</span>
                    <span class="info-box-number"> {{ $totalstock }}</span>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-primary bg-primary bg-opacity-25"><i class="bi bi-tags "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Category</span>
                    <span class="info-box-number"> {{ $totalCategory }}</span>
                </div>
            </div>
        </div> -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-success bg-success bg-opacity-25"><i class="fa-solid fa-users-viewfinder"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Active Players</span>
                    <span class="info-box-number"> {{ $activePlayers }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-danger bg-danger bg-opacity-25"><i class="fa-solid fa-users-slash"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Inctive Players</span>
                    <span class="info-box-number"> {{ $inactivePlayers }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon text-primary bg-primary bg-opacity-25"><i class="fa-regular fa-building"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Room Type</span>
                    <span class="info-box-number"> {{ $totalroomtype }}</span>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <div class="col-md-9 col-sm-12">
            <div class="card">
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