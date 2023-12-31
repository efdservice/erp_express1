<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <title>Rider Invoice</title>
    <style>
        .page-footer, .page-footer-space {
            /*height: 39px;*/
        }
        .page-footer {
            position: relative;
            bottom: 0;
            width: 100%;
            left: 0;
        }
        .headerDiv{position: relative;width: 33.33%;float: left;min-height: 1px;}
        #btns{position: relative;bottom: 20px;}
        /*.footer{
            position: absolute;bottom: 0;height: 39px;
        }*/
        .pcontainer{
            position: relative;height: 100%;
        }
        hr{margin-bottom: 2px;margin-top: 2px;}
        @media print{
            #btns{ display:none;}
            @page { margin: 0 0.10cm; margin-top: 10px;}
            html, body {
                padding: 20px;
                margin: 0;
            }
            #pnumber:after{
                counter-increment: page;
                content:"Page " counter(page);
            }
            .page-footer{position: absolute;}

        }
    </style>
</head>

<body>
<div style="position: relative;min-height: 100%;height: 100%;">
    <table width="100%" style="font-family: sans-serif;">
        <tr>
            <td width="33.33%"><img src="{{ URL::asset('public/dist/img/print-logo.png') }}" width="150" /></td>
            <td width="33.33%" style="text-align: center;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 14px;">Express Fast Delivery Service</h4>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;">Office No. 305, Al Rubaya Building Damascus Street Al Qusais 2 Dubai U.A.E</p>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;"> TRN 1005392707000003</p></td>
            <td width="33.33%" style="text-align: right;"></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="3"><h4 style="margin-bottom: 15px;margin-top: 25px;font-size: 14px;border-bottom: 1px solid #000;border-top: 1px solid #000;padding: 7px 0px;">Rider Invoice</h4></td>
        </tr>
    </table>
    <table width="100%" style="font-family: sans-serif; margin-top: 20px;font-size: 12px">
        <tr>
            <td style="padding: 3px;width: 65%;text-align: left;"><strong>Rider Name:</strong>:{{ \Illuminate\Support\Facades\DB::table("riders")->selectRaw('CONCAT(name," (",rider_id,")") AS rider_name')->where('id',$res[0]->RID)->value('rider_name') }}</td>
            <th style="padding: 3px;width: 15%;text-align: left;">Invoice Date:</th>
            <td style="padding: 3px;width: 20%;text-align: left;">{{ date('Y-m-d h:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 3px;width: 65%;text-align: left;"><strong>Invoice Type</strong>: Rider Invoice</td>
            <th style="padding: 3px;width: 15%;text-align: left;">#inv No:</th>
            <td style="padding: 3px;width: 15%;text-align: left;">{{ \App\Helpers\CommonHelper::inv_sch($res[0]->id,$res[0]->created_at) }}</td>
        </tr>

    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border: 1px solid #000; border-collapse: collapse; margin-top: 20px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;">
            <th>#</th>
            <th style="border: 1px solid #000; padding: 10px;">Item Description</th>
            <th style="border: 1px solid #000; padding: 10px;">Qty</th>
            <th style="border: 1px solid #000; padding: 10px;">Rate</th>
            <th style="border: 1px solid #000; padding: 10px;">Amount</th>
        </tr>
        </thead>
        <tbody>
        @php $total=0; @endphp
        @foreach($res[0]->riderInv_item as $key=>$val)
            @php $total+=$val->amount; @endphp
            <tr>
                <td style="padding: 5px;border:1px solid">{{ $key+1 }}</td>
                <td style="padding: 5px;border:1px solid; text-align: left">
                    {{ $val->riderInv_item }}
                    {{ \App\Models\Item::where('id',$val->item_id)->value('item_name') }}
                </td>
                <td style="padding: 5px;border:1px solid;text-align: center">{{ $val->qty }}</td>
                <td style="padding:5px;border:1px solid">{{ $val->rate }}</td>
                <td style="padding:5px;border:1px solid; text-align: right">{{ $val->amount }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 10px;text-align: left;"></td>
            <th style="padding: 10px;text-align: right;">Sub Total:</th>
            <th style="padding: 10px;text-align: right;">{{ \App\Helpers\Account::show_bal_format($total) }}</th>
        </tr>
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 10px;text-align: left;"></td>
            <th style="padding: 10px;text-align: right;">Total:</th>
            <th style="padding: 10px;text-align: right;">AED {{ \App\Helpers\Account::show_bal_format($total) }}</th>
        </tr>
        </tfoot>
    </table>
    <div id="btns" style="margin-top: 50px">
        <button class="btn btn-sm btn-outline-danger" type="button" onClick="window.print()"><i class="fa fa-file-pdf-o"></i> Print</button>
    </div>
</div>
</body>
</html>
