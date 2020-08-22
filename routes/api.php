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

/* Authentication routes */
Route::namespace('Auth')->group(function () {
    Route::post('login','LoginController@login')->name('login');
    Route::post('logout','LoginController@logout')->name('logout');
});

Route::middleware('auth:sanctum')->group(function () {
    /* Orders routes */
    Route::get('orders/list','OrderController@index')->name('orders.list');
    Route::post('orders/update-or-create','OrderController@updateOrCreate')->name('orders.update_or_create');
});
