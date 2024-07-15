<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <title>RiderID: {{$res[0]->rider->rider_id}} Month: {{date('M-Y',strtotime($res[0]->billing_month))}}</title>
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
            <td colspan="3"><h4 style="margin-bottom: 0px;margin-top: 5px;font-size: 12px;border-bottom: 1px solid #000;border-top: 1px solid #000;padding: 3px 0px;">Rider Invoice</h4></td>
        </tr>
    </table>


    <table width="100%" style="font-family: sans-serif; margin-top: 0px;font-size: 10px;">
        <tr>
            <td>
                <table style="text-align: left;">
                    <tr>
                        <th>Invoice Type:</th>
                        <td>Rider Invoice</td>
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
                <table style="text-align: left;">
                    <tr>
                        <th>Joining Date:</th>
                        <td>{{$res[0]->rider->doj}}</td>
                    </tr>
                        <tr>
                        <th>Zone:</th>
                        <td>{{$res[0]->zone}}</td>
                    </tr>
                    <tr>
                        <th>Bike #:</th>
                        <td>{{@$res[0]->bike->plate}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;border-top: 1px solid #000; border-collapse: collapse;">
                <b>Rider Detail</b>
            </td>
        </tr>

        <tr>
            <td>
                <table style="text-align: left;">

                        <tr>
                        <th>Rider ID:</th>
                        <td>{{$res[0]->rider->rider_id }}</td>
                    </tr>
                    <tr>
                        <th>Rider Name:</th>
                        <td>{{ \Illuminate\Support\Facades\DB::table("riders")->selectRaw('CONCAT(name," (",rider_id,")") AS rider_name')->where('id',$res[0]->RID)->value('rider_name') }}</td>
                    </tr>

                    <tr>
                        <th>Vendor:</th>
                        <td>{{@$res[0]->rider->vendor->name }}</td>
                    </tr>
                    <tr>
                        <th>Rider Contact:</th>
                        <td>{{@$res[0]->rider->personal_contact }}</td>
                    </tr>
                    <tr>
                        <th>Fleet Supervisor:</th>
                        <td>{{@$res[0]->rider->fleet_supervisor }}</td>
                    </tr>
                    <tr>
                        <th>Sup. Contact:</th>
                        <td>{{@$res[0]->rider->company_contact }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{@$res[0]->descriptions }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="text-align: left;">
                    <tr>
                        <th>Status:</th>
                        <td @if($res[0]->rider->status == 3) style="color:red;" @endif>{{ App\Helpers\CommonHelper::RiderStatus($res[0]->rider->status) }}</td>
                    </tr>
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
        @foreach($res[0]->riderInv_item as $key=>$val)
            @php
                $total+=$val->amount;
                $total_qty +=$val->qty;
            @endphp
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
            <td colspan="1" style="padding: 5px;text-align: left;"></td>
            <td colspan="1" style="padding: 5px;text-align: right;font-weight:bold;">Total Orders:</td>
            <td colspan="1" style="padding: 5px;text-align: center;font-weight:bold;">{{$total_qty}}</td>
            <th style="padding: 5px;text-align: right;">Sub Total:</th>
            <th style="padding: 5px;text-align: right;">{{ \App\Helpers\Account::show_bal_format($total) }}</th>
        </tr>

        @php
        $sim =\App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,9);
        @endphp
        @if($sim!=0)
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>
            <th style="padding: 5px;text-align: right;">Bike Rent & Vendor & Sim Charges:</th>

            <th style="padding: 5px;text-align: right;">{{ number_format($sim,2)}}</th>
        </tr>
        @endif
        @php
                $fuel =\App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,11);
        @endphp
        @if($fuel!=0)
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>
            <th style="padding: 5px;text-align: right;">Fuel Charges:</th>

            <th style="padding: 5px;text-align: right;">{{ number_format($fuel,2) }}</th>
        </tr>
        @endif
        @php
                $rent =\App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,10);
        @endphp
        @if($rent!=0)
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>
            <th style="padding: 5px;text-align: right;">Bike Rent Charges:</th>

            <th style="padding: 5px;text-align: right;">{{ number_format($rent,2) }}</th>
        </tr>
        @endif
        @php
        $maintenance =\App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,15);
        @endphp
        @if($rent!=0)
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>
            <th style="padding: 5px;text-align: right;">Bike Maintenenace Charges:</th>

            <th style="padding: 5px;text-align: right;">{{ number_format($maintenance,2) }}</th>
        </tr>
        @endif
        @php
        $rta =\App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,8);
        @endphp
        @if($rta!=0)
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>
            <th style="padding: 5px;text-align: right;">RTA Charges:</th>

            <th style="padding: 5px;text-align: right;">{{ number_format($rta,2)}}</th>
        </tr>
        @endif
        @php
        /* $repay =\App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,13);
        $loan_balance = \App\Helpers\Account::getVouchers($res[0]->RID,null,12)-\App\Helpers\Account::getVouchersTillMonth($res[0]->RID,$res[0]->billing_month,13); */

        $loan_advance = \App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,12);
     @endphp
     @if($loan_advance!=0)
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>

            <th style="padding: 5px;text-align: right;">Advance/Loan:</th>
            <th style="padding: 5px;text-align: right;">{{number_format($loan_advance,2)}}</th>
        </tr>
    @endif
    @php
      $cod = \App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,16);
     @endphp
     @if($cod!=0)
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>

            <th style="padding: 5px;text-align: right;">COD:</th>
            <th style="padding: 5px;text-align: right;">{{number_format($cod,2)}}</th>
        </tr>
    @endif
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>
            <th style="padding: 5px;text-align: right;">Total:</th>
            @php
            $credit = $sim+$rent+$rta+$fuel+$loan_advance+$maintenance+$cod;
            $balance = $total-$credit;
            @endphp
            <th style="padding: 5px;text-align: right;">AED {{ \App\Helpers\Account::show_bal_format($balance) }}</th>
        </tr>
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>
            <th style="padding: 5px;text-align: right;">Paid Amount:</th>
            @php
                $paid = \App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,3)+\App\Helpers\Account::getVouchers($res[0]->RID,$res[0]->billing_month,5);
            @endphp
            <th style="padding: 5px;text-align: right;">{{ number_format($paid,2)}}</th>
        </tr>
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 5px;text-align: left;"></td>
            <th style="padding: 5px;text-align: right;">Balance:</th>
            <th style="padding: 5px;text-align: right;">AED {{ number_format(($balance-$paid),2)}}</th>
        </tr>

