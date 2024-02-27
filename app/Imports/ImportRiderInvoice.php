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
use App\Models\Vouchers;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
use Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ImportRiderInvoice implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {

        $items = [
            $rows[0][3],
            $rows[0][4],
            $rows[0][5],
            $rows[0][6],
            $rows[0][7],
            $rows[0][8],
            $rows[0][9],
            $rows[0][10],
            $rows[0][11],
            $rows[0][12],
            $rows[0][13],
            $rows[0][14],
            $rows[0][15],
            $rows[0][16],
            $rows[0][17],
            $rows[0][18],
            $rows[0][19],
            $rows[0][20]
        ];
        $i = 1;
        foreach ($rows as $row) {
            $i++;
            try {
                DB::beginTransaction();
                if ($row[1] != 'ID') {
                    if ($row[1] != '') {

                        $dateTimeObject = Date::excelToDateTimeObject($row[0]);
                        $invoice_date = Carbon::instance($dateTimeObject)->format('Y-m-d');
                        /*  if (!$invoice_date) {
                             $invoice_date = date('Y-m-01', strtotime($row[0]));
                         } */
                        /* $Billingdate = Date::excelToDateTimeObject($row[28]);
                        $billing_month = Carbon::instance($Billingdate)->format('Y-m-01'); */

                        $billing_month = date('Y-m-01', strtotime($row[28]));


                        $rider = Rider::where('rider_id', $row[1])->first();
                        if (!$rider) {
                            throw ValidationException::withMessages(['file' => 'Row(' . $i . ') - Rider ID ' . $row[1] . ' do not match.']);
                        }
                        $RID = $rider->id;
                        $VID = $rider->VID;
                        //$VID = AssignVendorRider::where('RID', $RID)->value('VID');
                        if (isset($row[21])) {
                            $ret = RiderInvoice::create([
                                'inv_date' => $invoice_date,
                                'RID' => $RID,
                                'VID' => $VID,
                                'zone' => $row[23],
                                'login_hours' => $row[22],
                                'working_days' => $row[24],
                                'perfect_attendance' => $row[25],
                                'rejection' => $row[21],
                                'performance' => $row[27],
                                'billing_month' => $billing_month,
                                'off' => $row[26],
                                'descriptions' => $row[29],
                                'gaurantee' => $row[30],
                            ]);
                            $j = 3;
                            foreach ($items as $item) {
                                $itemId = Item::where('item_name', $item)->value('id');
                                if ($itemId) {
                                    $riderPrice = CommonHelper::riderItemPrice($RID, $itemId);
                                    $dta['item_id'] = $itemId;
                                    $dta['qty'] = $row[$j] ?? 0;
                                    $dta['rate'] = $riderPrice;
                                    $dta['amount'] = ($riderPrice) * ($row[$j]);
                                    $dta['inv_id'] = $ret->id;
                                    RiderInvoiceItem::create($dta);
                                }
                                $j++;
                            }
                            /* $k = 2;
                            foreach ($items as $itemm) {
                                $itemIdd = Item::where('item_name', $itemm)->value('id');
                                if($itemIdd) {
                                    $vendorPrice=CommonHelper::vendorItemPrice($VID, $itemIdd);
                                    $dtaa['item_id'] = $itemIdd;
                                    $dtaa['qty'] = $row[$k]??0;
                                    $dtaa['rate'] = $vendorPrice;
                                    $dtaa['amount'] = ($vendorPrice) * ($row[$k]);
                                    $dtaa['inv_id'] = $ret->id;
                                    VendorInvoiceItem::create($dtaa);
                                }
                                $k++;
                            } */
                            $total = RiderInvoiceItem::where('inv_id', $ret->id)->sum('amount');
                            RiderInvoice::where('id', $ret->id)->update(['total_amount' => $total]);
                            //accounts entries
                            $rider_amount = RiderInvoiceItem::where('inv_id', $ret->id)->sum('amount');
                            //$vendor_amount=VendorInvoiceItem::where('inv_id',$ret->id)->sum('amount');
                            //$profit=$vendor_amount-$rider_amount;
                            $data['trans_acc_id'] = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $RID])->value('id');
                            $data['vt'] = 4;
                            $data['amount'] = $rider_amount;
                            $data['narration'] = 'Rider Invoice Against #' . $ret->id . ' - ' . $row[29];
                            $data['status'] = 1;
                            $data['SID'] = $ret->id;
                            $data['created_by'] = Auth::user()->id;
                            $data['dr_cr'] = 2;
                            $data['trans_code'] = Account::trans_code();
                            $data['trans_date'] = date('Y-m-d');
                            $data['billing_month'] = date("Y-m-01", strtotime($row[28]));
                            $data['posting_date'] = date('Y-m-d');
                            Transaction::create($data);

                            /* creating Vendor Voucher for Bike rent and Sim charges */
                            if ($row[31]) {


                                $trans_code = Account::trans_code();

                                $tData['billing_month'] = $data['billing_month'];
                                $tData['trans_date'] = $data['trans_date'];
                                $tData['posting_date'] = $data['trans_date'];
                                $tData['trans_code'] = $trans_code;
                                $tData['status'] = 1;
                                $tData['vt'] = 9;
                                $tData['Created_By'] = Auth::user()->id;

                                //dr to rider
                                $tData['trans_acc_id'] = $data['trans_acc_id'];
                                $tData['dr_cr'] = 1;
                                $tData['amount'] = $row[31];
                                $tData['narration'] = "Bike & Sim Charges";
                                Transaction::create($tData);


                                //cr to compnay
                                //$tData['narration'] = $request->sim_narration;
                                $tData['trans_acc_id'] = 811; //Bike & Sim Charges Account
                                $tData['dr_cr'] = 2;
                                $tData['amount'] = $row[31];
                                Transaction::create($tData);

                                //creating/updating voucher
                                $vdata['trans_date'] = $data['trans_date'];
                                $vdata['voucher_type'] = 9;
                                $vdata['payment_type'] = 1;
                                $vdata['payment_from'] = 811; //Bike & Sim Charges Account
                                $vdata['billing_month'] = $data['billing_month'];
                                $vdata['amount'] = $row[31];
                                $vdata['trans_code'] = $trans_code;
                                $vdata['Created_By'] = Auth::user()->id;

                                Vouchers::create($vdata);

                            }

                        }
                    }
                }
                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();
            }
        }
    }
}
