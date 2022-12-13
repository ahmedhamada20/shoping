<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageMedia extends Model
{
    protected $fillable = [
        'package_id', 'image'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (strlen($this->image) > 0) {
            $files = [];
            $images = explode(',', $this->image);
            foreach ($images as $image) {
                $files[] = asset('/storage/packages/thumbnail/' . $image);
            }
            return $files;
        } else {
            $files = [];
            return $files;
        }
    }
}
