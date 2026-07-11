<?php

use App\Models\User;
use App\Models\Transaksi;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('admin can export sales report to pdf', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    Transaksi::create([
        'kode_transaksi' => 'TRX-' . strtoupper(uniqid()),
        'user_id' => $admin->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 10000,
        'bayar' => 15000,
        'kembalian' => 5000,
        'status' => 'Selesai',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/laporan/export-pdf');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('admin can export sales report with filters', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    $kasir = User::factory()->create(['role' => 'kasir']);
    $kasir->assignRole('kasir');

    Transaksi::create([
        'kode_transaksi' => 'TRX-MATCH',
        'user_id' => $kasir->id,
        'tanggal_transaksi' => '2026-07-10 10:00:00',
        'total_harga' => 10000,
        'bayar' => 15000,
        'kembalian' => 5000,
        'status' => 'Selesai',
    ]);

    Transaksi::create([
        'kode_transaksi' => 'TRX-MISMATCH',
        'user_id' => $admin->id,
        'tanggal_transaksi' => '2026-07-05 10:00:00',
        'total_harga' => 20000,
        'bayar' => 20000,
        'kembalian' => 0,
        'status' => 'Dibatalkan',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/laporan/export-pdf?start_date=2026-07-09&end_date=2026-07-11&status=Selesai&user_id=' . $kasir->id . '&jenis_transaksi=POS');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('admin can export sales report with many transactions', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    // Create 270 transactions
    $transactions = [];
    for ($i = 0; $i < 270; $i++) {
        $transactions[] = [
            'kode_transaksi' => 'TRX-' . $i . '-' . uniqid(),
            'user_id' => $admin->id,
            'tanggal_transaksi' => now()->subMinutes($i)->format('Y-m-d H:i:s'),
            'total_harga' => 10000,
            'bayar' => 10000,
            'kembalian' => 0,
            'status' => 'Selesai',
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }
    
    // Bulk insert for speed
    Transaksi::insert($transactions);

    $response = $this
        ->actingAs($admin)
        ->get('/laporan/export-pdf');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});
