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
//注册
Route::post('register', 'API\UserController@register');

//授权的接口
Route::group(['middleware' => 'auth:api'], function () {
    //获取用户信息
    Route::get('user', 'API\UserController@user');

});


