@extends('pages.layouts.app')
@section('title')
Fee Management
@endsection

@section('css')

@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>Fee Management And Record</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('feemanagement.list'))
                    <li class="breadcrumb-item"><a href="{{route('feemanagement.list')}}">Fee Management</a></li>
                    @endif
                    <li class="breadcrumb-item active">Fee Management</li>
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
    <div class="card pb-4">
        <div class="card-body">
            <div class="row">
                <!-- User Dropdown -->
                <div class="col-md-10 col-sm-12">
                    <div class="form-group">
                        <label for="userSelect" class="form-label">Select User <span class="text-danger">*</span></label>
                        <select name="registration_no" id="userSelect" class="form-select">
                            <option selected disabled>Select User</option>
                            @foreach ($viewpusers as $Register)
                            <option value="{{ $Register->registration_no }}">
                                {{ $Register->name }} - ({{ $Register->email }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-sm-12 mt-3">
                    <label for="userSelect" class="form-label"></label>
                    <button type="button" id="searchButton" class="btn btn-primary w-100">
                        Search
                    </button>
                </div>

            </div>
            <div class="form-group mt-3" id="userDetails" style="display: none;">
                <h5>User Details</h5>
                <p><strong>Father's Name:</strong> <span id="fatherName"></span></p>
                <p><strong>Email:</strong> <span id="email"></span></p>
            </div>
        </div>
    </div>
</div>


<!-- Button to fetch and edit selected user -->



<!-- table -->

</div>

@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userSelect = document.getElementById("userSelect");
        const searchButton = document.getElementById("searchButton");
        const userDetails = document.getElementById("userDetails");
        const fatherName = document.getElementById("fatherName");
        const email = document.getElementById("email");

        searchButton.addEventListener("click", function(e) {
            e.preventDefault(); // Prevent form submission if inside a form

            const registration_no = userSelect.value;

            if (!registration_no) {
                alert("Please select a user first!");
                return;
            }

            // Fetch user details
            fetch(registration.details)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch user details.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }

                    // Update the UI with fetched data
                    fatherName.textContent = data.father_name || "N/A";
                    email.textContent = data.email || "N/A";
                    userDetails.style.display = "block";
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                    alert("Failed to load user details. Please try again.");
                    userDetails.style.display = "none"; // Hide details if there's an error
                });
        });
    });
</script>

@endsection