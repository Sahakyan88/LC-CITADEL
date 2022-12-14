<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const PENDING_STATUS = 'pending';
    public const PAID_STATUS = 'paid';
    public const COMPLETED_STATUS = 'completed';
    protected $fillable = [
        'status',
        'product_id',
        'session_id',
        'user_id',
        'total_amount'
    ];
}
