@extends('pages.layouts.app')

@section('content')
@if(in_array('panel.add', $permissions))
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Add Role </h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('settings.role.list')}}">Role</a></li>
                    <li class="breadcrumb-item active">Role </li>
                </ol>
            </div>
        </div>
    </div>
</section>


<section class="section">
    <div class="row">
        <div class="col-lg-8">
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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add New Role</h5>

                    <!-- General Form Elements -->
                    <form action="{{ route('panel.insert') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                                <input type="text" class="form-control" name="role">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label fw-bold">Permissions</label>
                                @foreach ($getPermission as $row)
                                <div class="ms-5 mb-3 bg-light p-2">
                                    <h6 class="border-bottom fw-bold">{{ ucwords($row['name']) }}</h6>
                                    @foreach ($row['group'] as $gp)
                                    <div class="d-inline text-nowrap ms-5 my-5">
                                        <span>
                                            <input type="checkbox" name="permisssion_id[]" value="{{ $gp['id'] }}" id="{{ $gp['id'] }}"> <label for="{{ $gp['id'] }}" class="ms-2">{{ ucwords($gp['name']) }}</label>
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
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
</section>

@endif

@endsection