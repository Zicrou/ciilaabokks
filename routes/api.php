<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Group for API v1
Route::prefix('v1')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/register', [\App\Http\Controllers\api\v1\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\api\v1\AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\api\v1\AuthController::class, 'logout']);
    });


});
// Route::apiResource('ventes', \App\Http\Controllers\VenteController::class);

// Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

// Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

// Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
    