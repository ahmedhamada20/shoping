<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialCity extends Model
{
    protected $table = 'special_cities';

    protected $fillable = [
        'arabic', 'english', 'status'
    ];
  
}
