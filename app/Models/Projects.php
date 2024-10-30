<?php

namespace App\Models;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function riderr()
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');
    }

    public static function dropdown($id = 0)
    {
        $res = self::all();
        $list = '';
        foreach ($res as $project) {
            $list .= '<option ' . ($id == $project->id ? 'selected' : '') . ' value="' . $project->id . '">' . $project->name . '</option>';
        }
        return $list;
    }

    public function account()
    {
        return $this->belongsTo(TransactionAccount::class, 'id', 'Parent_Type')->where('PID', 2);
    }
}
