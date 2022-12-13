<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'parcel_id', 'parcel_description', 'weight', 'is_fragile', 'need_aircool', 'user_location', 'delivery_address_id', 'vehicle_type', 'recipient_name', 'recipient_phone', 'additional_notes', 'image', 'status', 'amount', 'order_date', 'order_time', 'order_type', 'payment_method'
    ];

    /**
     * Get the order record associated with the package.
     */
    // public function order()
    // {
    //     return $this->hasOne('App\Order', 'package_id', 'id');

    // }

    /**
     * Get the package that owns the order.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return asset('/storage/packages/thumbnail/'. $this->image);
    }
}
