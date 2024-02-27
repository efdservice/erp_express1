<?php
namespace App\Services;

use App\Helpers\Account;
use App\Models\Accounts\JournalVoucher;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\Sim;
use App\Models\SimCharge;
use App\Models\Vouchers;

class VoucherService
{


    public function JournalVoucher($request)
    {

        $rules = [
            'trans_date' => 'required',
            'payment_type' => 'required',
        ];
        $message = [
            'trans_date.required' => 'Transaction Date Required',
            'payment_type.required' => 'Payment Type Required',
        ];
        $request->validate($rules, $message);
        $data = $request->except(['_method', '_token', 'v_trans_code', 'narration', 'dr_amount', 'cr_amount', 'trans_acc_id', 'id']);
        $id = $request->v_trans_code;
        //account entry

        $tData['trans_date'] = $request->trans_date;
        $tData['posting_date'] = $request->trans_date;
        $tData['billing_month'] = $request->billing_month;
        $tData['status'] = 1;
        $tData['vt'] = 3;
        /*  $tData['trans_code'] = Account::trans_code(); */

        $data['remarks'] = 'Journal Voucher';
        $data['amount'] = array_sum($request->cr_amount);
        $data['billing_month'] = $request->billing_month;


        if ($id == '' || $id == 0) {
            $data['Created_By'] = \Auth::user()->id;

            $data['trans_code'] = Account::trans_code();
            $tData['trans_code'] = $data['trans_code'];

            $ret = Vouchers::create($data);

            $tData['Created_By'] = \Auth::user()->id;
            foreach ($request->trans_acc_id as $key => $val) {
                if (!empty($request['trans_acc_id'][$key]) && $request['dr_amount'][$key] > 0) {
                    $tData['trans_acc_id'] = $request['trans_acc_id'][$key];
                    $tData['amount'] = $request['dr_amount'][$key];
                    $tData['narration'] = $request['narration'][$key];
                    $tData['dr_cr'] = 1;
                    Transaction::create($tData);
                }
                if (!empty($request['trans_acc_id'][$key]) && $request['cr_amount'][$key] > 0) {
                    $tData['trans_acc_id'] = $request['trans_acc_id'][$key];
                    $tData['narration'] = $request['narration'][$key];
                    $tData['dr_cr'] = 2;
                    $tData['amount'] = $request['cr_amount'][$key];
                    Transaction::create($tData);
                }
            }
        } else {
            $data['Updated_By'] = \Auth::user()->id;

            $ret = Vouchers::where('trans_code', $id)->update($data);
            Transaction::where('trans_code', $id)->delete();
            $tData['updated_by'] = \Auth::user()->id;
            $tData['trans_code'] = $id;
            foreach ($request->trans_acc_id as $key => $val) {
                if (!empty($request['trans_acc_id'][$key]) && $request['dr_amount'][$key] > 0) {
                    $tData['trans_acc_id'] = $request['trans_acc_id'][$key];
                    $tData['amount'] = $request['dr_amount'][$key];
                    $tData['narration'] = $request['narration'][$key];
                    $tData['dr_cr'] = 1;
                    Transaction::create($tData);
                }
                if (!empty($request['trans_acc_id'][$key]) && $request['cr_amount'][$key] > 0) {
                    $tData['trans_acc_id'] = $request['trans_acc_id'][$key];
                    $tData['narration'] = $request['narration'][$key];
                    $tData['dr_cr'] = 2;
                    $tData['amount'] = $request['cr_amount'][$key];
                    Transaction::create($tData);
                }
            }
        }
        return $ret;


    }

    public function InvoiceVoucher($request)
    {


        $rules = [
            'trans_date' => 'required',
            'payment_from' => 'required',
            'payment_type' => 'required',
        ];
        $message = [
            'trans_date.required' => 'Transaction Date Required',
            'payment_from.required' => 'Bank/Cash Account Required',
            'payment_type.required' => 'Payment Type Required',
        ];
        $request->validate($rules, $message);
        $data = $request->except(['_method', '_token', 'narration', 'dr_amount', 'cr_amount', 'trans_acc_id', 'v_trans_code', 'id', 'VID', 'RID', 'riderBalance', 'inv_id', 'riderInvoiceBalance']);
        $data['trans_date'] = $request->trans_date;
        $data['posting_date'] = $request->trans_date;

        if ($request->invoice_voucher_type == 5) {
            $data['payment_to'] = 0;
            $data['remarks'] = 'Payment to Rider direct....';
        } else {
            $data['payment_to'] = $request->VID;
            $data['remarks'] = 'Payment to Rider of Vendor....';
        }

        $id = $request->v_trans_code;
        if ($id) {
            Transaction::where('trans_code', $id)->delete();
            $trans_code = $id;

        } else {
            $trans_code = Account::trans_code();

        }
        //account entry
        $tData['trans_date'] = $request->trans_date;
        $tData['posting_date'] = $request->trans_date;
        $tData['billing_month'] = $request->billing_month;
        //$tData['payment_to']=$request->RID??$request->VID;
        $tData['payment_from'] = $request->payment_from;
        $tData['status'] = 1;
        $tData['vt'] = 5;
        $tData['trans_code'] = $trans_code;

        /* if (isset($request->attach_file)) {
            $doc = $request->attach_file;
            $extension = $doc->extension();
            $name = time() . '.' . $extension;
            $doc->storeAs('voucher', $name);
            $data['attach_file'] = $name;
        } */

        $total_amount = 0;
        $count = count($request->amount);


        for ($i = 0; $i < $count; $i++) {
            if ($request['amount'][$i] > 0) {
                $total_amount += $request['amount'][$i];

                $RTAID = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $request['id'][$i]])->value('id');
                $tData['Created_By'] = \Auth::user()->id;
                $tData['SID'] = $request['inv_id'][$i] ?? null;
                //dr to rider
                $tData['trans_acc_id'] = $RTAID;
                $tData['dr_cr'] = 1;
                $tData['amount'] = $request['amount'][$i];
                $tData['narration'] = $request['narration'][$i];
                Transaction::create($tData);

            }
        }

        //cr to cash bank
        $tData['SID'] = 0;
        $tData['trans_acc_id'] = $request->payment_from;
        $tData['dr_cr'] = 2;
        $tData['amount'] = $total_amount;
        Transaction::create($tData);
        //creating Payment Voucher transaction


        $data['amount'] = $total_amount;
        if ($id) {
            $data['Updated_By'] = \Auth::user()->id;

            $ret = Vouchers::where('trans_code', $id)->update($data);
        } else {
            $data['Created_By'] = \Auth::user()->id;

            $data['trans_code'] = $trans_code;

            $ret = Vouchers::create($data);
        }
        return $ret;

    }

    public function SimVoucher($request)
    {

        $rules = [
            'trans_date' => 'required',
            /* 'ref_id' => 'required', */
            /*             'CID' => 'required',
             */ 'amount' => 'required',
        ];
        $message = [
            'trans_date.required' => 'Transaction Date Required',
            /*             'ref_id.required' => 'Please Select Sim',
             */ 'amount.required' => 'Amount should be greater than 0',
            /*             'CID.required'=>' Company required',
             */
        ];
        $request->validate($rules, $message);

        $data['trans_date'] = $request->trans_date;
        $data['voucher_type'] = $request->voucher_type;
        $data['payment_type'] = $request->payment_type;
        $data['payment_from'] = $request->payment_from;
        $data['billing_month'] = $request->billing_month;
        $data['ref_id'] = @$request->ref_id;
        $id = $request->v_trans_code;
        if ($id) {
            Transaction::where('trans_code', $id)->delete();
            $trans_code = $id;

        } else {
            $trans_code = Account::trans_code();

        }
        $tData['billing_month'] = $request->billing_month;
        $tData['trans_date'] = $request->trans_date;
        $tData['posting_date'] = $request->trans_date;
        $tData['trans_code'] = $trans_code;
        $tData['status'] = 1;
        $tData['vt'] = 9;
        $tData['Created_By'] = \Auth::user()->id;
        $tData['SID'] = $request['ref_id'];

        //dr to rider

        $total_amount = 0;
        $count = count($request->amount);


        for ($i = 0; $i < $count; $i++) {
            if ($request['amount'][$i] > 0) {
                $total_amount += $request['amount'][$i];

                $RTAID = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $request['id'][$i]])->value('id');
                //dr to rider
                $tData['trans_acc_id'] = $RTAID;
                $tData['dr_cr'] = 1;
                $tData['amount'] = $request['amount'][$i];
                $tData['narration'] = $request['narration'][$i];
                Transaction::create($tData);

            }
        }



        //cr to compnay
        //$tData['narration'] = $request->sim_narration;
        $tData['trans_acc_id'] = 811;//426;//$request->payment_from;
        $tData['dr_cr'] = 2;
        $tData['amount'] = $total_amount;
        Transaction::create($tData);

        //creating/updating voucher
        $data['amount'] = $total_amount;
        if ($id) {
            $data['Updated_By'] = \Auth::user()->id;

            $ret = Vouchers::where('trans_code', $id)->update($data);
        } else {
            $data['trans_code'] = $trans_code;
            $data['Created_By'] = \Auth::user()->id;

            $ret = Vouchers::create($data);
        }

    }

    public function RtaVoucher($request)
    {

        $rules = [
            'trans_date' => 'required',
            'ref_id' => 'required',
            /*             'CID' => 'required',
             */ 'amount' => 'required',
        ];
        $message = [
            'trans_date.required' => 'Transaction Date Required',
            'ref_id.required' => 'Please Select Sim',
            'amount.required' => 'Amount should be greater than 0',
            /*             'CID.required'=>' Company required',
             */
        ];
        $request->validate($rules, $message);

        $data['trans_date'] = $request->trans_date;
        $data['voucher_type'] = $request->voucher_type;
        $data['payment_type'] = $request->payment_type;
        $data['payment_from'] = $request->payment_from;
        $data['billing_month'] = $request->billing_month;
        $data['direction'] = $request->direction;
        $data['toll_gate'] = $request->toll_gate;
        $data['trip_date'] = $request->trip_date;
        $data['lease_company'] = $request->lease_company;
        $data['ref_id'] = $request->ref_id;

        $id = $request->v_trans_code;
        if ($id) {
            Transaction::where('trans_code', $id)->delete();
            $trans_code = $id;

        } else {
            $trans_code = Account::trans_code();

        }

        $tData['billing_month'] = $request->billing_month;
        $tData['trans_date'] = $request->trans_date;
        $tData['posting_date'] = $request->trans_date;
        $tData['trans_code'] = $trans_code;
        $tData['status'] = 1;
        $tData['vt'] = 8;
        $tData['Created_By'] = \Auth::user()->id;
        $tData['SID'] = $request['ref_id'];

        //dr to rider

        $total_amount = 0;
        $count = count($request->amount);


        for ($i = 0; $i < $count; $i++) {
            if ($request['amount'][$i] > 0) {
                $total_amount += $request['amount'][$i];

                $RTAID = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $request['id'][$i]])->value('id');
                //dr to rider
                $tData['trans_acc_id'] = $RTAID;
                $tData['dr_cr'] = 1;
                $tData['amount'] = $request['amount'][$i];
                $tData['narration'] = $request['narration'][$i];
                Transaction::create($tData);

            }
        }



        //cr to compnay
        //$tData['narration'] = $request->sim_narration;
        //$tData['trans_acc_id'] = $request->payment_from;
        $tData['trans_acc_id'] = 425;//TransactionAccount::where(['PID' => 22, 'parent_type' => $request->LCID])->value('id');
        $tData['dr_cr'] = 2;
        $tData['amount'] = $total_amount;
        Transaction::create($tData);

        //creating/updating voucher
        $data['amount'] = $total_amount;
        if ($id) {
            $data['Updated_By'] = \Auth::user()->id;

            $ret = Vouchers::where('trans_code', $id)->update($data);
        } else {
            $data['trans_code'] = $trans_code;
            $data['Created_By'] = \Auth::user()->id;

            $ret = Vouchers::create($data);
        }

    }
    public function RentVoucher($request)
    {

        $rules = [
            'trans_date' => 'required',
            'ref_id' => 'required',
            /*             'CID' => 'required',
             */ 'amount' => 'required',
        ];
        $message = [
            'trans_date.required' => 'Transaction Date Required',
            'ref_id.required' => 'Please Select Sim',
            'amount.required' => 'Amount should be greater than 0',
            /*             'CID.required'=>' Company required',
             */
        ];
        $request->validate($rules, $message);

        $data['trans_date'] = $request->trans_date;
        $data['voucher_type'] = $request->voucher_type;
        $data['payment_type'] = $request->payment_type;
        $data['payment_from'] = $request->payment_from;
        $data['billing_month'] = $request->billing_month;
        $data['direction'] = $request->direction;
        $data['toll_gate'] = $request->toll_gate;
        $data['trip_date'] = $request->trip_date;
        $data['lease_company'] = $request->lease_company;
        $data['vendor_id'] = $request->vendor_id;
        $data['ref_id'] = $request->ref_id;

        $id = $request->v_trans_code;
        if ($id) {
            Transaction::where('trans_code', $id)->delete();
            $trans_code = $id;

        } else {
            $trans_code = Account::trans_code();

        }

        $tData['billing_month'] = $request->billing_month;
        $tData['trans_date'] = $request->trans_date;
        $tData['posting_date'] = $request->trans_date;
        $tData['trans_code'] = $trans_code;
        $tData['status'] = 1;
        $tData['vt'] = 10;
        $tData['Created_By'] = \Auth::user()->id;
        $tData['SID'] = $request['ref_id'];

        //dr to rider

        $total_amount = 0;
        $count = count($request->amount);


        for ($i = 0; $i < $count; $i++) {
            if ($request['amount'][$i] > 0) {
                $total_amount += $request['amount'][$i];

                $RTAID = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $request['id'][$i]])->value('id');
                //dr to rider
                $tData['trans_acc_id'] = $RTAID;
                $tData['dr_cr'] = 1;
                $tData['amount'] = $request['amount'][$i];
                $tData['narration'] = $request['narration'][$i];
                Transaction::create($tData);

            }
        }



        //cr to compnay
        //$tData['narration'] = $request->sim_narration;
        //$tData['trans_acc_id'] = $request->payment_from;
        $tData['trans_acc_id'] = 441;//TransactionAccount::where(['PID' => 22, 'parent_type' => $request->LCID])->value('id');
        $tData['dr_cr'] = 2;
        $tData['amount'] = $total_amount;
        Transaction::create($tData);

        //creating/updating voucher
        $data['amount'] = $total_amount;
        if ($id) {
            $data['Updated_By'] = \Auth::user()->id;

            $ret = Vouchers::where('trans_code', $id)->update($data);
        } else {
            $data['Created_By'] = \Auth::user()->id;

            $data['trans_code'] = $trans_code;

            $ret = Vouchers::create($data);
        }

    }



}
