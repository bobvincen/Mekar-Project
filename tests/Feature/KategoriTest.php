<?php

use App\Models\User;
use App\Models\Kategori;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('admin can access kategori index and see paginated list', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    // Create 15 categories
    for ($i = 1; $i <= 15; $i++) {
        Kategori::create(['nama_kategori' => 'Golongan Kategori ' . $i]);
    }

    $response = $this
        ->actingAs($admin)
        ->get('/kategori');

    $response->assertOk();
    $response->assertSee('Daftar Golongan Kategori');
    $response->assertSee('Menampilkan');
    $response->assertSee('kategori');
});

test('admin can search categories by name', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    Kategori::create(['nama_kategori' => 'Paracetamol']);
    Kategori::create(['nama_kategori' => 'Amoxicillin']);

    $response = $this
        ->actingAs($admin)
        ->get('/kategori?search=Paracetamol');

    $response->assertOk();
    $response->assertSee('Paracetamol');
    $response->assertDontSee('Amoxicillin');
});

test('non-admin users without permission cannot access kategori index', function () {
    $user = User::factory()->create(['role' => 'pelanggan']);
    $user->assignRole('pelanggan');

    $response = $this
        ->actingAs($user)
        ->get('/kategori');

    $response->assertStatus(403);
});
