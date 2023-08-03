<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Bike Rent Voucher</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Transaction Date</label>
                            <input name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date" value="<?=date('Y-m-d')?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Posting Date</label>
                            <input name="posting_date" class="form-control form-control-sm date" placeholder="Posting Date" value="<?=date('Y-m-d')?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm pt">
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                    </div>
                    <div class="row">
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="exampleInputEmail1">Bank/Cash A/C</label>--}}
{{--                            <select name="payment_from" class="form-control form-control-sm select2">--}}
{{--                                <option value="">Select</option>--}}
{{--                                {!! App\Models\Accounts\TransactionAccount::bank_cash() !!}--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Select Bike</label>
                            <select name="BID" id="bike-plate" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! \App\Models\Bike::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Rider</label>
                            <select name="RID" class="form-control form-control-sm select2 rider" onchange="fetch_invoices(this.value)">
                                <option value="">Select</option>
                                {!! \App\Models\Rider::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Vendor</label>
                            <select name="VID" class="form-control form-control-sm select2 vendor" onchange="fetch_invoices(this.value)">
                                <option value="">Select</option>
                                {!! \App\Models\Vendor::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Lease Company</label>
                            <select name="LCID" class="form-control form-control-sm select2">
                                <option value="">Select Company</option>
                                {!! \App\Models\LeaseCompany::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Rider Amount</label>
                            <input type="text" name="rider_amount" class="form-control form-control-sm" placeholder="Rider Amount">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Vendor Amount</label>
                            <input type="text" name="vendor_amount" class="form-control form-control-sm" placeholder="Vendor Amount" value="0">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Credit Amount</label>
                            <input type="text" name="credit_amount" class="form-control form-control-sm" placeholder="Credit Amount" value="0">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Attach File</label>
                            <input type="file" name="attach_file" class="form-control form-control-sm" placeholder="Refrence #">
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Other Details</label>
                            <textarea type="text" name="other_detailse" class="form-control" placeholder="Enter...."></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-xs">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>
