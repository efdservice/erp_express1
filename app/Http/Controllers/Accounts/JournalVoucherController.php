<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Http\Request;
use App\Models\Accounts\Transaction;
use App\Helpers\Account;
use App\Models\Accounts\JournalVoucher;
use DB;
use Auth;

class JournalVoucherController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:jv_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Accounts.vouchers.journal_vouchers.index');
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
            'payment_type'=>'required',
        ];
        $message=[
            'trans_date.required'=>'Transaction Date Required',
            'payment_type.required'=>'Payment Type Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','narration','dr_amount','cr_amount','trans_acc_id']);
        $id=$request->id;
        //account entry
        /* $data['trans_date']=date('Y-m-d',strtotime($request->trans_date));
        $data['posting_date']=date('Y-m-d',strtotime($request->posting_date));
        $tData['trans_date']=date('Y-m-d',strtotime($request->trans_date));
        $tData['posting_date']=date('Y-m-d',strtotime($request->posting_date)); */
        $tData['trans_date']=$request->trans_date;
        $tData['posting_date']=$request->posting_date;
        $tData['status']=1;
        $tData['vt']=3;
        $tData['trans_code']=Account::trans_code();
        
        DB::beginTransaction();
        try {
            $data['created_by']=Auth::user()->id;
            $data['remarks']='Journal Voucher';
            $data['amount']=array_sum($request->cr_amount);
            $data['month']=$request->month;
            if ($id == '' || $id == 0) {
                $data['trans_code']=Account::trans_code();
                $ret=JournalVoucher::create($data);
                $tData['Created_By']=Auth::user()->id;
                foreach ($request->trans_acc_id as $key=>$val){
                    if(!empty($request['trans_acc_id'][$key]) && $request['dr_amount'][$key]>0) {
                        $tData['trans_acc_id'] = $request['trans_acc_id'][$key];
                        $tData['amount'] = $request['dr_amount'][$key];
                        $tData['narration'] = $request['narration'][$key];
                        $tData['dr_cr'] = 1;
                        Transaction::create($tData);
                    }
                    if(!empty($request['trans_acc_id'][$key]) && $request['cr_amount'][$key]>0) {
                        $tData['trans_acc_id'] = $request['trans_acc_id'][$key];
                        $tData['narration'] = $request['narration'][$key];
                        $tData['dr_cr'] = 2;
                        $tData['amount'] = $request['cr_amount'][$key];
                        Transaction::create($tData);
                    }
                }
            } else {
                $ret=JournalVoucher::where('trans_code',$id)->update($data);
                Transaction::where('trans_code',$id)->delete();
                $tData['updated_by']=Auth::user()->id;
                $tData['trans_code']=$id;
                foreach ($request->trans_acc_id as $key=>$val){
                    if(!empty($request['trans_acc_id'][$key]) && $request['dr_amount'][$key]>0) {
                        $tData['trans_acc_id'] = $request['trans_acc_id'][$key];
                        $tData['amount'] = $request['dr_amount'][$key];
                        $tData['narration'] = $request['narration'][$key];
                        $tData['dr_cr'] = 1;
                        Transaction::create($tData);
                    }
                    if(!empty($request['trans_acc_id'][$key]) && $request['cr_amount'][$key]>0) {
                        $tData['trans_acc_id'] = $request['trans_acc_id'][$key];
                        $tData['narration'] = $request['narration'][$key];
                        $tData['dr_cr'] = 2;
                        $tData['amount'] = $request['cr_amount'][$key];
                        Transaction::create($tData);
                    }
                }
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
        return JournalVoucher::orderBy('id','DESC')->paginate(15);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result=JournalVoucher::where('trans_code',$id)->first();
        $data=Transaction::where('trans_code',$id)->get();
        return view('Accounts.vouchers.journal_vouchers.show',compact('data','result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result=JournalVoucher::where('trans_code',$id)->first();
        $htmlData='';
        $data=Transaction::where('trans_code',$id)->get();
        $key=0;
        foreach ($data as $item){
            $htmlData.='
                    <div class="row">
                        <div class="form-group col-md-3">
                            '.($key==0?'<label for="exampleInputEmail1">Select Account</label>':'').'
                            <select name="trans_acc_id[]" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                '.TransactionAccount::dropdown($item->trans_acc_id).'
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            '.($key==0?'<label>Narration</label>':'').'
                            <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;">'.$item->narration.'</textarea>
                        </div>
                        <div class="form-group col-md-2">
                            '.($key==0?'<label>Dr Amount</label>':'').'
                            <input type="number" name="dr_amount[]" class="form-control form-control-sm dr_amount" placeholder="Dr Amount" value="'.($item->dr_cr==1?$item->amount:'').'">
                        </div>
                        <div class="form-group col-md-2">
                            '.($key==0?'<label>Cr Amount</label>':'').'
                            <input type="number" name="cr_amount[]" class="form-control form-control-sm cr_amount" placeholder="Cr Amount" value="'.($item->dr_cr==2?$item->amount:'').'">
                        </div>
                        <div class="form-group col-md-1">
                            '.($key==0?'<label style="visibility: hidden">plusplusplusplus</label>
                            <button type="button" class="btn btn-primary btn-xs new_line"><i class="fa fa-plus"></i> </button>
                            ':'<button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>').'
                        </div>
                    </div>
            ';
            $key++;
        }
        return compact('result','htmlData');
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
        JournalVoucher::where('trans_code', $id)->delete();
        Transaction::where('trans_code', $id)->delete();
    }
}
