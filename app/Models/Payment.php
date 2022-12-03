<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'email',
        'status',
        'type',
        'status_log',
        'log',
        'session_id',
    ];

    protected $casts = [
        'log' => 'json',
        'status_log' => 'json'
    ];
}
