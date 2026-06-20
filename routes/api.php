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
        Route::resource('countries', \App\Http\Controllers\api\v1\CountryController::class);
        Route::resource('regions', \App\Http\Controllers\api\v1\RegionController::class);
        Route::resource('departements', \App\Http\Controllers\api\v1\DepartementController::class);
        Route::resource('domaines', \App\Http\Controllers\api\v1\DomaineController::class);
        Route::resource('metiers', \App\Http\Controllers\api\v1\MetierController::class);
        Route::get('ouvriers/rechercher', [\App\Http\Controllers\api\v1\OuvrierController::class, 'rechercher'])->name('ouvriers.rechercher');
        Route::get('ouvriers/filtered', [\App\Http\Controllers\api\v1\OuvrierController::class, 'filtered'])->name('ouvriers.filtered');
        Route::get('mon_compte', [\App\Http\Controllers\api\v1\OuvrierController::class,'get_mon_compte'])->name('ouvriers.mon_compte');
        Route::get('/filtered/metiers', [\App\Http\Controllers\api\v1\OuvrierController::class, 'metiersByDomaine']);
        Route::get('/filtered/departements', [\App\Http\Controllers\api\v1\OuvrierController::class, 'departementsByRegion']);
        Route::resource('ouvriers', \App\Http\Controllers\api\v1\OuvrierController::class)->except(['index', 'show']);
        Route::resource('diplomes', \App\Http\Controllers\api\v1\DiplomeController::class);
    });
    Route::get('ouvriers', [\App\Http\Controllers\api\v1\OuvrierController::class, 'index'])->name('ouvriers');
    Route::get('ouvriers/{id}', [\App\Http\Controllers\api\v1\OuvrierController::class, 'show'])->name("ouvrier.show");
    Route::middleware('auth:sanctum')->group(function () {
    
});
});
// Route::apiResource('ventes', \App\Http\Controllers\VenteController::class);

// Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

// Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

// Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
    