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

    Route::controller('timeline', 'Api\TimelineController');
    Route::controller('activity', 'Api\ActivityController');
    Route::controller('topic',    'Api\TopicController');
    Route::controller('notice',   'Api\NoticeController');
    Route::controller('talk',     'Api\TalkController');
    Route::controller('system',   'Api\SystemController');

    Route::controller('wechat', 'Api\WeChatController');

    Route::controller('user', 'Api\UserController');
});
