<?php

namespace App\Models\Accounts;

use App\Models\Bike;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use Illuminate\Http\Request;

class Transaction extends Model
{
    use HasFactory;
    //    protected static function boot()
//    {
//        parent::boot();
//
//        Transaction::creating(function($model) {
//            $model->financial_year = session::get('financial_year');;
//        });
//    }
    protected $fillable = [
        'amount',
        'dr_cr',
        'vt',
        'trans_code',
        'trans_acc_id',
        'trans_date',
        'posting_date',
        'rec_date',
        'narration',
        'status',
        'Created_By',
        'Updated_By',
        'BID',
        'created_at',
        'updated_at',
        'payment_type',
        'SID',
        'billing_month'
    ];
    protected $attributes = ['Created_By' => 0, 'Updated_By' => 0, 'BID' => 0];

    public function trans_acc()
    {
        return $this->belongsTo(TransactionAccount::class, 'trans_acc_id', 'id');
    }
    public function bike()
    {
        return $this->hasOne(Bike::class, 'id', 'SID');
    }


}
