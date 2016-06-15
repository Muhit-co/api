<?php

namespace Muhit\Services;

use DB;
use Illuminate\Support\Str;

class ToolService
{
    public function generateApiToken()
    {
        do {

            $apiToken = Str::random(100);

        } while (DB::table('users')->where('api_token', $apiToken)->count() > 0);

        return $apiToken;
    }
}