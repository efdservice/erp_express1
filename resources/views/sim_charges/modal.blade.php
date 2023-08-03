<div class="modal" id="new">
    <div class="modal-dialog">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Sim Charges Voucher</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Transaction Date</label>
                            <input name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Posting Date</label>
                            <input name="post_date" class="form-control form-control-sm date" placeholder="Posting Date">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm pt">
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                    </div>
                    <div class="row">
{{--                        <div class="form-group col-md-4">--}}
{{--                            <label for="exampleInputEmail1">Bank/Cash A/C</label>--}}
{{--                            <select name="payment_from" class="form-control form-control-sm select2">--}}
{{--                                <option value="">Select</option>--}}
{{--                                {!! App\Models\Accounts\TransactionAccount::bank_cash() !!}--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Select Sim</label>
                            <select name="sim_id" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! \App\Models\Sim::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Company</label>
                            <select name="CID" class="form-control form-control-sm select2" onchange="fetch_invoices(this.value)">
                                <option value="19">Etislat </option>
                                <option value="20">Duo </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Charges Amount</label>
                            <input type="text" name="amount" placeholder="0.00" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Attach File</label>
                            <input type="file" name="attach_file" class="form-control form-control-sm" placeholder="Refrence #">
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Other Details</label>
                            <textarea type="text" name="other_details" class="form-control" placeholder="Enter...."></textarea>
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
