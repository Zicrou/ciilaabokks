<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::resource('countries', \App\Http\Controllers\CountryController::class);
    Route::resource('regions', \App\Http\Controllers\RegionController::class);
    Route::resource('departements', \App\Http\Controllers\DepartementController::class);
    // Route::resource('domains', \App\Http\Controllers\DomainController::class);
    // Route::resource('metiers', \App\Http\Controllers\MetierController::class);

});

require __DIR__.'/auth.php';
