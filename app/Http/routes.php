<?php


Route::get('/', 'IssuesController@getIssues');

#testing routes for dann;
Route::get('/issue', function () {
    return view('issues.show');
});

Route::get('/components', function () {
    return view('pages.components');
});

Route::get('/lang/{loc}', function ($loc) {
    Session::put('lang', $loc);
    return redirect()->back(); // ->with('success', 'Changed language to: '.$loc);
});

#end of testing routes for dann

# reports routing
Route::get('/report/district/{districtId}', 'ReportController@getReportDistrictById');
Route::get('/report/district/{districtId}/issues', 'ReportController@getReportDistrictIssues');

/*Route::get('/report', function () {
    return view('reports.show');
});*/

# email routing
Route::get('/emails', function () {
    return view('emails.index');
});
Route::get('/email/{page}', function ($page) {
    return view('emails.' . $page);
});

# 'manual' route for Kadıköy idea list
Route::get('/kadikoy', function () {
    return redirect('/?district=Kadıköy%2C+İstanbul&sort=map');
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
Route::get('/hosgeldin', function () {
    return view('auth.welcome');
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
    Route::controller('comments', 'CommentsController');
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
        return response()->api(200, "Welcome to the Muhit API. ");
    });

    Route::get('secure', [
        'before' => 'oauth',
        function () {
            return response()->api(500, "You have access to the secure calls");
        }
    ]);

    Route::controller('auth', 'AuthController');
    Route::controller('hoods', 'HoodsController');

    Route::get('tags/{q?}', 'TagController@index');
    Route::get('announcements/{hoodId}/{start?}/{take?}', 'AnnouncementController@getList');

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

    Route::get('profile/{user_id}', 'MemberController@getProfile');
    Route::get('supporters/{issue_id}/{start?}/{take?}', 'IssuesController@getSupporters');

    Route::group(['middleware' => 'oauth'], function () {
        Route::get('profile', 'MemberController@getMyProfile');
        Route::post('issues/add', 'IssuesController@postAdd');
        Route::post('issues/support/{id}', 'IssuesController@getSupport');
        Route::post('issues/unsupport/{id}', 'IssuesController@getUnSupport');
        Route::post('issues/comment/', 'IssuesController@postComment');
        Route::get('issues/delete/{id}', 'IssuesController@getDelete');
        Route::controller('members', 'MemberController');
        Route::get('support/{id}', 'IssuesController@getSupport');
        Route::get('unsupport/{id}', 'IssuesController@getUnSupport');

        Route::get('test', function () {
            return response()->api(200, 'passed', []);
        });
    });
});


# Temporary Workshop routes
# For Haritalama Workshop, Ekim 2018
Route::get('/anket/halic', function () {
    return view('workshop.halic');
});
Route::get('/anket/karakoy', function () {
    return view('workshop.karakoy');
});
Route::get('/anket/tophane', function () {
    return view('workshop.tophane');
});
Route::get('/anket/findikli', function () {
    return view('workshop.findikli');
});
