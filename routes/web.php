<?php

use App\Http\Controllers\Auth\RoleChoiceController;
use App\Http\Controllers\CicilanController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\KasLedgerController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MutasiStokController;
use App\Http\Controllers\Penjualan\SaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokProdukController;
use App\Http\Controllers\DashboardController;
use App\Models\Product;
use App\Models\Sale;
use App\Http\Controllers\UserManagementController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Note: we do NOT put `role.selected` on the "welcome" or login pages.

// But we do want it on dashboard + all child routes.
Route::middleware(['auth', 'verified', 'role.selected'])->group(function () {
    // Dashboard (now guarded by role.selected)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/sales-last-7-days', [DashboardController::class, 'getSalesLast7Days'])->name('api.sales.last7days');
    Route::get('/api/best-seller-products', [DashboardController::class, 'bestSellerProducts'])->name('api.sales.best-seller');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/dashboard/set-outlet', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'selected_outlet_id' => 'required',
        ]);
        session(['selected_outlet_id' => $request->input('selected_outlet_id')]);
        return response()->json(['status' => 'success']);
    })->name('dashboard.set-outlet');

    // Keuangan Management
    Route::prefix('dashboard/keuangan')->name('keuangan.')->group(function () {
        Route::get('/kas-ledger', [KasLedgerController::class, 'index'])->name('kas-ledger.index');
        Route::get('/kas-ledger/data', [KasLedgerController::class, 'getData'])->name('kas-ledger.data');
        Route::get('/kas-ledger/create', [KasLedgerController::class, 'create'])->name('kas-ledger.create');
        Route::post('/kas-ledger', [KasLedgerController::class, 'store'])->name('kas-ledger.store');
        Route::get('/kas-ledger/{id}/edit', [KasLedgerController::class, 'edit'])->name('kas-ledger.edit');
        Route::patch('/kas-ledger/{id}', [KasLedgerController::class, 'update'])->name('kas-ledger.update');
        Route::delete('/kas-ledger/{id}', [KasLedgerController::class, 'destroy'])->name('kas-ledger.destroy');

        Route::get('/hutang', [HutangController::class, 'index'])->name('hutang.index');
        Route::get('/hutang/data', [HutangController::class, 'getData'])->name('hutang.data');
        Route::get('/hutang/create', [HutangController::class, 'create'])->name('hutang.create');
        Route::post('/hutang', [HutangController::class, 'store'])->name('hutang.store');
        Route::get('/hutang/{id}/edit', [HutangController::class, 'edit'])->name('hutang.edit');
        Route::patch('/hutang/{id}', [HutangController::class, 'update'])->name('hutang.update');
        Route::delete('/hutang/{id}', [HutangController::class, 'destroy'])->name('hutang.destroy');

        Route::get('/cicilan', [CicilanController::class, 'index'])->name('cicilan.index');
        Route::get('/cicilan/data', [CicilanController::class, 'getData'])->name('cicilan.data');
        Route::get('/cicilan/create', [CicilanController::class, 'create'])->name('cicilan.create');
        Route::post('/cicilan', [CicilanController::class, 'store'])->name('cicilan.store');
        Route::get('/cicilan/{id}/edit', [CicilanController::class, 'edit'])->name('cicilan.edit');
        Route::patch('/cicilan/{id}', [CicilanController::class, 'update'])->name('cicilan.update');
        Route::delete('/cicilan/{id}', [CicilanController::class, 'destroy'])->name('cicilan.destroy');
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
        // Rute untuk Riwayat Penjualan
        Route::get('/data', [SaleController::class, 'getData'])->name('data');
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::get('/create', [SaleController::class, 'create'])->name('create');
        Route::post('/', [SaleController::class, 'store'])->name('store');
        Route::get('/produk/search', [SaleController::class, 'getProductsByOutlet'])->name('produk.search');
        Route::get('/{penjualan}', [SaleController::class, 'show'])->name('show');

    });

    // Laporan Management
    Route::prefix('dashboard/laporan')->name('laporan.')->group(function () {
        Route::get('/penjualan', [\App\Http\Controllers\Laporan\LaporanPenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/penjualan/data', [\App\Http\Controllers\Laporan\LaporanPenjualanController::class, 'getData'])->name('penjualan.data');
    });

    // Admin Management
    Route::prefix('dashboard/admin')->name('admin.')->group(function () {

        // Menu Management
        Route::resource('menu', MenuController::class);
        Route::patch('menu/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])
            ->name('menu.toggleStatus');
        Route::post('menu/update-order', [MenuController::class, 'updateOrder'])
            ->name('menu.updateOrder');
        Route::get('menu/{menu}/manage-roles', [MenuController::class, 'manageRoles'])
            ->name('menu.manageRoles');
        Route::patch('menu/{menu}/update-roles', [MenuController::class, 'updateRoles'])
            ->name('menu.updateRoles');

        // User Management
        Route::prefix('user-management')->name('user-management.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/data', [UserManagementController::class, 'getData'])->name('data');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/', [UserManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/reset-password', [UserManagementController::class, 'resetPassword'])->name('reset-password');
            //debug
            Route::get('/debug', [UserManagementController::class, 'debug'])->name('debug');
        });
    });

    // Produk Management
    Route::prefix('dashboard/laporan')->name('laporan.')->group(function () {

        Route::prefix('stok')->name('stok.')->group(function () {
            Route::get('/mutasi-stok/data', [MutasiStokController::class, 'getData'])->name('mutasi-stok.data');
            Route::get('/mutasi-stok', [MutasiStokController::class, 'index'])->name('mutasi-stok.index');
            Route::get('/mutasi-stok/{id}', [MutasiStokController::class, 'show'])->name('mutasi-stok.show');
            Route::get('/produk/data', [StokProdukController::class, 'getData'])->name('produk.data');
            Route::get('/produk', [StokProdukController::class, 'index'])->name('produk.index');
            Route::get('/produk/{id}', [StokProdukController::class, 'show'])->name('produk.show');
        });

        Route::get('/keuangan/data', [LaporanKeuanganController::class, 'getData'])->name('keuangan.data');
        Route::get('/keuangan', [LaporanKeuanganController::class, 'index'])->name('keuangan.index');
        Route::get('/keuangan/{id}', [LaporanKeuanganController::class, 'show'])->name('keuangan.show');
    });

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
