@extends('pages.layouts.app')
@section('title')
Edit Stock
@endsection

@section('css')

@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Edit Stock</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('stock.list'))
                    <li class="breadcrumb-item"><a href="{{route('stock.list')}}">Stock</a></li>
                    @endif
                    <li class="breadcrumb-item active">Edit Stock</li>
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
    <div class="card overflow-auto" @if (!$errors->any())@endif>

        <div class="card-body">
            <div class="row">
                <form action="{{route('stock.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="stock_id" value="{{ $edit_stock->stock_id }}">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="category">Category <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-select">
                                    <option value="" disabled>Select Category</option>
                                    @foreach ($category as $catgry)
                                    <option value="{{ $catgry->category_id }}"
                                        @if ( $edit_stock->category == $catgry->category_id) selected @endif> {{ $catgry->category }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="product_id">Product <span class="text-danger">*</span></label>
                                <select class="form-select" name="product_id" id="getproduct">
                                    <option value="" disabled selected>Select Product</option>
                                    @foreach ($products as $prodt)
                                    <option value="{{ $prodt->product_id }}"
                                        @if ($edit_stock->product_id == $prodt->product_id) selected @endif>{{ $prodt->product }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="unit">Unit <span class="text-danger">*</span></label>
                                <select name="unit" class="form-select" id="unit">
                                    <option value="" disabled>Select Unit</option>
                                    @foreach ($units as $unit)
                                    <option value="{{ $unit->unit_id }}"
                                        @if ($edit_stock->unit == $unit->unit_id) selected @endif> {{ $unit->unit }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="edit_quantity">Quantity</label>
                                <input type="text" id="edit_quantity" class="form-control quantity" name="quantity" min="1" step="1"
                                    value="{{ old('quantity', $edit_stock->quantity) }}" oninput="validateDecimalInput(this)">
                            </div>
                        </div>

                        <!-- <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="edit_single_price">Single Price</label>
                                <input type="text" id="edit_single_price" class="form-control single_price" name="single_price" min="0" step="0.01"
                                    value="{{ old('single_price', $edit_stock->single_price) }}" oninput="validateDecimalInput(this)">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="edit_total_price">Total Price</label>
                                <input type="text" id="edit_total_price" class="form-control total_price" name="total_price" min="0" step="0.01"
                                    value="{{ old('total_price', $edit_stock->total_price) }}" readonly>
                            </div>
                        </div> -->


                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Added Date </label>
                                <input type="date" class="form-control" name="added_on" value="{{ $edit_stock->added_on }}" placeholder="Enter Added Date">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="product_type">Product Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="product_type" id="product_type" onchange="toggleExpiryDateField()">
                                    <option value="" disabled>Select Product Type</option>
                                    <option value="0" {{ old('product_type', $edit_stock->product_type ?? '') == '0' ? 'selected' : '' }}>Non-Perishable</option>
                                    <option value="1" {{ old('product_type', $edit_stock->product_type ?? '') == '1' ? 'selected' : '' }}>Perishable</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12" id="expiry_date_field" style="display: none;">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" class="form-control  restrict-past-date" name="expiry_date" value="{{ $edit_stock->expiry_date }}" placeholder="Enter Expiry Date">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Vendor Name </label>
                                <input type="text" class="form-control" name="vender_name" value="{{ $edit_stock->vender_name }}" placeholder="Enter Vendor Name">
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <div class="form-group">
                                <label for="name">Notes</label>
                                <textarea type="text" class="form-control" name="notes" value="" placeholder="Write notes here...">{{ $edit_stock->notes }}</textarea>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 d-flex justify-content-between mt-2">
                        <div class="">
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="0" {{ old('status', $edit_stock->status) == '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="1" {{ old('status', $edit_stock->status) == '1' ? 'checked' : '' }}>
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
<script>
    function validateDecimalInput(input) {
        input.value = input.value.replace(/[^0-9.]/g, '');

        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.+$/, '');
        }
    }

    function updateTotalPrice() {
        let qty = parseFloat(document.getElementById('edit_quantity').value) || 0;
        let sp = parseFloat(document.getElementById('edit_single_price').value) || 0;

        let totalPrice = (sp * qty).toFixed(2);
        document.getElementById('edit_total_price').value = totalPrice;
    }
    document.getElementById('edit_quantity').addEventListener('input', updateTotalPrice);
    document.getElementById('edit_single_price').addEventListener('input', updateTotalPrice);
    document.addEventListener('DOMContentLoaded', updateTotalPrice);
</script>


<!-- hide show -->
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
                    $('#getproduct').html('');
                    $('#getproduct').append(
                        '<option value="" selected="" disabled="">Select Product</option>'
                    );
                    $.each(data, function(index, item) {
                        $('#getproduct').append('<option value="' + item
                            .product_id + '">' + item.product +
                            '</option>');
                    });
                }
            });
        });
    });
</script>
@endsection