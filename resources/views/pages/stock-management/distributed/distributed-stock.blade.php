@extends('pages.layouts.app')
@section('title')
Distributed Stock
@endsection

@section('css')

@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Create And Manage Distributed Stock</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                    <li class="breadcrumb-item active">Distributed Stock</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
    <div class="row mt-4">
        <div class="col-md-12 d-flex">
            @if(havePermission('distributed.add'))
            <button id="toggleButton" class="btn btn-info mb-3 ml-1"><i class="fas fa-plus-circle me-2"></i>Distributed Stock</button>
            @endif
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
                <form action="{{route('distributed.add')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="registration_no">User <span class="text-danger">*</span></label>
                                <select name="registration_no" class="form-select form-control" aria-label="Default select example">
                                    <option selected disabled>Select User</option>
                                    @foreach ($Registrations as $Register)
                                    <option value="{{ $Register->registration_no }}"
                                        @if (old('registration_no')==$Register->registration_no) selected @endif>{{ $Register->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="category">Category<span class="text-danger">*</span></label>
                                <select id="category" name="category" class="form-select form-control" aria-label="Default select example">
                                    <option selected disabled>Select Category</option>
                                    @foreach ($Category as $Cat)
                                    <option value="{{ $Cat->category_id }}"
                                        @if (old('category')==$Cat->category_id) selected @endif>{{ $Cat->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="product_id">Product <span class="text-danger">*</span></label>
                                <select name="product" id="product_id" class="form-control">
                                    <option value="" disabled selected>Select Product</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Unit<span class="text-danger">*</span></label>
                                <select name="unit" class="form-select">
                                    <option value="" disabled selected>Select Unit</option>
                                    @foreach ($units as $unit)
                                    <option value="{{ $unit->unit_id }}"
                                        @if (old('unit')==$unit->unit_id) selected @endif>{{ $unit->unit}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                <input type="text" class="form-control quantity" id="validateno" name="quantity" min="1" value="{{ old('quantity') }}" placeholder="Enter Quantity" oninput="validateDecimalInput(this)">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
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

                        <th>User</th>
                        <th>Product </th>
                        <th>Category </th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr class="">

                        <th>{{ $loop->iteration }}</th>

                        <td>{{ $row->register!=null ? $row->register->name : '' }}</td>
                        <td>{{ $row->products!=null ? $row->products->product : '' }}</td>
                        <td>{{ $row->Category!= null ? $row->Category->category : '' }}</td>
                        <td>{{ $row->quantity}}</td>
                        <td>{{ $row->units!= null ? $row->units->unit : '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->date)->format('d.m.y') }}</td>


                        <td>
                            <span class="badge {{ $row->status == '0' ? 'bg-success' : 'bg-danger' }}"> {{ $row->status == '0' ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td>
                            <!-- @if(havePermission('distributed.edit'))
                            <a href="{{ route('distributed.edit', $row->id) }}" class="text-info px-2"><i class="fas fa-edit"></i> </a>
                            @endif -->
                            @if(havePermission('distributed.destroy'))
                            <button class="btn btn-default text-danger btn-sm px-2 delete-distributed" data-id="{{ $row->id }}"><i class="fa-solid fa-trash"></i> </button>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.delete-distributed').click(function() {
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
                    url: "{{ route('distributed.destroy') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#category').change(function() {
            var category_id = $(this).val();
            $.ajax({
                url: "{{ route('stock.get.product') }}",
                method: 'POST',
                data: {
                    category_id: category_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // Clear the product dropdown and add a default option
                    $('#product_id').html('<option value="" disabled selected>Select Product</option>');
                    if (data.length > 0) {
                        $.each(data, function(index, product) {
                            $('#product_id').append('<option value="' + product.product_id + '">' + product.product + '</option>');
                        });
                    } else {
                        alert("No products available for this category.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error loading products: ", xhr.responseText);
                    alert("An error occurred while loading products.");
                }
            });
        });
    });
</script>


@endsection