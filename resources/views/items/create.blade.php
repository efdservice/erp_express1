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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Quick Example</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="form">
                        <input type="hidden" name="id" value="0">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>Item Name</label>
                                    <input type="text" class="form-control form-control-sm" name="item_name" placeholder="Item Name">
                                </div>
                                <!--col-->
                                <div class="col-md-3 form-group">
                                    <label>Item Unit</label>
                                    <select class="form-control form-control-sm" name="item_unit">
                                        <option value="1">Select</option>
                                    </select>
                                </div>
                                <!--col-->
                                <div class="col-md-2 form-group">
                                    <label>Sale Price</label>
                                    <input type="text" class="form-control form-control-sm" name="sale_price" placeholder="Sale Price">
                                </div>
                                <!--col-->
                                <div class="col-md-2 form-group">
                                    <label>Cost Price</label>
                                    <input type="text" class="form-control form-control-sm" name="cost_price" placeholder="Cost Price">
                                </div>
                                <!--col-->
                            </div>
                            <!--row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Rider Information:</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Vendor Information:</h5>
                                        </div>
                                    </div>
                                    <div class="row item_line_one">
                                        <div class="col-md-3 form-group">
                                            <label>Rider</label>
                                            <select class="form-control form-control-sm select2 selected_riders" onchange="fetch_vendor(this)" name="RID[]">
                                                <option value="">Select Rider</option>
                                                {!! \App\Models\Rider::dropdown() !!}
                                            </select>
                                        </div>
                                        <!--col-->
                                        <div class="col-md-2 form-group">
                                            <label>Assign Price</label>
                                            <input type="text" class="form-control form-control-sm" name="price[]" placeholder="Assign Price">
                                        </div>
                                        <!--col-->
                                        <div class="col-md-3 form-group">
                                            <label>Vendor</label>
                                            <select class="form-control form-control-sm select2 select_vendor" name="VID[]">
                                                <option value="">Select Vendor</option>
                                                {!! \App\Models\Vendor::dropdown() !!}
                                            </select>
                                        </div>
                                        <!--col-->
                                        <div class="col-md-2 form-group">
                                            <label>Assign Price</label>
                                            <input type="text" class="form-control form-control-sm" name="vendor_price[]" placeholder="Assign Price">
                                        </div>
                                        <!--col-->
                                        <div class="col-md-1 form-group">
                                            <label style="visibility: hidden">Assign Price</label>
                                            <button type="button" class="btn btn-sm btn-primary rider_line"><i class="fa fa-plus"></i> </button>
                                        </div>
                                        <!--col-->
                                    </div>
                                    <!--row-->
                                    <div class="rider_append"></div>
                                </div>
                                <!--col-md-6-->
                            </div>
                            <!--row-->
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Descriptions</label>
                                    <textarea class="form-control form-control-sm" name="descriptions" placeholder="Descriptions"></textarea>
                                </div>
                                <!--col-->
                            </div>
                            <!--row-->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary pull-right save_rec btn-sm">Save</button>
                            <button class="btn btn-primary btn-sm loader" type="button" disabled style="display: none">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Saving...
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @include('items.moda')
    @include('items.inc_func')
@endsection

