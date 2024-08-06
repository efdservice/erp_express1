<?php

namespace App\Models;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function dropdown($id = 0)
    {
        $res = self::all();
        $list = '';
        foreach ($res as $rider) {
            $list .= '<option ' . ($id == $rider->id ? 'selected' : '') . ' value="' . $rider->id . '">' . $rider->name . ' (' . $rider->rider_id . ')</option>';
        }
        return $list;
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'VID');
    }

    public function project()
    {
        return $this->hasOne(Projects::class, 'id', 'PID');
    }

    public function bikes()
    {
        return $this->hasOne(Bike::class, 'RID', 'id');
    }

    public function sims()
    {
        return $this->hasOne(Sim::class, 'assign_sim', 'id');
    }
    public function country()
    {
        return $this->hasOne(Countries::class, 'id', 'nationality');
    }
    public function account()
    {
        return $this->belongsTo(TransactionAccount::class, 'id', 'Parent_Type')->where('PID', 21);
    }

    public function items()
    {
        return $this->hasMany(RiderItemPrice::class, 'RID', 'id');
    }
}
