<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    use HasFactory;
    protected $table = 'action_logs';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'data',
        'type',
        'session_id'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'data' => 'json'
    ];
}
