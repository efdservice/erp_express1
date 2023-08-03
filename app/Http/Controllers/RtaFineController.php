<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Imports\RtaFineImport;
use App\Models\Accounts\PaymentVoucher;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\RtaFine;
use Illuminate\Http\Request;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class RtaFineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rta_fines.index');
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
            'RID'=>'required',
            'BID'=>'required',
            'amount'=>'required',
            'LCID'=>'required',
        ];
        $message=[
            'trans_date.required'=>'Transaction Date Required',
            'RID.required'=>'Please Select Rider',
            'BID.required'=>'Please Select Bike',
            'amount.required'=>'Amount should be greater than 0',
            'LCID.required'=>'Lease Company required',
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
                $data['other_detailse'] ='pay fine against Tool gate:'.$request->toll_gate.'(' .$request->other_detailse.')';
                $ret = RtaFine::create($data);
            } else {
                RtaFine::where('id',$id)->update($data);
            }
            $transcode=RtaFine::where('id',$id)->value('trans_code');
            Transaction::where(['trans_code'=>$transcode,'vt'=>8])->delete();
            $tData['trans_date']=$request->trans_date;
            $tData['posting_date']=$request->posting_date;
            $tData['trans_code'] = Account::trans_code();
            $tData['status']=1;
            $tData['vt']=8;
            $tData['Created_By'] = Auth::user()->id;
            //dr to rider
            $tData['trans_acc_id'] = TransactionAccount::where(['PID'=>21,'parent_type'=>$request->RID])->value('id');
            $tData['dr_cr'] = 1;
            $tData['amount']=$request->amount;
            $tData['narration']='pay fine against Tool gate:'.$request->toll_gate;
            Transaction::create($tData);
            //dr to compnay
            $tData['trans_acc_id'] = TransactionAccount::where(['PID'=>22,'parent_type'=>$request->LCID])->value('id');
            $tData['dr_cr'] = 1;
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
        return RtaFine::paginate(15);
    }
    /*
     * import riders in excel
     */
    public function import_excel(Request $request){
        $rules=[
            'file'=>'required|max:50000|mimes:xlsx'
        ];
        $message=[
            'file.required'=>'Excel File Required'
        ];
        $this->validate($request,$rules, $message);
        Excel::import(new RtaFineImport(), $request->file('file'));
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
        return RtaFine::where('trans_code',$id)->delete();
    }
}
