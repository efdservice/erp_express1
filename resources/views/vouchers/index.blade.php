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
<script>
    $(document).on("click", ".new_rider_line", function () {
    $(".append-line").append(`
                        <div class="row">
                            <div class="form-group col-md-4">
                                <select name="id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Rider::dropdown() !!}
                                </select>
                        </div>

                <div class="form-group col-md-3">
                    <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                </div>

                <div class="form-group col-md-2">
                    <input type="number" step="any" name="amount[]" class="form-control form-control-sm dr_amount" placeholder="Amount" onchange="getTotal();">
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>
                </div>
            </div>
`);
$(".select2").select2();
});
$(document).on("click", ".new_expense_line", function () {
    $(".append-line").append(`
                        <div class="row">
                            <div class="form-group col-md-4">
                                <select name="id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Accounts\TransactionAccount::visaExpense_dropdown() !!}
                                </select>
                        </div>

                <div class="form-group col-md-3">
                    <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                </div>

                <div class="form-group col-md-2">
                    <input type="number" step="any" name="amount[]" class="form-control form-control-sm dr_amount" placeholder="Amount" onchange="getTotal();">
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>
                </div>
            </div>
`);
$(".select2").select2();
});
$(document).on("click", ".new_bike_line", function () {
    $(".append-line").append(`
                        <div class="row">
                            <div class="form-group col-md-4">
                                <select name="id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Rider::dropdown() !!}
                                </select>
                        </div>

                        <div class="form-group col-md-2">
                                <select name="bike_id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Bike::dropdown() !!}
                                </select>
                        </div>

                <div class="form-group col-md-3">
                    <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                </div>

                <div class="form-group col-md-2">
                    <input type="number" step="any" name="amount[]" class="form-control form-control-sm dr_amount" placeholder="Amount" onchange="getTotal();">
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>
                </div>
            </div>
`);
$(".select2").select2();
});
</script>
@endsection

