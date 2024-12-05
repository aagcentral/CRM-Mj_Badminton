@extends('pages.layouts.app')
@section('title')
    View Call Leads
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-fluid py-3">
        <div class="row mt-5">
            <div class="col-lg-6 col-sm-12">
                 
                <div class="invoice p-3 mb-3">
 
                    <div class="row">
 
                        <div class="col-12">
                            <p class="lead fw-bold">View Details</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        
                                            <tr>
                                                <th style="width:50%">Name:</th>
                                                <td>{{ $viewdata->name?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td>{{ $viewdata->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>phone:</th>
                                                <td>{{ $viewdata->phone }}</td>
                                                
                                            </tr>
                                            <tr>
                                                <th>College:</th>
                                                <td>{{ $viewdata->college }}</td>
                                            </tr>
                                            <tr>
                                                <th>Course:</th>
                                                <td>{{ $viewdata->course }}</td>
                                            </tr>
                                            <tr>
                                                <th>Training Type:</th>
                                                <td>{{ $viewdata->training_type }}</td>
                                            </tr>
                                            <tr>
                                                <th>Lead Source:</th>
                                                <td>{{ $viewdata->lead_source }}</td>
                                            </tr>
                                            <tr>
                                                <th>Enquiry Date:</th>
                                                <td>{{ $viewdata->enquiry_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Follow Date:</th>
                                                <td>{{ $viewdata->follow_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Year:</th>
                                                <td>{{ $viewdata->year }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <span class="badge 
                                                    @if($viewdata->status == '0') bg-warning 
                                                        @elseif($viewdata->status == '1') bg-orange 
                                                        @elseif($viewdata->status == '2') bg-primary 
                                                        @elseif($viewdata->status == '3') bg-success 
                                                        @elseif($viewdata->status == '4') bg-info 
                                                        @elseif($viewdata->status == '5') bg-danger 
                                                        @elseif($viewdata->status == '6') bg-pink 
                                                        @elseif($viewdata->status == '7') bg-purple 
                                                        @elseif($viewdata->status == '8') bg-secondary 
                                                        @elseif($viewdata->status == '9') bg-dark 
                                                        @endif">
                                                        @if($viewdata->status == '0') Received 
                                                        @elseif($viewdata->status == '1') Not Recieved 
                                                        @elseif($viewdata->status == '2') Followup Date 
                                                        @elseif($viewdata->status == '3') Enrolled 
                                                        @elseif($viewdata->status == '4') Not Interested 
                                                        @elseif($viewdata->status == '5') Failed
                                                        @elseif($viewdata->status == '6') Brochure Sent 
                                                        @elseif($viewdata->status == '7') Insititute Visit 
                                                        @elseif($viewdata->status == '8') Invalid 
                                                        @elseif($viewdata->status == '9') Rejected 
                                                        
                                                    @endif    
                                                </span>
                                            </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                    <div class="row no-print">
                        <div class="col-12">
                            
                            <a href="{{route('Callleads.edit',$viewdata->lead_id)}}"><button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-edit"></i> Edit
                            </button></a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="callout callout-info">
                    <h5> Lead Notes:</h5>
                    <p>{{ $viewdata->notes}}</p>
                </div>
 
            </div>
            
        </div>
    </div>
@endsection

@section('js')
@endsection
