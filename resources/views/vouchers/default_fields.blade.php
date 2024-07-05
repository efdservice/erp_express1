<div class="bg-light" style="border-radius:5px;padding:10px;">



@isset($data)
<div id="fetchRiderInv" class="bg-white">

    <div class="row ">
        <div class="col-md-4">
        Account
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
                <div class="form-group col-md-4">
                    <br>
                    @if($entry->trans_acc->riderDetail)
                        <input type="hidden" name="id[]" value="{{$entry->trans_acc->riderDetail->id}}">
                       {{ @$entry->trans_acc->riderDetail->name.' ('.@$entry->trans_acc->riderDetail->rider_id.')'}}
                    @else
                    <input type="hidden" name="id[]" value="{{$entry->trans_acc->id}}">
                    {{@$entry->trans_acc->Trans_Acc_Name}}
                    @endif

                    @if(in_array($entry->vt,[8,10,11,15]))
                    @if($entry->SID)
                    <input type="hidden" name="bike_id[]" value="{{$entry->SID}}">
                    {{ ' (Bike:'.$entry->bike->plate.')'}}
                    @endif
                    @endif
                </div>


                <div class="form-group col-md-4">
                    <textarea name="narration[]" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;">{{$entry->narration}}</textarea>
                </div>
               @if($entry->dr_cr == 1)
                <div class="form-group col-md-2">
                    <input type="number" step="any" name="amount[]" value="{{$entry->amount}}" class="form-control form-control-sm dr_amount" placeholder="Paid Amount">
                </div>
                @endif
                @if($entry->dr_cr == 2)
                <div class="form-group col-md-2">
                </div>
                <div class="form-group col-md-2">
                    <input type="number" step="any" name="amount[]" value="{{$entry->amount}}" class="form-control form-control-sm" placeholder="Paid Amount">
                </div>
                @endif
            </div>
    @endforeach

    </div>
@else
<div class="row" >
    <div class="form-group col-md-4">
        <label for="exampleInputEmail1">Select Account</label>
        <select name="id[]" class="form-control form-control-sm select2" id="RID" >
            <option value="">Select</option>
            @if(in_array(request('vt'),[14]))
            {!! \App\Models\Accounts\TransactionAccount::visaExpense_dropdown() !!}
            @else
            {!! \App\Models\Rider::dropdown(@$vouchers->payment_to) !!}
            @endif
        </select>
    </div>
    @if(in_array(request('vt'),[8,10,11,15]))
    <div class="form-group col-md-2">
        <label for="exampleInputEmail1">Select Bike</label>
        <select name="bike_id[]" class="form-control form-control-sm select2" id="BIKEID" >
            <option value="">Select</option>
            {!! \App\Models\Bike::dropdown(@$vouchers->payment_to) !!}
        </select>
    </div>
@endif
    <div class="form-group col-md-3">
        <label>Narration</label>
        <textarea name="narration[]" id="narration" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
    </div>
    <div class="form-group col-md-2">
        <label>Amount</label>
        <input type="text" name="amount[]" class="form-control form-control-sm dr_amount" id="riderAmount" placeholder="Amount" step="any" onchange="getTotal();">
    </div>
    <div class="col-md-1"></div>

</div>
<div class="append-line"></div>
<button type="button" class="btn btn-success btn-sm @if(in_array(request('vt'),[12,13,16]))new_rider_line @endif @if(in_array(request('vt'),[14]))new_expense_line @endif @if(in_array(request('vt'),[8,10,11,15]))new_bike_line @endif" id="" ><i class="fa fa-plus"></i> Add Row</button>

</div>
<table id="myTable" class="table order-list">
</table>

@endisset
