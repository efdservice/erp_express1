<?php

namespace App\Http\Controllers\Accounts;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Accounts\BikeRent;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\Bike;
use Illuminate\Http\Request;
use DB;
use Auth;

class BikeRentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bikes.bikes_rent.index');
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
            'VID'=>'required',
            'LCID'=>'required',
            'credit_amount'=>'required',
        ];
        $message=[
            'trans_date.required'=>'Transaction Date Required',
            'RID.required'=>'Please Select Rider',
            'BID.required'=>'Please Select Bike',
            'VID.required'=>'Vendor required',
            'LCID.required'=>'Lease Company required',
            'credit_amount.required'=>'Credit Amount required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['payment_type','payment_from','other_detailse','credit_amount']);
        $id=$request->id;
        if(isset($request->attach_file)) {
            $photo=$request->attach_file;
            $docFile=url('/storage/app/'.$photo->store('public/vouchers/payment_voucher'));
            $data['attach_file']=$docFile;
        }
        DB::beginTransaction();
        try {
            $total=$request->rider_amount+$request->vendor_amount;
            $bike_plate=Bike::where('id',$request->BID)->value('plate');
            if ($id == '' || $id == 0) {
                $data['trans_code'] = Account::trans_code();
                $data['created_by'] = Auth::user()->id;
                $data['other_details'] ='Pay Bike Rent #plate:'.$bike_plate.'(' .$request->other_detailse.')';
                $ret = BikeRent::create($data);
            } else {
                BikeRent::where('id',$id)->update($data);
            }
            $transcode=BikeRent::where('id',$id)->value('trans_code');
            Transaction::where(['trans_code'=>$transcode,'vt'=>10])->delete();
            $tData['trans_date']=$request->trans_date;
            $tData['posting_date']=$request->posting_date;
            $tData['trans_code'] = Account::trans_code();
            $tData['status']=1;
            $tData['vt']=10;
            $tData['Created_By'] = Auth::user()->id;
            //dr to rider
            $tData['trans_acc_id'] = TransactionAccount::where(['PID'=>21,'parent_type'=>$request->RID])->value('id');
            $tData['dr_cr'] = 1;
            $tData['amount']=$request->rider_amount;
            $tData['narration']='Bike Rent #Plate:'.$bike_plate;
            Transaction::create($tData);
            //dr to Vendor
            $tData['trans_acc_id'] = TransactionAccount::where(['PID'=>9,'parent_type'=>$request->VID])->value('id');
            $tData['dr_cr'] = 1;
            $tData['amount']=$request->vendor_amount;
            Transaction::create($tData);
            //cr to compnay
            $tData['trans_acc_id'] = TransactionAccount::where(['PID'=>22,'parent_type'=>$request->LCID])->value('id');
            $tData['dr_cr'] = 2;
            $tData['amount']=$request->credit_amount;
            Transaction::create($tData);
            //cr to profit margin
            $tData['trans_acc_id'] = TransactionAccount::where(['code'=>'BR-001'])->value('id');
            $tData['dr_cr'] = 2;
            $tData['amount']=($total-$request->credit_amount);
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
        return BikeRent::with('bikes')->paginate(15);
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
        return BikeRent::where('trans_code',$id)->delete();
    }
}
