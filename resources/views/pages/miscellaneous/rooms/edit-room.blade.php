@extends('pages.layouts.app')
@section('title')
Edit Room
@endsection

@section('css')

@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Edit Room</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('room.list'))
                    <li class="breadcrumb-item"><a href="{{route('room.list')}}">Room</a></li>
                    @endif
                    <li class="breadcrumb-item active">Edit Room</li>
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
                <form action="{{route('room.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $edit_room->id }}" id="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Room Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="room_type" value="{{ $edit_room->room_type }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Room Fees<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="validateno" name="room_fees" value="{{ $edit_room->room_fees }}">
                            </div>
                        </div>


                    </div>
                    <div class="col-md-12 d-flex justify-content-between mt-2">
                        <div class="">
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="0" {{ old('status', $edit_room->status) == '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="1" {{ old('status', $edit_room->status) == '1' ? 'checked' : '' }}>
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