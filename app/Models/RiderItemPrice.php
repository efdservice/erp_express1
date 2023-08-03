<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderItemPrice extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function vendorItem(){
        return $this->hasMany(VendorItemPrice::class,'item_id','item_id');
    }
}
