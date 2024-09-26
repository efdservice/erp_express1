<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function project()
    {
        return $this->hasOne(Projects::class, 'id', 'PID');
    }
    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'VID');
    }

    public function projectInv_item()
    {
        return $this->hasMany(ProjectInvoiceItem::class, 'inv_id', 'id');
    }

}
