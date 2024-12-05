@extends('pages.layouts.app')
@section('title')
Edit Lead Source
@endsection

@section('css')

@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Edit Lead Source</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('leadsource.list'))
                    <li class="breadcrumb-item"><a href="{{route('leadsource.list')}}">Lead Source</a></li>
                    @endif
                    <li class="breadcrumb-item active">Edit Lead Source</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
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
    <div class="card  overflow-auto" @if (!$errors->any())@endif>

        <div class="card-body">
            <div class="row">
                <form action="{{route('leadsource.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $edit_leadsource->id }}" id="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Lead Source Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="leadsource" value="{{ $edit_leadsource->leadsource }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-between mt-2">
                        <div class="">
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="0" {{ old('status', $edit_leadsource->status) == '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="1" {{ old('status', $edit_leadsource->status) == '1' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger" for="danger-outlined">Inactive</label>
                        </div>
                        <div>
                            <button class="btn btn-info btn-md mb-2" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

@endsection