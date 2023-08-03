<?php

namespace App\Imports;

use App\Helpers\Account;
use App\Models\Accounts\TransactionAccount;
use App\Models\Country;
use App\Models\Rider;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;

class RiderImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            if($row[0]!='Name') {
                try {
                    $ret = Rider::create([
                        'name' => $row[0],
                        'rider_id' => $row[1],
                        'cdm_deposit_id' => $row[2],
                        'mashreq_id' => $row[3],
                        'doj' => $row[4],
                        'emirate_hub' => $row[5],
                        'DEPT' => $row[6],
                        'company_contact' => $row[7],
                        'personal_contact' => $row[8],
                        'nationality' => Country::where('name', $row[9])->value('id'),
                        'ethnicity' => $row[10],
                        'personal_email' => $row[11],
                        'emirate_id' => $row[12],
                        'emirate_exp' => $row[13],
                        'passport' => $row[14],
                        'dob' => $row[15],
                        'license_no' => $row[16],
                        'license_expiry' => $row[17],
                        'visa_status' => $row[18],
                        'vaccine_status' => $row[19],
                    ]);
                    $tData['Trans_Acc_Name'] = $row[0];
                    $tData['PID'] = 21;
                    $tData['Parent_Type'] = $ret->id;
                    $code = Account::current_code('RD', $ret->id);
                    $tData['Parent_Type'] = $ret->id;
                    $tData['code'] = $code;
                    TransactionAccount::create($tData);
                }catch (QueryException $e){
                    $e->getMessage();
                }
            }
        }
    }
}
