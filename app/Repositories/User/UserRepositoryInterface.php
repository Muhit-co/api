<?php

namespace Muhit\Repositories\User;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function register(Request $request);
}