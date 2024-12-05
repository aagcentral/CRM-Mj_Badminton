@extends('pages.layouts.app')
@section('title')
User
@endsection

@section('css')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Create And Manage User</h4>
            </div>
            <div class="col-md-6 col-sm-12 text-end">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid py-3">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mt-2">User List With Location</h5>
                        @if(havePermission('user.add'))
                        <button type="button" class="btn btn-primary rounded-pill" onclick="window.location.href='{{ route('user.add') }}'">Add New User</button>
                        @endif
                    </div>
                </div>

                <div class="card-body">

                    <table id="example1" class="table dataTable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Location</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getRecord as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->role->name ?? '' }}</td>
                                <td>{{ $row->locations->location ?? '' }}</td>
                                <th scope="col">
                                    @if ($row->role_id != 9) <!-- Check if the user is not a Super Admin -->
                                    @if(havePermission('user.edit'))
                                    <a href="{{ route('user.edit', $row->id) }}" class="badge bg-info">Edit</a>
                                    @endif
                                    @if(havePermission('user.delete'))
                                    <a href="{{ route('user.delete', $row->id) }}" class="badge bg-danger ms-3">Delete</a>
                                    @endif
                                    @else
                                    <span class="text-muted">No actions available</span>
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
</div>

@endsection