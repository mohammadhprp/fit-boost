<?php

namespace App\Http\Controllers\Api;

use App\Models\WorkoutProgress;
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

    /// User Routes
    Route::prefix('user')->group(function () {
        /// User Workout Routes
        Route::apiResource(
            'workouts', WorkoutController::class
        )->only(['index', 'show']);

        /// User Meal Routes
        Route::apiResource(
            'meals', MealController::class
        )->only(['index', 'show']);;

        /// User Profile Routes
        Route::controller(UserController::class)->group(function () {
            Route::get('profile', 'show');
            Route::put('profile', 'update');
        });

        /// User Workout Progress Routes
        Route::apiResource('progress/workout', WorkoutProgressController::class);

        /// User Progress Routes
        Route::apiResource('progress', UserProgressController::class);

        /// User Share Progress Routes
        Route::apiResource('share', ShareProgressController::class);
    });
});

// AuthenticationAction Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/user', 'authentication');
    Route::post('/auth/otp', 'otp');
});
