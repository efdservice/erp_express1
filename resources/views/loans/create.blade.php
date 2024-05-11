{{-- @extends('layouts.app')
@section('title', 'Loan Management')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Loans</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')
 --}}

            {!! Form::open(['route' => 'loans.store','id'=>'formajax']) !!}

            <div class="card-body">

                <div class="row">
                    @include('loans.fields')
                </div>

            </div>

            <div class="action-btn float-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}

    {{-- </div>
    </div>
@endsection
 --}}
