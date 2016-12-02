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


//
// Api
// ----------------------------
Route::group(['middleware' => ['tenantDataFilter'], 'prefix' => 'api'], function() {
    Route::get('/', function() {
        return view('api.index');
    });

    Route::controller('user', 'Api\UserController');
    Route::controller('timeline', 'Api\TimelineController');
    Route::controller('topic', 'Api\TopicController');
    Route::controller('notice', 'Api\NoticeController');
    Route::controller('wechat', 'Api\WeChatController');
    Route::controller('system', 'Api\SystemController');
});



//
// Dashboard
// ----------------------------
Route::get('/dashboard/log-in', 'Dashboard\HomeController@getLogIn');
Route::post('/dashboard/log-in', 'Dashboard\HomeController@postLogIn');
Route::get('/dashboard/log-out', 'Dashboard\HomeController@getLogOut');
Route::group(['middleware' => ['auth.tenant'], 'prefix' => 'dashboard'], function() {
    Route::controller('guide', 'Dashboard\GuideController');
    Route::controller('timeline', 'Dashboard\TimelineController');
    Route::controller('user', 'Dashboard\UserController');
    Route::controller('topic', 'Dashboard\TopicController');
    Route::controller('setting', 'Dashboard\SettingController');
    Route::controller('trend', 'Dashboard\TrendController');
    Route::controller('/', 'Dashboard\HomeController');
});



//
// Admin
// ----------------------------
Route::get('/admin/log-in', 'Admin\HomeController@getLogIn');
Route::post('/admin/log-in', 'Admin\HomeController@postLogIn');
Route::get('/admin/log-out', 'Admin\HomeController@getLogOut');
Route::group(['middleware' => ['auth.admin'], 'prefix' => 'admin'], function() {
    Route::controller('timeline', 'Admin\TimelineController');
    Route::controller('user', 'Admin\UserController');
    Route::controller('topic', 'Admin\TopicController');
    Route::controller('trend', 'Admin\TrendController');
    Route::controller('/', 'Admin\HomeController');
});



//
// Home
// ----------------------------
Route::resource('blog', 'OfficialBlogController');
Route::controller('/', 'HomeController');
