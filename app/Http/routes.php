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
$apiRoutes = function() {
    Route::get('/', function() {
        return view('api.index');
    });
    Route::resource('timeline', 'Api\TimelineController');
    Route::resource('activity', 'Api\ActivityController');
    Route::resource('topic',    'Api\TopicController');
    Route::resource('talk',     'Api\TalkController');

    Route::controller('user', 'Api\UserController');
    Route::controller('tenant', 'Api\TenantController');
};

Route::group(['middleware' => ['addTenant', 'addHeader'], 'domain' => 'api.hey-community.local'], $apiRoutes);
Route::group(['middleware' => ['addTenant', 'addHeader'], 'domain' => 'api.hey-community.online'], $apiRoutes);





//
//
// ----------------------------
$routes = function() {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
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
};

Route::group(['domain' => 'hey-community.online'], $routes);
Route::group(['domain' => 'www.hey-community.online'], $routes);
Route::group(['domain' => 'dev.hey-community.local'], $routes);
