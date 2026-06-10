<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::resource('kategori', KategoriController::class);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/pelanggan', [PelangganController::class, 'index']);
Route::resource('pelanggan', PelangganController::class);
