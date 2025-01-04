@extends('pages.layouts.app')
@section('title')
Registration
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
                    <h4>Registration List</h4>
                </div>
                <div class="col-md-6 col-sm-12">
                    <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                        <li class="breadcrumb-item"><a href="{{route('panel.dashboard')}}">Dasboard</a></li>
                        <li class="breadcrumb-item active">Registration List</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid py-3">
        <div class="row mt-4">
            <div class="col-md-12 d-flex gap-2">
                @if(havePermission('registration.add'))
                <a href="{{route('registration.form')}}"><button class="btn btn-info mb-3 ml-1"><i class="fas fa-plus-circle me-2"></i>New Registration</button></a>
                @endif

                <a href="#"><button class="btn btn-default text-white mb-3 ml-1 toggle-form" style="background-color:#7c5cc4;"><i class="fas fa-filter me-2" style="font-size:13px;"></i>Filter</button></a>
                <button type="button" class="btn btn-danger mb-3 ml-1" onclick="window.location.href='{{ route('registration.list') }}'">Refresh <i class="fa-solid fa-arrows-rotate"></i>
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
                                <select id="paymentType" name="year" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Year</option>
                                    @for ($year = 2024; $year <= date('Y') + 1; $year++)
                                        <option value="{{ $year }}" @if(isset($_GET['year']) && $_GET['year']==$year) selected @endif>{{ $year }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Filter by Payment Status -->
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <select id="paymentStatus" name="payment_status" class="form-select form-control">
                                    <option value="" disabled selected>Filter by Payment Status</option>
                                    <option value="0" @if(request()->get('payment_status') === '0') selected @endif>Success</option>
                                    <option value="1" @if(request()->get('payment_status') === '1') selected @endif>Due</option>
                                    <option value="2" @if(request()->get('payment_status') === '2') selected @endif>Pending</option>
                                    <option value="3" @if(request()->get('payment_status') === '3') selected @endif>Failed</option>
                                    <option value="4" @if(request()->get('payment_status') === '4') selected @endif>Refunded</option>
                                    <option value="5" @if(request()->get('payment_status') === '5') selected @endif>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <select id="applyFor" name="package" class="form-select form-control" aria-label="Default select example">
                                    <option selected disabled>Filter by Package</option>
                                    @foreach ($Packages as $pckg)
                                    <option value="{{ $pckg->package_id }}"
                                        @if (old('package')==$pckg->package_id) selected @endif>{{ $pckg->package }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group mb-3">
                                <select id="applyFor" name="training_program" class="form-select form-control" aria-label="Default select example">
                                    <option selected disabled>Filter by Training Type</option>
                                    @foreach ($Training as $Trng)
                                    <option value="{{ $Trng->program_id }}"
                                        @if (old('training_program')==$Trng->program_id) selected @endif>{{ $Trng->add_program }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-sm">Apply Filter <i class="fa-solid fa-filter"></i></button>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='{{ route('registration.list') }}'">Refresh <i class="fa-solid fa-arrows-rotate"></i>
                            </button>
                        </div>
                    </div>
            </div>

            </form>
        </div>
    </div>

    <div class="card">

        <div class="card-body">

            <table id="example1" class="table dataTable table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Training</th>
                        <th>Payment Status</th>
                        <th class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr class="">
                        <th>{{ $loop->iteration }}</th>

                        <td>
                            <div class="d-flex">
                                <div class="me-2">
                                    <img src="{{ $row->image && file_exists(public_path('player/' . $row->image)) ? asset('player/' . $row->image) : asset('assets/images/noimages.png') }}" class="rounded-circle" style="height:35px;width:35px">
                                </div>

                                <div>
                                    <span><a href="#" class="d-block fw-bold" style="color:#24ABF2">{{$row->name}}</a></span>
                                    <span>Reg.No. {{$row->registration_no}}</span><br>
                                    <span>Email: {{$row->email}}</span><br>
                                    <span>Phone No.: {{$row->phone}}</span><br>
                                    <span> Gender: @if($row->gender === '0') Male
                                        @elseif($row->gender === '1') Female
                                        @elseif($row->gender === '2') Other
                                        @else Not Specified
                                        @endif
                                    </span><br>

                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <span class="fw-bold" style="color:#24ABF2">Package:</span><span> {{$row->Packages!=null ? $row->Packages->package : '' }} </span><br>
                                <span>Training Program: {{$row->TrainedP!=null ? $row->TrainedP->add_program : '' }}</span><br>
                                <span>Session: {{ $row->sesion!=null ? $row->sesion->session : '' }} </span><br>
                                <span>Time Slot: {{ $row->Time!=null ? $row->Time->time_slot : '' }} </span><br>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold" style="color:#24ABF2">Total:</span><span> {{$row->PaymentDetail->total_amt ?? '' }} </span><br>
                            <span>Paid: {{$row->PaymentDetail->submitted_amt ?? '' }}</span><br>
                            <span>Remaining: {{$row->PaymentDetail->pending_amt ?? '' }} </span><br>

                            @php
                            $statusClasses = [
                            '0' => ['Success', 'badge-success'],
                            '1' => ['Due', 'badge-due'],
                            '2' => ['Pending', 'badge-pending'],
                            '3' => ['Failed', 'badge-failed'],
                            '4' => ['Refunded', 'badge-refunded'],
                            '5' => ['Cancelled', 'badge-cancelled'],
                            ];

                            // Get payment status, default to 0 (Success) if null
                            $status = $row->PaymentDetail->payment_status ?? 0;
                            @endphp

                            <!-- Check if the status exists and assign the correct class, else fallback to 'Unknown' -->
                            <span class="badge {{ isset($statusClasses[$status]) ? $statusClasses[$status][1] : 'badge-default' }}">
                                {{ isset($statusClasses[$status]) ? $statusClasses[$status][0] : 'Unknown' }}
                            </span>
                        </td>


                        <td>

                            @if(havePermission('registration.editpackage'))
                            <a href="{{ route('registration.editpackage', $row->registration_no) }}" class="btn btn-success btn-sm px-2">Update Package</a>
                            @endif
                            @if(havePermission('registration.details'))
                            <a href="{{ route('registration.details', $row->registration_no) }}" class="btn btn-success btn-sm small px-2"><i class="fas fa-eye"></i> </a>
                            @endif
                            @if(havePermission('registration.edit'))
                            <a href="{{ route('registration.edit', $row->registration_no) }}" class="btn btn-info btn-sm small px-2"><i class="fas fa-edit"></i> </a>
                            @endif
                            @if(havePermission('registration.destroy'))
                            <button class="btn btn-danger small btn-sm px-2 delete-registration" data-id="{{ $row->id }}"><i class="fa-solid fa-trash"></i> </button>
                            @endif
                            @if(havePermission('registration.updatePayment'))
                            <!-- Display Registration Data in Modal -->
                            <a href="#"
                                class="btn btn-primary btn-sm small"
                                data-bs-toggle="modal"
                                data-bs-target="#paymentModal"
                                data-registration_no="{{ $row->registration_no }}"
                                data-total_amt="{{ $row->PaymentDetail->total_amt ?? '' }}"
                                data-submitted_amt="{{ $row->PaymentDetail->submitted_amt ?? '' }}"
                                data-pending_amt="{{ $row->PaymentDetail->pending_amt ?? '' }}"
                                data-payment_status="{{ $row->PaymentDetail->payment_status ?? '' }}"
                                data-payment_method="{{ $row->PaymentDetail->payment_method ?? '' }}"
                                data-upcoming_date="{{ $row->PaymentDetail->upcoming_date ?? '' }}"
                                data-payment_notes="{{ $row->PaymentDetail->payment_notes ?? '' }}">
                                Collect Fee
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="paymentModalLabel">Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('registration.updatePayment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="registration_no" id="registration_no">

                        <!-- Total Amount (readonly) -->
                        <div class="d-flex gap-2 mb-2">
                            <div class="fw-bold">Total Amount :</div>
                            <div class="text-primary fw-bold" id="total_amt"></div>
                        </div>

                        <!-- Submitted Amount -->
                        <div class="d-flex gap-2 mb-2">
                            <div class="fw-bold">Paid :</div>
                            <div class="text-success fw-bold" id="submitted_amt_display"></div>
                        </div>

                        <!-- Remaining Amount -->
                        <div class="d-flex gap-2 mb-2">
                            <div class="fw-bold">Remaining:</div>
                            <div class="text-danger fw-bold" id="pending_amt"></div>
                        </div>

                        <!-- Submitted Amount (editable) -->
                        <div class="form-group mb-3">
                            <label for="submitted_amt" class="fw-bold">Amount:</label>
                            <input type="text" class="form-control" id="submitted_amt" name="submitted_amt" placeholder="Enter amount " min="0" required>
                        </div>
                        <!-- <div class="form-group mb-1">
                            <label for="submitted_amt" class="fw-bold">Amount:</label>
                            <input type="text" class="form-control" id=" " name=" " value="{{ old(' ') }}">
                        </div> -->

                        <!-- Payment Status -->
                        <div class="form-group mb-2">
                            <label for="payment_status" class="fw-bold">Payment Status:<span class="text-danger"> *</span></label>
                            <select class="form-select" id="payment_status" name="payment_status">
                                <option value="" disabled>Select Status</option>
                                <option value="0">Success</option>
                                <option value="1">Due</option>
                                <option value="2">Pending</option>
                                <option value="3">Failed</option>
                                <option value="4">Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="payment_method" class="fw-bold">Payment Method:</label>
                            <select class="form-select" id="payment_method" name="payment_method">
                                <option value="" disabled>Select Payment Method</option>
                                <option value="0">Offline</option>
                                <option value="1">Online</option>
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <label for="submitted_amt" class="fw-bold">Date:</label>
                            <input type="date" class="form-control" id="upcoming_date" name="upcoming_date" value="{{ old('upcoming_date') }}">
                        </div>
                        <!-- Payment Notes -->
                        <div class="form-group mb-2">
                            <label for="payment_notes" class="fw-bold">Payment Notes:</label>
                            <textarea class="form-control" id="payment_notes" name="payment_notes"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    @endsection

    @section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentModal = document.getElementById('paymentModal');

            // Event listener for when the modal is shown
            paymentModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // The button that triggered the modal

                // Retrieve dynamic data from the button's data attributes
                const registrationNo = button.getAttribute('data-registration_no');
                const totalAmt = parseFloat(button.getAttribute('data-total_amt')) || 0;
                const submittedAmt = parseFloat(button.getAttribute('data-submitted_amt')) || 0;
                const paymentStatus = button.getAttribute('data-payment_status');
                const paymentMethod = button.getAttribute('data-payment_method');
                const paymentDate = button.getAttribute('data-upcoming_date');
                const paymentNotes = button.getAttribute('data-payment_notes');

                // Populate modal fields with data from the button
                document.getElementById('registration_no').value = registrationNo;
                document.getElementById('total_amt').textContent = totalAmt.toFixed(2);
                document.getElementById('submitted_amt_display').textContent = submittedAmt.toFixed(2);
                document.getElementById('payment_status').value = paymentStatus;
                document.getElementById('payment_method').value = paymentMethod;
                document.getElementById('upcoming_date').value = paymentDate;
                document.getElementById('payment_notes').value = paymentNotes;

                // Update Remaining Amount (Total - Submitted)
                const pendingAmt = totalAmt - submittedAmt;
                document.getElementById('pending_amt').textContent = pendingAmt.toFixed(2);

                // Clear the 'Amount' field so user can fill it
                document.getElementById('submitted_amt').value = '';
            });

            // Event listener for when the modal is hidden (optional, to reset the 'Amount' field)
            paymentModal.addEventListener('hidden.bs.modal', function() {
                // Clear the 'Amount' field after modal is closed
                document.getElementById('submitted_amt').value = '';
            });
            // If pending amount is 0 and status is not filled, set status to 0 (Success)
            if (pendingAmt === 0 && !paymentStatus) {
                document.getElementById('payment_status').value = 0;
            }
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.delete-registration').click(function() {
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
                        url: "{{ route('registration.destroy') }}",
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
        document.querySelector('.toggle-form').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default action of the link

            var formSection = document.getElementById('filterForm');

            if (formSection.style.display === 'none' || formSection.style.display === '') {
                formSection.style.display = 'block'; // Show the form
            } else {
                formSection.style.display = 'none'; // Hide the form
            }
        });
    </script>




    @endsection