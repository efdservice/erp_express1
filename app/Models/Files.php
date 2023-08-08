<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $guarded=[];



    public static function dropdown($id=0){
        $res=self::all();
        $list='';
        foreach ($res as $file){
            $list.='<option '.($id==$file->id?'selected':'').' value="'.$file->id.'">'.$file->file_name.'</option>';
        }
        return $list;
    }
}
