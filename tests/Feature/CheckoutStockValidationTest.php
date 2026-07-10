<?php

use App\Models\User;
use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Supplier;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('checkout fails when stock is insufficient', function () {
    $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $user->assignRole('pelanggan');

    $kategori = Kategori::create(['nama_kategori' => 'Obat Bebas']);
    $supplier = Supplier::create([
        'nama_supplier' => 'Biofarma',
        'telepon' => '0812345678',
        'alamat' => 'Bandung',
    ]);
    
    $obat = Obat::factory()->create([
        'kategori_id' => $kategori->id,
        'supplier_id' => $supplier->id,
        'stok' => 5, // only 5 available
    ]);

    // Put 10 items in cart (which exceeds 5 stock)
    $cart = [
        $obat->id => [
            'id' => $obat->id,
            'name' => $obat->nama_obat,
            'category' => 'Obat Bebas',
            'price' => (float) $obat->harga_jual,
            'qty' => 10,
            'image' => '/premium_medicine_box.png',
            'subtotal' => (float) $obat->harga_jual * 10,
        ]
    ];

    $response = $this->actingAs($user)
        ->withSession(['checkout_cart' => $cart])
        ->post(route('checkout.process'), [
            'metode' => 'Ambil Sendiri',
            'ongkir' => 0,
            'subtotal' => (float) $obat->harga_jual * 10,
            'total' => (float) $obat->harga_jual * 10,
        ]);

    $response->assertStatus(422);
    $response->assertJsonFragment([
        'success' => false,
    ]);
    
    // Assert no transaction was created
    $this->assertDatabaseMissing('transaksis', [
        'user_id' => $user->id,
    ]);
});

test('checkout succeeds when stock is sufficient', function () {
    $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $user->assignRole('pelanggan');

    $kategori = Kategori::create(['nama_kategori' => 'Obat Bebas']);
    $supplier = Supplier::create([
        'nama_supplier' => 'Biofarma',
        'telepon' => '0812345678',
        'alamat' => 'Bandung',
    ]);

    $obat = Obat::factory()->create([
        'kategori_id' => $kategori->id,
        'supplier_id' => $supplier->id,
        'stok' => 20,
    ]);

    $cart = [
        $obat->id => [
            'id' => $obat->id,
            'name' => $obat->nama_obat,
            'category' => 'Obat Bebas',
            'price' => (float) $obat->harga_jual,
            'qty' => 5,
            'image' => '/premium_medicine_box.png',
            'subtotal' => (float) $obat->harga_jual * 5,
        ]
    ];

    $response = $this->actingAs($user)
        ->withSession(['checkout_cart' => $cart])
        ->post(route('checkout.process'), [
            'metode' => 'Ambil Sendiri',
            'ongkir' => 0,
            'subtotal' => (float) $obat->harga_jual * 5,
            'total' => (float) $obat->harga_jual * 5,
        ]);

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'success' => true,
    ]);
    
    $this->assertDatabaseHas('transaksis', [
        'user_id' => $user->id,
        'total_harga' => (float) $obat->harga_jual * 5,
    ]);
});
