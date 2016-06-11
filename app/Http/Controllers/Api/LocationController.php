<?php

namespace Muhit\Http\Controllers\Api;

use Muhit\Http\Controllers\Controller;
use Muhit\Repositories\Hood\HoodRepositoryInterface;

class LocationController extends Controller
{

    private $hoodRepository;

    public function __construct(HoodRepositoryInterface $hoodRepository)
    {
        $this->hoodRepository = $hoodRepository;
    }

    public function cities($query = null)
    {
        return $this->hoodRepository->cities($query);
    }

    public function hoods($cityId = null, $districtId = null, $query = null)
    {
        return $this->hoodRepository->hoods($query, $cityId, $districtId);
    }

    public function districts($city_id = null, $query = null)
    {
        return $this->hoodRepository->districts($city_id, $query);
    }
}