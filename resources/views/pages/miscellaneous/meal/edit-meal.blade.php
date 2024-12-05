@extends('pages.layouts.app')
@section('title')
Edit Meal
@endsection

@section('css')

@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Edit Meal</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('meal.list'))
                    <li class="breadcrumb-item"><a href="{{route('meal.list')}}">Meal</a></li>
                    @endif
                    <li class="breadcrumb-item active">Edit Meal</li>
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
                <form action="{{route('meal.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $edit_meal->id }}" id="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Meal Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="meal_type" value="{{ $edit_meal->meal_type }}">
                            </div>
                        </div>
                        <!-- <div class="col-12">
                            <div class="form-group">
                                <label for="name">Meal Fees<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="validateno" name="meal_fees" value="{{ $edit_meal->meal_fees }}">
                            </div>
                        </div> -->


                    </div>
                    <div class="col-md-12 d-flex justify-content-between mt-2">
                        <div class="">
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="0" {{ old('status', $edit_meal->status) == '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="1" {{ old('status', $edit_meal->status) == '1' ? 'checked' : '' }}>
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