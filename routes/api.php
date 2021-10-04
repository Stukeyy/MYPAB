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

Route::post('/login', 'App\Http\Controllers\Auth\AuthController@login');
Route::post('/register', 'App\Http\Controllers\Auth\AuthController@register');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/authUser', 'App\Http\Controllers\Auth\AuthController@authUser');
    Route::get('/user', 'App\Http\Controllers\Auth\AuthController@user');

});