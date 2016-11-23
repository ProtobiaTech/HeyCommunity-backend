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
Route::group(['middleware' => [], 'prefix' => 'api'], function() {
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
Route::group(['middleware' => [], 'prefix' => 'dashboard'], function() {
    Route::controller('guide', 'Dashboard\GuideController');
    Route::controller('data', 'Dashboard\DataController');
    Route::controller('setting', 'Dashboard\SettingController');
    Route::controller('trend', 'Dashboard\TrendController');
    Route::controller('/', 'Dashboard\HomeController');
});
