<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'image', 'description'
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        return asset('/storage/banner/'. $this->image);
    }
}
