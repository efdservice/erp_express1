<?php

namespace App\Imports;

use App\Helpers\Account;
use App\Helpers\CommonHelper;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\AssignVendorRider;
use App\Models\Item;
use App\Models\Rider;
use App\Models\RiderInvoice;
use App\Models\RiderInvoiceItem;
use App\Models\RiderItemPrice;
use App\Models\VendorInvoiceItem;
use App\Models\VendorItemPrice;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
use Auth;

class ImportRiderInvoice implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $items=[
            $rows[0][2],$rows[0][3],$rows[0][4],$rows[0][5],$rows[0][6],$rows[0][7],$rows[0][8],$rows[0][9],$rows[0][10],
            $rows[0][11],$rows[0][12],$rows[0][13],$rows[0][14],$rows[0][15],$rows[0][16]
        ];
        foreach ($rows as $row) {
            try {
                DB::beginTransaction();
                if ($row[0] != 'ID') {
                    $rider = Rider::where('rider_id', $row[0])->first();
                    $RID = $rider->id;
                    $VID = $rider->VID;
                    //$VID = AssignVendorRider::where('RID', $RID)->value('VID');
                    $ret = RiderInvoice::create([
                        'inv_date' => date('Y-m-d'),
                        'RID' => $RID,
                        'VID' => $VID,
                        'zone' => $row[21],
                        'login_hours' => $row[20],
                        'working_days' => $row[22],
                        'perfect_attendance' => $row[23],
                        'rejection' => $row[19],
                        'performance' => $row[26],
                        'month_invoice' => $row[25],
                        'off' => $row[24],
                        'descriptions' =>$row[27],
                    ]);
                    $j = 2;
                    foreach ($items as $item) {
                        $itemId = Item::where('item_name', $item)->value('id');
                        if($itemId) {
                            $riderPrice=CommonHelper::riderItemPrice($RID, $itemId);
                            $dta['item_id'] = $itemId;
                            $dta['qty'] = $row[$j];
                            $dta['rate'] = $riderPrice;
                            $dta['amount'] = ($riderPrice) * ($row[$j]);
                            $dta['inv_id'] = $ret->id;
                           RiderInvoiceItem::create($dta);
                        }
                        $j++;
                    }
                    $k = 2;
                    foreach ($items as $itemm) {
                        $itemIdd = Item::where('item_name', $itemm)->value('id');
                        if($itemIdd) {
                            $vendorPrice=CommonHelper::vendorItemPrice($VID, $itemIdd);
                            $dtaa['item_id'] = $itemIdd;
                            $dtaa['qty'] = $row[$k];
                            $dtaa['rate'] = $vendorPrice;
                            $dtaa['amount'] = ($vendorPrice) * ($row[$k]);
                            $dtaa['inv_id'] = $ret->id;
                            VendorInvoiceItem::create($dtaa);
                        }
                        $k++;
                    }
                    $total=RiderInvoiceItem::where('inv_id',$ret->id)->sum('amount');
                    RiderInvoice::where('id',$ret->id)->update(['total_amount'=>$total]);
                    //accounts entries
                    $rider_amount=RiderInvoiceItem::where('inv_id',$ret->id)->sum('amount');
                    $vendor_amount=VendorInvoiceItem::where('inv_id',$ret->id)->sum('amount');
                    $profit=$vendor_amount-$rider_amount;
                    $data['trans_acc_id']=TransactionAccount::where(['PID'=>21,'Parent_Type'=>$RID])->value('id');
                    $data['vt']=4;
                    $data['amount']=$rider_amount;
                    $data['narration']='Rider Invoice Against #'.$ret->id;
                    $data['status']=1;
                    $data['SID']=$ret->id;
                    $data['created_by']=Auth::user()->id;
                    $data['dr_cr']=2;
                    $data['trans_code']=Account::trans_code();
                    $data['trans_date']=date('Y-m-d');
                    $data['posting_date']=date('Y-m-d');
                    Transaction::create($data);
                    //cr to vendor
                    $data['trans_acc_id']=TransactionAccount::where(['PID'=>9,'Parent_Type'=>$VID])->value('id');
                    $data['amount']=$profit;
                    Transaction::create($data);
                }
                DB::commit();
            }catch (QueryException $e){
                DB::rollBack();
            }
        }
    }
}
