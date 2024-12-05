@extends('pages.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Create And Manage Role </h4>
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
    <div class="row mt-3">


        <div class="col-lg-12">

            <div class="card">

                <div class="card-header mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mt-2">Role List</h5>
                        @if(in_array('panel.add', $permissions))
                        <button type="button" class="btn btn-primary rounded-pill" onclick="window.location.href='{{ route('panel.add') }}'">Add New Role</button>
                        @endif
                    </div>
                </div>

                <div class="card-body">

                    <table id="example1" class="table dataTable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created at</th>
                                @if(in_array('panel.edit', $permissions) || in_array('panel.delete', $permissions))
                                <th scope="col">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getRecord as $row)
                            <tr>
                                <th scope="col">{{ $loop->iteration }}</th>
                                <th scope="col">{{ $row->name }}</th>
                                <th scope="col">{{ $row->created_at }}</th>
                                <th scope="col">
                                    @if(in_array('panel.edit', $permissions))
                                    <a href="{{ route('panel.edit',$row->id) }}" class="badge bg-success">Edit & Permission</a>
                                    @endif
                                    @if(in_array('panel.delete', $permissions))
                                    <a href="{{ route('panel.delete',$row->id) }}" class=" badge bg-danger ms-3">Delete</a>
                                    @endif
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