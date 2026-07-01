<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use App\Services\FonnteService;

class AdminTransaksiOnlineController extends Controller
{
    public function index()
    {
        // Prioritize "Menunggu Verifikasi" transactions, then sort by date
        $transaksis = Transaksi::whereNotNull('nama_pelanggan')
                        ->orderByRaw("CASE WHEN status = 'Menunggu Verifikasi' THEN 0 ELSE 1 END")
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
                        
        return view('admin.transaksi-online.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['detailTransaksis.obat', 'verifikator'])->findOrFail($id);
        return view('admin.transaksi-online.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $allowedStatuses = [
            'Menunggu Pembayaran',
            'Menunggu Verifikasi',
            'Ditolak',
            'Diproses',
            'Siap Diambil',
            'Sedang Diantar',
            'Selesai',
            'Dibatalkan'
        ];

        $request->validate([
            'status' => 'required|string|in:' . implode(',', $allowedStatuses)
        ]);

        $transaksi = Transaksi::with('detailTransaksis.obat')->findOrFail($id);
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            // State-machine based stock control
            $reducedStatuses = ['Diproses', 'Siap Diambil', 'Sedang Diantar', 'Selesai'];
            $isReducedCurrent = in_array($transaksi->status, $reducedStatuses);
            $isReducedNew = in_array($newStatus, $reducedStatuses);

            if (!$isReducedCurrent && $isReducedNew) {
                // Deduct stock
                foreach ($transaksi->detailTransaksis as $detail) {
                    $obat = $detail->obat;
                    if ($obat) {
                        if ($detail->jumlah > $obat->stok) {
                            throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi (Tersedia: {$obat->stok}, dibutuhkan: {$detail->jumlah}).");
                        }
                        $obat->stok = max(0, $obat->stok - $detail->jumlah);
                        $obat->save();
                    }
                }
            } elseif ($isReducedCurrent && !$isReducedNew) {
                // Restore stock
                foreach ($transaksi->detailTransaksis as $detail) {
                    $obat = $detail->obat;
                    if ($obat) {
                        $obat->stok += $detail->jumlah;
                        $obat->save();
                    }
                }
            }

            $transaksi->status = $newStatus;
            $transaksi->save();

            // If the transaction status is updated to Selesai, complete the linked prescription (if any)
            if ($newStatus === 'Selesai') {
                try {
                    $resepService = app(\App\Services\ResepDokterService::class);
                    $resepService->completeTransaction($transaksi->user_id);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal memperbarui status resep saat transaksi selesai: ' . $e->getMessage());
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $newStatus);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Verify payment proof (Terima / Tolak).
     */
    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|string|in:terima,tolak',
            'alasan' => 'required_if:action,tolak|nullable|string|max:500'
        ], [
            'alasan.required_if' => 'Alasan penolakan wajib diisi jika pembayaran ditolak.'
        ]);

        $transaksi = Transaksi::with('detailTransaksis.obat')->findOrFail($id);

        DB::beginTransaction();
        try {
            $action = $request->action;

            if ($action === 'terima') {
                $newStatus = 'Diproses';
                $transaksi->verifikator_id = auth()->id();
                $transaksi->tanggal_verifikasi = now();
                $transaksi->verifikasi_catatan = null;

                // Send WhatsApp to Customer via Fonnte
                $message = "Pembayaran Diterima\n\n";
                $message .= "Invoice :\n{$transaksi->kode_transaksi}\n\n";
                $message .= "Status :\nDiproses\n\n";
                $message .= "Pesanan Anda sedang diproses oleh apoteker kami. Terima kasih telah berbelanja di Mekar Pharmacy.";
            } else {
                $newStatus = 'Ditolak';
                $transaksi->verifikator_id = null;
                $transaksi->tanggal_verifikasi = null;
                $transaksi->verifikasi_catatan = $request->alasan;

                // Send WhatsApp to Customer via Fonnte
                $message = "Pembayaran Ditolak\n\n";
                $message .= "Invoice :\n{$transaksi->kode_transaksi}\n\n";
                $message .= "Alasan Penolakan :\n{$request->alasan}\n\n";
                $message .= "Silakan buka kembali halaman invoice Anda untuk mengunggah ulang bukti transfer yang valid.";
            }

            // Apply status change (which handles stock reduction if action is terima)
            $reducedStatuses = ['Diproses', 'Siap Diambil', 'Sedang Diantar', 'Selesai'];
            $isReducedCurrent = in_array($transaksi->status, $reducedStatuses);
            $isReducedNew = in_array($newStatus, $reducedStatuses);

            if (!$isReducedCurrent && $isReducedNew) {
                // Deduct stock
                foreach ($transaksi->detailTransaksis as $detail) {
                    $obat = $detail->obat;
                    if ($obat) {
                        if ($detail->jumlah > $obat->stok) {
                            throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi (Tersedia: {$obat->stok}, dibutuhkan: {$detail->jumlah}).");
                        }
                        $obat->stok = max(0, $obat->stok - $detail->jumlah);
                        $obat->save();
                    }
                }
            }

            $transaksi->status = $newStatus;
            $transaksi->save();

            DB::commit();

            // Send Fonnte WhatsApp message
            if (!empty($transaksi->whatsapp)) {
                // Prepend country code if missing
                $customerPhone = preg_replace('/^0/', '62', $transaksi->whatsapp);
                FonnteService::send($customerPhone, $message);
            }

            $msgText = $action === 'terima' ? 'pembayaran diterima' : 'pembayaran ditolak';
            return redirect()->back()->with('success', "Verifikasi berhasil: {$msgText}.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }
}
