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
        return view('dashboard.index', [
            'totalObat' => Obat::count(),
            'totalSupplier' => Supplier::count(),
            'totalPelanggan' => Pelanggan::count(),
            'totalTransaksi' => Transaksi::count(),
        ]);
    }
}
