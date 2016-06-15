<?php


Route::get('/', 'IssuesController@getIssues');

#testing routes for dann;
Route::get('/issue', function () {
    return view('issues.show');
});

Route::get('/components', function () {
    return view('pages.components');
});

Route::get('/user/{username}', function () {
    return view('pages.profile');
});

#end of testing routes for dann

# reports routing
Route::get('report', 'IssuesController@getList');
Route::get('/report', function () {
    return view('reports.show');
});

# email routing
Route::get('/emails', function () {
    return view('emails.index');
});
Route::get('/email/{page}', function ($page) {
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
Route::get('login/facebook', 'AuthController@getFacebookLogin');
Route::get('login/facebook/return', 'AuthController@getFacebookLoginReturn');
Route::get('confirm/{id}/{code}', 'AuthController@getConfirm');
Route::controller('auth', 'AuthController');
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::get('/register-muhtar', function () {

    return view('auth.register-muhtar');
});
Route::get('/forgot-password', function () {

    return view('auth.forgot-password');
});
Route::get('/reset-password', function () {

    return view('auth.reset-password');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('issues/new', 'IssuesController@getNew');
    Route::controller('members', 'MemberController');
    Route::get('profile', 'MemberController@getMyProfile');
    Route::get('support/{id}', 'IssuesController@getSupport');
    Route::get('unsupport/{id}', 'IssuesController@getUnSupport');

    Route::get('duyurular', 'AnnouncementController@index');
    Route::post('duyuru/ekle', 'AnnouncementController@create');
    Route::post('duyuru/duzenle/{id}', 'AnnouncementController@edit');
    Route::get('duyuru/sil/{id}', 'AnnouncementController@delete');
    Route::get('/muhtar', 'MuhtarController@index');
});

# Admin routes
Route::group(['middleware' => 'auth', 'before' => 'admin'], function () {

    Route::controller('admin', 'AdminController');
});

# Muhtar routes
Route::group(['middleware' => 'auth', 'before' => 'muhtar'], function () {

    Route::controller('muhtar', 'MuhtarController');
});

Route::get('profile/{id}', 'MemberController@getProfile');

#issue routing
Route::controller('issues', 'IssuesController');
Route::get('issues', 'IssuesController@getIssues');

Route::get('supporters/{issue_id}/{start?}/{take?}', 'IssuesController@getSupporters');

Route::get('popular', 'IssuesController@getPopular');
Route::get('map', 'IssuesController@getMap');

Route::group(['prefix' => 'api'], function () {

    Route::get('/', function () {
        return response()->json([
            'register',
            'login',
            'tags',
            'issues/list/{start?}/{take?}',
            'issues/view/{id}',
            'issues/create',
            'issues/delete/{userId}/{issueId}',
            'hoods/{cityId?}/{districtId?}/{query?}',
            'cities/{query?}',
            'districts/{cityId?}/{query?}',
        ]);
    });

    Route::get('secure', [
        'before' => 'oauth',
        function () {
            return response()->api(500, "You have access to the secure calls");
        }
    ]);

    Route::get('register', 'Api\UserController@register');
    Route::post('login', 'Api\UserController@login');
    Route::get('tags/{q?}', 'TagController@index');
    Route::get('issues/list/{start?}/{take?}', 'Api\IssueController@issues');
    Route::get('issues/view/{id}', 'Api\IssueController@issue');
    Route::get('issues/create', 'Api\IssueController@create');
    Route::post('issues/delete/{userId}/{issueId}', 'Api\IssueController@delete');
    Route::get('hoods/{cityId?}/{districtId?}/{query?}', 'Api\LocationController@hoods');
    Route::get('cities/{query?}', 'Api\LocationController@cities');
    Route::get('districts/{cityId?}/{query?}', 'Api\LocationController@districts');

    // forget password
    // my created issues
    // my supported issues
    // edit profile

    Route::post('issues/support/{id}', 'IssuesController@getSupport');
    Route::post('issues/unsupport/{id}', 'IssuesController@getUnSupport');
    Route::get('supporters/{issue_id}/{start?}/{take?}', 'IssuesController@getSupporters');
    Route::get('profile/{user_id}', 'MemberController@getProfile');
    Route::get('announcements/{hoodId}/{start?}/{take?}', 'AnnouncementController@getList');
    Route::get('issues/popular/{start?}/{take?}', 'IssuesController@getPopular');
    Route::get('issues/latest/{start?}/{take?}', 'IssuesController@getLatest');


    Route::group(['middleware' => 'oauth'], function () {

        Route::get('test', function () {
            return response()->api(200, 'passed', []);
        });
    });

});
