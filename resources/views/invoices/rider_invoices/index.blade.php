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
                            <li class="breadcrumb-item active">Rider Invoice</li>
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
                                @can('invoices_create')
                                <button type="button" class="text-white btn btn-primary btn-sm btn-flat float-right" onclick="add_new()">Add New</button>
                                <button type="button" class="text-white btn btn-success btn-sm btn-flat float-right" data-toggle="modal" data-target="#excel-modal"><i class="fa fa-file-excel"></i> Import Excel</button>
                                @endcan
                                <table class="table table-hover data-table text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#inv</th>
                                        <th>Date</th>
                                        <th>Rider</th>
                                        <th>Rider amount</th>
                                        <th>Vendor amount</th>
                                        <th>Total Qty</th>
                                        <th>Descriptions</th>
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
    @include('invoices.rider_invoices.moda')
    @include('invoices.rider_invoices.import-modal')
    @include('invoices.rider_invoices.inc_func')
@endsection

