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
                            <label for="exampleInputEmail1">Date</label>
                            <input name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date" value="{{ date('Y-m-d') }}">
                        </div>
                       {{--  <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Posting Date</label>
                            <input  name="posting_date" class="form-control form-control-sm date" placeholder="Posting Date">
                        </div> --}}
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
                            <select name="payment_type" class="form-control form-control-sm pt">
                                <option value="">Select</option>
                                <option value="5">Rider PV</option>
                                <option value="7">Vendor PV</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Payment To</label>
                            <select name="payment_to" class="form-control form-control-sm select2 client_inv" onchange="fetch_invoices(this.value)">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\TransactionAccount::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Inv List</label>
                            <select name="SID" class="form-control form-control-sm row invoices">

                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Narration</label>
                            <textarea name="narration" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control form-control-sm" placeholder="Paid Amount">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Cheque</label>
                            <input type="text" name="cheque" class="form-control form-control-sm" placeholder="e.g Cheque#">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Currency</label>
                            <select class="form-control form-control-sm select2" name="currency">
                                <option value="">Select</option>
                                {!! App\Models\Currency::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Conversion Rate</label>
                            <input type="text" name="conversion_rate" class="form-control form-control-sm" placeholder="Conversion Rate">
                        </div>
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
