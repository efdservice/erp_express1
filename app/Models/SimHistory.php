<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimHistory extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='sim_histories';

    public function rider(){
        return $this->belongsTo(Rider::class,'assign_sim','id');
    }


    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];
}
