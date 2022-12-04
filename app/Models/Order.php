<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public const SERVICE_TYPE = 'one_time_service';
    public const PACKAGE_TYPE = 'package';
    public const PENDING_STATUS = 'pending';
    public const PAID_STATUS = 'paid';
    public const COMPLETED_STATUS = 'completed';
    protected $fillable = [
        'user',
        'status',
        'product',
        'session_id',
        'user_id',
        'service_id',
        'total_amount'
    ];

    /**
     * @var string[]
     */
    // protected $casts = [
    //     'user' => 'json',
    //     'product' => 'array',
    // ];
}
