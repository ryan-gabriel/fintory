<?php

use App\Http\Controllers\CicilanController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\KasLedgerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Penjualan\SaleHistoryController;
use App\Http\Controllers\Penjualan\SaleTransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Auth\RoleChoiceController;

Route::get('/', function () {
    return view('welcome');
});

// Note: we do NOT put `role.selected` on the "welcome" or login pages.

// But we do want it on dashboard + all child routes.
Route::middleware(['auth', 'verified', 'role.selected'])->group(function () {
    // Dashboard (now guarded by role.selected)
    Route::get('/dashboard', function () {
        // Check if user has any roles, if not redirect to setup
        $user = auth()->user();
        if (!$user->hasAnyRole()) {
            return redirect()->route('auth.setup.lembaga');
        }

        // you can retrieve: session('current_lembaga_id'), session('current_role_id')

        // // Get all session data
        // $sessionData = session()->all();

        // // Dump and die
        // dd($sessionData);

        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keuangan Management
    Route::prefix('dashboard/keuangan')->name('keuangan.')->group(function () {
        Route::get('/kas-ledger', [KasLedgerController::class, 'index'])->name('index');
        Route::get('/kas-ledger/data', [KasLedgerController::class, 'getData'])->name('data');
        Route::get('/kas-ledger/create', [KasLedgerController::class, 'create'])->name('create');
        Route::post('/kas-ledger', [KasLedgerController::class, 'store'])->name('store');
        
        Route::get('/hutang', [HutangController::class, 'index'])->name('index');
        Route::get('/hutang/data', [HutangController::class, 'getData'])->name('data');
        Route::get('/hutang/create', [HutangController::class, 'create'])->name('create');
        Route::post('/hutang', [HutangController::class, 'store'])->name('store');
        
        Route::get('/cicilan', [CicilanController::class, 'index'])->name('index');
        Route::get('/cicilan/data', [CicilanController::class, 'getData'])->name('data');
        Route::get('/cicilan/create', [CicilanController::class, 'create'])->name('create');
        Route::post('/cicilan', [CicilanController::class, 'store'])->name('store');
    });

    // Produk Management
    Route::prefix('dashboard/produk-stok')->name('produk-stok.')->group(function () {
        // Rute untuk Barang
        Route::get('barang/data', [\App\Http\Controllers\BarangController::class, 'getData'])->name('barang.data');
        Route::resource('barang', \App\Http\Controllers\BarangController::class)->except(['show']);

        // Rute untuk Kategori
        Route::get('kategori/data', [\App\Http\Controllers\KategoriController::class, 'getData'])->name('kategori.data');
        Route::resource('kategori', \App\Http\Controllers\KategoriController::class)->except(['show']);

        // Rute untuk Produk
        Route::get('produk/data', [\App\Http\Controllers\ProductController::class, 'getData'])->name('produk.data');
        Route::resource('produk', \App\Http\Controllers\ProductController::class)->except(['show']);

        // Rute untuk Mutasi Stok
        Route::get('mutasi', [\App\Http\Controllers\StockMutationController::class, 'index'])->name('mutasi.index');
        Route::get('mutasi/data', [\App\Http\Controllers\StockMutationController::class, 'getData'])->name('mutasi.data');
    });

    // Penjualan Management
    Route::prefix('dashboard/penjualan')->name('penjualan.')->group(function () {
        Route::get('transaksi', [SaleTransactionController::class, 'index'])->name('transaksi.index');
        Route::get('riwayat', [SaleHistoryController::class, 'index'])->name('riwayat.index');
        Route::get('riwayat/data', [SaleHistoryController::class, 'getData'])->name('riwayat.data');
    });


    // Menu Management
    Route::resource('menu', MenuController::class);
    Route::patch('menu/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])
        ->name('menu.toggleStatus');
    Route::post('menu/update-order', [MenuController::class, 'updateOrder'])
        ->name('menu.updateOrder');
});

// These two "choose-role" routes must be reachable whenever a user is logged in
// but has not yet selected a role. We only protect them by 'auth'.
Route::middleware('auth')->group(function () {
    // Show the "choose your role & lembaga" form
    Route::get('/choose-role', [RoleChoiceController::class, 'show'])
        ->name('auth.choose_role');

    // Handle the form submission for choosing one combination
    Route::post('/choose-role', [RoleChoiceController::class, 'pick'])
        ->name('auth.pick_role');
});

require __DIR__ . '/auth.php';