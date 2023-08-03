<div class="modal fade" id="modal-new">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-0">
            <form id="form">
                <input type="hidden" name="id" value="0">
            <div class="modal-header rounded-0 bg-gradient-gray">
                <h4 class="modal-title">Vendor Invoice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label>Invoice Date</label>
                        <input type="text" class="form-control form-control-sm date" value="{{ date('Y-m-d') }}" name="inv_date" placeholder="Invoice Date">
                    </div>
                    <!--col-->
                    <div class="col-md-3 form-group">
                        <label>Vendor</label>
                        <select class="form-control form-control-sm select2" name="item_unit">
                            <option value="1">Select</option>
                            {!! \App\Models\Vendor::dropdown() !!}
                        </select>
                    </div>
                    <!--col-->
                    <div class="col-md-6 form-group">
                        <label>Descriptions</label>
                        <input class="form-control form-control-sm" name="descriptions" placeholder="Descriptions">
                    </div>
                    <!--col-->
                </div>
                <!--row-->
                <div class="card">
                    <div class="card-header bg-blue">
                        <h3 class="card-title">Item Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label>Item Description</label>
                                <select class="form-control form-control-sm select2" name="RID[]">
                                    <option value="">Select Vendor</option>
                                    {!! \App\Models\Item::dropdown() !!}
                                </select>
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Qty</label>
                                <input type="text" class="form-control form-control-sm" name="qty[]" placeholder="0" value="0">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Rate</label>
                                <input type="text" class="form-control form-control-sm" name="rate[]" placeholder="0" value="0">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Discount</label>
                                <input type="text" class="form-control form-control-sm" name="discount[]" placeholder="0" value="0">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Tax</label>
                                <input type="text" class="form-control form-control-sm" name="tax[]" placeholder="0" value="0">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control form-control-sm" name="amount[]" placeholder="0" value="0">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label style="visibility: hidden">Assign Price</label>
                                <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                            <!--col-->
                        </div>
                        <!--row-->
                        <div class="row">
                            <div class="col-md-1 offset-6 form-group text-right">
                                <label><strong>Sub Total</strong>:</label>
                            </div>
                            <div class="col-md-1 form-group">
                                <input type="text" class="form-control form-control-sm" placeholder="0.00" value="0.00">
                            </div>
                        </div>
                        <!--row-->
                            </div>
                            <!-- /.card-body -->
                </div>
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
