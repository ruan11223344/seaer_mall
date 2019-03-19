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
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::post('logout', 'AuthController@logout');
                Route::post('add_admin', 'AuthController@addAdmin')->name('admin.add');
                Route::get('get_account_info', 'AuthController@getAccountInfo');
                Route::get('can_access_route', 'AuthController@canAccessRoute');
            });
        });
        Route::prefix('user_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
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
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::post('add_role', 'RoleController@addRole')->name('admin.role.add');
                Route::post('edit_role', 'RoleController@editRole')->name('admin.role.edit');
                Route::post('delete_role', 'RoleController@deleteRole')->name('admin.role.delete');
                Route::get('get_role_list', 'RoleController@getRoleList')->name('admin.role.list');
                Route::get('get_role_permissions', 'RoleController@getRolePermissions')->name('admin.role.permissions');
                Route::get('get_permissions_list', 'RoleController@getPermissionsList')->name('admin.permissions.list');
            });
        });
        Route::prefix('product_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::get('get_product_list', 'ProductManagerController@getProductList')->name('admin.product.list');
                Route::get('get_product_audit_list', 'ProductManagerController@getAuditProductList')->name('admin.product.auditList');
                Route::get('get_product_info', 'ProductManagerController@getProductInfo')->name('admin.product.info');
                Route::post('product_audit', 'ProductManagerController@auditProduct')->name('admin.product.audit');
                Route::post('product_off_shelf', 'ProductManagerController@productOffShelf')->name('admin.product.offShelf');
            });
        });

        Route::prefix('article_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::post('publish_article', 'ArticleController@publishArticle')->name('admin.article.publish');
                Route::get('get_article_detail', 'ArticleController@getArticleDetail')->name('admin.article.detail');
                Route::post('edit_article', 'ArticleController@editArticle')->name('admin.article.edit');
                Route::post('delete_article', 'ArticleController@deleteArticle')->name('admin.article.delete');
                Route::get('get_agreements_list', 'ArticleController@getAgreementsList')->name('admin.article.AgreementsList');
                Route::get('get_system_article_list', 'ArticleController@getSystemArticleList')->name('admin.article.SystemArticleList');
                Route::get('get_system_announcement_list', 'ArticleController@getSystemAnnouncementList')->name('admin.article.SystemAnnouncementList');
            });
        });

        Route::prefix('feedback_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::get('get_feedback_list', 'FeedbackController@getFeedbackList')->name('admin.feedback.list');
                Route::post('process_feedback', 'FeedbackController@processFeedback')->name('admin.feedback.process');
            });
        });

        Route::prefix('ad_manager')->group(function (){
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::get('get_ad_list', 'AdManagerController@getAdList')->name('admin.ad.list');
                Route::post('edit_ad', 'AdManagerController@editAd')->name('admin.ad.edit');
                Route::get('get_index_product_recommend', 'AdManagerController@getIndexProductRecommend')->name('admin.ad.indexProductRecommend');
                Route::post('edit_index_product_recommend', 'AdManagerController@editIndexProductRecommend')->name('admin.ad.editIndexProductRecommend');
                Route::get('get_sale_product', 'AdManagerController@getSaleProduct')->name('admin.ad.getSaleProduct');
                Route::get('get_sale_product_search', 'AdManagerController@getSaleProductSearch')->name('admin.ad.getSaleProductSearch');
            });
        });

        Route::prefix('utils')->group(function (){
            Route::get('get_captcha', 'UtilsController@getCaptcha')->name('admin.get.captcha');
            Route::group(['middleware' => ['client.credentials', 'auth:api']], function () {
                Route::post('upload_img', 'UtilsController@uploadImg')->name('admin.uploadImg');
                Route::get('get_index_data', 'AdminController@getIndexData')->name('admin.index.data');
            });
        });
    });
});
