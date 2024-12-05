@extends('pages.layouts.app')

@section('content')

<div class="pagetitle">
    <h1>Add New Permission</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Settings</a></li>
            <li class="breadcrumb-item active">Add New Permission</li>
        </ol>
    </nav>
</div><!-- End Page Title -->


<section class="section">
    <div class="row">
        @if(in_array('permission.insert', $permissions))
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New Permission</h5>

                    <!-- General Form Elements -->
                    <form action="{{ route('permission.insert') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label text-nowrap">Select Group/Menu Name</label>
                                <select name="group_id" class="form-control">
                                    <option value="" disabled selected>--Select Group--</option>
                                    @foreach ($getRecord as $list)  
                                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label text-nowrap">Permission Name</label>
                                <input type="text" class="form-control" name="permission_name">
                            </div>
                        </div>
                       
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label text-nowrap">Route Name</label>
                                <input type="text" class="form-control" name="route_name">
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
        @endif

        <div class="col-lg-7">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List Permissions</h5>

                    <table class="table table-stripped table-hover border">
                        <tbody>
                            @foreach ($getPermission as $row)
                                <tr>
                                    <th class="text-capitalize">{{ $row->name }}</th>
                                    <td>
                                        @if(Count($row->permissions)>0)
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Permission</th>
                                                <th>Slug</th>
                                            </tr>
                                            @foreach ($row->permissions as $group)
                                            <tr>
                                                <td class="text-capitalize">{{ $group->name }}</td>
                                                <td>{{ $group->slug }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
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



@endsection