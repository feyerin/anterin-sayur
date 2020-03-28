<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('logout', 'Auth\LoginController@logout');

Auth::routes();
Route::group(['middleware'=>'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'Dashboard\DashboardController@index');
    Route::get('/add', 'Dashboard\DashboardController@add');
    Route::get('/detail/{id}', 'Dashboard\DashboardController@read');
});
