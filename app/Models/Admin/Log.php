<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'owner_id',
        'type'
    ];

    public function setUpdatedAtAttribute($value)
    {
        
    }
}
