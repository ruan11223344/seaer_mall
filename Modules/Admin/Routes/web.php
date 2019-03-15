<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['domain' => env('ADMIN_DOMAIN'), 'middleware' => 'cors'],function () {
    Route::get('/{any}', 'AdminController@index')->where('any', '.*');
});
