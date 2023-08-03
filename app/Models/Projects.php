<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function riderr(){
        return $this->belongsTo(Projects::class,'project_id','id');
    }

    public static function dropdown($id=0){
        $res=self::all();
        $list='';
        foreach ($res as $project){
            $list.='<option '.($id==$project->id?'selected':'').' value="'.$project->id.'">'.$project->name.'</option>';
        }
        return $list;
    }
}
