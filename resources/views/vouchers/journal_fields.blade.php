@isset($data)
    @foreach($data as $entry)
    <div class="row hide_row">
        <div class="form-group col-md-3">
            <label for="exampleInputEmail1">Select Account</label>
            <select name="trans_acc_id[]" class="form-control form-control-sm select2">
                <option value="">Select</option>
                {!! App\Models\Accounts\TransactionAccount::dropdown($entry->trans_acc_id) !!}
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Narration</label>
            <textarea name="narration[]"  class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;">{{$entry->narration}}</textarea>
        </div>
        <div class="form-group col-md-2">
            <label>Dr Amount</label>
            <input type="number" name="dr_amount[]" value="@if($entry->dr_cr == 1){{$entry->amount}}@endif" class="form-control form-control-sm dr_amount" placeholder="Paid Amount">
        </div>
        <div class="form-group col-md-2">
            <label>Cr Amount</label>
            <input type="number" name="cr_amount[]" value="@if($entry->dr_cr == 2){{$entry->amount}}@endif" class="form-control form-control-sm cr_amount" placeholder="Paid Amount">
        </div>
       {{--  <div class="form-group col-md-1">
            <label style="visibility: hidden">plus</label>
            <button type="button" class="btn btn-primary btn-xs new_line"><i class="fa fa-plus"></i> </button>
        </div> --}}
    </div>
    @endforeach
@else
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
        <label style="visibility: hidden">plus</label>
        <button type="button" class="btn btn-primary btn-xs new_line"><i class="fa fa-plus"></i> </button>
    </div>
</div>
@endisset
<div class="append-line"></div>
