@extends('pages.layouts.app')

@section('content')

<div class="pagetitle">
    <h1>Add New Permission Group</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Settings</a></li>
            <li class="breadcrumb-item active">Add New Permission Group</li>
        </ol>
    </nav>
</div><!-- End Page Title -->


<section class="section">
    <div class="row">
        @if(in_array('group.insert', $permissions))
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New Permission Group (Main Menu)</h5>

                    <!-- General Form Elements -->
                    <form action="{{ route('group.insert') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <label for="inputText" class="col-sm-2 col-form-label text-nowrap">Menu Name</label>
                                <input type="text" class="form-control" name="group_name">
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
                    <h5 class="card-title">List Permission Group (Main Menu)</h5>

                    <table class="table table-stripped table-hover">
                        <tr>
                            <th>Menu</th>
                            <th>Status</th>
                        </tr>
                        <tbody>
                            @foreach ($getRecord as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>
                                    <td><span class="fw-bold {{ $row->status=='active'?'text-success':'text-danger' }}">{{ $row->status=='active'?'Active':'Inactive' }}</span></td>
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