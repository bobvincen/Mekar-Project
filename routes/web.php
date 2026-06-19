<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApotekerDashboardController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ResepDokterController;
use App\Http\Controllers\AdminResepDokterController;

/*
|--------------------------------------------------------------------------
| Marketplace Routes (Public)
|--------------------------------------------------------------------------
*/

Route::get('/', [MarketplaceController::class, 'home'])->name('marketplace.home');
Route::get('/marketplace', [MarketplaceController::class, 'home']);
Route::get('/products', [MarketplaceController::class, 'products'])->name('marketplace.products');
Route::get('/products/{id}', [MarketplaceController::class, 'showProduct'])->name('marketplace.showProduct');
Route::get('/category/{id}', [MarketplaceController::class, 'category'])->name('marketplace.category');

Route::get('/upload-resep', [ResepDokterController::class, 'create'])->name('resep.create');
Route::post('/upload-resep', [ResepDokterController::class, 'store'])->name('resep.store');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/add/{id}', [CartController::class, 'add']); // Fallback GET method for simple links
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/update', [CartController::class, 'update']); // Fallback GET method for easy query param updates
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Profile Routes (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // API Route for dynamic sales summary chart data
    Route::get('/api/sales-summary', [DashboardController::class, 'salesSummary'])
        ->name('api.sales-summary');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Auth & Admin Middleware Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('pelanggan', PelangganController::class);
    
    // Admin Kelola Resep Dokter
    Route::get('/resep-dokter', [AdminResepDokterController::class, 'index'])->name('admin.resep.index');
    Route::delete('/resep-dokter/{id}', [AdminResepDokterController::class, 'destroy'])->name('admin.resep.destroy');
    
    // Admin Kelola Transaksi Online
    Route::get('/transaksi-online', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'index'])->name('admin.transaksi-online.index');
    Route::get('/transaksi-online/{id}', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'show'])->name('admin.transaksi-online.show');
    Route::patch('/transaksi-online/{id}/status', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'updateStatus'])->name('admin.transaksi-online.update-status');

    // RBAC & User Management Routes
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('user', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Admin & Kasir Shared Routes (Auth & Admin/Kasir Middleware Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin_or_kasir'])->group(function () {
    Route::resource('transaksi', TransaksiController::class);
    
    Route::get('/laporan', function () {
        $totalTransaksi = \App\Models\Transaksi::count();
        $totalPendapatan = \App\Models\Transaksi::sum('total_harga');
        $transaksis = \App\Models\Transaksi::with('pelanggan')->latest()->limit(50)->get();

        return view('laporan.index', compact('totalTransaksi', 'totalPendapatan', 'transaksis'));
    })->name('laporan.index');
});

/*
|--------------------------------------------------------------------------
| Kasir Routes (Auth & Kasir Middleware Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/kasir/dashboard', [DashboardController::class, 'index'])
        ->name('kasir.dashboard');
});

/*
|--------------------------------------------------------------------------
| Apoteker Routes (Auth & Apoteker Middleware Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'apoteker'])->group(function () {
    Route::get('/apoteker/dashboard', [ApotekerDashboardController::class, 'index'])->name('apoteker.dashboard');
    Route::get('/apoteker/resep-dokter', [ApotekerDashboardController::class, 'resepIndex'])->name('apoteker.resep.index');
    Route::get('/apoteker/resep-dokter/{id}', [ApotekerDashboardController::class, 'resepShow'])->name('apoteker.resep.show');
    Route::post('/apoteker/resep-dokter/{id}/verify', [ApotekerDashboardController::class, 'resepVerify'])->name('apoteker.resep.verify');
    Route::get('/apoteker/ketersediaan-obat', [ApotekerDashboardController::class, 'obatIndex'])->name('apoteker.obat.index');
});

/*
|--------------------------------------------------------------------------
| Pelanggan Routes (Auth & Pelanggan Middleware Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'pelanggan'])->group(function () {
    Route::get('/home', function () {
        return redirect('/marketplace');
    })->name('home');
});

// Logout Test Route
Route::get('/logout-test', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
});

require __DIR__.'/auth.php';
