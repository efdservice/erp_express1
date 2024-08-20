<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Helpers\CommonHelper;
use App\Models\Rider;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function rider_invoice_index()
    {
        return view('Reports.rider');
    }
    public function vendor_invoice_index()
    {
        return view('Reports.vendor');
    }
    public function rider_list()
    {
        $riders = Rider::all()->sortBy('rider_id');
        return view('Reports.rider_list', compact('riders'));
    }
    public function rider_report()
    {
        $riders = [];//Rider::all()->sortBy('rider_id');
        return view('Reports.rider_report', compact('riders'));
    }
    public function rider_report_data(Request $request)
    {

        $data = '';
        $total = 0;

        if ($request->billing_month) {
            $request->billing_month = $request->billing_month . "-01";
        }

        $result = new Rider();
        if ($request->status) {
            $result = $result->where('status', $request->status);
        }

        $result = $result->get();

        foreach ($result as $rider) {

            if (isset($rider->account->id)) {
                $balance = Account::ob($request->billing_month, $rider->account->id);
            } else {
                $balance = 0.00;
            }
            $data .= '<tr>';
            $data .= '<td  align="left">' . @$rider->rider_id . '</td>';
            $data .= '<td  align="left">' . @$rider->name . '</td>';
            $data .= '<td  align="left">' . @$rider->vendor->name . '</td>';
            $data .= '<td  align="left">' . @$rider->designation . '</td>';
            $data .= '<td  align="left">' . @$rider->bikes->plate . '</td>';
            $data .= '<td  align="left">' . CommonHelper::RiderStatus($rider->status) . '</td>';

            $data .= '<td align="right">' . Account::show_bal($balance) . '</td>';
            $data .= '</tr>';

            $total += $balance;

        }






        $data .= '<tr>';
        $data .= '<td colspan="6"></td>';
        $data .= '<th style="text-align: right">' . Account::show_bal($total) . '</th>';
        $data .= '</tr>';

        return compact('data', 'balance');
    }
}
