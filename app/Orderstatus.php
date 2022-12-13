<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderstatus extends Model
{
    protected $fillable = [
        'order_id', 'initial_status', 
        'approved_status', 'driver_status', 
        'driver_collected_status', 
        'delivery_status', 'driver_id','
        customer_rating','customer_comment',
        'image'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orderstatuses';

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id', 'id');
    }
    public function driver()
    {
        return $this->belongsTo('App\Driver', 'driver_id', 'id');
    }
}
