<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('kategori', KategoriController::class);

});

Route::middleware(['auth', 'kasir'])->group(function () {

    Route::get('/kasir/dashboard', [DashboardController::class, 'index'])
    ->name('kasir.dashboard');

});

Route::middleware(['auth', 'pelanggan'])->group(function () {

    Route::get('/home', function () {
        return view('pelanggan.home');
    })->name('home');

});

//sementara
Route::get('/logout-test', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
});

require __DIR__.'/auth.php';
