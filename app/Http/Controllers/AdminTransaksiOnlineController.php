<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class AdminTransaksiOnlineController extends Controller
{
    public function index()
    {
        // Get only online marketplace transactions (which have nama_pelanggan)
        $transaksis = Transaksi::whereNotNull('nama_pelanggan')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
                        
        return view('admin.transaksi-online.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksis.obat')->findOrFail($id);
        return view('admin.transaksi-online.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Menunggu Konfirmasi,Diproses,Dikirim,Selesai,Dibatalkan'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            // Jika pesanan diselesaikan, kurangi stok
            if ($newStatus === 'Selesai' && $transaksi->status !== 'Selesai') {
                foreach ($transaksi->detailTransaksis as $detail) {
                    $obat = $detail->obat;
                    if ($obat) {
                        $obat->stok = max(0, $obat->stok - $detail->jumlah);
                        $obat->save();
                    }
                }
            }

            // Jika pesanan dibatalkan dari selesai, kembalikan stok
            if ($newStatus === 'Dibatalkan' && $transaksi->status === 'Selesai') {
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

            DB::commit();
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $newStatus);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
        }
    }
}
