<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $table = 'job_status';

    public function rider()
    {
        return $this->hasOne(Rider::class, 'id', 'RID');
    }

    public static function dropdown($id = 0)
    {
        $res = self::all();
        $list = '';
        foreach ($res as $rider) {
            $list .= '<option ' . ($id == $rider->id ? 'selected' : '') . ' value="' . $rider->id . '">' . $rider->plate . '</option>';
        }
        return $list;
    }
}
