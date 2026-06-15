<?php

namespace Database\Factories;

use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Obat>
 */
class ObatFactory extends Factory
{
    protected $model = Obat::class;

    public function definition(): array
    {
        return [
            'kategori_id' => Kategori::inRandomOrder()->first()->id ?? 1,
            'supplier_id' => Supplier::inRandomOrder()->first()->id ?? 1,
            'kode_obat' => 'OBT-' . strtoupper($this->faker->unique()->bothify('??####')),
            'nama_obat' => $this->faker->words(3, true),
            'stok' => $this->faker->numberBetween(10, 500),
            'harga_jual' => $this->faker->numberBetween(5, 250) * 1000,
            'tanggal_kadaluarsa' => $this->faker->dateTimeBetween('+6 months', '+3 years')->format('Y-m-d'),
            'deskripsi' => $this->faker->paragraph(2),
        ];
    }
}
