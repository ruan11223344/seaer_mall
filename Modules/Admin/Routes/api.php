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
            Route::post('logout', 'AuthController@logout')->middleware('passport-custom-provider');
            Route::post('add_admin', 'AuthController@addAdmin')->middleware('passport-custom-provider');
        });
        Route::prefix('user_manager')->group(function (){
            Route::get('get_user_list', 'UserManagerController@getUserList')->middleware('passport-custom-provider')->name('admin.user.list');
            Route::get('search_user_list', 'UserManagerController@searchUserList')->middleware('passport-custom-provider')->name('admin.user.search');
            Route::post('set_inquiry', 'UserManagerController@setInquiry')->middleware('passport-custom-provider')->name('admin.user.setInquiry');
            Route::get('get_merchant_list', 'UserManagerController@getMerchantsList')->middleware('passport-custom-provider')->name('admin.user.merchants.list');
            Route::get('search_merchant_list', 'UserManagerController@searchMerchantsList')->middleware('passport-custom-provider')->name('admin.user.merchants.search');
            Route::get('get_admin_list', 'UserManagerController@getAdminList')->middleware('passport-custom-provider')->name('admin.user.admin.list');
            Route::get('get_admin_info', 'UserManagerController@getAdminInfo')->middleware('passport-custom-provider')->name('admin.user.admin.info');
            Route::post('edit_admin', 'UserManagerController@editAdmin')->middleware('passport-custom-provider')->name('admin.user.admin.edit');
            Route::post('delete_admin', 'UserManagerController@deleteAdmin')->middleware('passport-custom-provider')->name('admin.user.admin.delete');
        });

        Route::prefix('role_manager')->group(function (){
            Route::post('add_role', 'RoleController@addRole')->middleware('passport-custom-provider')->name('admin.role.add');
            Route::post('edit_role', 'RoleController@editRole')->middleware('passport-custom-provider')->name('admin.role.edit');
            Route::post('delete_role', 'RoleController@deleteRole')->middleware('passport-custom-provider')->name('admin.role.delete');
            Route::get('get_role_list', 'RoleController@getRoleList')->middleware('passport-custom-provider')->name('admin.role.list');
            Route::get('get_role_permissions', 'RoleController@getRolePermissions')->middleware('passport-custom-provider')->name('admin.role.permissions');
        });

        Route::prefix('product_manager')->group(function (){
            Route::get('get_product_list', 'ProductManagerController@getProductList')->middleware('passport-custom-provider')->name('admin.product.list');
            Route::get('get_product_audit_list', 'ProductManagerController@getAuditProductList')->middleware('passport-custom-provider')->name('admin.product.auditList');
        });

        Route::prefix('utils')->group(function (){
            Route::get('get_captcha', 'UtilsController@getCaptcha')->name('admin.get.captcha');
        });
    });
});
