<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;
    protected $table = 'error_logs';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'data',
        'type',
        'error',
        'session_id'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'data' => 'json'
    ];
}
