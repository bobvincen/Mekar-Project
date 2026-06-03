<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $stokRendah = Obat::where('stok', '<=', 20)
            ->orderBy('stok')
            ->limit(5)
            ->get();

        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', [
            'totalObat' => Obat::count(),
            'totalSupplier' => Supplier::count(),
            'totalPelanggan' => Pelanggan::count(),
            'totalTransaksi' => Transaksi::count(),
            'stokRendah' => $stokRendah,
            'transaksiTerbaru' => $transaksiTerbaru,
        ]);
    }


}
