<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Payment Vouchers</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Transaction Date</label>
                            <input  name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Posting Date</label>
                            <input  name="posting_date" class="form-control form-control-sm date" placeholder="Posting Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Bank/Cash A/C</label>
                            <select name="payment_from" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\TransactionAccount::bank_cash() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm pt">
                                <option value="">Select</option>
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Voucher Type</label>
                            <select name="voucher_type" class="form-control form-control-sm pt" id="voucher_type">
                                <option value="">Select</option>
                                <option value="5">Rider PV</option>
                                <option value="7">Vendor PV</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="vendor_section" style="display: none">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Select Vendor</label>
                            <select name="VID" class="form-control form-control-sm select2" onchange="fetch_invoices(this.value)">
                                <option value="">Select</option>
                                {!! \App\Models\Vendor::dropdown() !!}
                            </select>
                        </div>
                    </div>
                    <!--row-->
                    <div class="row" id="rider_section">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Select Rider</label>
                            <select name="RID" class="form-control form-control-sm select2" onchange="fetch_invoices(this.value)">
                                <option value="">Select</option>
                                {!! \App\Models\Rider::dropdown() !!}}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Rider Balance</label>
                            <input type="text" name="" class="form-control form-control-sm" id="riderBalance" readonly placeholder="Balance Amount">
                        </div>
                        <div id="rider_invoices"></div>
                    </div>
                    <!--row-->
                    <div id="fetchRiderInv"></div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Ref#</label>
                            <input type="text" name="ref" class="form-control form-control-sm" placeholder="Refrence #">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Attach File</label>
                            <input type="file" name="attach_file" class="form-control form-control-sm" placeholder="Refrence #">
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
