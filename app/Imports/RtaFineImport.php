<?php

namespace App\Imports;

use App\Helpers\Account;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\LeaseCompany;
use App\Models\Rider;
use App\Models\RtaFine;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
use Auth;

class RtaFineImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            if($row[0]!='Lease Company') {
                $RID=Rider::where('rider_id',$row[0])->value('id');
                $LCID=LeaseCompany::where('name',$row[1])->value('id');
                DB::beginTransaction();
                try {
                    $ret = RtaFine::create([
                        'trans_date'=>date('Y-m-d'),
                        'posting_date'=>date('Y-m-d',strtotime($row[4])),
                        'BID'=>$row[0],
                        'RID'=>$RID,
                        'toll_gate'=>$row[5],
                        'trip_date'=>date('Y-m-d',strtotime($row[2])),
                        'trip_time'=>date('h:i:s',strtotime($row[3])),
                        'LCID'=>$LCID,
                        'trans_code'=>Account::trans_code(),
                        'amount'=>$row[9],
                        'direction'=>$row[6],
                    ]);
                    $tData['trans_date']=date('Y-m-d');
                    $tData['posting_date']=date('Y-m-d',strtotime($row[4]));
                    $tData['trans_code'] = Account::trans_code();
                    $tData['status']=1;
                    $tData['vt']=8;
                    $tData['Created_By'] = Auth::user()->id;
                    //dr to rider
                    $tData['trans_acc_id'] = TransactionAccount::where(['PID'=>21,'parent_type'=>$RID])->value('id');
                    $tData['dr_cr'] = 1;
                    $tData['amount']=$row[9];
                    $tData['narration']='pay fine against Tool gate:'.$row[5];
                    Transaction::create($tData);
                    //dr to compnay
                    $tData['trans_acc_id'] = TransactionAccount::where(['PID'=>22,'parent_type'=>$LCID])->value('id');
                    $tData['dr_cr'] = 1;
                    Transaction::create($tData);
                    //cr to cash bank
                    $tData['trans_acc_id'] = 16;
                    $tData['dr_cr'] = 2;
                    Transaction::create($tData);
                    DB::commit();
                }catch (QueryException $e){
                    DB::rollback();
                    $e->getMessage();
                }
            }
        }
    }
}
