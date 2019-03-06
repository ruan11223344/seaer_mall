<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['domain' => env('ADMIN_DOMAIN'), 'middleware' => 'cors'], function () {
    Route::prefix('admin')->group(function (){
        Route::prefix('auth')->group(function (){
            Route::get('get_access_token', 'AuthController@getAccessToken')->middleware('passport-custom-provider');
            Route::post('logout', 'AuthController@logout')->middleware('passport-custom-provider');
        });
    });
    Route::prefix('utils')->group(function (){
        Route::get('get_captcha', 'UtilsController@getCaptcha')->name('admin.get.captcha');
    });
});
