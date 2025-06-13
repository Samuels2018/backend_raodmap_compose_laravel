<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WorkoutLogController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user-profile', [AuthController::class, 'userProfile']);
});

Route::group([
    //'middleware' => 'auth:api'
], function() {
    // Exercises
    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::get('exercises/{id}', [ExerciseController::class, 'show']);
    Route::get('exercises/filter', [ExerciseController::class, 'filter']);
    Route::post('exercises/create', [ExerciseController::class, 'store']);

    // Workouts
    Route::apiResource('workouts', WorkoutController::class);
    Route::get('workouts/upcoming', [WorkoutController::class, 'upcoming']);
    Route::get('workouts/past', [WorkoutController::class, 'past']);

    // Workout Logs
    Route::apiResource('workout-logs', WorkoutLogController::class);
    Route::get('workout-logs/progress-report', [WorkoutLogController::class, 'progressReport']);
});
