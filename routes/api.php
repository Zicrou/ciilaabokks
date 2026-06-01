<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('auth/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);