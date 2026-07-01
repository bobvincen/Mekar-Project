<?php

namespace App\Services;

use App\Models\ResepDokter;
use App\Models\ResepDokterItem;
use App\Models\Obat;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResepDokterService
{
    /**
     * Upload and save a doctor prescription privately.
     */
    public function upload(UploadedFile $file, ?string $catatan, User $user): ResepDokter
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $datePath = now()->format('Y/m');
        
        // Simpan file secara privat di storage/app/private/prescriptions/YEAR/MONTH/filename
        $file->storeAs('prescriptions/' . $datePath, $filename, 'local');
        
        // Simpan data ke database
        $resep = ResepDokter::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'whatsapp' => $user->whatsapp,
            'catatan' => $catatan,
            'foto_resep' => 'private/prescriptions/' . $datePath . '/' . $filename,
            'status' => 'menunggu_verifikasi',
        ]);

        // Audit Log
        Log::info("Audit Resep: Pelanggan {$user->name} (ID: {$user->id}) mengunggah resep dokter (ID: {$resep->id})");

        // Kirim WhatsApp pemberitahuan ke Admin (backward compatibility)
        try {
            $adminWa = config('services.fonnte.admin_phone', '6282240432990');
            $fotoUrl = route('resep.file', $resep->id);
            $pesan = "Halo Admin Mekar Pharmacy 👋\n\nPelanggan telah mengirim resep dokter baru.\n\nNama:\n" . $resep->nama . "\n\nWhatsApp:\n" . $resep->whatsapp . "\n\nCatatan:\n" . ($resep->catatan ?? '-') . "\n\nLink Foto Resep (Private):\n" . $fotoUrl . "\n\nMohon dilakukan pemeriksaan resep terlebih dahulu.\n\nTerima kasih 🙏";
            
            FonnteService::send($adminWa, $pesan);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi WA ke admin saat resep diunggah: ' . $e->getMessage());
        }

        return $resep;
    }

    /**
     * Process prescription by Apoteker/Admin: select medicines, quantities, availability.
     */
    public function process(int $resepId, array $itemsData, ?string $catatanVerifikasi): ResepDokter
    {
        $resep = ResepDokter::findOrFail($resepId);
        $user = auth()->user();

        DB::transaction(function () use ($resep, $itemsData, $catatanVerifikasi) {
            // Hapus items lama (jika ada pemrosesan ulang)
            $resep->items()->delete();

            // Simpan items baru
            foreach ($itemsData as $item) {
                ResepDokterItem::create([
                    'resep_dokter_id' => $resep->id,
                    'obat_id' => $item['obat_id'],
                    'qty' => (int) $item['qty'],
                    'status' => $item['status'], // tersedia / tidak_tersedia
                    'obat_pengganti_id' => !empty($item['obat_pengganti_id']) ? $item['obat_pengganti_id'] : null,
                    'catatan' => $item['catatan'] ?? null,
                ]);
            }

            // Update status resep
            $resep->status = 'menunggu_persetujuan';
            $resep->catatan_verifikasi = $catatanVerifikasi;
            $resep->save();
        });

        // Eager load items & obat for notification
        $resep->load('items.obat', 'items.obatPengganti');

        // Audit Log
        Log::info("Audit Resep: Staf {$user->name} (ID: {$user->id}) memproses resep dokter (ID: {$resep->id}) dan mengubah status menjadi 'menunggu_persetujuan'");

        // Kirim notifikasi WhatsApp ke Pelanggan
        try {
            $pesan = "Halo *{$resep->nama}*,\n\nResep Anda telah selesai diproses oleh Apoteker Mekar Pharmacy.\n\nSilakan login ke Mekar Pharmacy untuk meninjau detail penawaran resep Anda.\n\nObat yang tersedia sudah dimasukkan ke draf keranjang. Silakan tinjau dan setujui sebelum checkout.";

            $unavailableItems = [];
            foreach ($resep->items as $item) {
                if ($item->status === 'tidak_tersedia') {
                    $name = $item->obat->nama_obat ?? 'Obat';
                    $replacement = $item->obatPengganti ? $item->obatPengganti->nama_obat : 'Tidak ada pengganti';
                    $note = $item->catatan ? " (Catatan: {$item->catatan})" : "";
                    $unavailableItems[] = "- {$name} -> Pengganti: {$replacement}{$note}";
                }
            }

            if (!empty($unavailableItems)) {
                $pesan .= "\n\n*Obat tidak tersedia:*\n" . implode("\n", $unavailableItems);
            }

            $pesan .= "\n\nSilakan cek status resep Anda di menu *Resep Saya* di website Mekar Pharmacy.\n\nTerima kasih 🙏";

            FonnteService::send($resep->whatsapp, $pesan);
        } catch (\Exception $e) {
            Log::error("Gagal mengirim notifikasi WA ke pelanggan untuk resep ID {$resep->id}: " . $e->getMessage());
        }

        return $resep;
    }

    /**
     * Customer approves prescription items, transferring them to the active session cart.
     */
    public function approve(int $resepId): ResepDokter
    {
        $resep = ResepDokter::with('items.obat.kategori', 'items.obatPengganti.kategori')->findOrFail($resepId);
        $user = auth()->user();

        // Ubah status resep
        $resep->status = 'siap_checkout';
        $resep->save();

        // Pindahkan ke session keranjang (cart)
        $cart = session()->get('cart', []);

        foreach ($resep->items as $item) {
            $targetObat = null;
            if ($item->status === 'tersedia') {
                $targetObat = $item->obat;
            } elseif ($item->status === 'tidak_tersedia' && $item->obatPengganti) {
                $targetObat = $item->obatPengganti;
            }

            if ($targetObat && $targetObat->stok > 0) {
                $id = $targetObat->id;
                $qtyToAdd = min($item->qty, $targetObat->stok);

                if (isset($cart[$id])) {
                    $newQty = $cart[$id]['qty'] + $qtyToAdd;
                    if ($newQty > $targetObat->stok) {
                        $newQty = $targetObat->stok;
                    }
                    $cart[$id]['qty'] = $newQty;
                    $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['price'];
                } else {
                    $imageFallback = str_contains(strtolower($targetObat->kategori->nama_kategori ?? ''), 'vitamin')
                        ? '/premium_supplement_bottle.png'
                        : '/premium_medicine_box.png';

                    $cart[$id] = [
                        'id'       => $targetObat->id,
                        'name'     => $targetObat->nama_obat,
                        'category' => $targetObat->kategori->nama_kategori ?? 'Obat',
                        'price'    => (float) $targetObat->harga_jual,
                        'qty'      => $qtyToAdd,
                        'image'    => $targetObat->image_path ? asset('storage/' . $targetObat->image_path) : $imageFallback,
                        'subtotal' => (float) $targetObat->harga_jual * $qtyToAdd,
                    ];
                }
            }
        }

        session()->put('cart', $cart);

        // Audit Log
        Log::info("Audit Resep: Pelanggan {$user->name} (ID: {$user->id}) menyetujui penawaran resep dokter (ID: {$resep->id}) dan memasukkan obat ke keranjang.");

        return $resep;
    }

    /**
     * Customer requests a revision.
     */
    public function requestRevision(int $resepId, string $catatanRevisi): ResepDokter
    {
        $resep = ResepDokter::findOrFail($resepId);
        $user = auth()->user();

        $resep->status = 'sedang_diproses';
        $resep->catatan_revisi = $catatanRevisi;
        $resep->save();

        // Audit Log
        Log::info("Audit Resep: Pelanggan {$user->name} (ID: {$user->id}) mengajukan revisi resep dokter (ID: {$resep->id}) dengan catatan: {$catatanRevisi}");

        return $resep;
    }

    /**
     * Reject prescription.
     */
    public function reject(int $resepId, ?string $catatanVerifikasi): ResepDokter
    {
        $resep = ResepDokter::findOrFail($resepId);
        $user = auth()->user();

        $resep->status = 'ditolak';
        $resep->catatan_verifikasi = $catatanVerifikasi;
        $resep->save();

        // Audit Log
        Log::info("Audit Resep: Staf {$user->name} (ID: {$user->id}) menolak resep dokter (ID: {$resep->id}) dengan alasan: " . ($catatanVerifikasi ?? 'Tanpa alasan'));

        // Kirim WhatsApp pemberitahuan ke Pelanggan
        try {
            $pesan = "Halo *{$resep->nama}*,\n\nMohon maaf, resep dokter yang Anda unggah telah *Ditolak*.\n\nCatatan dari Apoteker:\n" . ($catatanVerifikasi ?? 'Foto resep tidak jelas / tidak valid.') . "\n\nSilakan unggah kembali resep dokter yang valid di website Mekar Pharmacy.\n\nTerima kasih 🙏";
            
            FonnteService::send($resep->whatsapp, $pesan);
        } catch (\Exception $e) {
            Log::error("Gagal mengirim notifikasi penolakan WA ke pelanggan untuk resep ID {$resep->id}: " . $e->getMessage());
        }

        return $resep;
    }

    /**
     * Complete checkout: transition from siap_checkout to checkout.
     */
    public function completeCheckout(int $userId): void
    {
        $updated = ResepDokter::where('user_id', $userId)
            ->where('status', 'siap_checkout')
            ->update(['status' => 'checkout']);

        if ($updated > 0) {
            Log::info("Audit Resep: Mengubah status resep milik Pelanggan ID: {$userId} menjadi 'checkout' setelah menyelesaikan transaksi.");
        }
    }

    /**
     * Complete transaction: transition from checkout to selesai.
     */
    public function completeTransaction(int $userId): void
    {
        $updated = ResepDokter::where('user_id', $userId)
            ->where('status', 'checkout')
            ->update(['status' => 'selesai']);

        if ($updated > 0) {
            Log::info("Audit Resep: Mengubah status resep milik Pelanggan ID: {$userId} menjadi 'selesai' setelah status pesanan selesai.");
        }
    }
}
