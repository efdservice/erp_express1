@extends('layouts.app')
@section('title', 'Rider List')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Rider List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default rounded-0">
                    <div class="card-body">
                        <h6>Fleet Supervisor</h6>
                        <div class="row">

                            @foreach($fleet_supervisor as $fs)

                            <div class="col-lg-2 col-6">
                                <!-- small box -->
                                <div class="small-box bg-default" >
                                    <div class="inner" >

                                        <a href="{{url('rider?fleet_supervisor='.$fs->fleet_supervisor)}}"><span>{{$fs->fleet_supervisor??'not-set'}}</span></a>
                                        <br/><b>Active: {{$fs->active??0}}</b>&nbsp;&nbsp;
                                        <b>Inactive: {{$fs->inactive??0}}</b>

                                    </div>

                                </div>
                            </div>

                            @endforeach
                        </div>
                        <h6>Status</h6>
                        <div class="row">
                            @foreach($status_count as $st)

                                <div class="col-lg-1 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-light" >
                                        <div class="inner" >
                                            <h5>{{$st->total}}</h5>

                                            <a href="{{url('rider?job_status='.$st->status)}}"><span>{{App\Helpers\CommonHelper::RiderStatus($st->status)}}</span></a>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                            @foreach($job_status_count as $wh)
                            @if($wh->job_status!=1)
                                <div class="col-lg-1 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-light" >
                                        <div class="inner" >
                                            <h5>{{$wh->total}}</h5>
                                            @isset($wh->job_status)
                                            <a href="{{url('rider?job_status='.$wh->job_status)}}"><span>{{App\Helpers\CommonHelper::JobStatus($wh->job_status)}}</span></a>
                                            @endisset
                                        </div>

                                    </div>
                                </div>
                                @endif
                                @endforeach


                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                @can('riders_create')
{{--                                 <button type="button" class="text-white btn btn-primary btn-sm btn-flat float-right" onclick="add_new()">Add New</button>
 --}}
 <a href="{{route('rider.create')}}" class="btn btn-primary btn-sm btn-flat float-right">Create</a>
 <button type="button" class="text-white btn btn-success btn-sm btn-flat float-right" data-toggle="modal" data-target="#excel-modal"><i class="fa fa-file-excel"></i> Import Excel</button>
                                @endcan


                                <table class="table table-hover text-nowrap data-table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Rider Name</th>
                                       {{--  <th>Vendor</th> --}}
                                        <th>Company Contact</th>
                                        <th>Bike Plate #</th>
                                        <th>Supervisor</th>
                                        <th>Emirate</th>
{{--                                         <th>Balance</th>
 --}}
                                        <th>Status</th>
                                        <th>Job Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @include('riders.moda')
    @include('riders.import-modal')
    @include('riders.contract-modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
    <script>
            $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: "{{ route('rider.index',['status'=>request('status'),'job_status'=>request('job_status'),'fleet_supervisor'=>request('fleet_supervisor')]) }}",
            columns: [
                {data: 'rider_id', name: 'rider_id'},
                {data: 'name', name: 'name'},
/*                 {data: 'VID', name: 'VID'},
 */                 {data: 'company_contact', name: 'company_contact'},
               {data: 'license_no', name: 'license_no'},
                {data: 'fleet_supervisor', name: 'fleet_supervisor'},
                {data: 'emirate_hub', name: 'emirate_hub'},
/*                 {data: 'Balance', name: 'Balance'},
 */                {data: 'status', name: 'status'},
                    {data: 'job_status', name: 'job_status'},
                {data: 'action', name: 'action',
                    orderable: false, searchable: false
                },
            ]
        });
    });
    </script>
    @include('riders.inc_func')
@endsection

