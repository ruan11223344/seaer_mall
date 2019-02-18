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
            Route::post('get_user_info', 'Auth\AuthorizationsController@getUserInfo');
        });
        Route::post('get_access_token', 'Auth\AuthorizationsController@getAccessToken');
        Route::post('login', 'Auth\LoginController@login');

        Route::post('reset_password', 'Auth\PasswordController@resetPassword')->name('password.reset');
        Route::get('get_reset_password', 'Auth\PasswordController@getResetPasswordUrl')->name('password.reset.url');
        Route::get('get_reset_password_member_id', 'Auth\PasswordController@getResetPasswordMemberId')->name('password.reset.member_id');
        Route::post('send_reset_password_email','Auth\PasswordController@sendResetPasswordEmail')->name('password.reset.email');

        Route::post('send_register_email','Auth\RegisterController@sendRegisterEmail')->name('send_register_email');
        Route::post('check_register_status','Auth\RegisterController@checkRegisterStatus')->name('check_register_status');
        Route::post('register', 'Auth\RegisterController@register');

    });

    //消息系统
    Route::prefix('message')->group(function() {
        Route::group(['middleware' => ['client.credentials','auth:api']], function(){
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
            Route::post('confirm_delete_message', 'MessagesController@confirmDeleteMessage'); //永久软删除消息
            Route::get('email_notification_status', 'MessagesController@emailNotificationStatus'); //查看邮件通知设置
            Route::post('set_email_notification', 'MessagesController@setEmailNotification'); //设置邮件通知
        });
    });

    //相册
    Route::prefix('album')->group(function() {
        Route::group(['middleware' => ['client.credentials','auth:api']], function(){
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

    //商品模块
    Route::prefix('shop')->group(function() {
        //商品分类
        Route::prefix('category')->group(function (){
            Route::get('get_category', 'Shop\ProductsCategoriesController@getProductsCategories')->name('shop.get.category');
            Route::get('search_category', 'Shop\ProductsCategoriesController@searchProductsCategories')->name('shop.search.category');
            Route::get('get_category_child', 'Shop\ProductsCategoriesController@getCategoriesChild')->name('shop.search.category.child');
            Route::get('get_category_parent', 'Shop\ProductsCategoriesController@getCategoriesParent')->name('shop.search.category.parent');
            Route::get('get_category_root', 'Shop\ProductsCategoriesController@getCategoriesRoot')->name('shop.search.category.root');
        });
        //商品产品
        Route::prefix('product')->group(function (){
            Route::group(['middleware' => ['client.credentials','auth:api']], function(){
                Route::post('publish_product', 'Shop\ProductsController@publishProduct')->name('shop.product.publish');
                Route::get('check_publish_product_permissions', 'Shop\ProductsController@checkPublishProductPermissions')->name('shop.product.publish.permissions');//商品发布权限检查
                Route::post('upload_product_img', 'Shop\ProductsController@uploadProductImg')->name('shop.product.uploadImg');
                Route::get('get_product_list', 'Shop\ProductsController@getProductList')->name('shop.product.productList');

            });
        });
        //商品分组
        Route::prefix('product_group')->group(function (){
            Route::group(['middleware' => ['client.credentials','auth:api']], function(){
                Route::get('product_group_list', 'Shop\ProductsGroupsController@productsGroupsList')->name('shop.group.list');
                Route::post('edit_products_group', 'Shop\ProductsGroupsController@editProductsGroup')->name('shop.group.edit');
                Route::post('create_products_group', 'Shop\ProductsGroupsController@createProductsGroup')->name('shop.group.create');
                Route::post('delete_products_group', 'Shop\ProductsGroupsController@deleteProductsGroup')->name('shop.group.create');
            });
        });
    });

    Route::group(['prefix' => 'utils'],function() {
        Route::get('get_captcha','UtilsController@getCaptcha')->name('get_captcha');
        Route::post('check_captcha_url','UtilsController@checkCaptchaUrl')->name('check_captcha');
        Route::get('get_provinces_list','UtilsController@getProvincesList')->name('get_provinces_list');
        Route::get('get_city_list','UtilsController@getCityList')->name('get_city_list');
    });
});

