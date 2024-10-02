<div class="modal fade" id="modal-new">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-0">
            <form id="form">
                <input type="hidden" name="id" value="0">
                <div class="modal-header rounded-0 bg-gradient-gray">
                    <h4 class="modal-title">Item Details:</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Item Name</label>
                            <input type="text" class="form-control form-control-sm" name="item_name" placeholder="Item Name">
                        </div>
                        <!--col-->
                        <div class="col-md-4 form-group">
                            <label>Item Unit</label>
                            <select class="form-control form-control-sm" name="item_unit">
                                <option value="1">Select</option>
                            </select>
                        </div>
                        <!--col-->
                        <div class="col-md-3 form-group">
                            <label>Sale Price</label>
                            <input type="text" class="form-control form-control-sm" name="sale_price" placeholder="Sale Price">
                        </div>
                        <!--col-->
                        <div class="col-md-3 form-group">
                            <label>Cost Price</label>
                            <input type="text" class="form-control form-control-sm" name="cost_price" placeholder="Cost Price">
                        </div>
                        <div class="col-md-3 form-group">
                            <label>VAT Percentage %</label>
                            <input type="text" class="form-control form-control-sm" name="tax" value="5" placeholder="VAT %">
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <h5>Rider Information:</h5>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <h5>Vendor Information:</h5>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row item_line_one">--}}
{{--                                <div class="col-md-3 form-group">--}}
{{--                                    <label>Rider</label>--}}
{{--                                    <select class="form-control form-control-sm select2 selected_riders" onchange="fetch_vendor(this)" name="RID[]">--}}
{{--                                        <option value="">Select Rider</option>--}}
{{--                                        {!! \App\Models\Rider::dropdown() !!}--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <!--col-->--}}
{{--                                <div class="col-md-2 form-group">--}}
{{--                                    <label>Assign Price</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm" name="price[]" placeholder="Assign Price">--}}
{{--                                </div>--}}
{{--                                <!--col-->--}}
{{--                                <div class="col-md-3 form-group">--}}
{{--                                    <label>Vendor</label>--}}
{{--                                    <select class="form-control form-control-sm select2 select_vendor" name="VID[]">--}}
{{--                                        <option value="">Select Vendor</option>--}}
{{--                                        {!! \App\Models\Vendor::dropdown() !!}--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <!--col-->--}}
{{--                                <div class="col-md-2 form-group">--}}
{{--                                    <label>Assign Price</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm" name="vendor_price[]" placeholder="Assign Price">--}}
{{--                                </div>--}}
{{--                                <!--col-->--}}
{{--                                <div class="col-md-1 form-group">--}}
{{--                                    <label style="visibility: hidden">Assign Price</label>--}}
{{--                                    <button type="button" class="btn btn-sm btn-primary rider_line"><i class="fa fa-plus"></i> </button>--}}
{{--                                </div>--}}
{{--                                <!--col-->--}}
{{--                            </div>--}}
{{--                            <!--row-->--}}
{{--                            <div class="rider_append"></div>--}}
{{--                        </div>--}}
{{--                        <!--col-md-6-->--}}
{{--                    </div>--}}
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
