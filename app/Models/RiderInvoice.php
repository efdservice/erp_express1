<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rider()
    {
        return $this->hasOne(Rider::class, 'id', 'RID');
    }
    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'VID');
    }

    public function riderInv_item()
    {
        return $this->hasMany(RiderInvoiceItem::class, 'inv_id', 'id');
    }
    public function vendorInv_item()
    {
        return $this->hasMany(VendorInvoiceItem::class, 'inv_id', 'id');
    }
    public function bike()
    {
        return $this->hasOne(Bike::class, 'RID', 'RID');
    }

    public function sim()
    {
        return $this->hasOne(Sim::class, 'assign_sim', 'RID');
    }
}
