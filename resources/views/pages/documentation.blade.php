@extends('pages.layouts.app')
@section('title','Document')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-md-12">
            <form action="" method="POST">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">Terms & Condition </h3>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <label>Description</label>
                                    <textarea name="description" id="summernote"> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary blue my-1 ml-1">save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection