<?php

use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Transaksi;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('admin can access payment methods list and perform CRUD', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    // Index
    $response = $this
        ->actingAs($admin)
        ->get('/admin/payment-methods');
    $response->assertOk();
    $response->assertSee('BCA Transfer');

    // Create Page
    $response = $this
        ->actingAs($admin)
        ->get('/admin/payment-methods/create');
    $response->assertOk();

    // Store QRIS method
    $response = $this
        ->actingAs($admin)
        ->post('/admin/payment-methods', [
            'type' => 'qris',
            'name' => 'Gopay QRIS',
            'is_active' => 1,
        ]);
    $response->assertRedirect('/admin/payment-methods');
    $this->assertDatabaseHas('payment_methods', ['name' => 'Gopay QRIS', 'type' => 'qris']);

    // Edit Page
    $method = PaymentMethod::where('name', 'Gopay QRIS')->first();
    $response = $this
        ->actingAs($admin)
        ->get("/admin/payment-methods/{$method->id}/edit");
    $response->assertOk();

    // Update E-wallet method
    $response = $this
        ->actingAs($admin)
        ->put("/admin/payment-methods/{$method->id}", [
            'type' => 'e_wallet',
            'name' => 'DANA E-Wallet',
            'account_number' => '081234567890',
            'account_owner' => 'John Doe',
        ]);
    $response->assertRedirect('/admin/payment-methods');
    $this->assertDatabaseHas('payment_methods', ['name' => 'DANA E-Wallet', 'type' => 'e_wallet']);

    // Delete
    $response = $this
        ->actingAs($admin)
        ->delete("/admin/payment-methods/{$method->id}");
    $response->assertRedirect('/admin/payment-methods');
    $this->assertDatabaseMissing('payment_methods', ['id' => $method->id]);
});

test('only active payment methods are displayed on invoice', function () {
    $pelanggan = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $pelanggan->assignRole('pelanggan');

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX' . time(),
        'user_id' => $pelanggan->id,
        'tanggal_transaksi' => now(),
        'nama_pelanggan' => 'Pelanggan Test',
        'whatsapp' => '628123456789',
        'metode_pengambilan' => 'Ambil di Apotek',
        'total_harga' => 100000,
        'subtotal' => 100000,
        'ongkir' => 0,
        'bayar' => 0,
        'kembalian' => 0,
        'status' => 'Menunggu Pembayaran',
    ]);

    PaymentMethod::query()->delete();
    $activeMethod = PaymentMethod::create([
        'type' => 'bank_transfer',
        'name' => 'Mandiri Transfer',
        'account_number' => '987654321',
        'account_owner' => 'Mekar Pharmacy Mandiri',
        'is_active' => true,
    ]);

    $inactiveMethod = PaymentMethod::create([
        'type' => 'e_wallet',
        'name' => 'OVO E-Wallet',
        'account_number' => '08999999999',
        'account_owner' => 'Mekar Pharmacy OVO',
        'is_active' => false,
    ]);

    $response = $this
        ->actingAs($pelanggan)
        ->get("/invoice/{$transaksi->kode_transaksi}");

    $response->assertOk();
    $response->assertSee('Mandiri Transfer');
    $response->assertSee('987654321');
    $response->assertDontSee('OVO E-Wallet');
});
