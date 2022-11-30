<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class ImageDB extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    protected $fillable = [
        'filename',
        'temp',
      
       
    ];
}