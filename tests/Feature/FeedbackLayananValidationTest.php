<?php

use App\Models\User;
use App\Models\Transaksi;
use App\Models\FeedbackLayanan;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('guest can submit feedback for a transaction', function () {
    $user = User::factory()->create(['role' => 'pelanggan']);
    
    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-1234',
        'user_id' => $user->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 50000,
        'status' => 'Selesai',
    ]);

    $response = $this->postJson(route('feedback.store'), [
        'rating' => 5,
        'komentar' => 'Sangat memuaskan sekali pelayanannya.',
        'transaksi_id' => $transaksi->id,
    ]);

    $response->assertStatus(200);
    $response->assertJsonFragment(['success' => true]);

    $this->assertDatabaseHas('feedback_layanans', [
        'transaksi_id' => $transaksi->id,
        'rating' => 5,
    ]);
});

test('user cannot submit feedback for another user transaction', function () {
    $user1 = User::factory()->create(['role' => 'pelanggan']);
    $user2 = User::factory()->create(['role' => 'pelanggan']);

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-5678',
        'user_id' => $user1->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 75000,
        'status' => 'Selesai',
    ]);

    $response = $this->actingAs($user2)->postJson(route('feedback.store'), [
        'rating' => 4,
        'komentar' => 'Pelayanan ramah dan cepat.',
        'transaksi_id' => $transaksi->id,
    ]);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('feedback_layanans', [
        'transaksi_id' => $transaksi->id,
    ]);
});

test('user cannot submit feedback for uncompleted transaction', function () {
    $user = User::factory()->create(['role' => 'pelanggan']);

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-9999',
        'user_id' => $user->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 100000,
        'status' => 'Menunggu Pembayaran',
    ]);

    $response = $this->actingAs($user)->postJson(route('feedback.store'), [
        'rating' => 3,
        'komentar' => 'Sedang menunggu obat datang.',
        'transaksi_id' => $transaksi->id,
    ]);

    $response->assertStatus(400);
    $this->assertDatabaseMissing('feedback_layanans', [
        'transaksi_id' => $transaksi->id,
    ]);
});

test('user cannot submit duplicate feedback for same transaction', function () {
    $user = User::factory()->create(['role' => 'pelanggan']);

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-7777',
        'user_id' => $user->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 20000,
        'status' => 'Selesai',
    ]);

    // Submit first feedback
    FeedbackLayanan::create([
        'transaksi_id' => $transaksi->id,
        'user_id' => $user->id,
        'rating' => 5,
        'komentar' => 'Sangat luar biasa.',
    ]);

    // Submit second feedback via route
    $response = $this->actingAs($user)->postJson(route('feedback.store'), [
        'rating' => 4,
        'komentar' => 'Mencoba kirim ulasan kedua.',
        'transaksi_id' => $transaksi->id,
    ]);

    $response->assertStatus(422);
    $this->assertEquals(1, FeedbackLayanan::where('transaksi_id', $transaksi->id)->count());
});
