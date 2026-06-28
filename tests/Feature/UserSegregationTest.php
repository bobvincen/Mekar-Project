<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('user management index only shows staff and excludes customers', function () {
    $admin = User::factory()->create(['role' => 'admin', 'phone_verified_at' => now()]);
    $admin->assignRole('admin');

    $kasir = User::factory()->create(['role' => 'kasir', 'phone_verified_at' => now()]);
    $kasir->assignRole('kasir');

    $customer = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $customer->assignRole('pelanggan');

    $response = $this->actingAs($admin)->get(route('user.index'));

    $response->assertStatus(200);
    $response->assertSee($admin->name);
    $response->assertSee($kasir->name);
    $response->assertDontSee($customer->name);
});

test('customer management index only shows customers and excludes staff', function () {
    $admin = User::factory()->create(['role' => 'admin', 'phone_verified_at' => now()]);
    $admin->assignRole('admin');

    $kasir = User::factory()->create(['role' => 'kasir', 'phone_verified_at' => now()]);
    $kasir->assignRole('kasir');

    $customer = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $customer->assignRole('pelanggan');

    $response = $this->actingAs($admin)->get(route('customer.index'));

    $response->assertStatus(200);
    $response->assertSee($customer->name);
    $response->assertDontSee($kasir->name);
});

test('admin can create customer and customer gets auto verified', function () {
    $admin = User::factory()->create(['role' => 'admin', 'phone_verified_at' => now()]);
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->post(route('customer.store'), [
        'name' => 'John Customer',
        'email' => 'john@gmail.com',
        'whatsapp' => '081299998888',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('customer.index'));
    $this->assertDatabaseHas('users', [
        'email' => 'john@gmail.com',
        'role' => 'pelanggan',
    ]);

    $customer = User::where('email', 'john@gmail.com')->first();
    expect($customer->hasRole('pelanggan'))->toBeTrue();
    expect($customer->phone_verified_at)->not->toBeNull(); // Auto-verified!
});
