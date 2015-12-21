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

Route::group(['middleware' => 'addTenant'], function() {
    Route::resource('timeline', 'TimelineController');
    Route::resource('activity', 'ActivityController');
});


//
// Admin dashboard
// ----------------------------
Route::get('admin', ['as' => 'admin.home', 'uses' => 'Admin\HomeController@index']);
Route::get('admin/login', ['as' => 'admin.auth.login', 'uses' => 'Admin\AuthController@getLogin']);
Route::post('/login', ['as' => 'admin.auth.loginHandle', 'uses' => 'Admin\AuthController@postLogin']);
Route::any('/logout', ['as' => 'admin.auth.logout', 'uses' => 'Admin\AuthController@anyLogout']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin'],], function() {
    Route::resource('timeline', 'Admin\TimelineController');
    Route::resource('activity', 'Admin\ActivityController');
});

