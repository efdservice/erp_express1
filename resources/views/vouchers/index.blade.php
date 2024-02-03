@extends('layouts.app')
@section('title', 'Vouchers')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vouchers</h1>
                </div>
                <div class="col-sm-6">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-plus"></i> Create Voucher
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach(App\Helpers\CommonHelper::VoucherType() as $key => $value)
                            <a class="dropdown-item show-modal float-right" href="javascript:void(0);" data-size="xl" data-title="Create {{$value}}"
                            data-action="{{ route('vouchers.create',["vt"=>$key]) }}">{{$value}}</a>
                            @endforeach
                        </div>
                      </div>
                    {{-- <a class="btn btn-primary float-right show-modal" href="javascript:void(0);" data-size="xl" data-title="Create Voucher"
                       data-action="{{ route('vouchers.create') }}">
                        Add New
                    </a> --}}
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-3">
                @include('vouchers.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection

