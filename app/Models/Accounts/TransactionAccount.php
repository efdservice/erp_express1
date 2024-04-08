<?php

namespace App\Models\Accounts;

use App\Models\Rider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'Trans_Acc_Name',
        'PID',
        'Parent_Type',
        'OB',
        'OB_Type',
        'BID',
        'Created_BY',
        'Updated_By',
        'Last_Activity',
        'code'
    ];

    public function subhead()
    {
        return $this->belongsTo(SubHeadAccount::class, 'PID', 'id');
    }
    public static function dropdown($id = 0)
    {
        $list = '';
        $res = self::all();
        foreach ($res as $re) {
            $rider_id = '';
            if ($re->PID == 21) {
                $rider_id = Rider::where('id', $re->Parent_Type)->value('rider_id');
                $rider_id = $rider_id . '-';
            }
            $list .= '<option ' . ($id == $re->id ? 'selected' : '') . ' value="' . $re->id . '">' . $rider_id . $re->Trans_Acc_Name . '</option>';
        }
        return $list;
    }
    //@vendor drop down
    public static function vendor_dd()
    {
        $list = '';
        $res = self::where('PID', 9)->get();
        foreach ($res as $re) {
            $list .= '<option value="' . $re->id . '">' . $re->Trans_Acc_Name . '</option>';
        }
        return $list;
    }
    //@client drop down
    public static function client_dd()
    {
        $list = '';
        $res = self::whereIn('PID', array(2, 21))->get();
        foreach ($res as $re) {
            $list .= '<option value="' . $re->id . '">' . $re->Trans_Acc_Name . '</option>';
        }
        return $list;
    }
    //@bank and cash drop down list
    public static function bank_cash()
    {
        $list = '';
        $res = self::where('PID', 1)->get();
        foreach ($res as $re) {
            $list .= '<option value="' . $re->id . '">' . $re->Trans_Acc_Name . '</option>';
        }
        return $list;
    }

    public static function bank_cash_list()
    {
        $list = self::where('PID', 1)->pluck('Trans_Acc_Name', 'id');
        return $list->prepend('Select', 0);

    }

    //relation with rider
    public function rider()
    {
        return $this->belongsTo(Rider::class, 'Parent_Type', 'id')->where('PID', 21);
    }

    public function riderDetail()
    {
        return $this->hasOne(Rider::class, 'id', 'Parent_Type');
    }

    public static function getSubAccounts($id)
    {
        $TA = self::find($id);
        if ($TA->PID == 9) {
            $ids = self::selectRaw('transaction_accounts.id')->join('riders', 'riders.id', 'transaction_accounts.Parent_Type')
                ->where('VID', $TA->Parent_Type)->where('transaction_accounts.PID', 21)->pluck('transaction_accounts.id')->toArray();
            return $ids;
        } else {
            return array();
        }

    }



}
