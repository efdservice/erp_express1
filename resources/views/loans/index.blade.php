@extends('layouts.app')
@section('title', 'Loan Management')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Loan Management</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right show-modal"
                       href="javascript:void(0);" data-action="{{ route('loans.create') }}" data-size="lg" data-title="New">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>


    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-3">
                @include('loans.table')

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

