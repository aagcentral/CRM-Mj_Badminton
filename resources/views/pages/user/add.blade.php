@extends('pages.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Create User</h4>
            </div>
            <div class="col-md-6 col-sm-12 text-end">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('user.list'))
                    <li class="breadcrumb-item"><a href="{{route('user.list')}}">User</a></li>
                    @endif
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
    <div class="row mt-3 mb-4">
        <div class="col-lg-8 m-auto">
            <div class="card mb-5">
                <div class="card-body">
                    <h5 class="card-header">Add New User</h5>

                    <!-- General Form Elements -->
                    <form action="{{ route('user.insert') }}" method="POST">
                        @csrf
                        <div class="row mb-2 mt-4">
                            <div class="col-sm-10 m-auto">
                                <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-10 m-auto">
                                <label for="inputText" class="col-sm-2 col-form-label">Email</label>
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-10 m-auto">
                                <label for="inputText" class="col-sm-2 col-form-label">Password</label>
                                <input type="text" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-10 m-auto">
                                <label for="inputText" class="col-sm-2 col-form-label">Role</label>
                                <select name="role_id" id="" class="form-select">
                                    <option value="" disabled selected>--Select Role--</option>
                                    @foreach ($getRole as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-10 m-auto">
                                <label for="inputText" class="col-sm-2 col-form-label">Location</label>
                                <select name="locationID" id="" class="form-select">
                                    <option value="" disabled selected>--Select Location--</option>
                                    @foreach ($getLocation as $location)
                                    <option value="{{ $location->location_id }}">{{ $location->location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-sm-11 text-end">
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