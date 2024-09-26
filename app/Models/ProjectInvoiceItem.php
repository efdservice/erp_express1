<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'item_id', 'qty', 'rate', 'discount', 'tax', 'amount', 'created_at', 'updated_at', 'inv_id'];

}
