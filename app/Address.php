<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'address', 'status','address_type', 'recipient_name', 'recipient_phone','city','street','building','apartment','longitude','latitude'
    ];
}
