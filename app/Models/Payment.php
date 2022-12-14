<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'status',
        'type',
        'status_log',
        'log',
        'session_id',
        'ameria_payment_id'
    ];

    protected $casts = [
        'log' => 'json',
        'status_log' => 'json'
    ];
}
