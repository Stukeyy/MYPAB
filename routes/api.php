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

// Test
Route::get('/check', 'App\Http\Controllers\DashboardController@check');

// Login
Route::post('/login', 'App\Http\Controllers\Auth\AuthController@login');
Route::post('/register', 'App\Http\Controllers\Auth\AuthController@register');

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Get User
    Route::get('/user', 'App\Http\Controllers\DashboardController@user');
    Route::get('/authUser', 'App\Http\Controllers\Auth\AuthController@authUser');

});

// Logout
Route::post('/logout', 'App\Http\Controllers\Auth\AuthController@logout');