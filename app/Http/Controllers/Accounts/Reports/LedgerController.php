<?php

namespace App\Http\Controllers\Accounts\Reports;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Http\Request;
use App\Models\Accounts\Transaction;
use App\Helpers\Account;
use Nette\Utils\Helpers;
use DB;

class LedgerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:general_ledger_view', ['only' => ['index']]);
    }
    //@view to main ledger files
    public function index()
    {
        return view('Accounts.reports.ledger.index');
    }
    //fetch data on click search button
    public function get_ledger(Request $request)
    {
        $tdr = 0;
        $tcr = 0;
        $cb = 0;


        if ($request->ledger_id) {
            $ids = TransactionAccount::getSubAccounts($request->ledger_id);

            if (count($ids) > 1) {

                array_push($ids, $request->ledger_id);

                $res = Transaction::whereIn('trans_acc_id', $ids);
            } else {
                $res = Transaction::where('trans_acc_id', $request->ledger_id);
            }
            //$res = Transaction::where('trans_acc_id', $request->ledger_id);

        } else {
            $res = Transaction::where('status', 1);

        }
        if ($request->billing_month) {
            $request->billing_month = $request->billing_month . "-01";
        }

        if ($request->billing_month) {
            $res = $res->where('billing_month', $request->billing_month);
            $request->df = $request->billing_month;

        } else {
            if ($request->df) {
                $res = $res->whereBetween('trans_date', ["$request->df", "$request->dt"]);


            }
        }


        if ($request->ledger_id) {
            $res = $res->where('status', 1)->orderBy('trans_date', 'ASC')->get();

            if ($request->billing_month) {
                $ob = Account::Monthly_ob($request->billing_month, $request->ledger_id);

            } else {
                $ob = Account::ob($request->df, $request->ledger_id);

            }
        } else {
            $res = $res->orderBy('trans_date', 'ASC')->groupBy('trans_acc_id')->get();

            $ob = 0;
        }


        //$ob = Account::ob($request->df, $request->ledger_id);

        $data = '';
        //$ob = Account::ob($request->df, $request->ledger_id);
        $data .= '<tr>';
        $data .= '<td colspan="9" align="right">Opening Balance As At ' . $request->df . '</td>';
        $data .= '<td align="right">' . Account::show_bal($ob) . '</td>';
        $data .= '</tr>';

        foreach ($res as $item) {
            $code = '';
            if ($item->dr_cr == 1) {
                $tdr += $item->amount;
            }
            if ($item->dr_cr == 2) {
                $tcr += $item->amount;
            }
            if ($item->trans_acc->PID == 21) {
                $rider = Account::getRider($item->trans_acc->Parent_Type);
                $code = $rider->rider_id . ' - ';

            }
            $cb = $ob + ($tdr - $tcr);
            $data .= '<tr>';
            $data .= '<td></td>';
            $data .= '<td>' . $item->trans_date . '</td>';
            $data .= '<td>' . $code . $item->trans_acc->Trans_Acc_Name . '</td>';
            $data .= '<td>' . date('M Y', strtotime($item->billing_month)) . '</td>';
            $data .= '<td>' . Account::vt($item->vt) . '</td>';
            $data .= '<td>' . CommonHelper::dsn($item->trans_code) . '</td>';
            $data .= '<td>' . $item->narration . '</td>';
            $data .= '<td>' . (($item->dr_cr == 1) ? $item->amount : '0.00') . '</td>';
            $data .= '<td>' . (($item->dr_cr == 2) ? $item->amount : '0.00') . '</td>';
            $data .= '<td align="right">' . Account::show_bal($cb) . '</td>';
            $data .= '</tr>';
        }
        $data .= '<tr>';
        $data .= '<td colspan="7"></td>';
        $data .= '<th> ' . number_format($tdr, 2) . '</th>';
        $data .= '<th> ' . number_format($tcr, 2) . '</th>';
        $data .= '<th style="text-align: right">' . Account::show_bal($cb) . '</th>';
        $data .= '</tr>';
        return compact('data', 'ob');
    }

    public function ledger()
    {
        return view('Accounts.reports.ledger.ledger');
    }
    public function getLedger(Request $request)
    {
        $tdr = 0;
        $tcr = 0;
        $cb = 0;
        $data = '';
        $SubHead = Account::getSubHead();

        foreach ($SubHead as $sh) {
            $tdr = 0;
            $tcr = 0;
            $cb = 0;

            //$ob = Account::ob($request->df, $request->ledger_id);
            $data .= '<tr>';
            $data .= '<th colspan="10" align="center">' . $sh->name . '</th>';
            $data .= '<td align="right">' . /* Account::show_bal($ob) */ '</td>';
            $data .= '</tr>';
            if ($request->billing_month) {
                $request->billing_month = $request->billing_month . "-01";
            }

            if ($sh->id) {
                $TAccount = Account::getTAbySubHead($sh->id);

                foreach ($TAccount as $ta) {
                    if ($ta->id) {

                        $ids = TransactionAccount::getSubAccounts($ta->id);

                        $res = Transaction::select(DB::raw("SUM(IF(dr_cr=1,amount,0)) AS dr"), DB::raw("SUM(IF(dr_cr=2,amount,0)) AS cr"));

                        if (count($ids) > 1) {

                            array_push($ids, $ta->id);

                            $res = $res->whereIn('trans_acc_id', $ids);
                        } else {
                            $res = $res->where('trans_acc_id', $ta->id);
                        }
                        //$res = Transaction::where('trans_acc_id', $request->ledger_id);



                        if ($request->billing_month) {
                            $res = $res->where('billing_month', $request->billing_month);
                            $request->df = $request->billing_month;

                        } else {
                            if ($request->df) {
                                $res = $res->whereBetween('trans_date', ["$request->df", "$request->dt"]);
                            }
                        }



                        $res = $res->where('status', 1)->orderBy('trans_date', 'ASC')->first();

                        if ($request->billing_month) {
                            $ob = Account::Monthly_ob($request->billing_month, $ta->id);

                        } else {
                            $ob = Account::ob($request->df, $ta->id);

                        }



                        $balance = $ob + ($res->dr - $res->cr);
                        $cb += $balance;
                        if ($ta->riderDetail) {
                            $rider_id = '(' . @$ta->riderDetail->rider_id . ')';
                        } else {
                            $rider_id = '';
                        }
                        $data .= '<tr>';
                        $data .= '<td colspan="7" align="left">' . $rider_id . $ta->Trans_Acc_Name . '<small>  B/F = ' . Account::show_bal($ob) . '  </small></td>';
                        $data .= '<td>' . $res->dr ?? 0.00 . '</td>';
                        $data .= '<td>' . $res->cr ?? 0.00 . '</td>';
                        $data .= '<td align="right">' . Account::show_bal($balance) . '</td>';
                        $data .= '<td align="right">' . Account::show_bal($cb) . '</td>';
                        $data .= '</tr>';

                        $tdr += $res->dr;

                        $tcr += $res->cr;


                        //$ob = Account::ob($request->df, $request->ledger_id);


                        /*  foreach ($res as $item) {
                             $code = '';
                             if ($item->dr_cr == 1) {
                                 $tdr += $item->amount;
                             }
                             if ($item->dr_cr == 2) {
                                 $tcr += $item->amount;
                             }
                             if ($item->trans_acc->PID == 21) {
                                 $rider = Account::getRider($item->trans_acc->Parent_Type);
                                 $code = $rider->rider_id . ' - ';

                             }
                             $cb = $ob + ($tdr - $tcr);
                             $data .= '<tr>';
                             $data .= '<td></td>';
                             $data .= '<td>' . $item->trans_date . '</td>';
                             $data .= '<td>' . $code . $item->trans_acc->Trans_Acc_Name . '</td>';
                             $data .= '<td>' . date('M Y', strtotime($item->billing_month)) . '</td>';
                             $data .= '<td>' . Account::vt($item->vt) . '</td>';
                             $data .= '<td>' . CommonHelper::dsn($item->trans_code) . '</td>';
                             $data .= '<td>' . $item->narration . '</td>';
                             $data .= '<td>' . (($item->dr_cr == 1) ? $item->amount : '0.00') . '</td>';
                             $data .= '<td>' . (($item->dr_cr == 2) ? $item->amount : '0.00') . '</td>';
                             $data .= '<td align="right">' . Account::show_bal($cb) . '</td>';
                             $data .= '</tr>';
                         } */
                    }
                }

            }
            $data .= '<tr>';
            $data .= '<td colspan="7"></td>';
            $data .= '<th> ' . number_format($tdr, 2) . '</th>';
            $data .= '<th> ' . number_format($tcr, 2) . '</th>';
            $data .= '<th style="text-align: right">' . Account::show_bal($cb) . '</th>';
            $data .= '<th style="text-align: right">' . Account::show_bal($cb) . '</th>';
            $data .= '</tr>';
        }
        return compact('data', 'ob');
    }
}
