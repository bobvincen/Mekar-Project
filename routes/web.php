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

/*
|--------------------------------------------------------------------------
| Marketplace Routes (Public)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('marketplace.home');
});

Route::get('/marketplace', function () {
    return view('marketplace.home');
});

Route::get('/cart', function () {
    return view('marketplace.cart');
});

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
