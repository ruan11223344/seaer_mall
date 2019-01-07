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

Route::prefix('ec')->group(function() {
    Route::get('/', 'EcController@index');
});

//无路由前缀也支持
Route::get('/test', function () {
    return view('ec::index');
});