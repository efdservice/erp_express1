<!-- Rider Id Field -->
<div class="col-sm-12">
    {!! Form::label('rider_id', 'Rider Id:') !!}
    <p>{{ $loans->rider_id }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $loans->amount }}</p>
</div>

<!-- Purpose Field -->
<div class="col-sm-12">
    {!! Form::label('purpose', 'Purpose:') !!}
    <p>{{ $loans->purpose }}</p>
</div>

<!-- Terms Field -->
<div class="col-sm-12">
    {!! Form::label('terms', 'Terms:') !!}
    <p>{{ $loans->terms }}</p>
</div>

<!-- Issue Date Field -->
<div class="col-sm-12">
    {!! Form::label('issue_date', 'Issue Date:') !!}
    <p>{{ $loans->issue_date }}</p>
</div>

<!-- Due Date Field -->
<div class="col-sm-12">
    {!! Form::label('due_date', 'Due Date:') !!}
    <p>{{ $loans->due_date }}</p>
</div>

<!-- Paid Field -->
<div class="col-sm-12">
    {!! Form::label('paid', 'Paid:') !!}
    <p>{{ $loans->paid }}</p>
</div>

<!-- Balance Field -->
<div class="col-sm-12">
    {!! Form::label('balance', 'Balance:') !!}
    <p>{{ $loans->balance }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $loans->status }}</p>
</div>

<!-- Created By Field -->
<div class="col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $loans->created_by }}</p>
</div>

