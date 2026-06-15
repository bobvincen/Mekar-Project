<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResepDokter;
use Faker\Factory as Faker;

class ResepDokterSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $reseps = [
            [
                'nama' => 'Ahmad Fauzi',
                'whatsapp' => '081234567891',
                'catatan' => 'Mohon obat demam diganti yang sirup jika tablet kosong.',
                'foto_resep' => 'reseps/dummy_resep_1.jpg',
            ],
            [
                'nama' => 'Siti Rahmawati',
                'whatsapp' => '082345678901',
                'catatan' => 'Resep dari dokter spesialis THT. Mohon segera diproses.',
                'foto_resep' => 'reseps/dummy_resep_2.jpg',
            ],
            [
                'nama' => 'Bambang Utomo',
                'whatsapp' => '085678901234',
                'catatan' => 'Obat untuk asam lambung kronis.',
                'foto_resep' => 'reseps/dummy_resep_3.jpg',
            ],
            [
                'nama' => 'Lani Marlina',
                'whatsapp' => '089876543210',
                'catatan' => 'Apakah obat batuknya aman untuk ibu menyusui?',
                'foto_resep' => 'reseps/dummy_resep_4.jpg',
            ],
            [
                'nama' => 'Hendra Wijaya',
                'whatsapp' => '081122334455',
                'catatan' => 'Obat antibiotik harus habis.',
                'foto_resep' => 'reseps/dummy_resep_5.jpg',
            ]
        ];

        foreach ($reseps as $resep) {
            ResepDokter::create($resep);
        }

        // Add 5 more random ones
        for ($i = 0; $i < 5; $i++) {
            ResepDokter::create([
                'nama' => $faker->name,
                'whatsapp' => '08' . $faker->numerify('##########'),
                'catatan' => $faker->optional(0.8)->sentence(8),
                'foto_resep' => 'reseps/dummy_resep_' . rand(1, 5) . '.jpg',
            ]);
        }
    }
}
