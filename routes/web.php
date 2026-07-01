<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

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

Route::post('/konsultasi-log', [MarketplaceController::class, 'logKonsultasi'])->name('konsultasi.log');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/add/{id}', [CartController::class, 'add']); // Fallback GET method for simple links
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/update', [CartController::class, 'update']); // Fallback GET method for easy query param updates
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/feedback-layanan', [\App\Http\Controllers\FeedbackLayananController::class, 'store'])->name('feedback.store');


/*
|--------------------------------------------------------------------------
| Profile & Customer Order Routes (Auth Required)
|--------------------------------------------------------------------------
|*/
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

    // Secure prescription file serving
    Route::get('/resep-dokter/file/{id}', [ResepDokterController::class, 'showFile'])->name('resep.file');

    // Shared processing routes for Admin and Apoteker
    Route::middleware(['role:admin|apoteker'])->group(function () {
        Route::get('/resep-dokter/{id}/proses', [ResepDokterController::class, 'prosesForm'])->name('resep.proses');
        Route::post('/resep-dokter/{id}/proses', [ResepDokterController::class, 'prosesSubmit'])->name('resep.proses.submit');
        Route::post('/resep-dokter/{id}/tolak', [ResepDokterController::class, 'prosesReject'])->name('resep.proses.reject');
        Route::get('/api/obats/search', [ResepDokterController::class, 'searchObat'])->name('api.obats.search');
    });
});

Route::middleware(['auth', 'phone_verified'])->group(function () {
    // Resep Customer Routes
    Route::get('/upload-resep', [ResepDokterController::class, 'create'])->name('resep.create');
    Route::post('/upload-resep', [ResepDokterController::class, 'store'])->name('resep.store');
    Route::get('/resep-saya', [ResepDokterController::class, 'index'])->name('resep.index');
    Route::get('/resep-saya/{id}', [ResepDokterController::class, 'show'])->name('resep.show');
    Route::post('/resep-saya/{id}/setujui', [ResepDokterController::class, 'approve'])->name('resep.approve');
    Route::post('/resep-saya/{id}/revisi', [ResepDokterController::class, 'revise'])->name('resep.revise');

    // Checkout & Invoice Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/invoice/{kode_transaksi}', [CheckoutController::class, 'showInvoice'])->name('marketplace.invoice');
    Route::post('/invoice/{kode_transaksi}/upload-bukti', [CheckoutController::class, 'uploadBukti'])->name('marketplace.invoice.upload-bukti');

    // Customer Orders Route (Pesanan Saya)
    Route::get('/pesanan-saya', [\App\Http\Controllers\CustomerOrderController::class, 'index'])->name('marketplace.pesanan-saya');
    Route::get('/invoice/{kode_transaksi}/download', [\App\Http\Controllers\CustomerOrderController::class, 'downloadInvoicePdf'])->name('marketplace.invoice.download');
});


/*
|--------------------------------------------------------------------------
| Dashboard & Administrative Routes (Auth & Permission Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'permission:Dashboard'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:Lihat User')
        ->name('dashboard');

    // Kasir Dashboard
    Route::get('/kasir/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:Lihat Transaksi')
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
|*/
Route::middleware(['auth'])->group(function () {
    // Kategori Management
    Route::middleware('permission:Lihat Kategori')->group(function () {
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });
    Route::middleware('permission:Tambah Kategori')->group(function () {
        Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    });

    // Supplier Management
    Route::middleware('permission:Lihat Supplier')->group(function () {
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    });
    Route::middleware('permission:Tambah Supplier')->group(function () {
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::post('/supplier/store-ajax', [SupplierController::class, 'storeAjax'])->name('supplier.store-ajax');
    });

    // Obat Management
    Route::middleware('permission:Lihat Obat')->group(function () {
        Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
        Route::get('/obat/{obat}/edit', [ObatController::class, 'edit'])->name('obat.edit');
        Route::put('/obat/{obat}', [ObatController::class, 'update'])->name('obat.update');
        Route::delete('/obat/{obat}', [ObatController::class, 'destroy'])->name('obat.destroy');
    });
    Route::middleware('permission:Tambah Obat')->group(function () {
        Route::get('/obat/download-template', [ObatController::class, 'downloadTemplate'])->name('obat.download-template');
        Route::post('/obat/preview-import', [ObatController::class, 'previewImport'])->name('obat.preview-import');
        Route::post('/obat/import', [ObatController::class, 'import'])->name('obat.import');
        Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
        Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
    });

    // Customer Management
    Route::middleware('permission:Lihat Pelanggan')->group(function () {
        Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    });
    Route::middleware('permission:Tambah Pelanggan')->group(function () {
        Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
    });

    // Admin Online Orders & Resep Management (Admin-only, protected by Kelola Pesanan Online)
    Route::middleware('permission:Kelola Pesanan Online')->group(function () {
        Route::get('/resep-dokter', [AdminResepDokterController::class, 'index'])->name('admin.resep.index');
        Route::delete('/resep-dokter/{id}', [AdminResepDokterController::class, 'destroy'])->name('admin.resep.destroy');
        Route::get('/transaksi-online', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'index'])->name('admin.transaksi-online.index');
        Route::get('/transaksi-online/{id}', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'show'])->name('admin.transaksi-online.show');
        Route::patch('/transaksi-online/{id}/status', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'updateStatus'])->name('admin.transaksi-online.update-status');
        Route::post('/transaksi-online/{id}/verifikasi', [\App\Http\Controllers\AdminTransaksiOnlineController::class, 'verifyPayment'])->name('admin.transaksi-online.verify');
        Route::get('/feedback-layanan', [\App\Http\Controllers\FeedbackLayananController::class, 'index'])->name('admin.feedback-layanan.index');
        Route::delete('/feedback-layanan/{id}', [\App\Http\Controllers\FeedbackLayananController::class, 'destroy'])->name('admin.feedback-layanan.destroy');
    });

    // RBAC & User Management (Admin-only)
    Route::middleware('permission:Lihat Role')->group(function () {
        Route::get('/role', [RoleController::class, 'index'])->name('role.index');
        Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/role/{role}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
    });
    Route::middleware('permission:Tambah Role')->group(function () {
        Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    });

    Route::middleware('permission:Lihat Permission')->group(function () {
        Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/permission/{permission}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::put('/permission/{permission}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('/permission/{permission}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });
    Route::middleware('permission:Tambah Permission')->group(function () {
        Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('/permission', [PermissionController::class, 'store'])->name('permission.store');
    });

    Route::middleware('permission:Lihat User')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        // WhatsApp Diagnostic Routes
        Route::get('/admin/whatsapp-diagnostic', [\App\Http\Controllers\WhatsAppDiagnosticController::class, 'index'])->name('admin.whatsapp-diagnostic');
        Route::post('/admin/whatsapp-diagnostic/test', [\App\Http\Controllers\WhatsAppDiagnosticController::class, 'testSend'])->name('admin.whatsapp-diagnostic.test');
    });
    Route::middleware('permission:Tambah User')->group(function () {
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
    });

    // POS & Reports (Shared/Individual Staff)
    Route::middleware('permission:Lihat Transaksi')->group(function () {
        Route::get('transaksi/export-pdf', [TransaksiController::class, 'exportPdf'])
            ->name('transaksi.export-pdf');
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
        Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');
        Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    });
    Route::middleware('permission:Tambah Transaksi')->group(function () {
        Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    });

    Route::get('/laporan', [LaporanController::class, 'index'])->middleware('role:admin|kasir')->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->middleware('role:admin|kasir')->name('laporan.export-pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->middleware('role:admin|kasir')->name('laporan.export-excel');

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