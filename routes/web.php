<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::resource('kategori', KategoriController::class);
Route::get('/', function () {
    return view('welcome');
});

