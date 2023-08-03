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
                            <li class="breadcrumb-item active">Item</li>
                            <li class="breadcrumb-item active">Assign Rider/Vendor</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Assign Price Rider/Vendor</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('save_rv') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="0">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>Select Item</label>
                                    <select class="form-control form-control-sm select2" id="items" name="item_id">
                                        <option value="">Select Item</option>
                                        {!! \App\Models\Item::dropdown($data[0]['item_id']) !!}
                                    </select>
                                </div>
                                <!--col-->
                                <div class="col-md-3 form-group">
                                    <label>Select Vendor</label>
                                    <select class="form-control form-control-sm select2" onchange="fetch_rider(this)" name="VID">
                                        <option value="">Select Vendor</option>
                                        {!! \App\Models\Vendor::dropdown($data[0]['VID']) !!}
                                    </select>
                                </div>
                                <!--col-->
                            </div>
                            <!--row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Price Information:</h5>
                                        </div>
                                    </div>
                                    @foreach($data as $key=>$item)
                                        <div class="row item_line_one">
                                            <div class="col-md-3 form-group">
                                                @if($key==0)<label>Rider</label>@endif
                                                <select class="form-control form-control-sm select2 selected_riders" onchange="fetch_vendor(this)" name="RID[]">
                                                    <option value="">Select Rider</option>
                                                    {!!   \App\Models\Rider::dropdown($item['RRID']) !!}
                                                </select>
                                            </div>
                                            <!--col-->
                                            <div class="col-md-2 form-group">
                                                @if($key==0)<label>Rider Price</label>@endif
                                                <input type="text" class="form-control form-control-sm sp" value="{{ $item['rider_price'] }}" name="price[]" placeholder="Assign Price">
                                            </div>
                                            <!--col-->
                                            <div class="col-md-2 form-group">
                                               @if($key==0)<label>Vendor Price</label>@endif
                                                <input type="text" class="form-control form-control-sm cp" value="{{ $item['vendor_price'] }}" name="vendor_price[]" placeholder="Assign Price">
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--row-->
                                    @endforeach
                                </div>
                                <!--col-md-6-->
                            </div>
                            <!--row-->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary pull-right save_rec btn-sm">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @include('items.inc_func')
@endsection

