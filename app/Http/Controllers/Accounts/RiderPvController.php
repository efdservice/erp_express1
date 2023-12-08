<?php

namespace App\Http\Controllers\Accounts;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Accounts\PaymentVoucher;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\Rider;
use App\Models\RiderInvoice;
use Illuminate\Http\Request;
use DB;
use Auth;

class RiderPvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Accounts.vouchers.rider_pv.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Accounts.vouchers.rider_pv.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $rules=[
            'trans_date'=>'required',
            'payment_from'=>'required',
            'payment_type'=>'required',
        ];
        $message=[
            'trans_date.required'=>'Transaction Date Required',
            'payment_from.required'=>'Bank/Cash Account Required',
            'payment_type.required'=>'Payment Type Required',
        ];
        $this->validate($request, $rules, $message);
        $data['trans_date']=$request->trans_date;
        $data['posting_date']=$request->trans_date;

        if($request->voucher_type == 5){
            $data['payment_to']=$request->RID;
        }else{
            $data['payment_to']=$request->VID;
        }
        
        $data['payment_reason']=$request->payment_reason;
        $data['payment_from']=$request->payment_from;
        $data['payment_type']=$request->payment_type;
        $data['voucher_type']=$request->voucher_type;
        $data['ref']=$request->ref;
        $id=$request->id;
        //account entry
        $tData['trans_date']=$request->trans_date;
        $tData['posting_date']=$request->trans_date;
        //$tData['payment_to']=$request->RID??$request->VID;
        $tData['payment_from']=$request->payment_from;
        $tData['status']=1;
        $tData['vt']=2;
        $tData['trans_code']=Account::trans_code();
      
        if(isset($request->attach_file)) {
            $doc = $request->attach_file;
            $extension =  $doc->extension();
            $name = time().'.'.$extension;
            $doc->storeAs('voucher',$name);
            $data['attach_file']=$name;
        }
        DB::beginTransaction();
        try {
            if ($request->voucher_type == 5) {
                $VID = TransactionAccount::where(['PID' => 21, 'parent_type' => $request->RID])->value('id');
                $data['trans_code'] = Account::trans_code();
                $data['Created_By'] = Auth::user()->id;
                $data['remarks'] = 'Payment to Rider direct....';
                $data['amount'] = array_sum($request->amount);
                
                $ret = PaymentVoucher::create($data);
                $count = count($request->amount);
                for ($i = 0; $i < $count; $i++) {
                    if ($request['amount'][$i] >0) {
                        $total_amount = $request['amount'][$i];
                        $vendor_amount = Transaction::where('SID', $request['inv_id'][$i])->where(['vt' => 4, 'trans_acc_id' => $VID])->sum('amount');
                        $rider_amount = $total_amount - $vendor_amount;
                        $RID = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $request->RID])->value('id');
                        $tData['Created_By'] = Auth::user()->id;
                        $tData['SID'] = $request['inv_id'][$i];
                        //dr to rider
                        $tData['trans_acc_id'] = $RID;
                        $tData['dr_cr'] = 1;
                        $tData['amount'] = $request['amount'][$i];
                        $tData['narration'] = $request['narration'][$i];
                        Transaction::create($tData);
                        //cr to cash bank
                        $tData['SID'] = 0;
                        $tData['trans_acc_id'] = $request->payment_from;
                        $tData['dr_cr'] = 2;
                        $tData['amount'] = $request['amount'][$i];
                        Transaction::create($tData);
                    }
                }
            }else {
                $count = count($request->RID);
                $VID = TransactionAccount::where(['PID' => 9, 'parent_type' => $request->VID])->value('id');
                if ($id == '' || $id == 0) {
                    $data['trans_code'] = Account::trans_code();
                    $data['Created_By'] = Auth::user()->id;
                    $data['remarks'] = 'Payment to Vendor of Riders etc....';
                    $data['amount'] = array_sum($request->amount);
                  
                    $ret = PaymentVoucher::create($data);
                    for ($i = 0; $i < $count; $i++) {
                        if ($request['amount'][$i] > 0 && $request['RID'][$i] != null) {
                            $total_amount = $request['amount'][$i];
                            $vendor_amount = Transaction::where('SID', $request['inv_id'][$i])->where(['vt' => 4, 'trans_acc_id' => $VID])->sum('amount');
                            $rider_amount = $total_amount - $vendor_amount;
                            $RID = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $request['RID'][$i]])->value('id');
                            $tData['Created_By'] = Auth::user()->id;
                            $tData['SID'] = $request['inv_id'][$i];
                            //dr to rider
                            $tData['trans_acc_id'] = $RID;
                            $tData['dr_cr'] = 1;
                            $tData['amount'] = $rider_amount;
                            $tData['narration'] = $request['narration'][$i];
                            Transaction::create($tData);
                            //dr to vendor
                            $tData['trans_acc_id'] = $VID;
                            $tData['dr_cr'] = 1;
                            $tData['amount'] = $vendor_amount;
                            Transaction::create($tData);
                            //cr to cash bank
                            $tData['SID'] = 0;
                            $tData['trans_acc_id'] = $request->payment_from;
                            $tData['dr_cr'] = 2;
                            $tData['amount'] = $request['amount'][$i];
                            Transaction::create($tData);
                        }
                    }
                } else {
                    $PID = Agent::where('id', $id)->value('PID');
                    Agent::where('id', $id)->update($data);
                    $tData['updated_by'] = Auth::user()->id;
                    TransactionAccount::where(['Parent_Type' => $id, 'PID' => $PID])->update($tData);
                }
            }
            DB::commit();
        }
        catch
        (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors' => $e->errorInfo,
                'code' => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
        return response()->json(['success' => 'Added new record Successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result=PaymentVoucher::where('trans_code',$id)->first();
        $data=Transaction::where('trans_code',$id)->get();
        return view('Accounts.vouchers.rider_pv.show',compact('data','result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result=PaymentVoucher::where('trans_code',$id)->first();
        $data=Transaction::where('trans_code',$id)->get();
        return view('Accounts.vouchers.rider_pv.edit',compact('result','data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->post()){
           
            $totalAmount = 0;
            foreach($request->trans as $trans){
               
               $transaction = Transaction::find($trans['id']);
               $transaction->narration = $trans['narration'];
               $transaction->amount = $trans['amount'];
               if($trans['dr_cr'] == 2){
                $transaction->trans_acc_id = $request->payment_from;
                $totalAmount += $trans['amount'];
                //$transaction->payment_type = $request->payment_type;
               }
               $transaction->save();               
            }

            
            $payment = PaymentVoucher::find($id);
            
            if(isset($request->attach_file)) {
                $doc = $request->attach_file;
                $extension =  $doc->extension();
                $name = time().'.'.$extension;
                $doc->storeAs('voucher',$name);
                $payment->attach_file=$name;
            }
            $payment->ref =$request->ref;
            $payment->trans_date = $request->trans_date;
            $payment->payment_reason = $request->payment_reason;
            $payment->payment_from = $request->payment_from;
            $payment->payment_type = $request->payment_type;
            $payment->amount = $totalAmount;
            $payment->save();
           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fetch_invoices($id, $vt){
        $date = date('Y-m-d');
        $date = date('Y-m-d', strtotime($date . ' +1 day'));
        if($vt==5){
            $res = RiderInvoice::where('RID', $id)->get();
            $htmlData = '';
            foreach ($res as $item) {
                $total = Transaction::where('SID', $item->id)->where('vt', 4)->sum('amount');
                $paid = Transaction::where('SID', $item->id)->where('vt', 2)->sum('amount');
                $balance = ($total) - ($paid);
                if ($balance > 0) {
                    $trans_acc_id = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $item->RID])->value('id');
                    $rider_balance = Account::ob($date, $trans_acc_id);
                    $htmlData .= '
                <div class="row">
                <input type="hidden" name="inv_id[]" value="' . $item->id . '">
                        <div class="form-group col-md-4">
                            <label>Narration</label>
                            <textarea name="narration[]" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;">Payment to Rider against #' . $item->id . ' through vendor</textarea>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Invoice Balance</label>
                            <input type="number" name="" class="form-control form-control-sm" value="' . $balance . '" readonly placeholder="Balance Amount">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Amount</label>
                            <input type="number" name="amount[]" class="form-control form-control-sm" placeholder="Paid Amount">
                        </div>
                    </div>
                    <!--row-->
            ';
                }
            }
            //SELECT SUM(t.amount) FROM rider_invoices rv INNER JOIN transactions AS t ON rv.id=t.SID WHERE vt='4' and rv.VID=1
            return compact('htmlData','rider_balance');
        }else {
            $res = RiderInvoice::where('VID', $id)->get();
            $htmlData = '';
            $vendor_balance=0;
            foreach ($res as $item) {
                $total = Transaction::where('SID', $item->id)->where('vt', 4)->sum('amount');
                $paid = Transaction::where('SID', $item->id)->where('vt', 2)->sum('amount');
                $balance = ($total) - ($paid);
                if ($balance > 0) {
                    $trans_acc_id = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $item->RID])->value('id');
                    $rider_balance = Account::ob($date, $trans_acc_id);
                    $htmlData .= '
                <div class="row">
                <input type="hidden" name="inv_id[]" value="' . $item->id . '">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Payment To</label>
                            <select name="RID[]" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                               ' . Rider::dropdown($item->RID) . '
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Narration</label>
                            <textarea name="narration[]" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;">Payment to Rider against #' . $item->id . ' through vendor</textarea>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Rider Balance</label>
                            <input type="text" name="" class="form-control form-control-sm" value="' . Account::show_bal($rider_balance) . '" readonly placeholder="Balance Amount">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Invoice Balance</label>
                            <input type="number" name="" class="form-control form-control-sm" value="' . $balance . '" readonly placeholder="Balance Amount">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Amount</label>
                            <input type="number" name="amount[]" class="form-control form-control-sm" placeholder="Paid Amount">
                        </div>
                    </div>
                    <!--row-->
            ';
           
                }
                $vendor_balance += $rider_balance;
            }
            //SELECT SUM(t.amount) FROM rider_invoices rv INNER JOIN transactions AS t ON rv.id=t.SID WHERE vt='4' and rv.VID=1
            return compact('htmlData','vendor_balance');
        }
    }
}
