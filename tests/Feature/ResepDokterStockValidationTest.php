<?php

use App\Models\User;
use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\ResepDokter;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('prescription processing fails when proposed quantity exceeds stock', function () {
    $apoteker = User::factory()->create(['role' => 'apoteker']);
    $apoteker->assignRole('apoteker');

    $customer = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);

    $kategori = Kategori::create(['nama_kategori' => 'Obat Bebas']);
    $supplier = Supplier::create([
        'nama_supplier' => 'Biofarma',
        'telepon' => '0812345678',
        'alamat' => 'Bandung',
    ]);

    $obat = Obat::factory()->create([
        'kategori_id' => $kategori->id,
        'supplier_id' => $supplier->id,
        'stok' => 5,
    ]);

    $resep = ResepDokter::create([
        'user_id' => $customer->id,
        'nama' => $customer->name,
        'whatsapp' => $customer->whatsapp ?? '081234567890',
        'catatan' => 'Resep mual',
        'foto_resep' => 'prescriptions/test.jpg',
        'status' => 'menunggu_verifikasi',
    ]);

    $response = $this->actingAs($apoteker)
        ->from(route('resep.proses', $resep->id))
        ->post(route('resep.proses.submit', $resep->id), [
            'items' => [
                [
                    'obat_id' => $obat->id,
                    'qty' => 10, // exceeds stock of 5
                    'status' => 'tersedia',
                    'obat_pengganti_id' => null,
                    'catatan' => 'Dosis penuh',
                ]
            ],
            'catatan_verifikasi' => 'Cek kembali dosis obat Anda.',
        ]);

    $response->assertRedirect(route('resep.proses', $resep->id));
    $response->assertSessionHasErrors('items.0.qty');

    // Resep status should not be changed to 'menunggu_persetujuan' (it might stay 'sedang_diproses' since it was opened)
    $resep->refresh();
    $this->assertNotEquals('menunggu_persetujuan', $resep->status);
});

test('prescription processing succeeds when proposed quantity is within stock', function () {
    $apoteker = User::factory()->create(['role' => 'apoteker']);
    $apoteker->assignRole('apoteker');

    $customer = User::factory()->create(['role' => 'pelanggan', 'phone_verified_at' => now()]);

    $kategori = Kategori::create(['nama_kategori' => 'Obat Bebas']);
    $supplier = Supplier::create([
        'nama_supplier' => 'Biofarma',
        'telepon' => '0812345678',
        'alamat' => 'Bandung',
    ]);

    $obat = Obat::factory()->create([
        'kategori_id' => $kategori->id,
        'supplier_id' => $supplier->id,
        'stok' => 15,
    ]);

    $resep = ResepDokter::create([
        'user_id' => $customer->id,
        'nama' => $customer->name,
        'whatsapp' => $customer->whatsapp ?? '081234567890',
        'catatan' => 'Resep pusing',
        'foto_resep' => 'prescriptions/test2.jpg',
        'status' => 'menunggu_verifikasi',
    ]);

    $response = $this->actingAs($apoteker)
        ->post(route('resep.proses.submit', $resep->id), [
            'items' => [
                [
                    'obat_id' => $obat->id,
                    'qty' => 5, // within stock of 15
                    'status' => 'tersedia',
                    'obat_pengganti_id' => null,
                    'catatan' => 'Minum 3x sehari',
                ]
            ],
            'catatan_verifikasi' => 'Segera tebus resep Anda.',
        ]);

    $response->assertSessionHasNoErrors();
    $resep->refresh();
    $this->assertEquals('menunggu_persetujuan', $resep->status);
});
