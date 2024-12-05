@extends('pages.layouts.app')
@section('title')
Edit User
@endsection
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Edit User</h4>
            </div>
            <div class="col-md-6 col-sm-12 text-end">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('user.list')}}">User</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
    <div class="row mt-4 mb-5">
        <div class="col-lg-8 m-auto">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit User</h5>

                    <!-- General Form Elements -->
                    <form action="{{ route('user.update',$getUser->id) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $getUser->name }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $getUser->email }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label">Password</label>
                                <input type="text" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label">Role</label>
                                <select name="role_id" id="" class="form-select">
                                    <option value="" disabled selected>--Select Role--</option>
                                    @foreach ($getRole as $role)
                                    <option value="{{ $role->id }}" @if($getUser->role_id==$role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label">Location</label>
                                <select name="locationID" id="" class="form-select">
                                    <option value="" disabled selected>--Select Location--</option>
                                    @foreach ($getLocation as $location)
                                    <option value="{{ $location->location_id }}" @if($getUser->locationID == $location->location_id) selected @endif>
                                        {{ $location->location }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>



@endsection