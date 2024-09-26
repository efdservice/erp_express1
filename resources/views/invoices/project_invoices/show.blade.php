<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <title>ProjectID: {{$res[0]->project->id}} Month: {{date('M-Y',strtotime($res[0]->billing_month))}}</title>
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
            <td width="33.33%">&nbsp;{{-- <img src="/public/dist/img/print-logo.png" width="150" /> --}}</td>
            <td width="33.33%" style="text-align: center;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 12px;">Express Fast Delivery Service</h4>
                <p style="margin-bottom: 5px;font-size: 12px;margin-top: 5px;">Office No. 305, Al Rubaya Building Damascus Street Al Qusais 2 Dubai U.A.E</p>
                <p style="margin-bottom: 5px;font-size: 12px;margin-top: 5px;"> TRN 1005392707000003</p></td>
            <td width="33.33%" style="text-align: right;"></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="3"><h4 style="margin-bottom: 0px;margin-top: 5px;font-size: 12px;border-bottom: 1px solid #000;border-top: 1px solid #000;padding: 3px 0px;">Customer Invoice</h4></td>
        </tr>
    </table>


    <table width="100%" style="font-family: sans-serif; margin-top: 0px;font-size: 10px;">
        <tr>
            <td>
                <table style="text-align: left;">
                    <tr>
                        <th>Invoice Type:</th>
                        <td>Customer Invoice</td>
                    </tr>
                        <tr>
                        <th>Invoice #:</th>
                        <td>{{ \App\Helpers\CommonHelper::inv_sch($res[0]->id,$res[0]->created_at) }}</td>
                    </tr>
                    <tr>
                        <th>Invoice Date:</th>
                        <td>{{ $res[0]->created_at->format("Y-m-d h:i A") }}</td>
                    </tr>
                    <tr>
                        <th>Billing Month:</th>
                        <td>{{date('M-Y',strtotime($res[0]->billing_month))}}</td>
                    </tr>
                </table>
            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;border-top: 1px solid #000; border-collapse: collapse;">
                <b>Customer Detail</b>
            </td>
        </tr>

        <tr>
            <td>
                <table style="text-align: left;">

                        <tr>
                        <th>Customer ID:</th>
                        <td>{{$res[0]->project->id }}</td>
                    </tr>
                    <tr>
                        <th>Customer Name:</th>
                        <td>{{$res[0]->project->name }}</td>
                    </tr>

                    <tr>
                        <th>Company:</th>
                        <td>{{@$res[0]->project->company_name }}</td>
                    </tr>
                    <tr>
                        <th>Company Contact:</th>
                        <td>{{@$res[0]->project->contact_number }}</td>
                    </tr>

                </table>
            </td>
            <td>
                <table style="text-align: left;">

                    <tr>
                        <th>Working Days:</th>
                        <td>{{$res[0]->working_days}}</td>
                    </tr>
                        <tr>
                        <th>Perfect Attendance:</th>
                        <td>{{$res[0]->perfect_attendance}}</td>
                    </tr>
                    <tr>
                        <th>Off:</th>
                        <td>{{@$res[0]->off}}</td>
                    </tr>
                    <tr>
                        <th>Rejection:</th>
                        <td>{{@$res[0]->rejection}}</td>
                    </tr>
                    <tr>
                        <th>Performance:</th>
                        <td>{{@$res[0]->performance}}</td>
                    </tr>
                </table>
            </td>
        </tr>


    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border: 1px solid #000; border-collapse: collapse; margin-top: 5px;font-size: 10px;">
        <thead>
        <tr >
            <th>#</th>
            <th style="border: 1px solid #000; padding: 5px;">Item Description</th>
            <th style="border: 1px solid #000; padding: 5px;">Qty</th>
            <th style="border: 1px solid #000; padding: 5px;">Rate</th>
            <th style="border: 1px solid #000; padding: 5px;">Amount</th>
        </tr>
        </thead>
        <tbody>
        @php
        $total=0;
        $total_qty=0;
        @endphp
        @foreach($res[0]->projectInv_item as $key=>$val)
            @php
                $total+=$val->amount;
                $total_qty +=$val->qty;
            @endphp
            <tr>
                <td style="padding: 5px;border:1px solid">{{ $key+1 }}</td>
                <td style="padding: 5px;border:1px solid; text-align: left">
                    {{ $val->projectInv_item }}
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
            <td colspan="1" style="padding: 5px;text-align: left;"></td>
            <td colspan="1" style="padding: 5px;text-align: right;font-weight:bold;">Total Orders:</td>
            <td colspan="1" style="padding: 5px;text-align: center;font-weight:bold;">{{$total_qty}}</td>
            <th style="padding: 5px;text-align: right;">Sub Total:</th>
            <th style="padding: 5px;text-align: right;">{{ \App\Helpers\Account::show_bal_format($total) }}</th>
        </tr>
        </tfoot>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border: 1px solid #000; border-collapse: collapse;font-size: 10px;border-top:0px;">
    <tr>
        <td style="width:55%;text-align: left;padding:5px;">
            <b>Notes</b>
            <br />{{$res[0]->notes}}
        </td>
        <td>
            <table style="width: 100%; font-family: sans-serif;text-align: center;border: 1px solid #000; border-collapse: collapse;font-size: 10px;border-top:0px;border-right:0px;">

                <tr style="border-top: 1px solid #000;">
                    <th style="padding: 5px;text-align: right;">Total:</th>

                    <th style="padding: 5px;text-align: right;">AED {{ \App\Helpers\Account::show_bal_format($total) }}</th>
                </tr>
                {{-- <tr style="border-top: 1px solid #000;">
                    <th style="padding: 5px;text-align: right;">Paid Amount:</th>
                    @php
                        $paid = \App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,3)+\App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,5);
                    @endphp
                    <th style="padding: 5px;text-align: right;">{{ number_format($paid,2)}}</th>
                </tr>
                <tr style="border-top: 1px solid #000;">
                    <th style="padding: 5px;text-align: right;">Balance:</th>
                    <th style="padding: 5px;text-align: right;">AED {{ number_format(($balance-$paid),2)}}</th>
                </tr> --}}
            </table>
        </td>
    </tr>

        </tfoot>
    </table>
</div>
</body>
</html>


