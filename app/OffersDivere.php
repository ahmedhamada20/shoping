<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OffersDivere extends Model
{
    protected $fillable = [
        'driver_id',
        'offers',
        'type',
        'user_id',
    ];

    const CREATENEWOFFER = 0;
    const AGREEMENTOFFER = 1;
    const CANSELOFFER = 2;



    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
