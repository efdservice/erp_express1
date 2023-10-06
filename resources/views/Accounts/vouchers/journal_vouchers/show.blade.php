
<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <title>Journal Voucher</title>
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

<body style="">
<div style="position: relative;min-height: 100%;height: 100%;">
    <table width="100%" style="font-family: sans-serif;">
        <tr>
            <td width="33.33%"><img src="{{ URL::asset('public/dist/img/print-logo.png') }}" width="150" /></td>
            <td width="33.33%" style="text-align: center;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 14px;">Express Fast Delivery Service</h4>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;">Office No. 305, Al Rubaya Building Damascus Street Al Qusais 2 Dubai U.A.E</p>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;"> TRN 1005392707000003</p>
            <td width="33.33%" style="text-align: right;"></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="3"><h4 style="margin-bottom: 15px;margin-top: 25px;font-size: 14px;border-bottom: 1px solid #000;border-top: 1px solid #000;padding: 7px 0px;">Journal Voucher</h4></td>
        </tr>
    </table>
    <table width="100%" style="font-family: sans-serif; margin-top: 20px;font-size: 12px">
        <tr>
            <td style="padding: 3px;width: 65%;text-align: left;"><strong>Voucher No</strong>: {{ $result->trans_code }}</td>
            <th style="padding: 3px;width: 15%;text-align: left;">Voucher Date:</th>
            <td style="padding: 3px;width: 20%;text-align: left;">{{ date('Y-m-d') }}</td>
        </tr>
        <tr>
            <td style="padding: 3px;width: 65%;text-align: left;"><strong>Voucher Type</strong>: Payment Voucher</td>
            <th style="padding: 3px;width: 15%;text-align: left;">Ref No:</th>
            <td style="padding: 3px;width: 20%;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding: 3px;width: 65%;text-align: left;">&nbsp;</td>

        </tr>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: left;border: 1px solid #000; border-collapse: collapse; margin-top: 20px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;">
            <th style="border: 1px solid #000; padding: 10px;width: 20px;">Sr</th>
            <th style="border: 1px solid #000; padding: 10px;">Account Name</th>
            <th style="border: 1px solid #000; padding: 10px;">Particulars</th>
            <th style="border: 1px solid #000; padding: 10px;">Dr.</th>
            <th style="border: 1px solid #000; padding: 10px;">Cr.</th>
        </tr>
        </thead>
        <tbody>
        @php $td=0; $tc=0; 
        $code ='';
        @endphp
        @foreach($data as $key=>$val)
        @php
            $code ='';
        @endphp
            @php
                if($val->dr_cr==1)
                {
                    $td+=$val->amount;
                }
                if($val->dr_cr==2)
                {
                    $tc+=$val->amount;
                }

                if($val->trans_acc->PID == 21){
                $rider = app\Helpers\Account::getRider($val->trans_acc->Parent_Type);
                $code = $rider->rider_id.' - ';

            }
            @endphp

          
            <tr>
                <td style="padding: 5px;border:1px solid">{{ $key+1 }}</td>
                <td style="padding: 5px;border:1px solid">
                    {{ $code.$val->trans_acc->Trans_Acc_Name}}
                    {{-- {{ \App\Models\Accounts\TransactionAccount::where('id',$val->trans_acc_id)->value('trans_acc_name') }} --}}
                </td>
                <td style="padding: 5px;border:1px solid;text-align: left">{{ $val->narration }}</td>
                <td style="padding:5px;border:1px solid">@if($val->dr_cr==1) {{ $val->amount }} @else 0.00 @endif</td>
                <td style="padding:5px;border:1px solid">@if($val->dr_cr==2) {{ $val->amount }} @else 0.00 @endif</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr style="border-top: 1px solid #000;">
            <td colspan="2" style="padding: 10px;text-align: left;"></td>
            <th style="padding: 10px;text-align: right;">Net:</th>
            <th style="padding: 10px;text-align: center;">{{ \App\Helpers\Account::show_bal_format($td) }}</th>
            <th style="padding: 10px;text-align: center;">{{ \App\Helpers\Account::show_bal_format($tc) }}</th>
        </tr>
        </tfoot>
    </table>
    <div id="btns" style="margin-top: 50px">
        <button class="btn btn-sm btn-outline-danger" type="button" onClick="window.print()"><i class="fa fa-file-pdf-o"></i> Print</button>
    </div>
</div>
</body>
</html>
