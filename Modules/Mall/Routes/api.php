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


Route::group(['domain'=>env('MALL_DOMAIN'),'middleware' => 'cors'],function () {
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
            Route::post('reply_message', 'MessagesController@replyMessage');
            Route::get('delete_message', 'MessagesController@deleteMessage');
            Route::get('inbox_message', 'MessagesController@inboxMessage');
            Route::get('outbox_message', 'MessagesController@outboxMessage');
            Route::get('spam_message', 'MessagesController@spamMessage');
            Route::get('flag_message', 'MessagesController@flagMessage');

            Route::get('message_info', 'MessagesController@getMessageInfo');

            Route::post('mark_spam_message', 'MessagesController@markSpamMessage');
            Route::post('mark_flag_message', 'MessagesController@markFlagMessage');
            Route::post('mark_delete_message', 'MessagesController@markDeleteMessage');
            Route::post('mark_read_message', 'MessagesController@markReadMessage');
            Route::post('empty_message', 'MessagesController@emptyMessage'); //清空消息
        });
    });

    //相册
    Route::prefix('album')->group(function() {
        Route::group(['middleware' => ['client.credentials','auth:api']], function(){
            //需要认证的组
            Route::post('create_album', 'AlbumController@createAlbum');
            Route::post('delete_album', 'AlbumController@deleteAlbum');
            Route::post('edit_album', 'AlbumController@editAlbum');
            Route::post('upload_img_to_album', 'AlbumController@uploadImgToAlbum');
            Route::post('save_img_to_album', 'AlbumController@saveImgToAlbum');
            Route::get('album_photo_list', 'AlbumController@albumPhotoList');
            Route::post('modify_photos', 'AlbumController@modifyPhotos');
            Route::get('album_list', 'AlbumController@albumList');
        });
    });


    //商品
    Route::prefix('shop')->group(function() {
            Route::get('get_category', 'Shop\ProductsCategoriesController@getProductsCategories')->name('shop.get.category');
    });


    Route::group(['prefix' => 'utils'],function() {
            Route::get('get_captcha','UtilsController@getCaptcha')->name('get_captcha');
            Route::post('check_captcha_url','UtilsController@checkCaptchaUrl')->name('check_captcha');
            Route::get('get_provinces_list','UtilsController@getProvincesList')->name('get_provinces_list');
            Route::get('get_city_list','UtilsController@getCityList')->name('get_city_list');
    });
});

