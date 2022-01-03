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
Route::post('/register/email', 'App\Http\Controllers\Auth\AuthController@checkEmail');

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Get User
    Route::get('/user', 'App\Http\Controllers\DashboardController@user');
    Route::get('/authUser', 'App\Http\Controllers\Auth\AuthController@authUser');

    // Tags
    // Called after Tag Table colour picker - only updates colour - separate update method and needs to be called before apiResource
    Route::put('/tags/{tag}/colour', 'App\Http\Controllers\TagController@updateColour');
    Route::apiResource('/tags', 'App\Http\Controllers\TagController');
    // Commitments
    Route::apiResource('/commitments', 'App\Http\Controllers\CommitmentController');
    // Events
    // Called after Full Calendar drag and drop - only updates time - separate to update method and needs to be called before apiResource
    Route::put('/events/{event}/time', 'App\Http\Controllers\EventController@updateTime');
    Route::apiResource('/events', 'App\Http\Controllers\EventController');
    // Checks
    Route::apiResource('/checks', 'App\Http\Controllers\CheckController');

});

// Logout
Route::post('/logout', 'App\Http\Controllers\Auth\AuthController@logout');