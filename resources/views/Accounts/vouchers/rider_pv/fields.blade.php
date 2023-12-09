<script src="{{ URL::asset('public/js/inc.func.js') }}"></script>

            <div class="row">
                <div class="form-group col-md-2">
                    <label for="exampleInputEmail1">Date</label>
                    <input  name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date" value="{{$result->trans_date??''}}" required >
                </div>
                {{-- <div class="form-group col-md-2">
                    <label for="exampleInputEmail1">Posting Date</label>
                    <input  name="posting_date" class="form-control form-control-sm date" placeholder="Posting Date">
                </div> --}}
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Bank/Cash A/C</label>
                    {!! Form::select('payment_from',App\Models\Accounts\TransactionAccount::bank_cash_list(),null ,['class' => 'form-control form-control-sm select2 ','id'=>'payment_from']) !!}

          
                </div>
                <div class="form-group col-md-2">
                    <label for="exampleInputEmail1">Payment Type</label>
                    {!! Form::select('payment_type',App\Helpers\Account::payment_type_list(),null ,['class' => 'form-control form-control-sm select2 ','id'=>'payment_type']) !!}

                
                </div>
                <div class="form-group col-md-2">
                    <label for="exampleInputEmail1">Voucher Type</label>
                    <select name="voucher_type" class="form-control form-control-sm pt" id="voucher_type" @isset($result) disabled @endisset>
                        <option value="">Select</option>
                        <option value="5" @if(@$result->voucher_type == 5) selected @endif>Rider PV</option>
                        <option value="7" @if(@$result->voucher_type == 7) selected @endif>Vendor PV</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="exampleInputEmail1">Select Reason</label>
                    <select name="payment_reason" class="form-control form-control-sm select2" >
                        <option value="">Select</option>
                        {!! App\Helpers\CommonHelper::get_PaymentReason(@$result->payment_reason) !!}
                    </select>
                </div>
            </div>
            <div class="row" id="vendor_section" style="display: none">
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Select Vendor</label>
                    <select name="VID" class="form-control form-control-sm select2" onchange="fetch_invoices(this.value)" @isset($result) disabled @endisset>
                        <option value="">Select</option>
                        {!! \App\Models\Vendor::dropdown(@$result->payment_to) !!}
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Balance</label>
                    <input type="text" name="" class="form-control form-control-sm" id="vendor_balance" readonly placeholder="Balance Amount">
                </div>
                <div id="rider_invoices"></div>
            </div>
            <!--row-->
            <div class="row" id="rider_section">
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Select Rider</label>
                    <select name="RID" class="form-control form-control-sm select2" onchange="fetch_invoices(this.value)" @isset($result) disabled @endisset>
                        <option value="">Select</option>
                        {!! \App\Models\Rider::dropdown(@$result->payment_to) !!}
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Rider Balance</label>
                    <input type="text" name="" class="form-control form-control-sm" id="riderBalance" readonly placeholder="Balance Amount">
                </div>
                <div id="rider_invoices"></div>
            </div>
            <!--row-->
            <div id="fetchRiderInv">
                @isset($data)
                <div class="row">
                    <div class="col-md-4">
                        Payment Account
                    </div>
                    <div class="col-md-4">
                        Narration
                    </div>
                    <div class="col-md-2">
                        Debit
                    </div>
                    <div class="col-md-2">
                        Credit
                    </div>
                </div>
                @foreach($data as $entry)
                
                        <div class="row">
                            <input type="hidden" name="trans[{{$entry->id}}][id]" value="{{$entry->id}}">
                            <input type="hidden" name="trans[{{$entry->id}}][dr_cr]" value="{{$entry->dr_cr}}">
                            <div class="form-group col-md-4">
                                <br>
                                @if($entry->trans_acc->riderDetail)
                                   {{ @$entry->trans_acc->riderDetail->name.' ('.@$entry->trans_acc->riderDetail->rider_id.')'}}
                                @else
                                {{@$entry->trans_acc->Trans_Acc_Name}}
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label>Narration</label>
                                <textarea name="trans[{{$entry->id}}][narration]" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;">{{$entry->narration}}</textarea>
                            </div>
                           @if($entry->dr_cr == 1)
                            <div class="form-group col-md-2">
                                <label>Amount</label>
                                <input type="number" name="trans[{{$entry->id}}][amount]" value="{{$entry->amount}}" class="form-control form-control-sm" placeholder="Paid Amount">
                            </div>
                            @endif
                            @if($entry->dr_cr == 2)
                            <div class="form-group col-md-2">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Amount</label>
                                <input type="number" name="trans[{{$entry->id}}][amount]" value="{{$entry->amount}}" class="form-control form-control-sm" placeholder="Paid Amount">
                            </div>
                            @endif
                        </div>
            @endforeach
            @endisset
        </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Ref#</label>
                    <input type="text" name="ref" value="{{@$result->ref}}" class="form-control form-control-sm" placeholder="Refrence #">
                </div>
                <div class="form-group col-md-3">
                    <label>Attach File @isset($result->attach_file)
                        (Uploaded: <a href="{{ Storage::url('app/voucher/'.$result->attach_file)}}" target="_blank">   View File</a>)
                        @endisset</label>
                    <input type="file" name="attach_file" class="form-control form-control-sm" placeholder="Refrence #">
                    
                </div>
            </div>
            <!-- Modal footer -->
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>  
        </div>
