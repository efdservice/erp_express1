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

                        <div class="row">
                            @foreach($status_count as $wh)
                                <div class="col-lg-2 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-light" >
                                        <div class="inner" >
                                            <h4>{{$wh->total}}</h4>

                                            <span>{{App\Helpers\CommonHelper::RiderStatus($wh->status)}}</span>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-user-circle fa-xs"></i>
                                        </div>
                                    </div>
                                </div>
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
    @include('riders.inc_func')
@endsection

