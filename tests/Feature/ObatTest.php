<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('admin can access obat index and see simplified toolbar', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    $response = $this
        ->actingAs($admin)
        ->get('/obat');

    $response->assertOk();
    
    // Check that we see the correct actions
    $response->assertSee('Template Excel');
    $response->assertSee('Import Data');
    $response->assertSee('Tambah Obat');

    // Check that we do NOT see export actions
    $response->assertDontSee('Export Excel');
    $response->assertDontSee('Export PDF');
});

test('admin can download template excel', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    $response = $this
        ->actingAs($admin)
        ->get('/obat/download-template');

    $response->assertOk();
    $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});

test('export routes return 404', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    // Attempting to access excel export route (which should be deleted)
    $responseExcel = $this
        ->actingAs($admin)
        ->get('/obat/export/excel');
    $responseExcel->assertStatus(404);

    // Attempting to access pdf export route (which should be deleted)
    $responsePdf = $this
        ->actingAs($admin)
        ->get('/obat/export/pdf');
    $responsePdf->assertStatus(404);
});

test('non-admin users cannot access obat routes', function () {
    $user = User::factory()->create(['role' => 'pelanggan']);
    $user->assignRole('pelanggan');

    $response = $this
        ->actingAs($user)
        ->get('/obat');

    $response->assertStatus(403);
});
