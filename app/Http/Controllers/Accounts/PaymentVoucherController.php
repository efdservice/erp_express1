<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Account;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\PaymentVoucher;
use DB;
use Auth;

class PaymentVoucherController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pv_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Accounts.vouchers.payment_vouchers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'payment_to'=>'required',
            'payment_type'=>'required',
        ];
        $message=[
            'trans_date.required'=>'Transaction Date Required',
            'payment_to.required'=>'Bank/Cash Account Required',
            'payment_type.required'=>'Payment Type Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','narration','OB']);
        $data['status']=1;
        $data['payment_reason']=$request->payment_reason;


        $id=$request->id;
        //account entry
        $tData['trans_date']=$request->trans_date;
        $tData['posting_date']=$request->trans_date;
        $tData['payment_type']=$request->payment_type;
        $tData['conversion_rate']=$request->conversion_rate;
        $tData['currency']=$request->currency;
        $tData['narration']=$request->narration;
        $tData['amount']=$request->amount;
        $tData['status']=1;
        $tData['vt']=2;
        if(isset($request->attach_file)) {
            $doc = $request->attach_file;
            $extension =  $doc->extension();
            $name = time().'.'.$extension;
            $doc->storeAs('voucher',$name);
            $data['attach_file']=$name;
        }
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['trans_code']=Account::trans_code();
                $data['created_by']=Auth::user()->id;
                $data['remarks']=$request->narration;
                $ret=PaymentVoucher::create($data);
                $tData['Created_By']=Auth::user()->id;
                //dr to cash bank
                $tData['trans_code']=Account::trans_code();
                $tData['trans_acc_id']=$request->payment_to;
                $tData['dr_cr']=1;
                Transaction::create($tData);
                //cr to client
                $tData['trans_acc_id']=$request->payment_from;
                $tData['dr_cr']=2;
                Transaction::create($tData);
            } else {
                $trans_code=PaymentVoucher::where('id', $id)->value('trans_code');
                PaymentVoucher::where('trans_code', $trans_code)->update($data);

                $tData['Updated_By']=Auth::user()->id;

                $tData['trans_acc_id']=$request->payment_to;
                $tData['dr_cr']=1;
                Transaction::where('trans_code',$trans_code)->where('dr_cr',1)->update($tData);
                //cr to client
                $tData['trans_acc_id']=$request->payment_from;
                $tData['dr_cr']=2;
                Transaction::where('trans_code',$trans_code)->where('dr_cr',2)->update($tData);
                //TransactionAccount::where(['Parent_Type'=>$id,'PID'=>$PID])->update($tData);
            }
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
        return response()->json(['success' => 'Added new record Successfully.']);
    }
    //@listing data
    public function get_data(Request $request){
        if($request->get('s')){
            return PaymentVoucher::where('status',1)->orderBy('id','DESC')->paginate(15);

        }else{
            return PaymentVoucher::where('status',0)->orderBy('id','DESC')->paginate(15);

        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PaymentVoucher::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return PaymentVoucher::where('trans_code',$id)->first();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaymentVoucher::where('trans_code', $id)->delete();
        Transaction::where('trans_code', $id)->delete();
    }
}
