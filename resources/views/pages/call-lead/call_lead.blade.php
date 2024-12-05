@extends('pages.layouts.app')
@section('title')
Call Lead
@endsection

@section('css')
   
@endsection

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <h3>Create and Manage Call Lead</h3>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <button id="toggleButton" class="btn btn-primary dark mb-3 ml-1"><i class="fas fa-plus-circle me-2"></i>Add New Lead</button>
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

        {{-- Add Call Lead form  --}}
        <div class="card  togglediv" @if (!$errors->any()) style="display: none;" @endif>
            <div class="card-header dark">
                <h3 class="card-title ">Add Call Lead</h3>
            </div>
            <div class="card-body">


                <div class="row">
                    <form action="{{route('Callleads.save')}}" method="POST">
                        @csrf
                         <div class="row">
                             
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Name </label>
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Email </label>
                                    <input type="text" class="form-control" name="email" value="{{old('email')}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Phone </label>
                                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">College </label>
                                    <input type="text" class="form-control" name="college" value="{{old('college')}}" placeholder="">
                                </div>
                            </div>


                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Courses </label>
                                    <select class="form-select" name="course" aria-label="Default select example">
                                        <option selected disabled>Select Courses</option>
                                        <option value="B.Tech">B.Tech</option>
                                        <option value="B.C.A">B.C.A</option>
                                        <option value="M.C.A">M.C.A</option>
                                        <option value="Diploma (CS)">Diploma (CS)</option>
                                        <option value="Diploma(IT)">Diploma(IT)</option>
                                        <option value="PGDCA">PGDCA</option>
                                        <option value="Others">Others</option>
                                        
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Training Type </label>
                                    <select class="form-select" name="training_type" aria-label="Default select example">
                                        <option selected disabled>Select Training Type</option>
                                        <option value="Php Summer Training">Php Summer Training</option>
                                        <option value="Php Apperenticeship Training">Php Apperenticeship Training</option>
                                        <option value="Flutter Summer Training">Flutter Summer Training</option>
                                        <option value="Flutter Apperenticeship Training">Flutter Apperenticeship Training</option>
                                        <option value="Job Oriented Training">Job Oriented Training</option>
                                        <option value="UI/UX Training">UI/UX Training</option>                                       
                                        <option value="Others">Others</option>
                                        
                                    </select>
                                     
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Lead Source </label>
                                    <select class="form-select" name="lead_source" aria-label="Default select example">
                                        <option selected disabled>Select Lead Source</option>
                                        <option value="Self Motivated">Self Motivated</option>
                                        <option value="Family & Friends">Family & Friends</option>
                                        <option value="Students Referal">Students Referal</option>
                                        <option value="Office Employees">Office Employees</option> 
                                        <option value="Others">Others</option>
                                        
                                    </select>
                                     
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Enquiry Date </label>
                                    <input type="text" class="form-control" name="enquiry_date" value="{{old('enquiry_date')}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Follow Date </label>
                                    <input type="text" class="form-control" name="follow_date" value="{{old('follow_date')}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Year </label>
                                    <select class="form-select" name="year" aria-label="Default select example">
                                        <option selected disabled>Select Year</option>
                                        <option value="First Year">First Year</option>
                                        <option value="Second Year">Second Year</option>
                                        <option value="Third Year">Third Year</option>
                                        <option value="Fourth Year">Fourth Year</option>                                      
                                        <option value="Others">Others</option>
                                        
                                    </select>
                                      
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name">Notes </label>
                                    <textarea type="text" class="form-control" name="notes" value="{{old('notes')}}" placeholder=""></textarea>
                                </div>
                            </div>
                            
                            
                         </div>
                         
 
                        <div class="col-md-12 d-flex justify-content-end">
                            <button class="btn btn-dark  my-3 ml-1" type="submit">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        {{-- ./ Add Call Lead form  --}}

        <div class="card">
            <div class="card-header dark">
                <h3 class="card-title ">Call Lead List</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0 py-3 px-1">

                                <table id="example2" class="table table-hover text-nowrap">
                                    <thead class="bg-light">
                                        <tr class="">
                                            <th>#</th>
                                            <th>Lead Id</th>
                                            {{-- <th>Added BY</th> --}}
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>College </th>
                                            <th>Course</th>
                                            <th>Training Type</th>
                                            <th>Lead Source</th>
                                            <th>Enquiry date</th>
                                            <th>Follow Date</th>
                                            <th>Notes</th>
                                            <th> Year</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $row)
                                            <tr class="">

                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $row->lead_id }}</td>
                                                {{-- <td>{{ $row->added_by }}</td> --}}
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->phone }}</td>
                                                <td>{{ $row->college }}</td>
                                                <td>{{ $row->course }}</td>
                                                <td>{{ $row->training_type }}</td>
                                                <td>{{ $row->lead_source }}</td>
                                                <td>{{ $row->enquiry_date }}</td>
                                                <td>{{ $row->follow_date }}</td>
                                                <td>{{ $row->notes }}</td>
                                                <td>{{ $row->year }}</td>
                                                
                                               
                                                <td>
                                                    <span class="badge 
                                                    @if($row->status == '0') bg-warning 
                                                    @elseif($row->status == '1') bg-orange 
                                                    @elseif($row->status == '2') bg-primary 
                                                    @elseif($row->status == '3') bg-success 
                                                    @elseif($row->status == '4') bg-info 
                                                    @elseif($row->status == '5') bg-danger 
                                                    @elseif($row->status == '6') bg-pink 
                                                    @elseif($row->status == '7') bg-purple 
                                                    @elseif($row->status == '8') bg-secondary 
                                                    @elseif($row->status == '9') bg-dark 
                                                    @endif">
                                                    @if($row->status == '0') Received 
                                                    @elseif($row->status == '1') Not Recieved 
                                                    @elseif($row->status == '2') Followup Date 
                                                    @elseif($row->status == '3') Enrolled 
                                                    @elseif($row->status == '4') Not Interested 
                                                    @elseif($row->status == '5') Failed
                                                    @elseif($row->status == '6') Brochure Sent 
                                                    @elseif($row->status == '7') Insititute Visit 
                                                    @elseif($row->status == '8') Invalid 
                                                    @elseif($row->status == '9') Rejected 
                                                    
                                                    @endif
                                                </span>
                                                    
                                                    
                                                </td> 

                                                <td>
                                                    <a href="{{route('Callleads.view-more',$row->lead_id)}}"><button class="btn btn-outline-success btn-sm px-2"><i class="fa-solid fa-eye"></i> </button></a>
                                                    <a href="{{route('Callleads.edit',$row->lead_id)}}"><button class="btn btn-outline-primary btn-sm px-2"><i class="fas fa-edit"></i> </button></a> 

                                                    <button class="btn btn-outline-danger btn-sm px-2 delete-Call Lead" data-id="{{ $row->id }}"><i class="fa-solid fa-trash"></i>
                                                    </button>

                                                </td>

                                            </tr>
                                        @endforeach 

                                    </tbody>
                                </table>


                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

   
@endsection

@section('js')

 
@endsection
