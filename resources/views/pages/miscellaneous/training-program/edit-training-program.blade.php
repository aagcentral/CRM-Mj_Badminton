@extends('pages.layouts.app')
@section('title')
Edit Training Program
@endsection

@section('css')

@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Edit Training Program</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('training.list'))
                    <li class="breadcrumb-item"><a href="{{route('training.list')}}">Training Program</a></li>
                    @endif
                    <li class="breadcrumb-item active">Edit Training Program</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
    @if ($errors->any())
    <div class="text-danger small">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card togglediv overflow-auto" @if (!$errors->any())@endif>

        <!-- <div class="card-header blue">
                <h3 class="card-title text-white">Edit Training Program</h3>
            </div> -->

        <div class="card-body">
            <div class="row">
                <form action="{{route('training.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $edit_training->id }}" id="">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="name">Training Program Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="add_program" value="{{ $edit_training->add_program }}">
                            </div>
                        </div>
                        <!-- <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="name">Training Program Fees<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fees" value="{{ $edit_training->fees }}">
                            </div>
                        </div> -->


                    </div>
                    <div class="col-md-12 d-flex justify-content-between mt-2">
                        <div class="">
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="0"
                                {{ old('status', $edit_training->status) == '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="1"
                                {{ old('status', $edit_training->status) == '1' ? 'checked' : '' }}>
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