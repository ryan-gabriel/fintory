<?php

use App\Http\Controllers\KasLedgerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Jika ingin tambah menu baru, pastikan untuk mengupdate route ini
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keuangan Management
    Route::prefix('dashboard/keuangan')->name('keuangan.')->group(function () {
        Route::get('/kas-ledger', [KasLedgerController::class, 'index'])->name('index');
        Route::get('/kas-ledger/create', [KasLedgerController::class, 'create'])->name('create');
        Route::post('/kas-ledger', [KasLedgerController::class, 'store'])->name('store');
    });

    // Menu Management

    Route::resource('menu', MenuController::class);
    Route::patch('menu/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggleStatus');
    Route::post('menu/update-order', [MenuController::class, 'updateOrder'])->name('menu.updateOrder');
});

require __DIR__.'/auth.php';
