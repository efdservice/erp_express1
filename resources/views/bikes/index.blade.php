@extends('layouts.app')
@section('title', 'Vendors')
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
                            <li class="breadcrumb-item active">Bike List</li>
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
                            <div class="col-md-12">
                                <button type="button" class="text-white btn btn-primary btn-sm btn-flat float-right" onclick="add_new()">Add New</button>
                                <table class="table table-hover text-nowrap data-table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Current Rider</th>
                                        <th>Vendor</th>
                                        <th>Sim</th>
                                        <th>Bike Plate #</th>
                                        <th>Supervisor</th>                                        
                                        <th>Project</th>    
                                        <th>Status</th>    
                                        
                                        <th>Company</th>
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
    @include('bikes.moda')
    @include('bikes.inc_func')
    @include('bikes.change-rider-modal')
@endsection

