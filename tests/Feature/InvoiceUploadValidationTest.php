<?php

use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\RolePermissionSeeder::class);
});

test('customer can upload valid payment proof', function () {
    Http::fake([
        'api.fonnte.com/send' => Http::response(['status' => true], 200)
    ]);

    $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $user->assignRole('pelanggan');

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-VALID-0001',
        'user_id' => $user->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 10000,
        'nama_pelanggan' => 'Test Customer',
        'whatsapp' => '081234567890',
        'metode_pengambilan' => 'Ambil di Apotek',
        'ongkir' => 0,
        'subtotal' => 10000,
        'status' => 'Menunggu Pembayaran',
    ]);

    $fakeImage = UploadedFile::fake()->image('bukti.jpg', 600, 800);

    $response = $this->actingAs($user)
        ->from(route('marketplace.invoice', $transaksi->kode_transaksi))
        ->post(route('marketplace.invoice.upload-bukti', $transaksi->kode_transaksi), [
            'bukti_transfer' => $fakeImage
        ]);

    $response->assertRedirect(route('marketplace.invoice', $transaksi->kode_transaksi));
    $response->assertSessionHas('success', 'Bukti transfer berhasil diunggah! Menunggu verifikasi dari admin.');

    $transaksi->refresh();
    expect($transaksi->status)->toBe('Menunggu Verifikasi');
    expect($transaksi->bukti_transfer)->not->toBeNull();
});

test('customer upload fails for unsupported file formats', function ($extension) {
    $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $user->assignRole('pelanggan');

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-INVALID-0001',
        'user_id' => $user->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 10000,
        'nama_pelanggan' => 'Test Customer',
        'whatsapp' => '081234567890',
        'metode_pengambilan' => 'Ambil di Apotek',
        'ongkir' => 0,
        'subtotal' => 10000,
        'status' => 'Menunggu Pembayaran',
    ]);

    $fakeFile = UploadedFile::fake()->create("bukti.{$extension}", 100);

    $response = $this->actingAs($user)
        ->from(route('marketplace.invoice', $transaksi->kode_transaksi))
        ->post(route('marketplace.invoice.upload-bukti', $transaksi->kode_transaksi), [
            'bukti_transfer' => $fakeFile
        ]);

    $response->assertRedirect(route('marketplace.invoice', $transaksi->kode_transaksi));
    $response->assertSessionHasErrors([
        'bukti_transfer' => 'Format file harus berupa JPG, JPEG, atau PNG.'
    ]);

    $transaksi->refresh();
    expect($transaksi->status)->toBe('Menunggu Pembayaran');
    expect($transaksi->bukti_transfer)->toBeNull();
})->with(['pdf', 'docx', 'zip', 'exe']);

test('customer upload fails when file exceeds max size limit', function () {
    $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $user->assignRole('pelanggan');

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-INVALID-0002',
        'user_id' => $user->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 10000,
        'nama_pelanggan' => 'Test Customer',
        'whatsapp' => '081234567890',
        'metode_pengambilan' => 'Ambil di Apotek',
        'ongkir' => 0,
        'subtotal' => 10000,
        'status' => 'Menunggu Pembayaran',
    ]);

    $fakeLargeImage = UploadedFile::fake()->create('large.jpg', 6000);

    $response = $this->actingAs($user)
        ->from(route('marketplace.invoice', $transaksi->kode_transaksi))
        ->post(route('marketplace.invoice.upload-bukti', $transaksi->kode_transaksi), [
            'bukti_transfer' => $fakeLargeImage
        ]);

    $response->assertRedirect(route('marketplace.invoice', $transaksi->kode_transaksi));
    $response->assertSessionHasErrors([
        'bukti_transfer' => 'Ukuran gambar maksimal 5 MB.'
    ]);

    $transaksi->refresh();
    expect($transaksi->status)->toBe('Menunggu Pembayaran');
});

test('customer upload fails when no file is uploaded', function () {
    $user = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);
    $user->assignRole('pelanggan');

    $transaksi = Transaksi::create([
        'kode_transaksi' => 'TRX-INVALID-0003',
        'user_id' => $user->id,
        'tanggal_transaksi' => now(),
        'total_harga' => 10000,
        'nama_pelanggan' => 'Test Customer',
        'whatsapp' => '081234567890',
        'metode_pengambilan' => 'Ambil di Apotek',
        'ongkir' => 0,
        'subtotal' => 10000,
        'status' => 'Menunggu Pembayaran',
    ]);

    $response = $this->actingAs($user)
        ->from(route('marketplace.invoice', $transaksi->kode_transaksi))
        ->post(route('marketplace.invoice.upload-bukti', $transaksi->kode_transaksi), [
            'bukti_transfer' => null
        ]);

    $response->assertRedirect(route('marketplace.invoice', $transaksi->kode_transaksi));
    $response->assertSessionHasErrors([
        'bukti_transfer' => 'Bukti pembayaran wajib diunggah.'
    ]);

    $transaksi->refresh();
    expect($transaksi->status)->toBe('Menunggu Pembayaran');
});
