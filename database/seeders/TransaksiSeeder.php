<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Obat;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    /**
     * Menjalankan proses seeding untuk tabel transaksi dan detail transaksi.
     * 
     * Fungsi ini menghasilkan dua jenis transaksi tiruan:
     * 1. Transaksi Offline (Kasir): Membuat 40 riwayat transaksi secara langsung di apotek
     *    termasuk logika penentuan uang bayar dan kembalian.
     * 2. Transaksi Online (Marketplace): Membuat 25 riwayat transaksi pesanan online
     *    dengan berbagai status pesanan, perhitungan ongkos kirim (jika dikirim), 
     *    dan rincian lokasi pelanggan (latitude/longitude).
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $users = User::whereIn('role', ['admin', 'kasir'])->get();
        $pelanggans = Pelanggan::all();
        $obats = Obat::all();

        if ($obats->isEmpty()) {
            $this->command->warn('Obat table is empty. Please run MarketplaceSeeder first.');
            return;
        }

        // 1. Generate Offline Transactions (Cashier)
        for ($i = 0; $i < 40; $i++) {
            $user = $users->random();
            $pelanggan = $faker->boolean(70) ? $pelanggans->random() : null; // 70% have a registered customer
            $daysAgo = rand(0, 30);
            $tanggal = Carbon::now()->subDays($daysAgo)->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            // Generate unique transaction code
            $dateStr = $tanggal->format('Ymd');
            $sequence = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $kodeTransaksi = "TRX-{$dateStr}-{$sequence}-OFF";

            // Determine detail items (1-4 different drugs)
            $itemsCount = rand(1, 4);
            $selectedObats = $obats->random($itemsCount);

            $total = 0;
            $details = [];

            foreach ($selectedObats as $obat) {
                $qty = rand(1, 3);
                $subtotal = $obat->harga_jual * $qty;
                $total += $subtotal;

                $details[] = [
                    'obat_id' => $obat->id,
                    'jumlah' => $qty,
                    'harga' => $obat->harga_jual,
                    'subtotal' => $subtotal
                ];
            }

            // Cash paid is rounded up to next 10,000 or 50,000 bill
            $bayar = ceil($total / 10000) * 10000;
            if ($bayar < $total) {
                $bayar += 10000;
            }
            // Sometimes they pay with a larger bill (e.g. 50k or 100k or 200k)
            if ($total <= 45000 && $faker->boolean(40)) {
                $bayar = 50000;
            } elseif ($total <= 95000 && $faker->boolean(40)) {
                $bayar = 100000;
            }
            
            $kembalian = $bayar - $total;

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => $user->id,
                'pelanggan_id' => $pelanggan ? $pelanggan->id : null,
                'tanggal_transaksi' => $tanggal,
                'total_harga' => $total,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                'status' => 'Selesai', // Offline transaction is always completed
            ]);

            foreach ($details as $detail) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id' => $detail['obat_id'],
                    'jumlah' => $detail['jumlah'],
                    'harga' => $detail['harga'],
                    'subtotal' => $detail['subtotal'],
                ]);
            }
        }

        // 2. Generate Online Transactions (Marketplace)
        $statuses = ['Menunggu Konfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
        
        for ($i = 0; $i < 25; $i++) {
            $pelanggan = $pelanggans->random();
            $status = $faker->randomElement($statuses);
            
            $daysAgo = rand(0, 30);
            $tanggal = Carbon::now()->subDays($daysAgo)->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $dateStr = $tanggal->format('Ymd');
            $sequence = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $kodeTransaksi = "TRX-{$dateStr}-{$sequence}-ON";

            $itemsCount = rand(1, 3);
            $selectedObats = $obats->random($itemsCount);

            $subtotal = 0;
            $details = [];

            foreach ($selectedObats as $obat) {
                $qty = rand(1, 2);
                $sub = $obat->harga_jual * $qty;
                $subtotal += $sub;

                $details[] = [
                    'obat_id' => $obat->id,
                    'jumlah' => $qty,
                    'harga' => $obat->harga_jual,
                    'subtotal' => $sub
                ];
            }

            $metode = $faker->randomElement(['Kirim', 'Ambil di Apotek']);
            if ($metode === 'Kirim') {
                $jarak = $faker->randomFloat(2, 0.5, 12.0); // 0.5 to 12 km
                $ongkir = ceil($jarak) * 2000;
                $alamat = $pelanggan->alamat ?? $faker->address;
                $lat = $faker->latitude(-6.4, -6.1);
                $lng = $faker->longitude(106.7, 107.0);
            } else {
                $jarak = null;
                $ongkir = 0;
                $alamat = null;
                $lat = null;
                $lng = null;
            }

            $total = $subtotal + $ongkir;

            // For completed online orders, set bayar/kembalian. For others, set bayar=0/kembalian=0
            $bayar = ($status === 'Selesai') ? $total : 0;
            $kembalian = 0;

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => ($status === 'Selesai' || $status === 'Diproses' || $status === 'Dikirim') ? $users->random()->id : null,
                'pelanggan_id' => $pelanggan->id,
                'tanggal_transaksi' => $tanggal,
                'total_harga' => $total,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                
                // Marketplace fields
                'nama_pelanggan' => $pelanggan->nama_pelanggan,
                'whatsapp' => $pelanggan->no_hp ?? '08' . $faker->numerify('##########'),
                'alamat' => $alamat,
                'metode_pengambilan' => $metode,
                'latitude' => $lat,
                'longitude' => $lng,
                'jarak' => $jarak,
                'ongkir' => $ongkir,
                'subtotal' => $subtotal,
                'catatan' => $faker->boolean(40) ? $faker->sentence(6) : null,
                'status' => $status,
            ]);

            foreach ($details as $detail) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id' => $detail['obat_id'],
                    'jumlah' => $detail['jumlah'],
                    'harga' => $detail['harga'],
                    'subtotal' => $detail['subtotal'],
                ]);
            }
        }
    }
}
