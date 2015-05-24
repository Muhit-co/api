<?php namespace Muhit\Providers;

use Illuminate\Support\ServiceProvider;
use Request;
use Response;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Response::macro("api", function ($code = 200, $msg = "", $data = []) {
			return response()->json([
				"info" => [
					"request_time" => date("r"),
					"request_uri" => Request::path(),
					"request_url" => Request::url(),
					"api_version" => "0.1",
					"response_time" => 0,
				],
				"msg" => $msg,
				"data" => $data,
			])
			->setStatusCode($code)
			->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization')
			->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, DELETE, PUT')
			->header('Access-Control-Allow-Origin', '*');
		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'Muhit\Services\Registrar'
		);
	}

}
