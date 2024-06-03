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

                        <div class="col-md-4 form-group">
                            <label>Change Status</label>
                            <select class="form-control form-control-sm warehouse select2" name="warehouse" id="warehouse" onchange="bike_status()">
                                {!! App\Helpers\CommonHelper::get_warehouse() !!}
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="rider_select">
                            <label>Change Rider</label>
                            <select class="form-control form-control-sm select2" name="RID" id="rider_change">
                                <option value="">--Select--</option>
                                {!! \App\Models\Rider::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Date</label>
                            <input  name="note_date" class="form-control form-control-sm date" placeholder="Date" value="{{ date('Y-m-d') }}">
                        </div>
                        <!--col-->
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Note....." name="notes"></textarea>
                        </div>

                        <!--col-->
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <button type="button" onclick="change_rider()" class="btn btn-primary pull-right save_rec">Save</button>
                    <button class="btn btn-primary loader" type="button" disabled style="display: none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Saving...
                    </button>
                        </div>
                    </div>
                    <!--row-->
                    <br>
                    <div class="card rounded-0">
                        <div class="card-header bg-gradient-dark">Latest 10 Changes</div>
                        <table class="table">
                            <tr>
                                <th>Rider</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Note</th>
                            </tr>
                            <tbody id="rider_history"></tbody>
                        </table>
                    </div>
                </div>
                </div>
                </div>
                </div>
