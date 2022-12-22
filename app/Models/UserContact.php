<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    use HasFactory;

    protected $table = 'contact_user';

    protected $fillable = [
        'user_id', 
        'service_id', 
        'pay_allowed'

      
    ];
}
