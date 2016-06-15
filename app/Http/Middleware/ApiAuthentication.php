<?php

namespace Muhit\Http\Middleware;

use Closure;
use Muhit\Models\User;
use Redis;
use ResponseService;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('user_id') || $request->has('api_token')) {

            return ResponseService::createErrorMessage('authParameterMissing');
        }

        $user_id = $request->get('user_id');
        $api_token = $request->get('api_token');
        $key = "auth:user:{$user_id}";

        if (!Redis::exists($key)) {

            $user = User::find($user_id);

            if (!$user || $user->api_token !== $api_token) {

                return ResponseService::createErrorMessage('authFailed');
            }
        }

        if (Redis::get($key) !== $api_token) {

            return ResponseService::createErrorMessage('authFailed');
        }

        return $next($request);
    }
}
