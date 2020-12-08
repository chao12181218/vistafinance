<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//登录
Route::post('login', 'API\UserController@login');
Route::get('test', 'TestController@index');
//授权的接口
Route::group(['middleware' => 'auth:api'], function () {
    //获取用户信息
    Route::get('usermessage', 'API\UserController@usermessage');
    //管理员
    Route::get('admin', 'API\AdminController@index');
    Route::post('admin/create', 'API\AdminController@create');
    Route::post('admin/store', 'API\AdminController@store');
    Route::post('admin/edit', 'API\AdminController@edit');
    Route::post('admin/update', 'API\AdminController@update');
    Route::post('admin/destroy', 'API\AdminController@destroy');

    //角色
    Route::get('role', 'API\RoleController@index');
    Route::post('role/create', 'API\RoleController@create');
    Route::post('role/store', 'API\RoleController@store');
    Route::post('role/edit', 'API\RoleController@edit');
    Route::post('role/update', 'API\RoleController@update');
    Route::post('role/destroy', 'API\RoleController@destroy');

    //权限
    Route::get('permission', 'API\PermissionController@index');
    Route::post('permission/create', 'API\PermissionController@create');
    Route::post('permission/store', 'API\PermissionController@store');
    Route::post('permission/edit', 'API\PermissionController@edit');
    Route::post('permission/update', 'API\PermissionController@update');
    Route::post('permission/destroy', 'API\PermissionController@destroy');

    //供货商
    Route::get('supplier', 'API\SupplierController@index');
    Route::post('supplier/create', 'API\SupplierController@create');
    Route::post('supplier/store', 'API\SupplierController@store');
    Route::post('supplier/edit', 'API\SupplierController@edit');
    Route::post('supplier/update', 'API\SupplierController@update');
    Route::post('supplier/destroy', 'API\SupplierController@destroy');

    //客户
    Route::get('fran', 'API\FranController@index');
    Route::post('fran/create', 'API\FranController@create');
    Route::post('fran/store', 'API\FranController@store');
    Route::post('fran/edit', 'API\FranController@edit');
    Route::post('fran/update', 'API\FranController@update');
    Route::post('fran/destroy', 'API\FranController@destroy');

    //产品
    Route::get('product', 'API\ProductController@index');
    Route::post('product/create', 'API\ProductController@create');
    Route::post('product/store', 'API\ProductController@store');
    Route::post('product/edit', 'API\ProductController@edit');
    Route::post('product/update', 'API\ProductController@update');
    Route::post('product/destroy', 'API\ProductController@destroy');

    //基础数据
    Route::get('basedata', 'API\BasedataController@index');
    Route::post('basedata/create', 'API\BasedataController@create');
    Route::post('basedata/store', 'API\BasedataController@store');
    Route::post('basedata/edit', 'API\BasedataController@edit');
    Route::post('basedata/update', 'API\BasedataController@update');
    Route::post('basedata/destroy', 'API\BasedataController@destroy');

});


