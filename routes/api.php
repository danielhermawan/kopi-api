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

Route::post('/login', 'AuthController@login');
Route::post('/admin/login', 'AuthController@loginAdmin');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('category', 'CategoryController@index');
    Route::post('order', 'OrderController@create');
    Route::post('request', 'RequestController@create');
    Route::get('/me/product', "MeController@getProducts");
    Route::get('/me/category', "MeController@getCategories");
    Route::post('/logout', 'AuthController@logout');
});

Route::group(['middleware' => 'auth:api-admin'], function () {
    Route::resource('product', 'ProductController', ['except' => [
        'create', 'edit'
    ]]);
    Route::resource('seller', 'SellerController', ['except' => [
        'create', 'edit'
    ]]);
});