<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\Transaksi;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stokRendah = Obat::where('stok', '<=', 20)
            ->orderBy('stok')
            ->get();

        $obatKadaluarsa = Obat::whereNotNull('tanggal_kadaluarsa')
            ->where('tanggal_kadaluarsa', '<=', now()->addDays(30))
            ->orderBy('tanggal_kadaluarsa')
            ->get();

        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->latest()
            ->limit(5)
            ->get();

        // Default awal: Bulanan (Total Transaksi per Bulan dalam 12 bulan terakhir)
        $chartLabels = [];
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();
            
            $count = Transaksi::whereBetween('tanggal_transaksi', [
                $startOfMonth->toDateTimeString(),
                $endOfMonth->toDateTimeString()
            ])->count();
            
            $chartLabels[] = $month->format('M Y');
            $chartData[] = $count;
        }

        $totalKonsultasiHariIni = \App\Models\KonsultasiLog::whereDate('waktu', today())->count();
        $totalKonsultasiBulanIni = \App\Models\KonsultasiLog::whereMonth('waktu', now()->month)
                                    ->whereYear('waktu', now()->year)
                                    ->count();

        return view('dashboard.index', [
            'totalObat' => Obat::count(),
            'totalSupplier' => Supplier::count(),
            'totalPelanggan' => Pelanggan::count(),
            'totalTransaksi' => Transaksi::count(),
            'stokRendah' => $stokRendah,
            'obatKadaluarsa' => $obatKadaluarsa,
            'transaksiTerbaru' => $transaksiTerbaru,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'totalKonsultasiHariIni' => $totalKonsultasiHariIni,
            'totalKonsultasiBulanIni' => $totalKonsultasiBulanIni,
        ]);
    }

    public function salesSummary(\Illuminate\Http\Request $request)
    {
        $filter = $request->get('filter', 'bulanan');
        $chartLabels = [];
        $chartData = [];
        $chartType = 'line';
        $datasetLabel = 'Jumlah Transaksi';
        $isCurrency = false;

        switch ($filter) {
            case 'harian':
                // Harian: total transaksi (count) per hari selama 30 hari terakhir
                $sales = Transaksi::select(
                    DB::raw('DATE(tanggal_transaksi) as tanggal'),
                    DB::raw('COUNT(id) as count')
                )
                ->where('tanggal_transaksi', '>=', now()->subDays(29)->startOfDay())
                ->groupBy('tanggal')
                ->get()
                ->pluck('count', 'tanggal');

                for ($i = 29; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $dateStr = $date->format('Y-m-d');
                    $chartLabels[] = $date->format('d M');
                    $chartData[] = (int) ($sales->get($dateStr) ?? 0);
                }
                $chartType = 'line';
                $datasetLabel = 'Total Transaksi (Harian)';
                break;

            case 'mingguan':
                // Mingguan: total transaksi (count) per minggu selama 12 minggu terakhir
                for ($i = 11; $i >= 0; $i--) {
                    $startOfWeek = now()->subWeeks($i)->startOfWeek();
                    $endOfWeek = now()->subWeeks($i)->endOfWeek();

                    $count = Transaksi::whereBetween('tanggal_transaksi', [
                        $startOfWeek->toDateTimeString(),
                        $endOfWeek->toDateTimeString()
                    ])->count();

                    $chartLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
                    $chartData[] = $count;
                }
                $chartType = 'line';
                $datasetLabel = 'Total Transaksi (Mingguan)';
                break;

            case 'bulanan':
                // Bulanan: total transaksi (count) per bulan selama 12 bulan terakhir
                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $startOfMonth = $month->copy()->startOfMonth();
                    $endOfMonth = $month->copy()->endOfMonth();

                    $count = Transaksi::whereBetween('tanggal_transaksi', [
                        $startOfMonth->toDateTimeString(),
                        $endOfMonth->toDateTimeString()
                    ])->count();

                    $chartLabels[] = $month->format('M Y');
                    $chartData[] = $count;
                }
                $chartType = 'line';
                $datasetLabel = 'Total Transaksi (Bulanan)';
                break;

            case 'tahunan':
                // Tahunan: total transaksi (count) per tahun selama 5 tahun terakhir
                for ($i = 4; $i >= 0; $i--) {
                    $year = now()->subYears($i);
                    $startOfYear = $year->copy()->startOfYear();
                    $endOfYear = $year->copy()->endOfYear();

                    $count = Transaksi::whereBetween('tanggal_transaksi', [
                        $startOfYear->toDateTimeString(),
                        $endOfYear->toDateTimeString()
                    ])->count();

                    $chartLabels[] = $year->format('Y');
                    $chartData[] = $count;
                }
                $chartType = 'bar';
                $datasetLabel = 'Total Transaksi (Tahunan)';
                break;

            case 'obat_terlaris':
                // Obat Terlaris: jumlah penjualan setiap obat (top 10)
                $topSelling = \App\Models\DetailTransaksi::select('obat_id', DB::raw('SUM(jumlah) as total_qty'))
                    ->with('obat')
                    ->groupBy('obat_id')
                    ->orderBy('total_qty', 'desc')
                    ->limit(10)
                    ->get();

                foreach ($topSelling as $item) {
                    $chartLabels[] = $item->obat->nama_obat ?? 'Tidak Diketahui';
                    $chartData[] = (int) $item->total_qty;
                }
                $chartType = 'bar';
                $datasetLabel = 'Jumlah Terjual (Pcs)';
                break;

            case 'pendapatan':
                // Pendapatan: total pendapatan per bulan selama 12 bulan terakhir
                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $startOfMonth = $month->copy()->startOfMonth();
                    $endOfMonth = $month->copy()->endOfMonth();

                    $revenue = Transaksi::whereBetween('tanggal_transaksi', [
                        $startOfMonth->toDateTimeString(),
                        $endOfMonth->toDateTimeString()
                    ])->sum('total_harga');

                    $chartLabels[] = $month->format('M Y');
                    $chartData[] = (float) $revenue;
                }
                $chartType = 'line';
                $datasetLabel = 'Total Pendapatan (Rupiah)';
                $isCurrency = true;
                break;
        }

        return response()->json([
            'labels' => $chartLabels,
            'data' => $chartData,
            'chart_type' => $chartType,
            'dataset_label' => $datasetLabel,
            'is_currency' => $isCurrency,
        ]);
    }
}
