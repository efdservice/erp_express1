<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorItemPrice extends Model
{
    use HasFactory;
    protected $guarded=[];

    function vendors(){
        return $this->belongsTo(Vendor::class,'VID','id');
    }
    function items(){
        return $this->belongsTo(Item::class,'item_id','id');
    }
}
