<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'all_emirates_rate_bike', 'all_emirates_rate_car', 'all_emirates_rate_van', 'special_city_rate_bike', 'special_city_rate_car',
        'special_city_rate_van', 'per_kilogram_rate', 'air_condition_rate', 'deliver_type', 'discount'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }
}
