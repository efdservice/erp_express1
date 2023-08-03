<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseCompany extends Model
{
    use HasFactory;

    protected $guarded=[];


    public static function dropdown($id=0){
        $res=self::all();
        $list='';
        foreach ($res as $item){
            $list.='<option '.($id==$item->id?'selected':'').' value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
}
