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

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public static function fromName($name)
    {
        $district = District::where('name', $name)->first();
        // $district = District::find($name)->first();

        return $district;
    }
}
