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

Route::get('/', 'IssuesController@getList');

#testing routes for dann;
Route::get('/issue', function() {
    return view('issues.show');
});
Route::get('/issue/new', function() {
    return view('issues.new');
});
Route::get('/components', function() {
    return view('pages.components');
});
#end of testing routes for dann

Route::get('login', 'AuthController@getLogin');
Route::get('register', 'AuthController@getRegister');
Route::post('login', 'AuthController@postLogin');
Route::post('register', 'AuthController@postRegister');
Route::get('logout', function(){
    Auth::logout();
    return redirect('/');
});

#issue routing
Route::controller('issues', 'IssuesController');

Route::group(['prefix' => 'api'], function () {
    Route::get('/', function () {
        return response()->api(200, "Welcome to the Muhit API. ");
    });

    Route::get('/secure', ['before' => 'oauth', function () {
        return response()->api(500, "You have access to the secure calls");
    }]);

    Route::controller('/auth', 'AuthController');
    Route::controller('/hoods', 'HoodsController');

    Route::get('tags/{q?}', 'TagsController@getList');
    Route::get('announcements/{hood_id}/{start?}/{take?}', 'AnnouncementsController@getList');

    Route::get('/issues/view/{id}', 'IssuesController@getView');
    Route::get('/issues/list/{start?}/{take?}', 'IssuesController@getList');
    Route::post('/issues/search', 'IssuesController@postSearch');
    Route::get('/issues/popular/{start?}/{take?}', 'IssuesController@getPopular');
    Route::get('/issues/latest/{start?}/{take?}', 'IssuesController@getLatest');
    Route::get('/issues/by-tag/{tag_id}/{start?}/{take?}', 'IssuesController@getByTag');
    Route::get('/issues/by-hood/{hood_id}/{start?}/{take?}', 'IssuesController@getByHood');
    Route::get('/issues/by-district/{district_id}/{start?}/{take?}', 'IssuesController@getByDistrict');
    Route::get('/issues/by-city/{city_id}/{start?}/{take?}', 'IssuesController@getByCity');
    Route::get('/issues/by-user/{user_id}/{start?}/{take?}', 'IssuesController@getByUser');
    Route::get('/issues/by-status/{status}/{start?}/{take?}', 'IssuesController@getByStatus');
    Route::get('/issues/by-supporter/{user_id}/{start?}/{take?}', 'IssuesController@getBySupporter');

    Route::get('/profile/{user_id?}', 'MembersController@getProfile');

    Route::group(['before' => 'oauth'], function () {
        Route::post('/issues/add', 'IssuesController@postAdd');
        Route::post('/issues/support/{id}', 'IssuesController@getSupport');
        Route::post('/issues/unsupport/{id}', 'IssuesController@getUnSupport');
        Route::post('/issues/comment/', 'IssuesController@postComment');
        Route::controller('/members', 'MembersController');
    });

});
