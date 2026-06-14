<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$nameRegex = '[a-zA-Z]+';

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
    Route::resource('domaines', \App\Http\Controllers\DomaineController::class);
    Route::resource('metiers', \App\Http\Controllers\MetierController::class);
    Route::get('ouvriers/rechercher', [\App\Http\Controllers\OuvrierController::class, 'rechercher'])->name('ouvriers.rechercher');
    Route::get('ouvriers/filtered', [\App\Http\Controllers\OuvrierController::class, 'filtered'])->name('ouvriers.filtered');
    Route::get('mon_compte', [\App\Http\Controllers\OuvrierController::class,'get_mon_compte'])->name('ouvriers.mon_compte');
    Route::get('/api/metiers', [\App\Http\Controllers\OuvrierController::class, 'metiersByDomaine']);
    Route::get('/api/departements', [\App\Http\Controllers\OuvrierController::class, 'departementsByRegion']);
    Route::resource('ouvriers', \App\Http\Controllers\OuvrierController::class);
    Route::resource('diplomes', \App\Http\Controllers\DiplomeController::class);

});

require __DIR__.'/auth.php';
