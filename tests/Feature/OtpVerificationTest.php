<?php

use App\Models\User;
use App\Models\OtpVerification;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed default roles and permissions
    $this->seed(RolePermissionSeeder::class);
});

test('otp verify screen requires verify session', function () {
    // Access verify screen without session should redirect to login
    $response = $this->get(route('otp.verify'));
    $response->assertRedirect(route('login'));
});

test('customer can verify phone with correct otp', function () {
    $user = User::factory()->create([
        'name' => 'Budi Customer',
        'email' => 'budi@gmail.com',
        'whatsapp' => '08123456789',
        'phone_verified_at' => null,
        'role' => 'pelanggan',
    ]);
    $user->assignRole('pelanggan');

    // Create active OTP verification code
    $otpRecord = OtpVerification::create([
        'user_id' => $user->id,
        'otp' => '123456',
        'expired_at' => now()->addMinutes(5),
        'attempts' => 0,
    ]);

    // Send post verification with verify session set
    $response = $this->withSession(['otp_user_id' => $user->id])
        ->post(route('otp.verify.submit'), [
            'otp' => '123456',
        ]);

    $response->assertRedirect('/marketplace');
    $this->assertAuthenticatedAs($user);

    $user->refresh();
    expect($user->phone_verified_at)->not->toBeNull();

    $otpRecord->refresh();
    expect($otpRecord->verified_at)->not->toBeNull();
});

test('otp verification fails and increments attempts with incorrect otp', function () {
    $user = User::factory()->create([
        'name' => 'Budi Customer',
        'email' => 'budi@gmail.com',
        'whatsapp' => '08123456789',
        'phone_verified_at' => null,
        'role' => 'pelanggan',
    ]);
    $user->assignRole('pelanggan');

    $otpRecord = OtpVerification::create([
        'user_id' => $user->id,
        'otp' => '123456',
        'expired_at' => now()->addMinutes(5),
        'attempts' => 0,
    ]);

    $response = $this->withSession(['otp_user_id' => $user->id])
        ->from(route('otp.verify'))
        ->post(route('otp.verify.submit'), [
            'otp' => '654321', // wrong OTP
        ]);

    $response->assertRedirect(route('otp.verify'));
    $response->assertSessionHas('error');
    $this->assertGuest();

    $otpRecord->refresh();
    expect($otpRecord->attempts)->toBe(1);
    expect($otpRecord->verified_at)->toBeNull();
});

test('otp verification blocks after 5 failed attempts', function () {
    $user = User::factory()->create([
        'name' => 'Budi Customer',
        'email' => 'budi@gmail.com',
        'whatsapp' => '08123456789',
        'phone_verified_at' => null,
        'role' => 'pelanggan',
    ]);
    $user->assignRole('pelanggan');

    $otpRecord = OtpVerification::create([
        'user_id' => $user->id,
        'otp' => '123456',
        'expired_at' => now()->addMinutes(5),
        'attempts' => 5, // reached limit
    ]);

    $response = $this->withSession(['otp_user_id' => $user->id])
        ->from(route('otp.verify'))
        ->post(route('otp.verify.submit'), [
            'otp' => '123456', // correct OTP, but blocked
        ]);

    $response->assertRedirect(route('otp.verify'));
    $response->assertSessionHas('error', 'Anda telah melebihi batas maksimal percobaan (5 kali). Silakan kirim ulang OTP baru.');
    $this->assertGuest();
});

test('otp resend is throttled within 60 seconds', function () {
    $user = User::factory()->create([
        'name' => 'Budi Customer',
        'email' => 'budi@gmail.com',
        'whatsapp' => '08123456789',
        'phone_verified_at' => null,
        'role' => 'pelanggan',
    ]);
    $user->assignRole('pelanggan');

    $otpRecord = OtpVerification::create([
        'user_id' => $user->id,
        'otp' => '123456',
        'expired_at' => now()->addMinutes(5),
        'attempts' => 0,
    ]);

    // Fast-forward or just check immediately since it was created now (0 seconds diff)
    $response = $this->withSession(['otp_user_id' => $user->id])
        ->from(route('otp.verify'))
        ->post(route('otp.resend'));

    $response->assertRedirect(route('otp.verify'));
    $response->assertSessionHas('error');
});

test('phone_verified middleware blocks unverified customers from checkout', function () {
    $user = User::factory()->create([
        'name' => 'Budi Customer',
        'email' => 'budi@gmail.com',
        'whatsapp' => '08123456789',
        'phone_verified_at' => null, // unverified
        'role' => 'pelanggan',
    ]);
    $user->assignRole('pelanggan');

    $response = $this->actingAs($user)->get(route('checkout.index'));

    // Should logout user and redirect to verify screen with error
    $response->assertRedirect(route('otp.verify'));
    $response->assertSessionHas('error', 'Nomor WhatsApp Anda belum terverifikasi. Silakan masukkan kode OTP yang dikirim.');
    $this->assertGuest();
});
