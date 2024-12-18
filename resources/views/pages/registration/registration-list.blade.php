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
                            @php
                            $statusClasses = [
                            '0' => ['Success', 'badge-success'],
                            '1' => ['Due', 'badge-due'],
                            '2' => ['Pending', 'badge-pending'],
                            '3' => ['Failed', 'badge-failed'],
                            '4' => ['Refunded', 'badge-refunded'],
                            '5' => ['Cancelled', 'badge-cancelled'],
                            ];
                            $status = $row->PaymentDetail->payment_status ?? null;
                            @endphp
                            <span class="badge {{ $statusClasses[$status][1] ?? 'badge-default' }}">
                                {{ $statusClasses[$status][0] ?? 'Unknown' }}
                            </span>
                        </td>
                        <td>

                            @if(havePermission('registration.details'))
                            <a href="{{ route('registration.details', $row->registration_no) }}" class="text-success px-2"><i class="fas fa-eye"></i> </a>
                            @endif
                            @if(havePermission('registration.edit'))
                            <a href="{{ route('registration.edit', $row->registration_no) }}" class="text-info px-2"><i class="fas fa-edit"></i> </a>
                            @endif
                            @if(havePermission('registration.destroy'))
                            <button class="btn btn-default text-danger btn-sm px-2 delete-registration" data-id="{{ $row->id }}"><i class="fa-solid fa-trash"></i> </button>
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
    <script>
        $(document).ready(function() {
            function toggleFields(paymentMethod) {

                $('#utr_no_group').toggle(paymentMethod == '1');
                $('#registration_fee_group').toggle(paymentMethod == '0');
            }
            toggleFields($('#payment_method').val());
            $('#payment_method').on('change', function() {
                toggleFields($(this).val());
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const packageSelect = document.getElementById("package");
            const trainingProgramField = document.getElementById("training_program_field");
            const knownPackages = ['Training Program', 'TrainingProgram', 'training program', 'training-program', 'Training Programme', 'Training programme', 'trainingprogram', 'Training-Program'];

            // Fuse.js options
            const options = {
                includeScore: true,
                threshold: 0.3,
            };
            const fuse = new Fuse(knownPackages, options);

            // Check the pre-selected value on page load
            const selectedText = packageSelect.options[packageSelect.selectedIndex].text.trim();
            const result = fuse.search(selectedText);
            let showTrainingProgram = false;
            for (let i = 0; i < result.length; i++) {
                if (result[i].item.toLowerCase() === 'training program') {
                    showTrainingProgram = true;
                    break;
                }
            }
            // Show or hide the Training Program field based on the selection
            if (showTrainingProgram) {
                trainingProgramField.style.display = "block";
            } else {
                trainingProgramField.style.display = "none";
            }

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
                    trainingProgramField.style.display = "block";
                } else {
                    trainingProgramField.style.display = "none";
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-bs-target="#exampleModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    // Map data-* attributes to modal fields
                    const fields = [
                        'registration_no',
                        'package',
                        'training_program',
                        'session',
                        'time_slot',
                        'payment_module',
                        'payment_date',
                        'payment_status',
                        'payment_method',
                        'registration_fees',
                        'utr_no',
                        'notes'
                    ];

                    fields.forEach(field => {
                        const modalField = document.getElementById(field);
                        const dataValue = this.getAttribute(`data-${field}`);
                        if (modalField) {
                            if (modalField.tagName === 'SELECT' || modalField.tagName === 'INPUT') {
                                modalField.value = dataValue || '';
                            } else if (modalField.tagName === 'TEXTAREA') {
                                modalField.textContent = dataValue || '';
                            }
                        }
                    });
                });
            });
        });
    </script>


    @endsection