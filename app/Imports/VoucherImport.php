<?php

namespace App\Imports;

use App\Helpers\Account;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\Rider;
use App\Models\Vouchers;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
use Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class VoucherImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    private $additionalData;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function collection(Collection $rows)
    {
        $request = $this->request;

        $request['payment_type'] = 1;

        if ($request['voucher_type'] == 15) {
            $request['payment_from'] = 767;
            $dr_cr = 1;
        }
        if ($request['voucher_type'] == 8) {
            $request['payment_from'] = 425;
            $dr_cr = 1;
        }
        if ($request['voucher_type'] == 11) {
            $request['payment_from'] = 617;
            $dr_cr = 1;
        }
        if ($request['voucher_type'] == 9) {
            $request['payment_from'] = 811;
            $dr_cr = 1;
        }

        foreach ($rows as $row) {

            DB::beginTransaction();
            try {
                if ($row[1] != 'Invoice Date') {


                    $total_amount = 0;
                    if (in_array($request['voucher_type'], [15, 11, 8])) {
                        $amount = $row[5] ?? 0;
                        $tData['SID'] = $row[3];
                        $narration = $row[4];
                    } else {
                        $amount = $row[4] ?? 0;
                        $narration = $row[3];
                    }
                    $total_amount = $amount;

                    if (is_numeric($amount) && $amount > 0) {
                        //1 for debit 2 for credit
                        if ($dr_cr == 1) {
                            $rider_dr_cr = 1;
                            $payment_dr_cr = 2;
                        } else {
                            $rider_dr_cr = 2;
                            $payment_dr_cr = 1;
                        }
                        /*  if (is_numeric($row[0])) {
                             $dateTimeObject = Date::excelToDateTimeObject($row[0]);
                             $trans_date = Carbon::instance($dateTimeObject)->format('Y-m-d');
                         } else { */
                        $trans_date = date('Y-m-d', strtotime($row[0]));
                        //}

                        $billing_month = date('Y-m-01', strtotime($row[1]));
                        /* if ($billing_month == '1970-01-01') {
                            $Billingdate = Date::excelToDateTimeObject($row[1]);
                            $billing_month = Carbon::instance($Billingdate)->format('Y-m-01');
                        } */


                        $data['trans_date'] = $trans_date;
                        $data['voucher_type'] = $request['voucher_type'];
                        $data['payment_type'] = $request['payment_type'];
                        $data['payment_from'] = $request['payment_from'];
                        $data['billing_month'] = $billing_month;
                        $data['ref_id'] = @$request->ref_id;

                        $trans_code = Account::trans_code();

                        $tData['billing_month'] = $billing_month;
                        $tData['trans_date'] = $trans_date;
                        $tData['posting_date'] = $trans_date;
                        $tData['trans_code'] = $trans_code;
                        $tData['status'] = 1;
                        $tData['vt'] = $request['voucher_type'];
                        $tData['Created_By'] = \Auth::user()->id;

                        $tData['payment_type'] = @$request['payment_type'];

                        //dr to rider


                        /* if (in_array($request->voucher_type, [14])) {
                            $RTAID = $row[2];
                            $amount = $row[5];
                        } else { */
                        $rider = Rider::where('rider_id', $row[2])->first();

                        $RTAID = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $rider->id])->value('id');
                        //}
                        //dr to rider
                        $tData['trans_acc_id'] = $RTAID;
                        $tData['dr_cr'] = $rider_dr_cr;
                        $tData['amount'] = $amount;
                        $tData['narration'] = $narration;

                        Transaction::create($tData);

                        /*  }
                     } */



                        //cr to compnay
                        //$tData['narration'] = $request->sim_narration;
                        //$tData['SID'] = null;
                        $tData['trans_acc_id'] = $request['payment_from'];
                        $tData['dr_cr'] = $payment_dr_cr;
                        $tData['amount'] = $total_amount;
                        Transaction::create($tData);

                        //creating/updating voucher
                        $data['amount'] = $total_amount;

                        $data['trans_code'] = $trans_code;
                        $data['Created_By'] = \Auth::user()->id;

                        $ret = Vouchers::create($data);
                    }

                }
                DB::commit();
            } catch (QueryException $e) {
                DB::rollback();
                $e->getMessage();
            }

        }
    }
}
