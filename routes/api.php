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
    Route::post('order', 'Mobile\OrderController@create');
    Route::post('request', 'Mobile\RequestController@create');
    Route::get('/me/product', "Mobile\MeController@getProducts");
    Route::get('/me/category', "Mobile\MeController@getCategories");
    Route::post('/logout', 'AuthController@logout');
});

Route::group(['middleware' => 'auth:api-admin'], function () {
    Route::resource('category', 'CategoryController', ['except' => [
        'create', 'edit'
    ]]);
    Route::resource('product', 'ProductController', ['except' => [
        'create', 'edit'
    ]]);
    Route::resource('seller', 'SellerController', ['except' => [
        'create', 'edit'
    ]]);
});