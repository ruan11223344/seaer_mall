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
    Route::prefix('auth')->group(function () {
        Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
            Route::post('get_user_info', 'Auth\AuthorizationsController@getUserInfo');
            Route::post('change_password', 'Auth\PasswordController@changePassword');
            Route::post('upload_avatar_img', 'Auth\AuthorizationsController@uploadAvatarImg');
            Route::get('get_avatar', 'Auth\AuthorizationsController@getAvatar');
            Route::get('get_account_info', 'Auth\AuthorizationsController@getAccountInfo');
            Route::post('set_account_info', 'Auth\AuthorizationsController@setAccountInfo');
            Route::get('get_company_info', 'Auth\AuthorizationsController@getCompanyInfo');
            Route::post('set_company_info', 'Auth\AuthorizationsController@setCompanyInfo');
        });
        Route::post('get_access_token', 'Auth\AuthorizationsController@getAccessToken');
        Route::post('login', 'Auth\LoginController@login');

        Route::post('reset_password', 'Auth\PasswordController@resetPassword')->name('password.reset');
        Route::get('get_reset_password', 'Auth\PasswordController@getResetPasswordUrl')->name('password.reset.url');
        Route::get('get_reset_password_member_id', 'Auth\PasswordController@getResetPasswordMemberId')->name('password.reset.member_id');
        Route::post('send_reset_password_email', 'Auth\PasswordController@sendResetPasswordEmail')->name('password.reset.email');

        Route::post('send_register_email', 'Auth\RegisterController@sendRegisterEmail')->name('send_register_email');
        Route::post('check_register_status', 'Auth\RegisterController@checkRegisterStatus')->name('check_register_status');
        Route::post('register', 'Auth\RegisterController@register');

    });

    //消息系统
    Route::prefix('message')->group(function () {
        Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
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
    Route::prefix('album')->group(function () {
        Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
            Route::post('create_album', 'AlbumController@createAlbum');
            Route::post('delete_album', 'AlbumController@deleteAlbum');
            Route::post('edit_album', 'AlbumController@editAlbum');
            Route::post('upload_img_to_album', 'AlbumController@uploadImgToAlbum');
            Route::post('save_img_to_album', 'AlbumController@saveImgToAlbum');
            Route::get('album_photo_list', 'AlbumController@albumPhotoList');
            Route::post('modify_photos', 'AlbumController@modifyPhotos');
            Route::get('album_list', 'AlbumController@albumList');
            Route::post('replace_img_to_album', 'AlbumController@replaceImgToAlbum');
        });
        Route::get('get_img_info', 'AlbumController@getImgInfo');
    });

    //收藏
    Route::prefix('favorites')->group(function () {
        Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
            Route::post('set_favorites', 'FavoritesController@setFavorites')->name('favorites.set');
            Route::get('get_favorites', 'FavoritesController@getFavorites')->name('favorites.get');
            Route::post('delete_favorites', 'FavoritesController@deleteFavorites')->name('favorites.delete');
        });
    });

    //商品模块
    Route::prefix('shop')->group(function () {
        Route::get('shop_search', 'Shop\ShopController@shopSearch')->name('shop.shopSearch');
        Route::get('get_company_detail', 'Shop\ShopController@getCompanyDetail')->name('shop.getCompanyDetail');

        //店铺管理
        Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
            Route::post('upload_slide', 'Shop\ShopController@uploadSlide')->name('shop.uploadSlide');
            Route::post('set_slides', 'Shop\ShopController@setSlides')->name('shop.setSlide');
            Route::get('get_slides_list', 'Shop\ShopController@getSlidesList')->name('shop.getSlidesList');
            Route::get('get_shop_banner', 'Shop\ShopController@getShopBanner')->name('shop.getShopBanner');
            Route::post('set_shop_banner', 'Shop\ShopController@setShopBanner')->name('shop.setShopBanner');
            Route::post('delete_shop_banner', 'Shop\ShopController@deleteShopBanner')->name('shop.deleteShopBanner');
            Route::get('get_recommend_product_list', 'Shop\ShopController@getRecommendProductList')->name('shop.getRecommendProductList');
            Route::post('set_recommend_product_list', 'Shop\ShopController@setRecommendProductList')->name('shop.setRecommendProductList');
            Route::get('search_recommend_product', 'Shop\ShopController@searchRecommendProduct')->name('shop.searchRecommendProduct');
        });

        //商品分类
        Route::prefix('category')->group(function () {
            Route::get('get_category', 'Shop\ProductsCategoriesController@getProductsCategories')->name('shop.get.category');
            Route::get('search_category', 'Shop\ProductsCategoriesController@searchProductsCategories')->name('shop.search.category');
            Route::get('get_category_child', 'Shop\ProductsCategoriesController@getCategoriesChild')->name('shop.search.category.child');
            Route::get('get_category_parent', 'Shop\ProductsCategoriesController@getCategoriesParent')->name('shop.search.category.parent');
            Route::get('get_category_root', 'Shop\ProductsCategoriesController@getCategoriesRoot')->name('shop.search.category.root');
            Route::get('get_category_product', 'Shop\ProductsCategoriesController@getCategoriesProduct')->name('shop.category.product');
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::get('get_last_products_categories', 'Shop\ProductsCategoriesController@getLastProductsCategories')->name('shop.category.last.product');
            });
        });
        //商品产品
        Route::prefix('product')->group(function () {
            Route::get('get_product_detail', 'Shop\ProductsController@getProductDetail')->name('shop.product.productDetail');
            Route::get('product_search', 'Shop\ProductsController@productSearch')->name('shop.product.productSearch');

            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::post('publish_product', 'Shop\ProductsController@publishProduct')->name('shop.product.publish');
                Route::get('check_publish_product_permissions', 'Shop\ProductsController@checkPublishProductPermissions')->name('shop.product.publish.permissions'); //商品发布权限检查
                Route::post('upload_product_img', 'Shop\ProductsController@uploadProductImg')->name('shop.product.uploadImg');
                Route::get('get_product_list', 'Shop\ProductsController@getProductList')->name('shop.product.productList');
                Route::post('delete_product', 'Shop\ProductsController@deleteProduct')->name('shop.product.delete');
                Route::post('edit_product', 'Shop\ProductsController@editProduct')->name('shop.product.edit');
                Route::post('change_products_warehouse', 'Shop\ProductsController@changeProductsWarehouse')->name('shop.product.change.warehouse');
            });
        });
        //商品分组
        Route::prefix('product_group')->group(function () {
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::get('product_group_list', 'Shop\ProductsGroupsController@productsGroupsList')->name('shop.group.list');
                Route::post('edit_products_group', 'Shop\ProductsGroupsController@editProductsGroup')->name('shop.group.edit');
                Route::post('create_products_group', 'Shop\ProductsGroupsController@createProductsGroup')->name('shop.group.create');
                Route::post('delete_products_group', 'Shop\ProductsGroupsController@deleteProductsGroup')->name('shop.group.create');
            });
        });
    });

    Route::group(['prefix' => 'utils'], function () {
        Route::get('get_captcha', 'UtilsController@getCaptcha')->name('get_captcha');
        Route::post('check_captcha_url', 'UtilsController@checkCaptchaUrl')->name('check_captcha');
        Route::get('get_provinces_list', 'UtilsController@getProvincesList')->name('get_provinces_list');
        Route::get('get_city_list', 'UtilsController@getCityList')->name('get_city_list');
        Route::post('currency_converter', 'UtilsController@currencyConverter');

        Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
            Route::post('upload_business_license', 'UtilsController@uploadBusinessLicense');
        });

    });

    Route::get('get_sys_config', 'SystemController@sysConfig');
});
