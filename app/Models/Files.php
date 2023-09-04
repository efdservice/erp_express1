<?php

namespace App\Models;

use App\Models\Rider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Files extends Model
{
    use HasFactory;
    use Notifiable;
    protected $guarded=[];



    public static function dropdown($id=0){
        $res=self::all();
        $list='';
        foreach ($res as $file){
            $list.='<option '.($id==$file->id?'selected':'').' value="'.$file->id.'">'.$file->file_name.'</option>';
        }
        return $list;
    }

    public function rider(){
        return $this->hasOne(Rider::class,'id','type_id');
    }
}
