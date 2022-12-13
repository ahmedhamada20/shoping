<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverActivity extends Model
{
    protected $fillable = [
        'driver_id', 'in_time', 'out_time', 'status', 'total_time', 'lat', 'lng','activity_type'
    ];

    protected $table = 'driver_activity';
}
