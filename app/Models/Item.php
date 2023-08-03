<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable=['id', 'item_name', 'item_unit', 'pirce', 'cost_price', 'created_by', 'updated_by', 'descriptions', 'created_at', 'updated_at'];

    public static function dropdown($id=0){
        $list='';
        $result=self::all();
        foreach ($result as $item){
            $list.='<option data-price="'.$item->pirce.'~'.$item->cost_price.'" '.($id==$item->id?'selected':'').' value="'.$item->id.'">'.$item->item_name.'</option>';
        }
        return $list;
    }
}
