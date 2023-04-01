<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Authentication Routes
    Route::controller(AuthController::class)->group(function () {
        Route::get('/auth/logout', 'logout');
        Route::get('/auth/refresh', 'refresh');
    });

    Route::prefix('user')->group(function () {
        Route::apiResource('workouts', WorkoutController::class);
        Route::apiResource('meals', MealController::class);
    });
});

// AuthenticationAction Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/user', 'authentication');
    Route::post('/auth/otp', 'otp');
});
