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

    // Version
    Route::get('/version', function () {
        return response('v1.0.0', 200);
    });

    // Get User
    Route::get('/user', 'App\Http\Controllers\DashboardController@user');
    Route::get('/authUser', 'App\Http\Controllers\Auth\AuthController@authUser');

    // Dashboard
    Route::get('/dashboard/events', 'App\Http\Controllers\DashboardController@dashboardEvents');
    Route::get('/dashboard/tasks', 'App\Http\Controllers\DashboardController@dashboardTasks');
    Route::get('/dashboard/chart/bar', 'App\Http\Controllers\DashboardController@dashboardBarChart');

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
    // Tasks
    // Called after Full Calendar drag and drop - only updates time - separate to update method and needs to be called before apiResource
    Route::put('/tasks/{task}/time', 'App\Http\Controllers\TaskController@updateTime');
    // Called when clicking complete button on tasks table
    Route::put('/tasks/{task}/complete', 'App\Http\Controllers\TaskController@completeTask');
    Route::apiResource('/tasks', 'App\Http\Controllers\TaskController');
    // Activities
    Route::apiResource('/activities', 'App\Http\Controllers\ActivityController');

    // Balancer
    Route::get('/balancer/running', 'App\Http\Controllers\BalancerController@currentlyBalancing');
    Route::get('/balancer/start', 'App\Http\Controllers\BalancerController@newBalance');
    Route::put('/balancer/suggestion/confirm/{event}', 'App\Http\Controllers\BalancerController@confirmSuggestion');
    Route::get('/balancer/finish', 'App\Http\Controllers\BalancerController@finishBalance');

});

// Logout
Route::post('/logout', 'App\Http\Controllers\Auth\AuthController@logout');