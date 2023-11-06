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
                            <li class="breadcrumb-item active">Item List</li>
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
                                @can('items_create')
                                <button type="button" class="text-white btn btn-primary btn-sm btn-flat float-right" onclick="add_new()">Add New</button>
                                @endcan
                                <table class="table table-hover data-table text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Unit</th>
                                        <th>Sale Price</th>
                                        <th>Cost Price</th>
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
    @include('items.moda')
    @include('items.inc_func')
@endsection

