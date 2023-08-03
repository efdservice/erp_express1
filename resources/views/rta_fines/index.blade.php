@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>RTA Fine List</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Bikes</li>
                            <li class="breadcrumb-item active">RTA Fine</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="From Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="To Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Searh With Voucher#">
                                </div>
                                <div class="col-md-2">
                                    <button type="text" class="btn btn-flat btn-xs btn-dark"><i class="fas fa-search"></i> </button>
                                </div>
                            </div>
                            <button class="btn btn-xs btn-dark float-right btn-flat" onclick="add_new()">Add New</button>
                            <button type="button" class="text-white btn btn-success btn-xs btn-flat float-right" data-toggle="modal" data-target="#excel-modal"><i class="fa fa-file-excel"></i> Import Excel</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voucher#</th>
                                    <th>Trans Date</th>
                                    <th>Narration</th>
                                    <th>Amount</th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="pagination-panel"></div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('rta_fines.modal')
    @include('rta_fines.import-modal')
    @include('rta_fines.inc_func')
@endsection<!-- jQuery -->
