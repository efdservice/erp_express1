<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisors extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'email', 'phone', 'address'];
    static function dropdown($id = 0)
    {
        $list = '';
        $result = self::all();
        foreach ($result as $item) {
            $list .= '<option ' . (($item->id == $id) ? 'selected' : '') . ' value="' . $item->id . '">' . $item->name . '</option>';
        }
        return $list;
    }

}
