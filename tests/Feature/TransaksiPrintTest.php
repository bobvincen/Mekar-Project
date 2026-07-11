<?php

use App\Models\User;
use App\Models\Transaksi;
use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\DetailTransaksi;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('admin can print pos receipt to pdf', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    $kategori = Kategori::create(['nama_kategori' => 'Obat Bebas']);
    $supplier = Supplier::create([
        'nama_supplier' => 'Biofarma',
        'telepon' => '0812345678',
        'alamat' => 'Bandung',
    ]);

    $obat = Obat::factory()->create([
        'kategori_id' => $kategori->id,
        'supplier_id' => $supplier->id,
        'nama_obat' => 'Paracetamol 500mg',
        'harga_jual' => 5000,
        'stok' => 50,
    ]);

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-' . strtoupper(uniqid()),
        'user_id' => $admin->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 10000,
        'bayar' => 15000,
        'kembalian' => 5000,
        'status' => 'Selesai',
    ]);

    DetailTransaksi::create([
        'transaksi_id' => $transaksi->id,
        'obat_id' => $obat->id,
        'jumlah' => 2,
        'harga' => 5000,
        'subtotal' => 10000,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get("/transaksi/{$transaksi->id}/print");

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});
