@extends('pages.layouts.app')
@section('title')
Edit Distributed Stock
@endsection

@section('css')

@endsection


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Edit Distributed Stock</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('distributed.list'))
                    <li class="breadcrumb-item"><a href="{{route('distributed.list')}}">Distributed Stock</a></li>
                    @endif
                    <li class="breadcrumb-item active">Edit Distributed Stock</li>
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
                <form action="{{route('distributed.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $edit_dstock->id }}" id="">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="registration_no">User <span class="text-danger">*</span></label>
                                <select name="registration_no" class="form-select form-control" aria-label="Default select example">
                                    <option selected disabled>Select User</option>
                                    @foreach ($Registrations as $Register)
                                    <option value="{{ $Register->registration_no }}"
                                        @if ($edit_dstock->registration_no == $Register->registration_no) selected @endif>{{ $Register->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="category">Category <span class="text-danger">*</span></label>
                                <select id="category" name="category" class="form-select form-control">
                                    <option selected disabled>Select Category</option>
                                    @foreach ($Category as $catg)
                                    <option value="{{ $catg->category_id }}"
                                        @if ($edit_dstock->category == $catg->category_id) selected @endif>{{ $catg->category }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="product_id">Product <span class="text-danger">*</span></label>
                                <select name="product" id="product_id" class="form-control">
                                    <option value="" disabled>Select Product</option>
                                    @foreach ($Product as $Prodt)
                                    <option value="{{ $Prodt->product_id }}"
                                        @if ($edit_dstock->product == $Prodt->product_id) selected @endif>{{ $Prodt->product }}
                                    </option>
                                    @endforeach
                                    <!-- Products will be loaded dynamically via JS -->
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
                                        @if (old('unit', $edit_dstock->unit ?? '') == $unit->unit_id) selected @endif>
                                        {{ $unit->unit }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="edit_quantity">Quantity</label>
                                <input type="text" id="edit_quantity" class="form-control" name="quantity" min="1" step="1"
                                    value="{{ $edit_dstock->quantity }}">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="name">Notes</label>
                                <textarea type="text" class="form-control" name="notes" value="" placeholder="Write notes here...">{{ $edit_dstock->notes }}</textarea>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-12 d-flex justify-content-between mt-2">
                        <div class="">
                            <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value="0" {{ old('status', $edit_dstock->status) == '0' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="success-outlined">Active</label>

                            <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="1" {{ old('status', $edit_dstock->status) == '1' ? 'checked' : '' }}>
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
                    $('#product_id').html('');
                    $('#product_id').append(
                        '<option value="" selected="" disabled="">Select Product</option>'
                    );
                    $.each(data, function(index, item) {
                        $('#product_id').append('<option value="' + item
                            .product_id + '">' + item.product +
                            '</option>');
                    });
                }
            });
        });
    });
</script>
@endsection