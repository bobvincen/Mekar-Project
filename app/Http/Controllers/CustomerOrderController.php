<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerOrderController extends Controller
{
    /**
     * Display a list of the customer's orders.
     */
    public function index()
    {
        $transaksis = Transaksi::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('marketplace.pesanan-saya', compact('transaksis'));
    }

    /**
     * Download the invoice as a PDF file.
     */
    public function downloadInvoicePdf($kode_transaksi)
    {
        // Enforce security: transaction must belong to the logged-in user
        $transaksi = Transaksi::with(['detailTransaksis.obat'])
            ->where('kode_transaksi', $kode_transaksi)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('marketplace.pdf-invoice', compact('transaksi'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Invoice-' . $transaksi->kode_transaksi . '.pdf');
    }
}
