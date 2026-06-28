<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Obat;
use Faker\Factory as Faker;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Buat Kategori
        $kategoriNames = [
            'Obat Demam', 'Obat Batuk', 'Obat Flu', 'Obat Sakit Kepala', 
            'Vitamin & Suplemen', 'Obat Lambung', 'Obat Alergi', 'Obat Diare', 
            'Obat Kulit', 'Obat Anak', 'Alat Kesehatan', 'Herbal'
        ];
        
        $kategoriMap = [];
        foreach ($kategoriNames as $name) {
            $kategoriMap[$name] = Kategori::firstOrCreate(['nama_kategori' => $name])->id;
        }

        $suppliers = [];
        for ($i = 1; $i <= 5; $i++) {
            $companyName = 'PT Pharma ' . $faker->companySuffix . ' ' . $i;
            $suppliers[] = Supplier::firstOrCreate([
                'nama_supplier' => $companyName,
            ], [
                'alamat' => $faker->address,
                'telepon' => $faker->phoneNumber,
                'email' => $faker->unique()->companyEmail,
                'status' => 'Lengkap',
            ])->id;
        }

        // 3. Data Produk Realistis
        $produkList = [
            // Obat Demam
            ['nama' => 'Paracetamol 500mg', 'kat' => 'Obat Demam'],
            ['nama' => 'Panadol Biru 500mg', 'kat' => 'Obat Demam'],
            ['nama' => 'Sanmol Tablet', 'kat' => 'Obat Demam'],
            ['nama' => 'Sumagesic 600mg', 'kat' => 'Obat Demam'],
            ['nama' => 'Dumin 500mg', 'kat' => 'Obat Demam'],
            ['nama' => 'Biogesic 500mg', 'kat' => 'Obat Demam'],
            ['nama' => 'Tempra Syrup', 'kat' => 'Obat Demam'],
            ['nama' => 'Proris Ibuprofen', 'kat' => 'Obat Demam'],
            
            // Obat Sakit Kepala
            ['nama' => 'Bodrex Extra', 'kat' => 'Obat Sakit Kepala'],
            ['nama' => 'Panadol Merah', 'kat' => 'Obat Sakit Kepala'],
            ['nama' => 'Oskadon', 'kat' => 'Obat Sakit Kepala'],
            ['nama' => 'Paramex', 'kat' => 'Obat Sakit Kepala'],
            ['nama' => 'Neuralgin RX', 'kat' => 'Obat Sakit Kepala'],
            ['nama' => 'Feminax', 'kat' => 'Obat Sakit Kepala'],
            ['nama' => 'Saridon', 'kat' => 'Obat Sakit Kepala'],
            ['nama' => 'Bintang Toedjoe', 'kat' => 'Obat Sakit Kepala'],

            // Obat Flu
            ['nama' => 'Mixagrip Flu', 'kat' => 'Obat Flu'],
            ['nama' => 'Decolgen', 'kat' => 'Obat Flu'],
            ['nama' => 'Procold', 'kat' => 'Obat Flu'],
            ['nama' => 'Ultraflu', 'kat' => 'Obat Flu'],
            ['nama' => 'Neozep Forte', 'kat' => 'Obat Flu'],
            ['nama' => 'Alpara Tablet', 'kat' => 'Obat Flu'],
            ['nama' => 'Flucadex', 'kat' => 'Obat Flu'],
            ['nama' => 'Tolak Angin Flu', 'kat' => 'Obat Flu'],

            // Obat Batuk
            ['nama' => 'OBH Combi', 'kat' => 'Obat Batuk'],
            ['nama' => 'Woods Syrup Peppermint', 'kat' => 'Obat Batuk'],
            ['nama' => 'Komix Herbal', 'kat' => 'Obat Batuk'],
            ['nama' => 'Siladex Mucolytic', 'kat' => 'Obat Batuk'],
            ['nama' => 'Bisolvon Extra', 'kat' => 'Obat Batuk'],
            ['nama' => 'Vicks Formula 44', 'kat' => 'Obat Batuk'],
            ['nama' => 'Actifed Plus', 'kat' => 'Obat Batuk'],
            ['nama' => 'Konidin', 'kat' => 'Obat Batuk'],

            // Vitamin & Suplemen
            ['nama' => 'Enervon C', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Blackmores Vitamin C 500mg', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Vitacimin', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Imboost Force', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Holisticare Ester C', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Redoxon Double Action', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Pharmaton Formula', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Sangobion', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Natur-E 100 IU', 'kat' => 'Vitamin & Suplemen'],
            ['nama' => 'Stimuno Forte', 'kat' => 'Vitamin & Suplemen'],

            // Obat Lambung
            ['nama' => 'Promag', 'kat' => 'Obat Lambung'],
            ['nama' => 'Mylanta', 'kat' => 'Obat Lambung'],
            ['nama' => 'Polysilane', 'kat' => 'Obat Lambung'],
            ['nama' => 'Plantacid', 'kat' => 'Obat Lambung'],
            ['nama' => 'Lansoprazole 30mg', 'kat' => 'Obat Lambung'],
            ['nama' => 'Omeprazole 20mg', 'kat' => 'Obat Lambung'],
            ['nama' => 'Antasida Doen', 'kat' => 'Obat Lambung'],
            ['nama' => 'Waisan', 'kat' => 'Obat Lambung'],

            // Obat Alergi
            ['nama' => 'CTM (Chlorpheniramine)', 'kat' => 'Obat Alergi'],
            ['nama' => 'Cetirizine 10mg', 'kat' => 'Obat Alergi'],
            ['nama' => 'Incisidal-OD', 'kat' => 'Obat Alergi'],
            ['nama' => 'Loratadine 10mg', 'kat' => 'Obat Alergi'],
            ['nama' => 'Ozen 10mg', 'kat' => 'Obat Alergi'],
            ['nama' => 'Ryvel', 'kat' => 'Obat Alergi'],
            ['nama' => 'Orphen', 'kat' => 'Obat Alergi'],

            // Obat Diare
            ['nama' => 'Diapet', 'kat' => 'Obat Diare'],
            ['nama' => 'Entrostop', 'kat' => 'Obat Diare'],
            ['nama' => 'New Diatabs', 'kat' => 'Obat Diare'],
            ['nama' => 'Loperamide 2mg', 'kat' => 'Obat Diare'],
            ['nama' => 'Oralit', 'kat' => 'Obat Diare'],
            ['nama' => 'Lodia', 'kat' => 'Obat Diare'],

            // Obat Kulit
            ['nama' => 'Kalpanax', 'kat' => 'Obat Kulit'],
            ['nama' => 'Daktarin', 'kat' => 'Obat Kulit'],
            ['nama' => 'Salep 88', 'kat' => 'Obat Kulit'],
            ['nama' => 'Fungiderm', 'kat' => 'Obat Kulit'],
            ['nama' => 'Acyclovir Cream', 'kat' => 'Obat Kulit'],
            ['nama' => 'Ketoconazole Cream', 'kat' => 'Obat Kulit'],
            ['nama' => 'Hydrocortisone 2.5%', 'kat' => 'Obat Kulit'],
            ['nama' => 'Betadine Salep', 'kat' => 'Obat Kulit'],

            // Obat Anak
            ['nama' => 'Sanmol Drop', 'kat' => 'Obat Anak'],
            ['nama' => 'Termorex', 'kat' => 'Obat Anak'],
            ['nama' => 'Hufagrip', 'kat' => 'Obat Anak'],
            ['nama' => 'Bodrexin', 'kat' => 'Obat Anak'],
            ['nama' => 'Tempra Drop', 'kat' => 'Obat Anak'],
            ['nama' => 'Curcuma Plus', 'kat' => 'Obat Anak'],
            ['nama' => 'Scott Emulsion', 'kat' => 'Obat Anak'],
            ['nama' => 'Sakatonik ABC', 'kat' => 'Obat Anak'],

            // Alat Kesehatan
            ['nama' => 'Thermometer Digital', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Masker Medis Sensi', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Hansaplast Plester', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Betadine Antiseptic', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Kasa Steril', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Povidone Iodine', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Rivanol', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Minyak Kayu Putih Cap Lang', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Alkohol 70%', 'kat' => 'Alat Kesehatan'],
            ['nama' => 'Tensimeter Digital', 'kat' => 'Alat Kesehatan'],

            // Herbal
            ['nama' => 'Tolak Angin Cair', 'kat' => 'Herbal'],
            ['nama' => 'Antangin JRG', 'kat' => 'Herbal'],
            ['nama' => 'Mastin Ekstrak Manggis', 'kat' => 'Herbal'],
            ['nama' => 'Kuku Bima Ener-G', 'kat' => 'Herbal'],
            ['nama' => 'Minyak Angin FreshCare', 'kat' => 'Herbal'],
            ['nama' => 'Tolak Linu', 'kat' => 'Herbal'],
            ['nama' => 'Diapet Anak', 'kat' => 'Herbal'],
            ['nama' => 'Sari Kurma', 'kat' => 'Herbal'],
            ['nama' => 'Habbatussauda', 'kat' => 'Herbal'],
            ['nama' => 'Madu TJ', 'kat' => 'Herbal'],
        ];

        // Tambahkan produk random dari obat factory jika kurang dari 100
        $count = count($produkList);
        
        foreach ($produkList as $index => $item) {
            $kode = 'OBT-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $stok = rand(10, 500);
            $harga = rand(5, 250) * 1000;
            $supplier_id = $suppliers[array_rand($suppliers)];
            $kategori_id = $kategoriMap[$item['kat']];
            
            Obat::updateOrCreate(
                ['kode_obat' => $kode],
                [
                    'kategori_id' => $kategori_id,
                    'supplier_id' => $supplier_id,
                    'nama_obat' => $item['nama'],
                    'stok' => $stok,
                    'harga_jual' => $harga,
                    'tanggal_kadaluarsa' => $faker->dateTimeBetween('+6 months', '+3 years')->format('Y-m-d'),
                    'deskripsi' => $item['nama'] . ' adalah ' . strtolower($item['kat']) . ' yang terbukti efektif. ' . $faker->sentence(10),
                ]
            );
        }

        // Genapkan jadi 100 dengan random factory
        if ($count < 100) {
            $sisa = 100 - $count;
            for ($i = 0; $i < $sisa; $i++) {
                Obat::factory()->create([
                    'kategori_id' => $kategoriMap[array_rand($kategoriMap)],
                    'supplier_id' => $suppliers[array_rand($suppliers)],
                ]);
            }
        }
    }
}
