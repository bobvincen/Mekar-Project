<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use Faker\Factory as Faker;

class PelangganSeeder extends Seeder
{
    /**
     * Menjalankan proses seeding untuk tabel pelanggan.
     * 
     * Fungsi ini akan membuat beberapa data pelanggan awal secara statis
     * dan juga meng-generate 15 data pelanggan acak tambahan menggunakan library Faker,
     * lalu menyimpannya ke dalam database.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $pelanggans = [
            [
                'nama_pelanggan' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat',
            ],
            [
                'nama_pelanggan' => 'Siti Aminah',
                'no_hp' => '081398765432',
                'alamat' => 'Jl. Mawar No. 45, Bandung',
            ],
            [
                'nama_pelanggan' => 'Andi Wijaya',
                'no_hp' => '085711223344',
                'alamat' => 'Jl. Sudirman No. 120, Surabaya',
            ],
            [
                'nama_pelanggan' => 'Dewi Lestari',
                'no_hp' => '089988776655',
                'alamat' => 'Jl. Melati No. 8, Yogyakarta',
            ],
            [
                'nama_pelanggan' => 'Rian Hidayat',
                'no_hp' => '082155667788',
                'alamat' => 'Jl. Diponegoro No. 3, Semarang',
            ]
        ];

        foreach ($pelanggans as $p) {
            Pelanggan::updateOrCreate(
                ['no_hp' => $p['no_hp']],
                $p
            );
        }

        // Generate 15 more random customers
        for ($i = 0; $i < 15; $i++) {
            Pelanggan::create([
                'nama_pelanggan' => $faker->name,
                'no_hp' => '08' . $faker->numerify('##########'),
                'alamat' => $faker->address,
            ]);
        }
    }
}
