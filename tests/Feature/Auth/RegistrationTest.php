<?php

use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register when OTP sending is successful', function () {
    Http::fake([
        'api.fonnte.com/send' => Http::response([
            'status' => true,
            'reason' => 'success'
        ], 200)
    ]);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'whatsapp' => '08123456789',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('otp.verify'));

    $user = \App\Models\User::where('email', 'test@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->phone_verified_at)->toBeNull();

    $otpRecord = \App\Models\OtpVerification::where('user_id', $user->id)->first();
    expect($otpRecord)->not->toBeNull();
});

test('registration fails when OTP sending fails', function () {
    Http::fake([
        'api.fonnte.com/send' => Http::response([
            'status' => false,
            'reason' => 'device disconnected'
        ], 400)
    ]);

    $response = $this->from('/register')->post('/register', [
        'name' => 'Test User Failed',
        'email' => 'test_failed@example.com',
        'whatsapp' => '08123456789',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors(['whatsapp']);

    $user = \App\Models\User::where('email', 'test_failed@example.com')->first();
    expect($user)->toBeNull();
});
