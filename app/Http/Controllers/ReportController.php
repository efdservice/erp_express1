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
        $ob_total = 0;
        $b_total = 0;

        if ($request->billing_month) {
            $request->billing_month = $request->billing_month . "-01";
        }

        $result = new Rider();
        if ($request->status) {
            $result = $result->where('status', $request->status);
        }
        if ($request->VID) {
            $result = $result->where('VID', $request->VID);
        }
        if ($request->designation) {
            $result = $result->where('designation', $request->designation);
        }
        $result = $result->get();
        $balance = 0.00;
        foreach ($result as $rider) {

            if (isset($rider->account->id)) {
                $opening_balance = Account::Monthly_ob($request->billing_month, $rider->account->id);
                $balance = Account::BillingMonth_Balance($request->billing_month, $rider->account->id);
            } else {
                $balance = 0.00;
            }
            $data .= '<tr>';
            $data .= '<td  >' . @$rider->rider_id . '</td>';
            $data .= '<td  >' . @$rider->name . '</td>';
            $data .= '<td >' . @$rider->vendor->name . '</td>';
            $data .= '<td >' . @$rider->designation . '</td>';
            $data .= '<td  >' . @$rider->bikes->plate . '</td>';
            $data .= '<td >' . CommonHelper::RiderStatus($rider->status) . '</td>';

            $data .= '<td align="right" >' . number_format($opening_balance, 2) . '</td>';
            $data .= '<td align="right" >' . number_format($balance, 2) . '</td>';
            $data .= '<td align="right">' . Account::show_bal($opening_balance + $balance) . '</td>';
            $data .= '</tr>';

            $ob_total += $opening_balance;
            $total += $balance;
            $b_total += $opening_balance + $balance;

        }






        $data .= '<tr>';
        $data .= '<td colspan="6"></td>';
        $data .= '<th style="text-align: right">' . number_format($ob_total, 2) . '</th>';
        $data .= '<th style="text-align: right">' . number_format($total, 2) . '</th>';
        $data .= '<th style="text-align: right">' . Account::show_bal($b_total) . '</th>';
        $data .= '</tr>';

        return compact('data', 'balance');
    }
}
