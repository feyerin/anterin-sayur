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

Route::get('/product/{id}', 'Product\ProductController@read');

Route::post('/product/create', 'Product\ProductController@create');

Route::post('/product/update', 'Product\ProductController@update');

Route::delete('/product/delete', 'Product\ProductController@delete');