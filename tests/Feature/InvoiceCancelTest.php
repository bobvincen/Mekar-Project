<?php

use App\Models\User;
use App\Models\Transaksi;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('customer can cancel their own order when status is Menunggu Pembayaran', function () {
    $pelanggan = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $pelanggan->assignRole('pelanggan');

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-' . date('Ymd') . '-9999',
        'user_id' => $pelanggan->id,
        'tanggal_transaksi' => now(),
        'nama_pelanggan' => $pelanggan->name,
        'whatsapp' => $pelanggan->whatsapp,
        'metode_pengambilan' => 'Ambil di Apotek',
        'total_harga' => 150000,
        'subtotal' => 150000,
        'ongkir' => 0,
        'bayar' => 0,
        'kembalian' => 0,
        'status' => 'Menunggu Pembayaran',
    ]);

    $response = $this
        ->actingAs($pelanggan)
        ->post("/invoice/{$transaksi->kode_transaksi}/cancel");

    $response->assertRedirect("/invoice/{$transaksi->kode_transaksi}");
    $response->assertSessionHas('success', 'Pesanan berhasil dibatalkan.');

    $this->assertDatabaseHas('transaksis', [
        'id' => $transaksi->id,
        'status' => 'Dibatalkan',
    ]);
});

test('customer cannot cancel their order when status is NOT Menunggu Pembayaran', function () {
    $pelanggan = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $pelanggan->assignRole('pelanggan');

    // Status is Menunggu Verifikasi
    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-' . date('Ymd') . '-9998',
        'user_id' => $pelanggan->id,
        'tanggal_transaksi' => now(),
        'nama_pelanggan' => $pelanggan->name,
        'whatsapp' => $pelanggan->whatsapp,
        'metode_pengambilan' => 'Ambil di Apotek',
        'total_harga' => 150000,
        'subtotal' => 150000,
        'ongkir' => 0,
        'bayar' => 0,
        'kembalian' => 0,
        'status' => 'Menunggu Verifikasi',
    ]);

    $response = $this
        ->actingAs($pelanggan)
        ->post("/invoice/{$transaksi->kode_transaksi}/cancel");

    $response->assertStatus(403);
    
    // Status must remain unchanged
    $this->assertDatabaseHas('transaksis', [
        'id' => $transaksi->id,
        'status' => 'Menunggu Verifikasi',
    ]);
});

test('customer cannot cancel another customer\'s order', function () {
    $pelanggan1 = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $pelanggan1->assignRole('pelanggan');

    $pelanggan2 = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $pelanggan2->assignRole('pelanggan');

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-' . date('Ymd') . '-9997',
        'user_id' => $pelanggan1->id,
        'tanggal_transaksi' => now(),
        'nama_pelanggan' => $pelanggan1->name,
        'whatsapp' => $pelanggan1->whatsapp,
        'metode_pengambilan' => 'Ambil di Apotek',
        'total_harga' => 150000,
        'subtotal' => 150000,
        'ongkir' => 0,
        'bayar' => 0,
        'kembalian' => 0,
        'status' => 'Menunggu Pembayaran',
    ]);

    // Pelanggan 2 attempts to cancel Pelanggan 1's transaction
    $response = $this
        ->actingAs($pelanggan2)
        ->post("/invoice/{$transaksi->kode_transaksi}/cancel");

    $response->assertStatus(404); // returns 404 because of firstOrFail search restricted by user_id
    
    $this->assertDatabaseHas('transaksis', [
        'id' => $transaksi->id,
        'status' => 'Menunggu Pembayaran',
    ]);
});
