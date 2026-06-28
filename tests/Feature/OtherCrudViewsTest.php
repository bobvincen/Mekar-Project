<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('admin can access all CRUD index pages without errors', function (string $url, string $textToSee) {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    $response = $this
        ->actingAs($admin)
        ->get($url);

    $response->assertOk();
    $response->assertSee($textToSee);
})->with([
    ['/supplier', 'Supplier'],
    ['/obat', 'Obat'],
    ['/user', 'User'],
    ['/customer', 'Pelanggan'],
    ['/role', 'Role'],
    ['/permission', 'Permission'],
]);
