@extends('pages.layouts.app')
@section('title')
Enquiry
@endsection

@section('css')

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
                @if(havePermission('enquiry.Form'))
                <a href="{{route('enquiry.Form')}}"><button class="btn btn-info mb-3 ml-1"><i class="fas fa-plus-circle mr-2"></i> Add Enquiry </button></a>
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

        <div class="card" id="filterForm" style="display: none;">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">

                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="enquiryDate" class="small">Filter by Enquiry Date</label>
                                <input type="date" id="enquiryDate" name="enquiry_date" class="form-control" value="{{ old('enquiry_date', request('enquiry_date')) }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label>Followup Date From :</label>
                                <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <label>Followup Date To :</label>
                                <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">

                                <!-- <label for="followupDate" class="small">Filter by Follow-up Date</label>
                                <input type="date" id="followupDate" name="followup_date" class="form-control" value="{{ old('followup_date', request('followup_date')) }}"> -->
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <label for="followupDate" class="small">Month</label>
                                <select id="paymentType" name="month" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Month</option>
                                    @foreach ($months as $month)
                                    <option value="{{ $month }}" @if(isset($_GET['month']) && $_GET['month']==$month) selected @endif>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <!-- <label for="followupDate" class="small">Year</label> -->
                                <select id="paymentType" name="year" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Year</option>
                                    @for ($year = 2024; $year <= date('Y') + 1; $year++)
                                        <option value="{{ $year }}" @if(isset($_GET['year']) && $_GET['year']==$year) selected @endif>{{ $year }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <select id="leadStatus" name="lead_status" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Hostel</option>
                                    <option value="0" @if(request()->get('hostel') === '0') selected @endif>No</option>
                                    <option value="1" @if(request()->get('hostel') === '1') selected @endif>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <select id="leadStatus" name="transport" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Transport</option>
                                    <option value="0" @if(request()->get('transport') === '0') selected @endif>No</option>
                                    <option value="1" @if(request()->get('transport') === '1') selected @endif>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <select name="package" id="package" class="form-select">
                                    <option value="" disabled selected>Filter by Category</option>
                                    @foreach ($Packages as $Packag)
                                    <option value="{{ $Packag->package_id }}"
                                        @if (old('package')==$Packag->package_id) selected @endif>
                                        {{ $Packag->package }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Filter by Payment Status -->
                        <!-- <div class="col-lg-3 col-sm-12">
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
                        </div> -->


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
                            <th>Name & Category</th>
                            <th>Date & Status</th>
                            <th>Notes</th>
                            <!-- <th>Move</th> -->
                            <th class="text-center">Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr class="small">
                            <th>{{ $loop->iteration }}</th>
                            <td>
                                <strong>Name:</strong> {{ $row->name }}<br>
                                <!-- <strong>Enquiry_Id:</strong> {{ $row->enquiry_Id }}<br> -->
                                <!-- <strong>Email:</strong> {{ $row->email }}<br> -->
                                <strong>Phone:</strong> {{ $row->mobile }}<br>
                                <strong>Category:</strong> {{ $row->Package!=null ? $row->Package->package : '' }} <br>
                                <!-- <strong>Lead Source:</strong> {{ $row->leads!=null ? $row->leads->leadsource : '' }} <br> -->
                            </td>

                            <!-- <td>
                                <strong>Category:</strong> {{ $row->Package!=null ? $row->Package->package : '' }} <br>
                                <strong>Session:</strong> {{ $row->sesion!=null ? $row->sesion->session : '' }} <br>
                                <strong>Time Slot:</strong> {{ $row->Time!=null ? $row->Time->time_slot : '' }}<br>
                                <strong>Training Program:</strong> {{ $row->TrainedP!=null ? $row->TrainedP->add_program : '' }}
                            </td> -->

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
                                <strong>Interested Branch: </strong>{{ $row->interestedlocation ? $row->interestedlocation->location : 'N/A' }}
                            </td>
                            <td style="max-width: 150px; overflow: auto; white-space: normal;">
                                <div style="max-height: 100px; overflow-y: auto;">
                                    {{ $row->notes }}
                                </div>
                            </td>
                            <!-- BUTTONS -->
                            <td id="lead-row-{{ $row->id }}" class="text-center">
                                <div class="d-inline-block">
                                    @if($row->is_converted == '0')
                                    <form action="{{ route('enquiry.moveLocation', $row->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <div class="d-flex align-items-center gap-2">
                                            <select name="locationID" class="form-select form-select-sm">
                                                @foreach ($location as $loc)
                                                <option value="{{ $loc->location_id }}" {{ $row->locationID == $loc->location_id ? 'selected' : '' }}>
                                                    {{ $loc->location }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm" title="Send Lead">
                                                <i class="fa-solid fa-arrow-up"></i>
                                            </button>
                                        </div>
                                    </form>

                                    @if(havePermission('enquiry.status'))
                                    <a href="{{ route('enquiry.status', ['id' => $row->enquiry_Id]) }}" class="btn btn-dark btn-sm d-inline-block" title="View Status">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif

                                    @if(havePermission('enquiry.updateStatus'))
                                    <a href="#" class="btn btn-success btn-sm d-inline-block"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        data-enquiry_id="{{ $row->enquiry_Id }}"
                                        data-followup_date="{{ $row->followup_date }}"
                                        data-status="{{ $row->lead_status }}"
                                        data-notes="{{ $row->notes }}"
                                        title="Followup Status">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </a>
                                    @endif

                                    @if(havePermission('enquiry.edit'))
                                    <a href="{{ route('enquiry.edit', $row->enquiry_Id) }}" class="btn btn-info btn-sm d-inline-block" title="Edit Enquiry">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif

                                    @if(havePermission('registration.form') && $row->lead_status == 3)
                                    <a href="{{ route('registration.form', $row->id) }}" class="btn bg-primary text-white btn-sm d-inline-block" title="Convert Lead Into Registration">
                                        Convert
                                    </a>
                                    @endif

                                    @if(havePermission('enquiry.destroy'))
                                    <button class="btn btn-danger btn-sm delete-registration d-inline-block"
                                        data-id="{{ $row->id }}"
                                        data-enquiry_id="{{ $row->enquiry_Id }}"
                                        title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    @endif
                                    @else
                                    <span class="badge bg-success d-inline-block">Converted</span>
                                    @endif
                                </div>
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
    <script>
        $(document).on('change', '.move-location-dropdown', function() {
            let enquiryId = $(this).data('id');
            let newLocation = $(this).val();

            $.ajax({
                url: `/enquiry/move-location/${enquiryId}`,
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    new_location: newLocation
                },
                success: function(response) {
                    alert('Location updated successfully!');
                },
                error: function() {
                    alert('Failed to update location.');
                }
            });
        });
    </script>

    @endsection