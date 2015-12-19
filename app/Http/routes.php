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
    return view('welcome');
});

Route::resource('timeline', 'TimelineController');
Route::resource('activity', 'ActivityController');


//
// Admin dashboard
// ----------------------------
Route::group(['prefix' => 'admin',], function() {
    Route::get('/', ['as' => 'admin.home', 'uses' => 'Admin\HomeController@index']);

    Route::resource('timeline', 'Admin\TimelineController');
    Route::resource('activity', 'Admin\ActivityController');
});

