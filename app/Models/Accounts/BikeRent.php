<?php

namespace App\Models\Accounts;

use App\Models\Bike;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeRent extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function bikes(){
        return $this->belongsTo(Bike::class,'BID','id');
    }
}
