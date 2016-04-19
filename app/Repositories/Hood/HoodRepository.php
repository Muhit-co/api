<?php

namespace Muhit\Repositories\Hood;


use Muhit\Models\Hood;

class HoodRepository implements HoodRepositoryInterface
{
    private $hood;

    public function __construct(Hood $hood)
    {
        $this->hood = $hood;
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
}