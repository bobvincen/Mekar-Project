<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Menjalankan seluruh seeder database secara berurutan.
     * 
     * Fungsi ini bertugas memanggil seeder lain untuk mengisi database
     * dengan data awal (dummy data) yang dibutuhkan oleh aplikasi.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RolePermissionSeeder::class,
            MarketplaceSeeder::class,
            PelangganSeeder::class,
            ResepDokterSeeder::class,
            TransaksiSeeder::class,
        ]);
    }
}
