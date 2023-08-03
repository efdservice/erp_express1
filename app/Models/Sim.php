<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sim extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function riderr(){
        return $this->belongsTo(Rider::class,'assign_sim','id');
    }

    public static function dropdown($id=0){
        $res=self::all();
        $list='';
        foreach ($res as $rider){
            $list.='<option '.($id==$rider->id?'selected':'').' value="'.$rider->id.'">'.$rider->sim_number.'</option>';
        }
        return $list;
    }
}
