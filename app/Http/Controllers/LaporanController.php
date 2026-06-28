<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Helper to build filtered transaction query based on request parameters.
     */
    private function getFilteredQuery(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'user']);

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->end_date);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('jenis_transaksi')) {
            if ($request->jenis_transaksi === 'POS') {
                $query->whereNull('nama_pelanggan');
            } elseif ($request->jenis_transaksi === 'Online') {
                $query->whereNotNull('nama_pelanggan');
            }
        }
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'Selesai') {
                $query->where(function ($q) {
                    $q->where('status', 'Selesai')
                      ->orWhere(function ($sq) {
                          $sq->whereNotNull('user_id')
                             ->where('status', '!=', 'Dibatalkan');
                      });
                });
            } else {
                $query->where('status', $status);
            }
        }

        return $query;
    }

    /**
     * Display report index with filters.
     */
    public function index(Request $request)
    {
        $query = $this->getFilteredQuery($request);

        $totalTransaksi = $query->count();
        $totalPendapatan = $query->sum('total_harga');
        
        $transaksis = $query->latest('tanggal_transaksi')->paginate(25)->withQueryString();
        $cashiers = User::whereIn('role', ['admin', 'kasir'])->orderBy('name')->get();
        
        $statuses = [
            'Menunggu Pembayaran',
            'Menunggu Verifikasi',
            'Diproses',
            'Siap Diambil',
            'Sedang Diantar',
            'Selesai',
            'Dibatalkan',
            'Ditolak'
        ];

        return view('laporan.index', compact(
            'totalTransaksi',
            'totalPendapatan',
            'transaksis',
            'cashiers',
            'statuses'
        ));
    }

    /**
     * Export report data as PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        $transaksis = $query->orderBy('tanggal_transaksi', 'asc')->get();

        $totalTransaksi = $transaksis->count();
        $totalPendapatan = $transaksis->sum('total_harga');
        
        // Calculations for report summary
        $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
        
        $totalSelesai = $transaksis->filter(function($t) {
            return $t->user_id ? ($t->status !== 'Dibatalkan') : ($t->status === 'Selesai');
        })->count();
        
        $totalDibatalkan = $transaksis->filter(function($t) {
            return $t->status === 'Dibatalkan';
        })->count();

        // Build file name based on filters
        $periodeText = 'Semua_Periode';
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $periodeText = Carbon::parse($request->start_date)->format('Y-m-d') . '_sampai_' . Carbon::parse($request->end_date)->format('Y-m-d');
        } elseif ($request->filled('start_date')) {
            $periodeText = 'mulai_' . Carbon::parse($request->start_date)->format('Y-m-d');
        } elseif ($request->filled('end_date')) {
            $periodeText = 'hingga_' . Carbon::parse($request->end_date)->format('Y-m-d');
        }

        $filename = 'Laporan_Penjualan_' . $periodeText . '_' . date('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'transaksis',
            'totalTransaksi',
            'totalPendapatan',
            'rataRata',
            'totalSelesai',
            'totalDibatalkan',
            'request'
        ))->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    /**
     * Export report data as Excel.
     */
    public function exportExcel(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        $transaksis = $query->orderBy('tanggal_transaksi', 'asc')->get();

        $periodeText = 'Semua_Periode';
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $periodeText = Carbon::parse($request->start_date)->format('Y-m-d') . '_sampai_' . Carbon::parse($request->end_date)->format('Y-m-d');
        } elseif ($request->filled('start_date')) {
            $periodeText = 'mulai_' . Carbon::parse($request->start_date)->format('Y-m-d');
        } elseif ($request->filled('end_date')) {
            $periodeText = 'hingga_' . Carbon::parse($request->end_date)->format('Y-m-d');
        }

        $filename = 'Laporan_Penjualan_' . $periodeText . '_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new LaporanExport($transaksis), $filename);
    }
}
