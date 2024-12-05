@extends('pages.layouts.app')
@section('title')
Enquiry
@endsection

@section('css')

@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6 col-sm-12">
                <h4>View Status and Enquiry History</h4>
            </div>
            <div class="col-md-6 col-sm-12">
                <ol class="breadcrumb float-sm-right" style="font-family: sans-serif;">
                    @if(havePermission('enquiry.list'))
                    <li class="breadcrumb-item"><a href="{{route('enquiry.list')}}">Enquiry</a></li>
                    @endif
                    <li class="breadcrumb-item active">Status</li>
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

    <!-- table -->
    <div class="col-md-10 col-sm-12 m-auto">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table dataTable table-hover">
                    <thead>
                        <tr class="">
                            <th>Enquiry & Lead Status</th>
                            <th>Enquiry & Lead Notes</th>
                            <th>Date</th>
                        </tr>

                    </thead>
                    <tbody>

                        @forelse($data->LeadStatusTrackers as $row)
                        <tr class="">
                            <td>

                                <span class="badge 
                                {{$row->leads_status == '0' ? 'bg-primary' : 
                                ($row->leads_status == '1' ? 'bg-info' : 
                                ($row->leads_status == '2' ? 'bg-warning' : 
                                ($row->leads_status == '3' ? 'bg-success' : 
                                ($row->leads_status == '4' ? 'bg-dark' : 
                                'bg-secondary')))) }}">
                                    {{ $row->leads_status == '0' ? 'New' : 
                                ($row->leads_status == '1' ? 'Assigned' : 
                                ($row->leads_status == '2' ? 'Inprocess' : 
                                ($row->leads_status == '3' ? 'Converted' : 
                                ($row->leads_status == '4' ? 'Dead' : 'Recycle')))) }}
                                </span>
                                <br>
                            </td>
                            <td>{{ $row->leads_notes }}</td>
                            <td>{{ $row->date }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

@endsection