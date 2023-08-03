<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeHistory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function rider(){
        return $this->belongsTo(Rider::class,'RID','id');
    }


    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];
}
