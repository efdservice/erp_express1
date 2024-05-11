<!-- Rider Id Field -->
<div class="form-group col-md-6">
    <label>Select Rider</label>
    <select name="rider_id" class="form-control form-control-sm select2" id="RID" >
        <option value="">Select</option>
        {!! \App\Models\Rider::dropdown(@$loans->rider_id) !!}
    </select>
</div>

<!-- Terms Field -->
<div class="form-group col-sm-6">
    {!! Form::label('terms', 'Terms') !!}
    {!! Form::select('terms',App\Helpers\CommonHelper::LoanTerms(), null, ['class' => 'form-control form-control-sm select2']) !!}
</div>

<!-- Purpose Field -->
<div class="form-group col-sm-12">
    {!! Form::label('purpose', 'Purpose') !!}
    {!! Form::text('purpose', null, ['class' => 'form-control form-control-sm','maxlength' => 255,'maxlength' => 255]) !!}
</div>



<!-- Issue Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issue_date', 'Issue Date') !!}
    {!! Form::date('issue_date', null, ['class' => 'form-control form-control-sm','id'=>'issue_date']) !!}
</div>


<!-- Due Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('due_date', 'Due Date') !!}
    {!! Form::date('due_date', null, ['class' => 'form-control form-control-sm','id'=>'due_date']) !!}
</div>
<div class="form-group col-md-12">
<h5>Payment Detail</h5>
</div>
<div class="form-group col-md-6">
    <label for="exampleInputEmail1">Bank/Cash A/C</label>
    {!! Form::select('payment_from',App\Models\Accounts\TransactionAccount::bank_cash_list(),null ,['class' => 'form-control form-control-sm select2 ','id'=>'payment_from']) !!}
</div>
<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount') !!}
    {!! Form::number('amount', null, ['class' => 'form-control form-control-sm']) !!}
</div>

<script src="{{ URL::asset('public/js/voucher.js') }}"></script>
