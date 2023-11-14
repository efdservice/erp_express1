@extends('layouts.app')
@section('title','Settings')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-primary rounded-0">

    <div class="card-header">
    <h3 class="card-title">Application Settings</h3>
    </div>
    
    
   
    <div class="card-body">
{!! Form::open(['route'=>'settings','method'=>'post']) !!}
@csrf
    <div class="form-group col-md-4">
    <label >Working Month</label>
       
        <select class="form-control" name="settings[working_month]">
            @for($i=01; $i<=12; $i++)
            @php
                $value = str_pad($i,2,"0",STR_PAD_LEFT);
            @endphp
                <option value="{{ $value }}" @if($settings['working_month'] == $value) selected @endif>{{ date('F',mktime(0, 0, 0, $i, 10)) }}</option>
            @endfor
        </select>
   
    </div>
    
    
    <div class="card-footer">
    <button type="submit" class="btn btn-primary">Save</button>
    </div>
    {!! Form::close() !!}
</div>   
        </div>
    </section>
</div> 
@endsection