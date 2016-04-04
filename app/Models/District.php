<?php namespace Muhit\Models;

class District extends \Eloquent
{

    protected $guarded = ['id'];

    public function hoods()
    {
        return $this->hasMany(Hood::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
