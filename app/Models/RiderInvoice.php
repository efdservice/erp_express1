<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderInvoice extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function rider(){
        return $this->hasOne(Rider::class,'id','RID');
    }

    public function riderInv_item(){
        return $this->hasMany(RiderInvoiceItem::class,'inv_id','id');
    }
    public function vendorInv_item(){
        return $this->hasMany(VendorInvoiceItem::class,'inv_id','id');
    }
}
