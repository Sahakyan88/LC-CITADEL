<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_am', 'title_en', 'title_ru',
        'body_am', 'body_ru', 'body_en',
        'price',
        'image_id',
        'ordering',
        'published',
    ];
}
