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

    public function getHood($hoodId)
    {
        return $this->hood->with('district.city')->find($hoodId);
    }
}