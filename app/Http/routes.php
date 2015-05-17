<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/', function () {
	return response()->api(200, "Welcome to the Muhit API. ");
});

Route::get('/secure', ['before' => 'oauth', function () {
	return response()->api(500, "You have access to the secure calls");
}]);

Route::controller('/auth', 'AuthController');

Route::group(['before' => ['oauth']], function () {

});