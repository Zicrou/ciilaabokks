<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('auth/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);