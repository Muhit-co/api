<?php
namespace Muhit\Http\Middleware;

use Closure;

class HttpsProtocol
{

    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('APP_ENV') === 'prod') {
            $request->setTrustedProxies([ $request->getClientIp() ]);
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
