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

Route::get('/', 'IssuesController@getIssues');

#testing routes for dann;
Route::get('/issue', function() {
    return view('issues.show');
});

Route::get('/components', function() {
    return view('pages.components');
});

Route::get('/user/{username}', function() {
    return view('pages.profile');
});

Route::get('/announcements', function() {
    return view('announcements.list');
});
Route::get('/muhtar', function() {
    return view('pages.muhtar');
});
#end of testing routes for dann

# reports routing
Route::get('report', 'IssuesController@getList');
Route::get('/report', function() {
    return view('reports.show');
});


# email routing
Route::get('/emails', function() {
    return view('emails.index');
});
Route::get('/email/{page}', function($page) {
    return view('emails.' . $page);
});


#issues
Route::get('fikirler/{hood_id?}', 'IssuesController@getIssues');
Route::post('fikirler/{hood_id?}', 'IssuesController@getIssues');

# auth routing
Route::get('login', 'AuthController@getLogin');
Route::get('register', 'AuthController@getRegister');
Route::post('login', 'AuthController@postLogin');
Route::post('register', 'AuthController@postRegister');
Route::get('logout', function(){
    Auth::logout();
    return redirect('/');
});

Route::get('/register-muhtar', function() {
    return view('auth.register-muhtar');
});
Route::get('/forgot-password', function() {
    return view('auth.forgot-password');
});
Route::get('/reset-password', function() {
    return view('auth.reset-password');
});


Route::group(['middleware' => 'auth'], function(){
    Route::get('issues/new', 'IssuesController@getNew');
    Route::controller('members', 'MembersController');
    Route::get('profile', 'MembersController@getMyProfile');
    Route::get('support/{id}', 'IssuesController@getSupport');
    Route::get('unsupport/{id}', 'IssuesController@getUnSupport');

});

Route::get('profile/{id}', 'MembersController@getProfile');

#issue routing
Route::controller('issues', 'IssuesController');
Route::get('issues', 'IssuesController@getIssues');

Route::get('supporters/{issue_id}/{start?}/{take?}', 'IssuesController@getSupporters');

Route::get('popular', 'IssuesController@getPopular');
Route::get('map', 'IssuesController@getMap');

Route::group(['prefix' => 'api'], function () {
    Route::get('/', function () {
        return response()->api(200, "Welcome to the Muhit API. ");
    });

    Route::get('secure', ['before' => 'oauth', function () {
        return response()->api(500, "You have access to the secure calls");
    }]);

    Route::controller('auth', 'AuthController');
    Route::controller('hoods', 'HoodsController');

    Route::get('tags/{q?}', 'TagsController@getList');
    Route::get('announcements/{hood_id}/{start?}/{take?}', 'AnnouncementsController@getList');

    Route::get('issues/view/{id}', 'IssuesController@getView');
    Route::get('issues/list/{start?}/{take?}', 'IssuesController@getList');
    Route::post('issues/search', 'IssuesController@postSearch');
    Route::get('issues/popular/{start?}/{take?}', 'IssuesController@getPopular');
    Route::get('issues/latest/{start?}/{take?}', 'IssuesController@getLatest');
    Route::get('issues/by-tag/{tag_id}/{start?}/{take?}', 'IssuesController@getByTag');
    Route::get('issues/by-hood/{hood_id}/{start?}/{take?}', 'IssuesController@getByHood');
    Route::get('issues/by-district/{district_id}/{start?}/{take?}', 'IssuesController@getByDistrict');
    Route::get('issues/by-city/{city_id}/{start?}/{take?}', 'IssuesController@getByCity');
    Route::get('issues/by-user/{user_id}/{start?}/{take?}', 'IssuesController@getByUser');
    Route::get('issues/by-status/{status}/{start?}/{take?}', 'IssuesController@getByStatus');
    Route::get('issues/by-supporter/{user_id}/{start?}/{take?}', 'IssuesController@getBySupporter');

    Route::get('profile/{user_id}', 'MembersController@getProfile');
    Route::get('supporters/{issue_id}/{start?}/{take?}', 'IssuesController@getSupporters');

    Route::group(['middleware' => 'oauth'], function () {
        Route::get('profile', 'MembersController@getMyProfile');
        Route::post('issues/add', 'IssuesController@postAdd');
        Route::post('issues/support/{id}', 'IssuesController@getSupport');
        Route::post('issues/unsupport/{id}', 'IssuesController@getUnSupport');
        Route::post('issues/comment/', 'IssuesController@postComment');
        Route::get('issues/delete/{id}', 'IssuesController@getDelete');
        Route::controller('members', 'MembersController');
        Route::get('support/{id}', 'IssuesController@getSupport');
        Route::get('unsupport/{id}', 'IssuesController@getUnSupport');

        Route::get('test', function(){
            return response()->api(200, 'passed', []);
        });
    });

});
