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

Route::group(['domain' => env('MALL_DOMAIN'), 'middleware' => 'cors'], function () {
    Route::prefix('admin')->group(function (){
        Route::post('get_access_token', 'AdminController@getAccessToken')->middleware('passport-custom-provider');
    });
});
