<?php

namespace Muhit\Repositories\Hood;


interface HoodRepositoryInterface
{
    public function get($hoodId);

    public function all($query, $cityId, $districtId);

    public function hoods($query, $cityId, $districtId);

    public function cities($query);

    public function districts($city_id = null, $query = null);
}