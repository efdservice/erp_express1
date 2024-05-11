<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Loans
 * @package App\Models
 * @version May 7, 2024, 10:53 am +04
 *
 * @property integer $rider_id
 * @property number $amount
 * @property string $purpose
 * @property string $terms
 * @property string $issue_date
 * @property string $due_date
 * @property number $paid
 * @property number $balance
 * @property boolean $status
 * @property integer $created_by
 */
class Loans extends Model
{

    use HasFactory;

    public $table = 'loans';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'rider_id',
        'amount',
        'purpose',
        'terms',
        'issue_date',
        'due_date',
        'paid',
        'balance',
        'status',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'rider_id' => 'integer',
        'amount' => 'decimal:2',
        'purpose' => 'string',
        'terms' => 'string',
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid' => 'decimal:2',
        'balance' => 'decimal:2',
        'status' => 'boolean',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'rider_id' => 'required|integer',
        'amount' => 'required|numeric',
        'purpose' => 'nullable|string|max:255',
        'terms' => 'nullable|string|max:100',
        'issue_date' => 'nullable',
        'due_date' => 'nullable',
        'paid' => 'nullable|numeric',
        'balance' => 'nullable|numeric',
        'status' => 'nullable|boolean',
        'created_by' => 'nullable|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];


}
