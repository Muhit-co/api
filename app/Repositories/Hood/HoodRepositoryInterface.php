<?php

namespace Muhit\Repositories\Hood;


interface HoodRepositoryInterface
{
    public function get($hoodId);

    public function all($query, $cityId, $districtId);
}