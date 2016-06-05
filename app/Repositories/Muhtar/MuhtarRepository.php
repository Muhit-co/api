<?php

namespace Muhit\Repositories\Muhtar;

use Muhit\Models\User;

class MuhtarRepository implements MuhtarRepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getMuhtar()
    {
        $hoodId = \Auth::user()->hood_id;

        if ($hoodId) {

            // updated from 4 to 5
            $muhtar = $this->user->where('level', 5)->where('hood_id', $hoodId)->first();

            return $muhtar;
        }

        return $hoodId;
    }
}