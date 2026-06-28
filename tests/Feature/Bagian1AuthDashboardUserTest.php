<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed roles and permissions for Spatie and application default users
    $this->seed(RolePermissionSeeder::class);
});

/*
|--------------------------------------------------------------------------
| Authentication Tests (Login & Logout)
|--------------------------------------------------------------------------
*/

test('login screen can be rendered', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('admin is redirected to admin dashboard after login', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    $response = $this->post('/login', [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($admin);
    $response->assertRedirect('/dashboard');
});

test('apoteker is redirected to apoteker dashboard after login', function () {
    $apoteker = User::factory()->create(['role' => 'apoteker']);
    $apoteker->assignRole('apoteker');

    $response = $this->post('/login', [
        'email' => $apoteker->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($apoteker);
    $response->assertRedirect('/apoteker/dashboard');
});

test('kasir is redirected to kasir dashboard after login', function () {
    $kasir = User::factory()->create(['role' => 'kasir']);
    $kasir->assignRole('kasir');

    $response = $this->post('/login', [
        'email' => $kasir->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($kasir);
    $response->assertRedirect('/kasir/dashboard');
});

test('pelanggan is redirected to marketplace after login', function () {
    $pelanggan = User::factory()->create([
        'role' => 'pelanggan',
        'phone_verified_at' => now(),
    ]);
    $pelanggan->assignRole('pelanggan');

    $response = $this->post('/login', [
        'email' => $pelanggan->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($pelanggan);
    $response->assertRedirect('/marketplace');
});

test('login validation fails with wrong password', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('authenticated user can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

/*
|--------------------------------------------------------------------------
| Dashboard & Authorization Tests
|--------------------------------------------------------------------------
*/

test('guests are redirected to login from dashboards', function () {
    $this->get('/dashboard')->assertRedirect('/login');
    $this->get('/kasir/dashboard')->assertRedirect('/login');
    $this->get('/apoteker/dashboard')->assertRedirect('/login');
});

test('users without permissions cannot access admin dashboard', function () {
    $pelanggan = User::factory()->create([
        'role' => 'pelanggan',
        'phone_verified_at' => now(),
    ]);
    $pelanggan->assignRole('pelanggan');

    $response = $this->actingAs($pelanggan)->get('/dashboard');
    $response->assertStatus(403);
});

/*
|--------------------------------------------------------------------------
| User Management Tests (CRUD & Safety Checks)
|--------------------------------------------------------------------------
*/

test('admin can access user list, create, edit, store, update, and delete users', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    // 1. Read / Index
    $response = $this->actingAs($admin)->get('/user');
    $response->assertStatus(200);
    $response->assertSee($admin->name);

    // 2. Render Create Page
    $response = $this->actingAs($admin)->get('/user/create');
    $response->assertStatus(200);

    // 3. Store new User
    $newUserData = [
        'name' => 'New Staff Member',
        'email' => 'newstaff@mekar.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'kasir',
    ];

    $response = $this->actingAs($admin)->post('/user', $newUserData);
    $response->assertRedirect('/user');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'email' => 'newstaff@mekar.com',
        'role' => 'kasir',
    ]);

    $createdUser = User::where('email', 'newstaff@mekar.com')->first();
    expect($createdUser->hasRole('kasir'))->toBeTrue();

    // 4. Render Edit Page
    $response = $this->actingAs($admin)->get("/user/{$createdUser->id}/edit");
    $response->assertStatus(200);

    // 5. Update User
    $updateData = [
        'name' => 'Updated Staff Member',
        'email' => 'newstaff@mekar.com',
        'role' => 'apoteker',
    ];
    $response = $this->actingAs($admin)->put("/user/{$createdUser->id}", $updateData);
    $response->assertRedirect('/user');

    $createdUser->refresh();
    expect($createdUser->name)->toBe('Updated Staff Member');
    expect($createdUser->hasRole('apoteker'))->toBeTrue();
    expect($createdUser->hasRole('kasir'))->toBeFalse();

    // 6. Delete User
    $response = $this->actingAs($admin)->delete("/user/{$createdUser->id}");
    $response->assertRedirect('/user');
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('users', ['id' => $createdUser->id]);
});

test('admin cannot delete themselves', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->delete("/user/{$admin->id}");
    $response->assertRedirect('/user');
    $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri');

    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

test('non-admin users cannot access user management', function () {
    $kasir = User::factory()->create(['role' => 'kasir']);
    $kasir->assignRole('kasir');

    $this->actingAs($kasir)->get('/user')->assertStatus(403);
    $this->actingAs($kasir)->get('/user/create')->assertStatus(403);
    $this->actingAs($kasir)->post('/user', [])->assertStatus(403);
});
