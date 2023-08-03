<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignVendorRider extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function rider(){
        return $this->belongsTo(Rider::class,'RID','id');
    }

    public function vndor(){
        return $this->belongsTo(Vendor::class,'VID','id');
    }
}
