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

Route::post('/konsultasi-log', [MarketplaceController::class, 'logKonsultasi'])->name('konsultasi.log');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/add/{id}', [CartController::class, 'add']); // Fallback GET method for simple links
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/update', [CartController::class, 'update']); // Fallback GET method for easy query param updates
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/feedback-layanan', [\App\Http\Controllers\FeedbackLayananController::class, 'store'])->name('feedback.store');


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
| Dashboard & Administrative Routes (Auth & Permission Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'permission:Dashboard'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:Kelola User')
        ->name('dashboard');

    // Kasir Dashboard
    Route::get('/kasir/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:Kelola Transaksi')
        ->name('kasir.dashboard');

    // Apoteker Dashboard
    Route::get('/apoteker/dashboard', [ApotekerDashboardController::class, 'index'])
        ->middleware('permission:Verifikasi Resep')
        ->name('apoteker.dashboard');
});

/*
|--------------------------------------------------------------------------
| Authorized Staff & Resource Management Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('kategori', KategoriController::class)->middleware('permission:Kelola Kategori');
    Route::resource('supplier', SupplierController::class)->middleware('permission:Kelola Supplier');

    // Obat Management
    Route::middleware('permission:Kelola Obat')->group(function () {
        Route::get('/obat/download-template', [ObatController::class, 'downloadTemplate'])->name('obat.download-template');
        Route::post('/obat/preview-import', [ObatController::class, 'previewImport'])->name('obat.preview-import');
        Route::post('/obat/import', [ObatController::class, 'import'])->name('obat.import');
        Route::resource('obat', ObatController::class);
    });

    Route::resource('pelanggan', PelangganController::class)->middleware('permission:Kelola Pelanggan');

    // Admin Online Orders & Resep Management (Admin-only, protected by Kelola Pesanan Online)
    Route::middleware('permission:Kelola Pesanan Online')->group(function () {
        Route::get('/resep-dokter', [AdminResepDokterController::class, 'index'])->name('admin.resep.index');
        Route::delete('/resep-dokter/{id}', [AdminResepDokterController::class, 'destroy'])->name('admin.resep.destroy');
        Route::get('/transaksi-online', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'index'])->name('admin.transaksi-online.index');
        Route::get('/transaksi-online/{id}', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'show'])->name('admin.transaksi-online.show');
        Route::patch('/transaksi-online/{id}/status', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'updateStatus'])->name('admin.transaksi-online.update-status');
        Route::get('/feedback-layanan', [\App\Http\Controllers\FeedbackLayananController::class, 'index'])->name('admin.feedback-layanan.index');
        Route::delete('/feedback-layanan/{id}', [\App\Http\Controllers\FeedbackLayananController::class, 'destroy'])->name('admin.feedback-layanan.destroy');
    });

    // RBAC & User Management (Admin-only)
    Route::resource('role', RoleController::class)->middleware('permission:Kelola Role');
    Route::resource('permission', PermissionController::class)->middleware('permission:Kelola Permission');
    Route::resource('user', UserController::class)->middleware('permission:Kelola User');

    // POS & Reports (Shared/Individual Staff)
    Route::middleware('permission:Kelola Transaksi')->group(function () {
        Route::get('transaksi/export-pdf', [TransaksiController::class, 'exportPdf'])
            ->name('transaksi.export-pdf');
        Route::resource('transaksi', TransaksiController::class);
    });

    Route::get('/laporan', function () {
        $totalTransaksi = \App\Models\Transaksi::count();
        $totalPendapatan = \App\Models\Transaksi::sum('total_harga');
        $transaksis = \App\Models\Transaksi::with('pelanggan')->latest()->limit(50)->get();

        return view('laporan.index', compact('totalTransaksi', 'totalPendapatan', 'transaksis'));
    })->middleware('permission:Kelola Laporan')->name('laporan.index');

    // Apoteker Actions
    Route::middleware('permission:Verifikasi Resep')->group(function () {
        Route::get('/apoteker/resep-dokter', [ApotekerDashboardController::class, 'resepIndex'])->name('apoteker.resep.index');
        Route::get('/apoteker/resep-dokter/{id}', [ApotekerDashboardController::class, 'resepShow'])->name('apoteker.resep.show');
        Route::post('/apoteker/resep-dokter/{id}/verify', [ApotekerDashboardController::class, 'resepVerify'])->name('apoteker.resep.verify');
    });

    Route::get('/apoteker/ketersediaan-obat', [ApotekerDashboardController::class, 'obatIndex'])
        ->middleware('permission:Lihat Stok Obat')
        ->name('apoteker.obat.index');

    // Pelanggan Portal Redirect
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

require __DIR__ . '/auth.php';