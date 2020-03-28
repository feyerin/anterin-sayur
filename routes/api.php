<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/product', 'Product\ProductController@index');

Route::get('/product/read/{id}', 'Product\ProductController@read');

Route::post('/product/create', 'Product\ProductController@create');

Route::post('/product/update', 'Product\ProductController@update');

Route::post('/product/delete', 'Product\ProductController@delete');

//-------------------------------------------------------------------------------

Route::get('/order/check-session', 'Order\OrderController@checkSession');

Route::get('/order', 'Order\OrderController@index');

Route::get('/order/read/{id}', 'Order\OrderController@read');

Route::get('/order/order-product/{id}', 'Order\OrderController@getOrderProduct');

Route::get('/order/get-cart', 'Order\OrderController@getCart');

Route::post('/order/update-cart', 'Order\OrderController@updateCart');

Route::get('/order/checkout', 'Order\OrderController@checkout');

Route::post('/order/set-user-data', 'Order\OrderController@setUserData');

//-------------------------------------------------------------------------------

Route::get('/banner', 'Banner\BannerController@index');

Route::get('/banner/read/{id}', 'Banner\BannerController@read');

Route::post('/banner/create', 'Banner\BannerController@create');

Route::post('/banner/update', 'Banner\BannerController@update');

Route::post('/banner/delete', 'Banner\BannerController@delete');