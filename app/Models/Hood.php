<?php namespace Muhit\Models;

use Exception;
use Log;

class Hood extends \Eloquent
{
    protected $guarded = ['id'];
    protected $issuesCount = ['issueCount'];

    /**
     * gets the hood_id from location string. creates table records if not exists
     *
     * @param $location
     * @return Hood object
     * @author gcg
     */
    public static function fromLocation($location)
    {
        $location_parts = explode(",", $location);

        foreach ($location_parts as $index => $lp) {

            $location_parts[$index] = trim($lp);
        }

        try {
            $city = City::firstOrCreate(['name' => $location_parts[2]]);

        } catch (Exception $e) {

            Log::error('HoodModel/city', (array)$e);

            return false;
        }

        try {
            $district = District::firstOrCreate(['name' => $location_parts[1], 'city_id' => $city->id]);

        } catch (Exception $e) {

            Log::error('HoodModel/district', (array)$e);

            return false;
        }

        try {
            $hood = Hood::firstOrCreate([
                'name' => $location_parts[0],
                'city_id' => $city->id,
                'district_id' => $district->id
            ]);

        } catch (Exception $e) {

            Log::error('HoodModel/hood', (array)$e);

            return false;
        }

        return $hood;
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
