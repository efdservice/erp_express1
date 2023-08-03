<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\Rider;
use App\Models\Sim;
use App\Models\SimCharge;
use Illuminate\Http\Request;
use DB;
use Auth;

class SimChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sim_charges.index');
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
            'sim_id'=>'required',
            'CID'=>'required',
            'amount'=>'required',
        ];
        $message=[
            'trans_date.required'=>'Transaction Date Required',
            'sim_id.required'=>'Please Select Sim',
            'amount.required'=>'Amount should be greater than 0',
            'CID.required'=>' Company required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['payment_type','payment_from']);
        $id=$request->id;
        if(isset($request->attach_file)) {
            $photo=$request->attach_file;
            $docFile=url('/storage/app/'.$photo->store('public/vouchers/payment_voucher'));
            $data['attach_file']=$docFile;
        }
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['trans_code'] = Account::trans_code();
                $data['created_by'] = Auth::user()->id;
                $data['other_details'] ='pay sim charges' .'(' .$request->other_detailse.')';
                $ret = SimCharge::create($data);
            } else {
                SimCharge::where('id',$id)->update($data);
            }
            $transcode=SimCharge::where('id',$id)->value('trans_code');
            Transaction::where(['trans_code'=>$transcode,'vt'=>8])->delete();
            $tData['trans_date']=$request->trans_date;
            $tData['posting_date']=$request->post_date;
            $tData['trans_code'] = Account::trans_code();
            $tData['status']=1;
            $tData['vt']=9;
            $tData['Created_By'] = Auth::user()->id;
            //dr to rider
            $rider=Sim::where('assign_sim',$request->sim_id)->value('assign_sim');
            $tData['trans_acc_id'] = TransactionAccount::where(['PID'=>21,'parent_type'=>$rider])->value('id');
            $tData['dr_cr'] = 1;
            $tData['amount']=$request->amount;
            $tData['narration']='pay sim charges';
            Transaction::create($tData);
            //cr to compnay
            $tData['trans_acc_id'] = $request->CID;
            $tData['dr_cr'] = 2;
            Transaction::create($tData);
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
        return SimCharge::paginate(15);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        Transaction::where('trans_code',$id)->delete();
        return SimCharge::where('trans_code',$id)->delete();
    }
}
