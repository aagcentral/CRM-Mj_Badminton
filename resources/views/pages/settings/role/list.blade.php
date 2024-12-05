@extends('pages.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Create and Manage Role </h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                    <li class="breadcrumb-item active">Role </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="row mt-2">


        <div class="col-lg-12">

            <div class="card">

                <div class="card-header mb-3">
                    <div class="d-flex justify-content-between">
                        <h5 class="fw-bold text-dark">Table with stripped rows</h5>
                        <button type="button" class="btn btn-primary rounded-pill" onclick="window.location.href='{{ route('panel.add') }}'">Add New Role</button>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getRecord as $row)
                            <tr>
                                <th scope="col">{{ $loop->iteration }}</th>
                                <th scope="col">{{ $row->name }}</th>
                                <th scope="col">{{ $row->created_at }}</th>
                                <th scope="col">
                                    <a href="{{ route('panel.edit',$row->id) }}" class="badge bg-info">Edit & Permission</a>
                                    <a href="{{ route('panel.delete',$row->id) }}" class=" badge bg-danger ms-3">Delete</a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>

@endsection