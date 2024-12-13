@extends('pages.layouts.app')
@section('title')
Product
@endsection

@section('css')
<style>
    .table_export_button0_wrapper {
        margin: 0;
        padding: 0;
    }

    .inputDnD .form-control-file {
        position: relative;
        width: 100%;
        height: 100%;
        min-height: 6em;
        outline: none;
        visibility: hidden;
        cursor: pointer;
        background-color: #bebebe;
        box-shadow: 0 0 5px solid #bebebe;
    }

    .inputDnD .form-control-file:before {
        content: attr(data-title);
        position: absolute;
        top: 0.5em;
        left: 0;
        width: 100%;
        min-height: 6em;
        line-height: 2em;
        padding-top: 1.5em;
        opacity: 1;
        visibility: visible;
        text-align: center;
        border: 0.25em dashed #bebebe;
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
        overflow: hidden;
    }

    .inputDnD .form-control-file:hover:before {
        border-style: solid;
        box-shadow: 0px 0px 0px 0.25em #bebebe;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Create And Manage Product</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
    <div class="row mt-4">
        <div class="col-md-12 d-flex gap-2">
            @if(havePermission('product.add'))
            <button id="toggleButton" class="btn btn-info mb-3 ml-1"><i class="fas fa-plus-circle me-2"></i>Add Product</button>
            @endif
            <!-- <button class="btn btn-primary mb-3 ml-1" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-arrow-up-from-bracket me-2"></i></i>Import</button> -->
        </div>
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
    <div class="card togglediv overflow-auto" @if (!$errors->any()) style="display: none;" @endif>

        <div class="card-body">
            <div class="row">
                <form action="{{route('product.add')}}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="name">Category<span class="text-danger">*</span></label>
                                <select name="category" class="form-select">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($Category as $Catgry)
                                    <option value="{{ $Catgry->category_id }}"
                                        @if (old('Catgry')==$Catgry->category_id) selected @endif>{{ $Catgry->category}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="name">Add Product <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="product" value="{{ old('product') }}" placeholder="Enter Product">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="name">Notes</label>
                                <textarea type="text" class="form-control" name="notes" value="{{ old('notes') }}" placeholder="Write notes here..."></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 d-flex justify-content-between align-items-center mt-2 w-100">
                        <div>
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="active" {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success btn-md" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger btn-md" for="danger-outlined">Inactive</label>
                        </div>
                        <div>
                            <button class="btn btn-info btn-md mb-2" type="submit">Submit</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

    <!-- table -->
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table dataTable table-hover">
                <thead>
                    <tr class="">
                        <th>#</th>
                        <th>Category</th>
                        <th>Product </th>
                        <th>Added Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>

                    @foreach ($data as $row)
                    <tr class="">

                        <th>{{ $loop->iteration }}</th>

                        <td>{{ $row->categories != null ? $row->categories->category : '' }}</td>
                        <td>{{ $row->product}}</td>
                        <td>{{ $row->date }}</td>

                        <td>
                            <span class="badge {{ $row->status == '0' ? 'bg-success' : 'bg-danger' }}"> {{ $row->status == '0' ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td>
                            @if(havePermission('product.edit'))
                            <a href="{{ route('product.edit', $row->id) }}" class="text-info px-2"><i class="fas fa-edit"></i> </a>
                            @endif
                            @if(havePermission('product.destroy'))
                            <button class="btn btn-default text-danger btn-sm px-2 delete-product" data-id="{{ $row->id }}"><i class="fa-solid fa-trash"></i> </button>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bulk Product Upload via Excel / CSV File</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body card-body">
                <form id="uploadForm" action="#" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <div class="container p-y-1">
                            <div class="row m-b-1">
                                <div class="col-12">
                                    <div class="form-group inputDnD" id="inputDnD">
                                        <label class="sr-only" for="inputFile">File Upload</label>
                                        <input type="file" class="form-control-file text-dark font-weight-bold" name="file" id="inputFile" data-title="Drag and drop a file" placeholder="dfsf" onchange="updateFileName(this)">
                                    </div>
                                    <p id="msg"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted fw-bold">Please don't close or refresh the window, or else the upload might fail.</small>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-block">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- end modal ---->

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.delete-product').click(function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('product.destroy') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Success: show a success message
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Error: show a concise smart message
                        var errorMessage = xhr.responseJSON.message || 'An unexpected error occurred. Please try again later.';

                        // Shorter and smarter alert
                        Swal.fire({
                            title: 'Deletion Failed',
                            text: 'Cannot delete product with available stock. Please check inventory.',
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            }
        });
    });
</script>
<!-- upload file -->
<script>
    function updateFileName(input) {
        var fileName = input.files[0].name;
        input.setAttribute('data-title', fileName);
    }
</script>
<script>
    $(document).ready(function() {
        $('#uploadForm').submit(function(e) {
            e.preventDefault();

            // Show loading message
            toastr.info('Uploading...', 'Please wait', {
                timeOut: 0
            });
            $('#inputDnD').hide();
            $('#msg').html('Uploading Please Wait.....').addClass('text-warning pt-3 fw-bold');
            $('.hide_btn').hide();

            var formData = new FormData(this);

            $.ajax({
                url: "#",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    $('#msg').html('Uploaded Successfully...').removeClass('text-warning text-danger').addClass('text-success');
                    $('#myModal').modal('hide');

                    toastr.clear();

                    toastr.success(response.message, 'Success');

                    location.reload();
                },
                error: function(xhr, status, error) {
                    toastr.clear();
                    $('#msg').html(error).removeClass('text-warning text-success').addClass('text-danger');
                    toastr.error('Upload failed: ' + error, 'Error');
                }
            });
        });
    });
</script>


@endsection