<?php namespace Muhit\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Routing\Middleware;
use Session;

class Language implements Middleware
{

    public function __construct(Application $app, Redirector $redirector, Request $request)
    {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->request->has('lang')) {
            $lang = $this->request->get('lang');
            Session::put('lang', $lang);
        } else {
            $lang = Session::get('lang');
        }

        $this->app->setLocale($lang);
        return $next($request);
    }
}
