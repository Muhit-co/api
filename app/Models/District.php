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

    public static function fromName($location)
    {
        $location_parts = explode(",", $location);

        foreach ($location_parts as $index => $lp) {

            $location_parts[$index] = trim($lp);
        }

        try {
            $city = City::firstOrCreate(['name' => $location_parts[1]]);

        } catch (Exception $e) {

            Log::error('DistrictModel/city', (array)$e);

            return false;
        }

        try {
            $district = District::firstOrCreate(['name' => $location_parts[0], 'city_id' => $city->id]);

        } catch (Exception $e) {

            Log::error('DistrictModel/district', (array)$e);

            return false;
        }

        return $district;

        // $district = District::with('city')->where('name', $location)->first();
        // // $district = District::find($location)->first();

        // return $district;
    }
}
