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
            Route::post('get_access_token', 'AuthController@getAccessToken')->middleware('passport-custom-provider');
            Route::group(['middleware' => ['client.credentials', 'auth:api','passport-custom-provider']], function () {
                Route::post('logout', 'AuthController@logout');
                Route::post('add_admin', 'AuthController@addAdmin');
            });
        });
        Route::prefix('user_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api','passport-custom-provider']], function () {
                Route::get('get_user_list', 'UserManagerController@getUserList')->name('admin.user.list');
                Route::get('search_user_list', 'UserManagerController@searchUserList')->name('admin.user.search');
                Route::post('set_inquiry', 'UserManagerController@setInquiry')->name('admin.user.setInquiry');
                Route::get('get_merchant_list', 'UserManagerController@getMerchantsList')->name('admin.user.merchants.list');
                Route::get('search_merchant_list', 'UserManagerController@searchMerchantsList')->name('admin.user.merchants.search');
                Route::get('get_admin_list', 'UserManagerController@getAdminList')->name('admin.user.admin.list');
                Route::get('get_admin_info', 'UserManagerController@getAdminInfo')->name('admin.user.admin.info');
                Route::post('edit_admin', 'UserManagerController@editAdmin')->name('admin.user.admin.edit');
                Route::post('delete_admin', 'UserManagerController@deleteAdmin')->name('admin.user.admin.delete');
            });
        });
        Route::prefix('role_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api','passport-custom-provider']], function () {
                Route::post('add_role', 'RoleController@addRole')->name('admin.role.add');
                Route::post('edit_role', 'RoleController@editRole')->name('admin.role.edit');
                Route::post('delete_role', 'RoleController@deleteRole')->name('admin.role.delete');
                Route::get('get_role_list', 'RoleController@getRoleList')->name('admin.role.list');
                Route::get('get_role_permissions', 'RoleController@getRolePermissions')->name('admin.role.permissions');
            });
        });
        Route::prefix('product_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api','passport-custom-provider']], function () {
                Route::get('get_product_list', 'ProductManagerController@getProductList')->name('admin.product.list');
                Route::get('get_product_audit_list', 'ProductManagerController@getAuditProductList')->name('admin.product.auditList');
                Route::get('get_product_info', 'ProductManagerController@getProductInfo')->name('admin.product.info');
                Route::post('product_audit', 'ProductManagerController@auditProduct')->name('admin.product.audit');
                Route::post('product_off_shelf', 'ProductManagerController@productOffShelf')->name('admin.product.offShelf');
            });
        });

        Route::prefix('article_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api','passport-custom-provider']], function () {
                Route::post('publish_article', 'ArticleController@publishArticle')->name('admin.article.publish');
                Route::get('get_article_detail', 'ArticleController@getArticleDetail')->name('admin.article.detail');
                Route::post('edit_article', 'ArticleController@editArticle')->name('admin.article.edit');
                Route::post('delete_article', 'ArticleController@deleteArticle')->name('admin.article.delete');
            });
        });

        Route::prefix('utils')->group(function (){
            Route::get('get_captcha', 'UtilsController@getCaptcha')->name('admin.get.captcha');
        });
    });
});
