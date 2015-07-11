<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;
use Muhit\Models\City;
use Muhit\Models\District;

class Hood extends Model {

    //

    protected $guarded = ['id'];


    /**
     * gets the hood_id from location string. creates table records if not exists
     *
     * @return hood object
     * @author gcg
     */
    public static function fromLocation($location)
    {
        $hood = false;
        $location_parts = explode(",", $location);

        foreach ($location_parts as $index => $lp) {
            $location_parts[$index] = trim($lp);
        }

        try {
            $city = City::firstOrCreate(['name' => $location_parts[2]]);
        } catch (Exception $e) {
            Log::error('HoodModel/city', (array) $e);
            return false;
        }

        try {
            $district = District::firstOrCreate(['name' => $location_parts[1], 'city_id' => $city->id]);
        } catch (Exception $e) {
            Log::error('HoodModel/district', (array) $e);
            return false;
        }

        try {
            $hood = Hood::firstOrCreate([
                'name' => $location_parts[0],
                'city_id' => $city->id,
                'district_id' => $district->id]);
        } catch (Exception $e) {
            Log::error('HoodModel/hood', (array) $e);
            return false;

        }

        return $hood;
    }
}
