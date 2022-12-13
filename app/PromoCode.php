<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code','discount'
    ];
   
}
