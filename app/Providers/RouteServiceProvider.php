<?php namespace Muhit\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Request;
use Auth;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Muhit\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router) {
		parent::boot($router);

		Route::filter('admin', function () {
			if (Auth::guest()) {
				if (Request::ajax()) {
					return Response::make('Unauthorized', 401);
				} else {
					return redirect('/login');
				}
			}

			if (Auth::user()->level !== 10) {
				return redirect('/');
			}
		});

		Route::filter('muhtar', function () {
			if (Auth::guest()) {
				if (Request::ajax()) {
					return Response::make('Unauthorized', 401);
				} else {
					return redirect('/login');
				}
			}

			if (Auth::user()->level !== 5) {
				return redirect('/');
			}
		});
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router) {
		$router->group(['namespace' => $this->namespace], function ($router) {
			require app_path('Http/routes.php');
		});
	}

}
