<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerTTHController;
use App\Http\Controllers\CustomerTTHDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to TTH index
Route::get('/', function () {
    return redirect()->route('tth.index');
});

// Customer Routes
Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
});

// TTH Routes
Route::prefix('tth')->name('tth.')->group(function () {
    Route::get('/', [CustomerTTHController::class, 'index'])->name('index');
    Route::get('/create', [CustomerTTHController::class, 'create'])->name('create');
    Route::post('/', [CustomerTTHController::class, 'store'])->name('store');
    Route::get('/{id}', [CustomerTTHController::class, 'show'])->name('show');
    Route::delete('/{id}', [CustomerTTHController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/status', [CustomerTTHController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/{tthNo}/details', [CustomerTTHController::class, 'getDetails'])->name('getDetails');
});

// TTH Detail Routes (AJAX)
Route::prefix('tth/details')->name('tth.details.')->group(function () {
    Route::post('/', [CustomerTTHDetailController::class, 'store'])->name('store');
    Route::put('/{id}', [CustomerTTHDetailController::class, 'update'])->name('update');
    Route::delete('/{id}', [CustomerTTHDetailController::class, 'destroy'])->name('destroy');
});