<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;

use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Marketplace Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [MarketplaceController::class, 'home'])->name('marketplace.home');
Route::get('/marketplace', [MarketplaceController::class, 'home']);
Route::get('/products', [MarketplaceController::class, 'products'])->name('marketplace.products');
Route::get('/products/{id}', [MarketplaceController::class, 'showProduct'])->name('marketplace.showProduct');
Route::get('/category/{id}', [MarketplaceController::class, 'category'])->name('marketplace.category');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/add/{id}', [CartController::class, 'add']); // Fallback GET method for simple links
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/update', [CartController::class, 'update']); // Fallback GET method for easy query param updates
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::resource('kategori', KategoriController::class);
Route::resource('supplier', SupplierController::class);
Route::resource('obat', ObatController::class);
Route::resource('transaksi', TransaksiController::class);