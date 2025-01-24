@extends('pages.layouts.app')
@section('title')
Enquiry
@endsection

@section('css')
<script src="https://cdn.jsdelivr.net/npm/fuse.js@6.4.6/dist/fuse.min.js"></script>
@endsection
@php
use Carbon\Carbon;

// Create an array with all months
$months = [];
for ($i = 1; $i <= 12; $i++) {
    $months[]=Carbon::create()->month($i)->format('F');
    }

    @endphp
    @section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-12">
                    <h4>Create And Manage Enquiry </h4>
                </div>
                <div class="col-md-6 col-sm-12">
                    <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                        <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                        <li class="breadcrumb-item active">Enquiry </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid py-3">
        <div class="row mt-4">
            <div class="col-md-12 d-flex gap-2">
                @if(havePermission('enquiry.add'))
                <button id="toggleButton" class="btn btn-info mb-3 ml-1"><i class="fas fa-plus-circle mr-2"></i> Add Enquiry </button>
                @endif
                <a href="#"><button class="btn btn-default text-white mb-3 ml-1 toggle-form" style="background-color:#7c5cc4;"><i class="fas fa-filter mr-2" style="font-size:13px;"></i> Filter</button></a>
                <button type="button" class="btn btn-danger mb-3 ml-1" onclick="window.location.href='{{ route('enquiry.list') }}'">Refresh <i class="fa-solid fa-arrows-rotate"></i>
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
        <div class="card togglediv overflow-auto" @if (!$errors->any()) style="display: none;" @endif>

            <div class="card-body">
                <div class="row">
                    <form action="{{route('enquiry.add')}}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control quantity" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Email </label>
                                    <input type="text" class="form-control quantity" name="email" value="{{ old('email') }}" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Phone No.<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control quantity" name="mobile" value="{{ old('mobile') }}" placeholder="Enter Phone No.">
                                </div>
                            </div>


                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="lead_source">Lead Source </label>
                                    <select name="lead_source" class="form-select">
                                        <option value="" disabled selected>Select Lead Source</option>
                                        @foreach ($leads as $lead)
                                        <option value="{{ $lead->leadsource_id }}"
                                            @if (old('lead_source')==$lead->leadsource_id) selected @endif>
                                            {{ $lead->leadsource }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="package">Category </label>
                                    <select name="package" id="package" class="form-select">
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($Packages as $Packag)
                                        <option value="{{ $Packag->package_id }}"
                                            @if (old('package')==$Packag->package_id) selected @endif>
                                            {{ $Packag->package }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- make sure add Training Program -->
                            <div id="trainingProgramContainer" class="col-md-4 col-sm-12" style="display: none;">
                                <div class="form-group">
                                    <label for="training_program">Training Program Type </label>
                                    <select name="training_program" class="form-select">
                                        <option value="" disabled selected>Select Training Program Type</option>
                                        @foreach ($Training as $Trng)
                                        <option value="{{ $Trng->program_id }}"
                                            @if (old('training_program')==$Trng->program_id) selected @endif>
                                            {{ $Trng->add_program }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="session">Session </label>
                                    <select name="session" class="form-select">
                                        <option value="" disabled selected>Select Session</option>
                                        @foreach ($session as $sesion)
                                        <option value="{{ $sesion->session_id }}"
                                            @if (old('session')==$sesion->session_id) selected @endif>
                                            {{ $sesion->session }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="time_slot">Time Slot </label>
                                    <select name="time_slot" class="form-select">
                                        <option value="" disabled selected>Select Time Slot</option>
                                        @foreach ($Timing as $Time)
                                        <option value="{{ $Time->timing_id }}"
                                            @if (old('time_slot')==$Time->timing_id) selected @endif>
                                            {{ $Time->time_slot }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Enquiry Date<span class="text-danger">*</span></label>
                                    <input type="Date" class="form-control quantity" name="enquiry_date" value="{{ old('enquiry_date') }}" placeholder="Enter Followup Date">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Followup Date<span class="text-danger">*</span></label>
                                    <input type="Date" class="form-control quantity" name="followup_date" value="{{ old('followup_date') }}" placeholder="Enter Followup Date">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="lead_status">Lead Status <span class="text-danger">*</span></label>
                                    <select class="form-control" name="lead_status">
                                        <option value="" disabled selected>Select Lead Status</option>
                                        <option value="0" @if (old('lead_status')==0) selected @endif>New</option>
                                        <option value="1" @if (old('lead_status')==1) selected @endif>Assigned</option>
                                        <option value="2" @if (old('lead_status')==2) selected @endif>In Process</option>
                                        <option value="3" @if (old('lead_status')==3) selected @endif>Converted</option>
                                        <option value="4" @if (old('lead_status')==4) selected @endif>Dead</option>
                                        <option value="5" @if (old('lead_status')==5) selected @endif>Recycle</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="interested_branch">Interested Branch</label>
                                    <select name="interested_branch" class="form-select">
                                        <option value="" disabled {{ old('interested_branch') == null ? 'selected' : '' }}>Select Branch</option>
                                        @foreach ($location as $locate)
                                        <option value="{{ $locate->location_id }}"
                                            @if (old('interested_branch')==$locate->location_id) selected @endif>
                                            {{ $locate->location }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Address</label>
                                    <textarea class="form-control" name="address" placeholder="Write Address here...">{{ old('address') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Notes</label>
                                    <textarea class="form-control" name="notes" placeholder="Write notes here...">{{ old('notes') }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 d-flex justify-content-between align-items-center mt-4 w-100">
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
        <div class="card" id="filterForm" style="display: none;">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">
                        <!-- <div class="">
                            <h6 class="card-title">Filter</h6>
                        </div> -->

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label for="enquiryDate" class="small">Filter by Enquiry Date</label>
                                <input type="date" id="enquiryDate" name="enquiry_date" class="form-control" value="{{ old('enquiry_date', request('enquiry_date')) }}">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label for="followupDate" class="small">Filter by Follow-up Date</label>
                                <input type="date" id="followupDate" name="followup_date" class="form-control" value="{{ old('followup_date', request('followup_date')) }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group mb-3">
                                <select id="paymentType" name="month" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Month</option>
                                    @foreach ($months as $month)
                                    <option value="{{ $month }}" @if(isset($_GET['month']) && $_GET['month']==$month) selected @endif>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group mb-3">
                                <select id="paymentType" name="year" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Year</option>
                                    @for ($year = 2024; $year <= date('Y') + 1; $year++)
                                        <option value="{{ $year }}" @if(isset($_GET['year']) && $_GET['year']==$year) selected @endif>{{ $year }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Filter by Payment Status -->
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group mb-3">
                                <select id="leadStatus" name="lead_status" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Lead Status</option>
                                    <option value="0" @if(request()->get('lead_status') === '0') selected @endif>New</option>
                                    <option value="1" @if(request()->get('lead_status') === '1') selected @endif>Assigned</option>
                                    <option value="2" @if(request()->get('lead_status') === '2') selected @endif>Inprocess</option>
                                    <option value="3" @if(request()->get('lead_status') === '3') selected @endif>Converted</option>
                                    <option value="4" @if(request()->get('lead_status') === '4') selected @endif>Dead</option>
                                    <option value="5" @if(request()->get('lead_status') === '5') selected @endif>Recycle</option>
                                </select>
                            </div>
                        </div>


                        <div class="d-flex gap-2 justify-content-end">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-sm">Apply Filter <i class="fa-solid fa-filter"></i></button>
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='{{ route('enquiry.list') }}'">Refresh <i class="fa-solid fa-arrows-rotate"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- table -->
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table dataTable table-hover">
                    <thead>
                        <tr class="">
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Date & Status</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr class="small">
                            <th>{{ $loop->iteration }}</th>
                            <td>
                                <strong>Name:</strong> {{ $row->name }}<br>
                                <strong>Email:</strong> {{ $row->email }}<br>
                                <strong>Phone:</strong> {{ $row->mobile }}<br>
                                <strong>Lead Source:</strong> {{ $row->leads!=null ? $row->leads->leadsource : '' }} <br>
                            </td>

                            <td>
                                <strong>Category:</strong> {{ $row->Package!=null ? $row->Package->package : '' }} <br>
                                <strong>Session:</strong> {{ $row->sesion!=null ? $row->sesion->session : '' }} <br>
                                <strong>Time Slot:</strong> {{ $row->Time!=null ? $row->Time->time_slot : '' }}<br>
                                <strong>Training Program:</strong> {{ $row->TrainedP!=null ? $row->TrainedP->add_program : '' }}
                            </td>

                            <td>
                                <strong>Enquiry Date:</strong> {{ \Carbon\Carbon::parse($row->enquiry_date)->format('d/m/y') }}<br>
                                <strong>Followup Date:</strong> {{ \Carbon\Carbon::parse($row->followup_date)->format('d/m/y') }}<br>

                                <strong>Lead Status:</strong>
                                <span class="badge 
                                {{ $row->lead_status == '0' ? 'bg-primary' : 
                                ($row->lead_status == '1' ? 'bg-info' : 
                                ($row->lead_status == '2' ? 'bg-warning' : 
                                ($row->lead_status == '3' ? 'bg-success' : 
                                ($row->lead_status == '4' ? 'bg-dark' : 
                                'bg-secondary')))) }}">
                                    {{ $row->lead_status == '0' ? 'New' : 
                                ($row->lead_status == '1' ? 'Assigned' : 
                                ($row->lead_status == '2' ? 'Inprocess' : 
                                ($row->lead_status == '3' ? 'Converted' : 
                                ($row->lead_status == '4' ? 'Dead' : 'Recycle')))) }}
                                </span>
                                <br>
                            </td>
                            <td>{{ $row->notes }}</td>

                            <td>
                                @if(havePermission('enquiry.status'))
                                <a href="{{ route('enquiry.status', ['id' => $row->enquiry_Id])}}" class="btn btn-default text-white btn-sm" style="background-color: #7c5cc4;"><i class="fas fa-eye"></i></a>
                                @endif
                                @if(havePermission('enquiry.updateStatus'))
                                <a href="#" class="btn btn-success text-white  btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-enquiry_id="{{ $row->enquiry_Id }}"
                                    data-followup_date="{{ $row->followup_date }}" data-status="{{ $row->lead_status }}" data-notes="{{ $row->notes }}">
                                    <i class="fa-solid fa-user-plus"></i>
                                </a>
                                @endif


                                @if(havePermission('enquiry.edit'))
                                <a href="{{ route('enquiry.edit', $row->enquiry_Id) }}" class=" btn btn-info btn-sm"><i class="fas fa-edit"></i> </a>
                                @endif
                                @if(havePermission('registration.form'))
                                @if ($row->lead_status == 3)
                                <a href="{{ route('registration.form', $row->id) }}" class="btn bg-primary text-white btn-sm small"> </i>convert</a>
                                @else @endif
                                @endif



                                @if(havePermission('enquiry.destroy'))
                                <button class="btn btn-danger btn-sm  delete-enquiry" data-id="{{ $row->id }}"><i class="fa-solid fa-trash"></i> </button>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Followup Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body">
                        <form action="{{ route('enquiry.updateStatuss') }}" method="POST">
                            @csrf

                            <input type="hidden" name="enquiry_Id" id="enquiry_Id">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="followup_date">Followup Date</label>
                                        <input type="date" class="form-control" name="followup_date" id="followup_date">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="lead_status">Lead Status</label>
                                        <select class="form-control" name="lead_status" id="lead_status">
                                            <option value="" disabled selected>Select Lead Status</option>
                                            <option value="0">New</option>
                                            <option value="1">Assigned</option>
                                            <option value="2">In Process</option>
                                            <option value="3">Converted</option>
                                            <option value="4">Dead</option>
                                            <option value="5">Recycle</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" name="notes" id="notes"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.delete-enquiry').click(function() {
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
                        url: "{{ route('enquiry.destroy') }}",
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
        document.addEventListener("DOMContentLoaded", function() {
            const packageSelect = document.getElementById("package");
            const trainingProgramContainer = document.getElementById("trainingProgramContainer");
            const knownPackages = ['Training Program', 'TrainingProgram', 'training program', 'training-program', 'Training Programme', 'Training programme',
                'trainingprogram', 'Training-Program'
            ];
            // Fuse.js options
            const options = {
                includeScore: true,
                threshold: 0.3,
            };
            const fuse = new Fuse(knownPackages, options);
            packageSelect.addEventListener("change", function() {
                const selectedText = packageSelect.options[packageSelect.selectedIndex].text.trim();
                const result = fuse.search(selectedText);
                let showTrainingProgram = false;
                for (let i = 0; i < result.length; i++) {
                    if (result[i].item.toLowerCase() === 'training program') {
                        showTrainingProgram = true;
                        break;
                    }
                }
                if (showTrainingProgram) {
                    trainingProgramContainer.style.display = "block";
                } else {
                    trainingProgramContainer.style.display = "none";
                }
            });
        });
    </script>
    <script>
        // When the modal is triggered, populate the fields dynamically
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var enquiryId = button.data('enquiry_id');
            var followup = button.data('followup_date');
            var leadStatus = button.data('status');
            var notes = button.data('notes');

            // Populate the modal's form with the values
            var modal = $(this);
            modal.find('#enquiry_Id').val(enquiryId);
            modal.find('#followup_date').val(followup);
            modal.find('#lead_status').val(leadStatus);
            modal.find('#notes').val(notes);
        });
    </script>
    <script>
        document.querySelector('.toggle-form').addEventListener('click', function(e) {
            e.preventDefault();

            var formSection = document.getElementById('filterForm');

            if (formSection.style.display === 'none' || formSection.style.display === '') {
                formSection.style.display = 'block';
            } else {
                formSection.style.display = 'none';
            }
        });
    </script>
    @endsection