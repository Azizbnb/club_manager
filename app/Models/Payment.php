<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Payment",
 *      required={"amount","payment_method","status","date","user_id"},
 *      @OA\Property(
 *          property="amount",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="payment_method",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="transaction_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */class Payment extends Model
{
    use HasFactory;    public $table = 'payments';

    public $fillable = [
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'date',
        'user_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_method' => 'string',
        'status' => 'string',
        'transaction_id' => 'string',
        'date' => 'datetime'
    ];

    public static array $rules = [
        'amount' => 'nullable|numeric',
        'payment_method' => 'nullable|string|max:255',
        'status' => 'nullable|string|max:255',
        'transaction_id' => 'nullable|string|max:255',
        'date' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'user_id' => 'nullable'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
