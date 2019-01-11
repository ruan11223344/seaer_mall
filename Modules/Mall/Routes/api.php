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

/*Route::middleware('auth:api')->get('/ec', function (Request $request) {
    return $request->user();
});*/

Route::group(['domain'=>env('HOME_DOMAIN')],function () {
    Route::prefix('auth')->group(function() {
        Route::group(['middleware' => ['client.credentials','auth:api']], function(){
            Route::post('get_user_info', 'Auth\AuthorizationsController@getUserInfo');
        }); //需要认证的组
        Route::post('get_access_token', 'Auth\AuthorizationsController@getAccessToken');

        Route::post('/register', 'Auth\RegisterController@register')->name('register');
        Route::post('/login', 'Auth\LoginController@login')->name('login');
        Route::post('/reset_password', 'Auth\PasswordController@resetPassword')->name('reset');
        Route::post('/forget_password', 'Auth\PasswordController@forgetPassword')->name('forget');
    });
});