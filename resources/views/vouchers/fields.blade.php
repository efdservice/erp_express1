

@isset($vouchers->voucher_type)
    @php($voucherType = $vouchers->voucher_type)
@else
    @php($voucherType = request("vt"))
@endisset

<input type="hidden" name="v_trans_code" value="{{@$vouchers->trans_code??0}}">
<input type="hidden" name="voucher_type" value="{{$voucherType}}">

        <div class="row">

            <div class="form-group col-md-3">
                <label for="exampleInputEmail1">Date</label>

                <input  name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date" value="@isset($vouchers->trans_date){{date('Y-m-d',strtotime($vouchers->trans_date)) }}@else{{date('Y-m-d')}}@endisset" >
            </div>
           {{--  <div class="form-group col-md-3">
                <label for="exampleInputEmail1">Posting Date</label>
                <input  name="posting_date" class="form-control form-control-sm date" placeholder="Posting Date" value="{{ date('Y-m-d') }}">
            </div> --}}
            @if($voucherType==5)
            <div class="form-group col-md-3">
                <label for="exampleInputEmail1">Bank/Cash A/C</label>
                {!! Form::select('payment_from',App\Models\Accounts\TransactionAccount::bank_cash_list(),null ,['class' => 'form-control form-control-sm select2 ','id'=>'payment_from']) !!}
            </div>
            @endif
            @if($voucherType==9)
            <input type="hidden" name="payment_from" value="811" /><!--Sim Bike and Vendor Charges Account ID-->
            @endif
            @if($voucherType==11)
            <input type="hidden" name="payment_from" value="617" /><!--Fuel Charges Account ID-->
            @endif
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Payment Type</label>
                {!! Form::select('payment_type',App\Helpers\Account::payment_type_list(),null ,['class' => 'form-control form-control-sm select2 ','id'=>'payment_type']) !!}


            </div>
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Billing Month</label>
{{--                 {!! Form::select('billing_month',App\Helpers\CommonHelper::BillingMonth(),null ,['class' => 'form-control form-control-sm select2 ','id'=>'billing_month']) !!}
 --}}                <input type="month" name="billing_month" class="form-control form-control-sm" value="@isset($vouchers->billing_month){{date('Y-m',strtotime($vouchers->billing_month)) }}@else{{date('Y-m')}}@endisset">
            </div>

        </div>

            @if($voucherType == 3)
            <h5>Journal Voucher</h5>
            @include("vouchers.journal_fields")
            @endif
            @if($voucherType == 5)
            <h5>Invoice Voucher</h5>
            @include("vouchers.invoice_fields")
            @endif
            @if($voucherType == 9)
            <h5>Vendor Charges Voucher</h5>
            @include("vouchers.sim_fields")
            @endif
            @if($voucherType == 10)
            <h5>Bike Rent Voucher</h5>
            @include("vouchers.rent_fields")
            @endif
            @if($voucherType == 11)
            <h5>Fuel Voucher</h5>
            @include("vouchers.fuel_fields")
            @endif
            @if($voucherType == 8)
            <h5>RTA Fine Voucher</h5>
            @include("vouchers.rta_fields")
            @endif


            <div class="row">
                <div class="col-md-7 text-right">Total:</div>
                <div class="form-group col-md-2">
                    <input type="number" class="form-control form-control-sm" id="total_dr" readonly placeholder="Total Dr">
                </div>
                <div class="form-group col-md-2">
                    <input type="number" class="form-control form-control-sm" id="total_cr" readonly placeholder="Total Cr">
                </div>
            </div>

    </div>

<script>
    $(document).ready(function() {
  $('#datepicker').datepicker({
    format: "mm-yyyy", // Output format
    minView: 1, // Start with month view
    startView: 1, // Open in month view
  });
});
    $(document).ready(function () {
   var base_url = $('#base_url').val();

var counter = 0;
$("#RID").on("change", function () {
    var id = $('#RID').val();
    var type = 5;

        $.get(base_url+'/get_invoice_balance?id='+id+'&type='+type).done(function(data){
            $("#riderInvoiceBalance").val(data.invoice_balance);
            $("#riderBalance").val(data.balance);
            $("#inv_id").val(data.inv_id);
        });
});

        $("#addRiderRow").on("click", function () {
                var item_id = $('#RID').val();
                var item_name = $('#RID option:selected').text();
                var item_price = $('#riderAmount').val();
                var narration = $('#narration').val();
                var inv_id = $('#inv_id').val();
                var invoice = '';
            if(item_price !='' && item_id != ''){

                var newRow ='<tr style="padding:5px;"><td width="200"><label>'+item_name+'</label><input type="hidden" name="id[]" value="'+item_id+'" /><input type="hidden" name="inv_id[]" value="'+inv_id+'" /></td>';
                    newRow +='<td width="200"><input type="text" name="narration[]"  value="'+narration+'" class="form-control form-control-sm" /></td>';
                    newRow +='<td width="100"><input type="number" step="any" name="amount[]"  value="'+item_price+'" step="any" class="form-control form-control-sm amount" onchange="getTotal();" /></td>';
                    newRow +='<td width="100"><input type="button" class="ibtnDel btn btn-md btn-xs btn-danger "  value="Delete"></td></tr>';

                    $("table.order-list").append(newRow);
                    $('#riderAmount').val('');
                    $('#narration').val('');
                    $('#RID option:selected').text('select');
                    $('#RID').val(0);
                    $('#riderBalance').val('');
                    counter++;

                }else{
                    alert("Select Rider and Amount");
                }
                getTotal();
            });


                $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counter -= 1;
                getTotal();
        });
    });

$(".cr_amount").on("focus keyup change",function(){
    getTotal();
});
$(".dr_amount").on("focus keyup change",function(){
    getTotal();
});
$(".amount").on("focus keyup change",function(){
    getTotal();
});
function getTotal() {
    var cr_sum = 0;
    var dr_sum = 0;
    //iterate through each textboxes and add the values
    $(".cr_amount").each(function () {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            cr_sum += parseFloat(this.value);
        }
    });
    //iterate through each textboxes and add the values
    $(".dr_amount").each(function () {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            dr_sum += parseFloat(this.value);
        }
    });
    $(".amount").each(function () {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            cr_sum += parseFloat(this.value);
        }
    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $("#total_cr").val(cr_sum.toFixed(2));
    $("#total_dr").val(dr_sum.toFixed(2));
}

$(document).on("change","#invoice_voucher_type",function () {
            let thisVal=$(this).val();

            if(thisVal==5){
                $("#vendor_section").hide();
                $("#rider_section").show();
                $("table.order-list").html('');
            }else{
                $("#vendor_section").show();
                $("#rider_section").hide();
                $("table.order-list").html('');
            }
           getTotal();
        });
function fetch_invoices(g) {
            let id=g;
            var vt=$("#invoice_voucher_type").val();
            $.ajax({
                url: "{{ url('fetch_invoices') }}/"+id+'/'+vt,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("table.order-list").html(data.htmlData);
                    $("#riderBalance").val(data.rider_balance);
                    $("#vendor_balance").val(data.vendor_balance);

                }
            });
        }
</script>

<script src="{{ URL::asset('public/js/voucher.js') }}"></script>
