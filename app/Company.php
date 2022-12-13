<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address','status'
    ];

    public function toggleStatus()
    {
        $this->status = !$this->status;
        return $this;
    }

    public function rate()
    {
        return $this->belongsTo('App\Rate', 'id', 'company_id');
    }
}
