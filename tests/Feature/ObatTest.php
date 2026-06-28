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

test('admin can import medications and create or update suppliers from preview data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $admin->assignRole('admin');

    // Seed session data for import
    $tempImportData = [
        [
            'nama_obat' => 'Paracetamol 500mg',
            'kategori' => 'Obat Demam',
            'supplier' => 'PT Kimia Baru',
            'stok' => 100,
            'harga_jual' => 5000,
            'tanggal_kadaluarsa' => '2027-01-01',
            'gambar' => null,
            'gambar_temp_path' => null
        ]
    ];

    // Post to import route with new supplier data
    $response = $this
        ->actingAs($admin)
        ->withSession([
            'temp_import_data' => $tempImportData,
            'temp_import_dir' => null
        ])
        ->post('/obat/import', [
            'suppliers' => [
                [
                    'nama_supplier' => 'PT Kimia Baru',
                    'alamat' => 'Jl. Baru No. 12',
                    'telepon' => '081299998888',
                    'email' => 'contact@kimiabaru.com',
                    'kontak_pic' => 'Andi',
                    'kota' => 'Jakarta',
                    'keterangan' => 'Distributor'
                ]
            ]
        ]);

    $response->assertRedirect('/obat');
    
    // Check that supplier was created
    $this->assertDatabaseHas('suppliers', [
        'nama_supplier' => 'PT Kimia Baru',
        'alamat' => 'Jl. Baru No. 12',
        'telepon' => '081299998888',
        'email' => 'contact@kimiabaru.com',
        'status' => 'Lengkap'
    ]);

    // Check that medication was created
    $this->assertDatabaseHas('obats', [
        'nama_obat' => 'Paracetamol 500mg',
        'stok' => 100,
        'harga_jual' => 5000,
    ]);
});
