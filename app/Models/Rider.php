<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function dropdown($id=0){
        $res=self::all();
        $list='';
        foreach ($res as $rider){
            $list.='<option '.($id==$rider->id?'selected':'').' value="'.$rider->id.'">'.$rider->name.' ('.$rider->rider_id.')</option>';
        }
        return $list;
    }

    public function vendor(){
        return $this->hasOne(Vendor::class,'id','VID');
    }

    public function bikes(){
        return $this->hasMany(Bike::class,'RID','id');
    }

    public function sims(){
        return $this->hasMany(Sim::class,'assign_sim','id');
    }
}
