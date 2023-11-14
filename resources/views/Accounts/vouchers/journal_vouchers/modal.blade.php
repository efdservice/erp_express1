<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Journal Voucher</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Date</label>
                            @php
                                $month = App\Models\Settings::where('name','working_month')->first()->value;
                            @endphp
                            <input  name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date" value="{{ date('Y-'.$month.'-d') }}">
                        </div>
                       {{--  <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Posting Date</label>
                            <input  name="posting_date" class="form-control form-control-sm date" placeholder="Posting Date" value="{{ date('Y-m-d') }}">
                        </div> --}}
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                       {{--  <div class="col-md-2 form-group">
                            <label>Month of Invoice</label>
                            <select class="form-control form-control-sm" name="month">
                                @for($i=1; $i<=12; $i++)
                                    <option value="{{ $i }}">{{ date('F',mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </div> --}}
                        <!--col-->
                    </div>
                    <div class="row hide_row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Select Account</label>
                            <select name="trans_acc_id[]" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\TransactionAccount::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Narration</label>
                            <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Dr Amount</label>
                            <input type="number" name="dr_amount[]" class="form-control form-control-sm dr_amount" placeholder="Paid Amount">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Cr Amount</label>
                            <input type="number" name="cr_amount[]" class="form-control form-control-sm cr_amount" placeholder="Paid Amount">
                        </div>
                        <div class="form-group col-md-1">
                            <label style="visibility: hidden">plusplusplusplus</label>
                            <button type="button" class="btn btn-primary btn-xs new_line"><i class="fa fa-plus"></i> </button>
                        </div>
                    </div>
                    <div class="append-line"></div>
                    <div class="row">
                        <div class="col-md-7 text-right">Total:</div>
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control form-control-sm total_dr" readonly placeholder="Total Dr">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control form-control-sm total_cr" readonly placeholder="Total Cr">
                        </div>
                    </div>
                    <!--row-->
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>
