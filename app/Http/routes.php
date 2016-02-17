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
Route::group(['middleware' => ['addTenant'], 'prefix' => 'api'], function() {
    Route::get('/', function() {
        return view('api.index');
    });
    Route::controller('timeline', 'Api\TimelineController');
    Route::controller('activity', 'Api\ActivityController');
    Route::resource('topic',    'Api\TopicController');
    Route::resource('talk',     'Api\TalkController');

    Route::controller('user', 'Api\UserController');
    Route::controller('tenant', 'Api\TenantController');
});



//
// Base and Admin
// ----------------------------
Route::group([], function() {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('create-tenant', ['as' => 'home.create-tenant', 'uses' => 'HomeController@createTenant']);
    Route::post('store-tenant', ['as' => 'home.store-tenant', 'uses' => 'HomeController@storeTenant']);

    Route::controller('system', 'SystemController');

    // Admin dashboard
    // ----------------------------
    Route::get('admin', ['as' => 'admin.home', 'uses' => 'Admin\HomeController@index']);
    Route::get('admin/login', ['as' => 'admin.auth.login', 'uses' => 'Admin\AuthController@getLogin']);
    Route::post('/login', ['as' => 'admin.auth.loginHandle', 'uses' => 'Admin\AuthController@postLogin']);
    Route::any('/logout', ['as' => 'admin.auth.logout', 'uses' => 'Admin\AuthController@anyLogout']);

    Route::group(['prefix' => 'admin', 'middleware' => ['auth.tenant', 'addTenantWithAdmin']], function() {
        Route::resource('timeline', 'Admin\TimelineController');
        Route::resource('activity', 'Admin\ActivityController');
    });
});
