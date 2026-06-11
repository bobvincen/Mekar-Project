<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;


Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::resource('kategori', KategoriController::class);
Route::resource('supplier', SupplierController::class);
Route::get('/marketplace', function () {
    return view('marketplace.home');
});
Route::resource('obat', ObatController::class);
Route::resource('transaksi', TransaksiController::class);

Route::resource('pelanggan', PelangganController::class);
