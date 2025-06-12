<?php

use App\Http\Controllers\CicilanController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\KasLedgerController;
use App\Http\Controllers\ProfileController;
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
        Route::get('/kas-ledger', [KasLedgerController::class, 'index'])->name('kas-ledger.index');
        Route::get('/kas-ledger/data', [KasLedgerController::class, 'getData'])->name('kas-ledger.data');
        Route::get('/kas-ledger/create', [KasLedgerController::class, 'create'])->name('kas-ledger.create');
        Route::post('/kas-ledger', [KasLedgerController::class, 'store'])->name('kas-ledger.store');
        
        Route::get('/hutang', [HutangController::class, 'index'])->name('hutang.index');
        Route::get('/hutang/data', [HutangController::class, 'getData'])->name('hutang.data');
        Route::get('/hutang/create', [HutangController::class, 'create'])->name('hutang.create');
        Route::post('/hutang', [HutangController::class, 'store'])->name('hutang.store');
        
        Route::get('/cicilan', [CicilanController::class, 'index'])->name('cicilan.index');
        Route::get('/cicilan/data', [CicilanController::class, 'getData'])->name('cicilan.data');
        Route::get('/cicilan/create', [CicilanController::class, 'create'])->name('cicilan.create');
        Route::post('/cicilan', [CicilanController::class, 'store'])->name('cicilan.store');
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