@extends('pages.layouts.app')
@section('title')
Edit Unit
@endsection

@section('css')

@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Edit Unit</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('unit.list'))
                    <li class="breadcrumb-item"><a href="{{route('unit.list')}}">Unit</a></li>
                    @endif
                    <li class="breadcrumb-item active">Edit Unit</li>
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
                <form action="{{route('unit.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $edit_unit->id }}" id="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Unit Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="unit" value="{{ $edit_unit->unit }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 d-flex justify-content-between mt-2">
                        <div class="">
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="0" {{ old('status', $edit_unit->status) == '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="1" {{ old('status', $edit_unit->status) == '1' ? 'checked' : '' }}>
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