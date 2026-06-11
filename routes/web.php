<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::resource('kategori', KategoriController::class);
Route::resource('supplier', SupplierController::class);
Route::get('/', function () {
    return view('marketplace.home');
});

