<?php

use App\Http\Controllers\KeuanganController;
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

    Route::prefix('dashboard/keuangan')->name('keuangan.')->group(function () {
        Route::get('/kas-ledger', [KeuanganController::class, 'index'])->name('index');
        Route::get('/kas-ledger/create', [KeuanganController::class, 'create'])->name('create');
        Route::post('/kas-ledger', [KeuanganController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';
