<div class="modal fade" id="modal-new">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-0">
            <form id="form">
                <input type="hidden" name="id" value="0">
            <div class="modal-header rounded-0 bg-gradient-gray">
                <h4 class="modal-title">Rider Invoice:</h4>
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
                    <div class="col-md-2 form-group">
                        <label>Rider</label>
                        <select class="form-control form-control-sm select2" id="RID" name="RID">
                            <option value="0">Select</option>
                            {!! \App\Models\Rider::dropdown() !!}
                        </select>
                    </div>
                    <!--col-->
                    <div class="col-md-2 form-group">
                        <label>Zone</label>
                        <input type="text" class="form-control form-control-sm" name="zone" placeholder="Zone">
                    </div>
                    <!--col-->
                    <div class="col-md-2 form-group">
                        <label>Login Hours</label>
                        <input type="text" class="form-control form-control-sm" name="login_hours" placeholder="Login Hours">
                    </div>
                    <!--col-->
                    <div class="col-md-2 form-group">
                        <label>Working Days</label>
                        <input type="text" class="form-control form-control-sm" name="working_days" placeholder="Working Days">
                    </div>
                    <!--col-->
                    <div class="col-md-2 form-group">
                        <label>Perfect Attendance</label>
                        <input type="text" class="form-control form-control-sm" name="perfect_attendance" placeholder="Perfect Attendance">
                    </div>
                    <!--col-->
                    <div class="col-md-2 form-group">
                        <label>Rejection</label>
                        <input type="text" class="form-control form-control-sm" name="rejection" placeholder="Rejection">
                    </div>
                    <!--col-->
                    <div class="col-md-2 form-group">
                        <label>Performance</label>
                        <input type="text" class="form-control form-control-sm" name="performance" placeholder="Performance">
                    </div>
                    <!--col-->
                    <div class="col-md-2 form-group">
                        <label>Off</label>
                        <input type="text" class="form-control form-control-sm" name="off" placeholder="Performance">
                    </div>
                    <!--col-->
                   {{--  <div class="col-md-2 form-group">
                        <label>Month of Invoice</label>
                        <select class="form-control form-control-sm" name="month_invoice">
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}">{{ date('F',mktime(0, 0, 0, $i, 10)) }}</option>
                            @endfor
                        </select>
                    </div> --}}
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Billing Month</label>
                        <input type="month" name="billing_month"  class="form-control form-control-sm" id="billing_month" />

{{--                         {!! Form::select('billing_month',App\Helpers\CommonHelper::BillingMonth(),null ,['class' => 'form-control form-control-sm select2 ','id'=>'billing_month']) !!}
 --}}                    </div>
                    <!--col-->
                    <div class="col-md-12 form-group">
                        <label>Descriptions</label>
                        <textarea class="form-control form-control-sm" name="descriptions" placeholder="Descriptions"></textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Notes</label>
                        <textarea class="form-control form-control-sm" name="notes" placeholder="Notes"></textarea>
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
                        <div class="row item">
                            <div class="col-md-3 form-group">
                                <label>Item Description</label>
                                <select class="form-control form-control-sm select2" onchange="search_price(this)" name="item_id[]">
                                    <option value="">--Select--</option>
                                    {!! \App\Models\Item::dropdown() !!}
                                </select>
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Qty</label>
                                <input type="text" class="form-control form-control-sm qty" name="qty[]" placeholder="0" value="1">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Rate</label>
                                <input type="text" class="form-control form-control-sm rate" name="rate[]" placeholder="0" value="0">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Discount</label>
                                <input type="text" class="form-control form-control-sm discount" name="discount[]" placeholder="0" value="0">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Tax</label>
                                <input type="text" class="form-control form-control-sm tax" name="tax[]" placeholder="0" value="0">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control form-control-sm amount" name="amount[]" placeholder="0" value="0">
                            </div>
                            <!--col-->

                            <!--col-->
                        </div>
                        <!--row-->
                        <div class="append-line"></div>
                        <div class="col-md-1 form-group">
                            <label style="visibility: hidden">Assign Price</label>
                            <button type="button" class="btn btn-sm btn-primary new_line_item"><i class="fa fa-plus"></i> </button>
                        </div>
                        <div class="row">
                            <div class="col-md-1 offset-6 form-group text-right">
                                <label><strong>Sub Total</strong>:</label>
                            </div>
                            <div class="col-md-1 form-group">
                                <input type="text" name="total_amount" class="form-control form-control-sm" id="sub_total" placeholder="0.00" value="0.00" readonly>
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
