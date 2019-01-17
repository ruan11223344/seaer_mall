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


Route::group(['domain'=>env('MALL_DOMAIN')],function () {
    Route::prefix('auth')->group(function() {
        Route::group(['middleware' => ['client.credentials','auth:api']], function(){
            //需要认证的组
            Route::post('get_user_info', 'Auth\AuthorizationsController@getUserInfo');
        });

        Route::post('get_access_token', 'Auth\AuthorizationsController@getAccessToken');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('reset_password', 'Auth\PasswordController@resetPassword');
        Route::post('forget_password', 'Auth\PasswordController@forgetPassword');
        Route::post('send_register_email','Auth\RegisterController@sendRegisterEmail')->name('send_register_email');
        Route::post('check_register_status','Auth\RegisterController@checkRegisterStatus')->name('check_register_status');
        Route::post('register', 'Auth\RegisterController@register');

    });

    //消息系统
    Route::prefix('message')->group(function() {
        Route::group(['middleware' => ['client.credentials','auth:api']], function(){
            //需要认证的组
            Route::post('create_message', 'MessagesController@createMessage');
            Route::get('create_message', 'MessagesController@replyMessage');
            Route::get('create_message', 'MessagesController@deleteMessage');
            Route::get('create_message', 'MessagesController@emptyMessage');
            Route::get('create_message', 'MessagesController@getIndexList');
            Route::get('get_index_list', 'MessagesController@getIndexList');
        });
    });

    Route::group(['prefix' => 'utils'],function() {
            Route::get('get_captcha','UtilsController@getCaptcha')->name('get_captcha');
            Route::post('check_captcha_url','UtilsController@checkCaptchaUrl')->name('check_captcha');
            Route::get('get_provinces_list','UtilsController@getProvincesList')->name('get_provinces_list');
            Route::get('get_city_list','UtilsController@getCityList')->name('get_city_list');
    });
});

