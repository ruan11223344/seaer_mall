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


Route::get('/{any}', 'HomeController@index')->where('any', '.*');
//Route::get('/', 'HomeController@index')->name('home');

/*Route::prefix('auth')->group(function() {
    Route::get('/',function (){
        return redirect('/');
    });
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.show.login');
    Route::post('login', 'Auth\LoginController@login')->name('auth.login');
    Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');
    Route::get('register', 'Auth\RegisterController@showRegisterForm')->name('auth.show.register');
    Route::post('register', 'Auth\RegisterController@register')->name('auth.register');
    Route::get('reset-password', 'Auth\ResetPasswordController@showResetPasswordForm')->name('auth.show.logout');
    Route::post('reset-password', 'Auth\ResetPasswordController@resetPassword')->name('auth.logout');

});*/

/*
 包含路由前缀
Route::prefix('ec')->group(function() {
    Route::get('/', 'EcController@index');
});

无路由前缀
Route::get('/test', function () {
    return view('ec::index');
});
*/