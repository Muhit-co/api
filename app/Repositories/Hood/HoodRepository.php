<?php

namespace Muhit\Repositories\Hood;


use Muhit\Models\City;
use Muhit\Models\District;
use Muhit\Models\Hood;

class HoodRepository implements HoodRepositoryInterface
{
    private $hood;
    private $city;
    private $district;

    public function __construct(Hood $hood, City $city, District $district)
    {
        $this->hood = $hood;
        $this->city = $city;
        $this->district = $district;
    }

    public function get($hoodId)
    {
        return $this->hood->with('district.city')->find($hoodId);
    }

    public function all($query, $cityId, $districtId)
    {
        $hoods = $this->hood->orderBy('name', 'asc');

        if ($query && $query !== 'null') {

            $hoods->where('name', 'LIKE', "%{$query}%");
        }

        if ($cityId && $cityId !== 'null') {

            $hoods->where('city_id', $cityId);
        }

        if ($districtId && $districtId !== 'null') {

            $hoods->where('district_id', $districtId);
        }

        return $hoods->get();
    }

    public function cities($query)
    {
        $cities = $this->city->orderBy('name', 'asc');

        if ($query && $query !== 'null') {

            $cities->where('name', 'LIKE', '%' . $query . '%');
        }

        $cities = $cities->get();
        $cities = $cities ? $cities : [];

        return response()->api(200, 'Cities: ', compact('cities'));
    }

    public function hoods($query, $cityId, $districtId)
    {
        $hoods = $this->all($query, $cityId, $districtId);
        $hoods = $hoods ? $hoods : [];

        return response()->api(200, 'Cities: ', compact('hoods'));
    }

    public function districts($city_id = null, $query = null)
    {
        $districts = $this->district->orderBy('name', 'asc');

        if ($query && $query !== 'null') {

            $districts->where('name', 'LIKE', '%' . $query . '%');
        }

        if ($city_id !== null and $city_id !== 'null') {

            $districts->where('city_id', $city_id);
        }

        $districts = $districts->get();
        $districts = $districts ? $districts : [];

        return response()->api(200, 'Districts: ', compact('districts'));
    }
}