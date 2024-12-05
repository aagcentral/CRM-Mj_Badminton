@extends('pages.layouts.app')
@section('title')
Stock
@endsection

@section('css')

@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Create And Manage Stock</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                    <li class="breadcrumb-item active">Stock</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid py-3">
    <div class="row mt-4">
        <div class="col-md-12 d-flex  gap-2">
            @if(havePermission('stock.add'))
            <button id="toggleButton" class="btn btn-info mb-3 ml-1"><i class="fas fa-plus-circle me-2"></i>Add Stock</button>
            @endif
            <a href="#"><button class="btn btn-default text-white mb-3 ml-1 toggle-form" style="background-color:#7c5cc4;"><i class="fas fa-filter me-2" style="font-size:13px;"></i>Filter</button></a>
            <button type="button" class="btn btn-danger mb-3 ml-1" onclick="window.location.href='{{ route('stock.list') }}'">Refresh <i class="fa-solid fa-arrows-rotate"></i>
            </button>
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
    <div class="card" id="filterForm" style="display: none;">
        <div class="card-body">

            <form method="GET" action="">
                <div class="row">
                    <div class="">
                        <h6 class="card-title"> Filter</h6>
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group mb-3">
                            <select id="applyFor" name="category" class="form-select form-control findcategory" aria-label="Default select example">
                                <option selected disabled>Filter by Category</option>
                                @foreach ($Category as $Cat)
                                <option value="{{ $Cat->category_id }}"
                                    @if (old('category')==$Cat->category_id) selected @endif>{{ $Cat->category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group mb-3">
                            <select id="product" name="product_id" class="form-control">
                                <option value="" disabled selected>Filter by Product</option>
                                <!-- Products will be dynamically loaded here -->
                            </select>
                        </div>
                    </div>

                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-sm">Apply Filter <i class="fa-solid fa-filter"></i></button>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='{{ route('stock.list') }}'">Refresh <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </div>
                </div>
        </div>

        </form>
    </div>
    <div class="card togglediv overflow-auto" @if (!$errors->any()) style="display: none;" @endif>

        <div class="card-body">
            <div class="row">
                <form action="{{route('stock.add')}}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="category">Category<span class="text-danger">*</span></label>
                                <select id="category" name="category" class="form-select form-control" aria-label="Default select example">
                                    <option selected disabled>Select Category</option>
                                    @foreach ($Category as $Cat)
                                    <option value="{{ $Cat->category_id }}">{{ $Cat->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="product_id">Product <span class="text-danger">*</span></label>
                                <select name="product_id" id="getproduct" class="form-control">
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
                                <input type="text" class="form-control quantity" id="validateno" name="quantity" value="{{ old('quantity') }}" placeholder="Enter Quantity" oninput="validateDecimalInput(this)">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="single_price">Single Price <span class="text-danger">*</span></label>
                                <input type="text" class="form-control single_price" name="single_price" value="{{ old('single_price') }}" placeholder="Enter Single Price"
                                    oninput="validateDecimalInput(this)">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="total_price">Total Price</label>
                                <input type="text" class="form-control total_price" id="validateno" name="total_price" value="{{ old('total_price') }}" placeholder="Calculated Automatically" readonly>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Added Date </label>
                                <input type="date" class="form-control" name="added_on" value="{{ old('added_on') }}" placeholder="Enter Added Date">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="product_type">Product Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="product_type" id="product_type" onchange="toggleExpiryDateField()">
                                    <option value="" disabled selected>Select Product Type</option>
                                    <option value="0" {{ old('product_type') == '0' ? 'selected' : '' }}>Non-Perishable</option>
                                    <option value="1" {{ old('product_type') == '1' ? 'selected' : '' }}>Perishable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12" id="expiry_date_field" style="display: none;">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" class="form-control" name="expiry_date" value="{{ old('expiry_date') }}" placeholder="Enter Expiry Date">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Vendor Name </label>
                                <input type="text" class="form-control" name="vender_name" value="{{ old('vender_name') }}" placeholder="Enter Vendor Name">
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12">
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
                        <th>Stock </th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr class="">

                        <th>{{ $loop->iteration }}</th>

                        <td>{{ $row->Category!= null ? $row->Category->category : '' }}</td>
                        <!-- <td>{{ $row->product_id}}</td> -->
                        <td>{{ $row->products!=null ? $row->products->product : '' }}</td>
                        <td>{{ $row->quantity}}</td>
                        <td>{{ $row->total_price}}</td>

                        <td>
                            <span class="badge {{ $row->status == '0' ? 'bg-success' : 'bg-danger' }}"> {{ $row->status == '0' ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td>
                            @if(havePermission('stock.edit'))
                            <a href="{{ route('stock.edit', $row->stock_id) }}" class="text-info px-2"><i class="fas fa-edit"></i> </a>
                            @endif
                            @if(havePermission('stock.destroy'))
                            <button class="btn btn-default text-danger btn-sm px-2 delete-stock" data-id="{{ $row->id }}"><i class="fa-solid fa-trash"></i> </button>
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
    $('.delete-stock').click(function() {
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
                    url: "{{ route('stock.destroy') }}",
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
<!-- expiey field hide show -->
<script>
    function toggleExpiryDateField() {
        var productType = document.getElementById("product_type").value;
        var expiryDateField = document.getElementById("expiry_date_field");

        if (productType === "1") {
            expiryDateField.style.display = "block";
        } else {
            expiryDateField.style.display = "none";
        }
    }

    // Run the function on page load in case the old value is set to "1"
    document.addEventListener("DOMContentLoaded", function() {
        toggleExpiryDateField();
    });
</script>
<script>
    document.querySelectorAll('.quantity, .single_price').forEach(input => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9.]/g, '');
            let sp = parseFloat(document.querySelector('.single_price').value) || 0;
            let qty = parseFloat(document.querySelector('.quantity').value) || 0;
            document.querySelector('.total_price').value = (sp * qty).toFixed(2);
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
                    $('#getproduct').html('<option value="" disabled selected>Select Product</option>');
                    if (data.length > 0) {
                        $.each(data, function(index, product) {
                            $('#getproduct').append('<option value="' + product.product_id + '">' + product.product + '</option>');
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

<script>
    document.querySelector('.toggle-form').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default action of the link

        var formSection = document.getElementById('filterForm');

        if (formSection.style.display === 'none' || formSection.style.display === '') {
            formSection.style.display = 'block'; // Show the form
        } else {
            formSection.style.display = 'none'; // Hide the form
        }
    });

    // validate total price
    function validateDecimalInput(input) {
        input.value = input.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d{2})./g, '$1');
    }
</script>

<!-- dependentdropdown for filter -->
<script>
    $(document).ready(function() {
        $('.findcategory').on('change', function() {
            var categoryId = $(this).val();

            // Clear the product dropdown
            $('#product').html('<option value="" disabled selected>Loading...</option>');

            if (categoryId) {
                $.ajax({
                    url: "{{ route('stock.category') }}",
                    type: "GET",
                    data: {
                        category_id: categoryId
                    },
                    success: function(data) {
                        $('#product').html('<option value="" disabled selected>Filter by Product</option>');
                        $.each(data, function(index, product) {
                            $('#product').append(
                                `<option value="${product.product_id}">${product.product}</option>`
                            );
                        });
                    },
                    error: function() {
                        alert('Failed to fetch products.');
                    }
                });
            }
        });
    });
</script>
@endsection