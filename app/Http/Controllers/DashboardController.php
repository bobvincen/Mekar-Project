<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\ResepDokter;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        // Low Stock Medicines (stok <= 20)
        $stokRendah = Obat::where('stok', '<=', 20)
            ->orderBy('stok')
            ->get();

        // Expiring Medicines (<= 30 days)
        $obatKadaluarsa = Obat::whereNotNull('tanggal_kadaluarsa')
            ->where('tanggal_kadaluarsa', '<=', now()->addDays(30))
            ->orderBy('tanggal_kadaluarsa')
            ->get();

        // Recent Transactions (eager load user for online orders and pelanggan for offline)
        $transaksiTerbaru = Transaksi::with(['user', 'pelanggan'])
            ->latest()
            ->limit(5)
            ->get();

        // Optimization: Fetch all monthly transactions in 1 query instead of 12 separate queries
        $startOfPeriod = now()->subMonths(11)->startOfMonth()->toDateTimeString();
        $sales = Transaksi::select(
            DB::raw("DATE_FORMAT(tanggal_transaksi, '%Y-%m') as month_year"),
            DB::raw("COUNT(id) as count")
        )
        ->where('tanggal_transaksi', '>=', $startOfPeriod)
        ->groupBy('month_year')
        ->get()
        ->pluck('count', 'month_year');

        $chartLabels = [];
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            
            $chartLabels[] = $month->format('M Y');
            $chartData[] = (int) ($sales->get($monthKey) ?? 0);
        }

        // New Widget Data
        $pendingPembayaranCount = Transaksi::where('status', 'Menunggu Verifikasi')->count();
        $pendingResepCount = ResepDokter::where('status', 'pending')->count();
        $totalPendapatan = Transaksi::sum('total_harga');
        $totalPelanggan = User::role('pelanggan')->count();

        return view('dashboard.index', [
            'totalObat' => Obat::count(),
            'totalSupplier' => Supplier::count(),
            'totalPelanggan' => $totalPelanggan,
            'totalTransaksi' => Transaksi::count(),
            'totalPendapatan' => $totalPendapatan,
            'pendingPembayaranCount' => $pendingPembayaranCount,
            'pendingResepCount' => $pendingResepCount,
            'stokRendah' => $stokRendah,
            'obatKadaluarsa' => $obatKadaluarsa,
            'transaksiTerbaru' => $transaksiTerbaru,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }

    /**
     * Get Sales Summary for AJAX Charts (Optimized Query Paths).
     */
    public function salesSummary(Request $request)
    {
        $filter = $request->get('filter', 'bulanan');
        $chartLabels = [];
        $chartData = [];
        $chartType = 'line';
        $datasetLabel = 'Jumlah Transaksi';
        $isCurrency = false;

        switch ($filter) {
            case 'harian':
                // Harian: 1 query for last 30 days
                $sales = Transaksi::select(
                    DB::raw('DATE(tanggal_transaksi) as tanggal'),
                    DB::raw('COUNT(id) as count')
                )
                ->where('tanggal_transaksi', '>=', now()->subDays(29)->startOfDay()->toDateTimeString())
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
                // Mingguan: 1 optimized query using YEARWEEK grouping
                $sales = Transaksi::select(
                    DB::raw("YEARWEEK(tanggal_transaksi, 1) as year_week"),
                    DB::raw("COUNT(id) as count")
                )
                ->where('tanggal_transaksi', '>=', now()->subWeeks(11)->startOfWeek()->toDateTimeString())
                ->groupBy('year_week')
                ->get()
                ->pluck('count', 'year_week');

                for ($i = 11; $i >= 0; $i--) {
                    $startOfWeek = now()->subWeeks($i)->startOfWeek();
                    $endOfWeek = now()->subWeeks($i)->endOfWeek();
                    $yearWeekKey = $startOfWeek->format('oW'); // ISO-8601 week number

                    $chartLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
                    $chartData[] = (int) ($sales->get($yearWeekKey) ?? 0);
                }
                $chartType = 'line';
                $datasetLabel = 'Total Transaksi (Mingguan)';
                break;

            case 'bulanan':
                // Bulanan: 1 optimized query
                $sales = Transaksi::select(
                    DB::raw("DATE_FORMAT(tanggal_transaksi, '%Y-%m') as month_year"),
                    DB::raw("COUNT(id) as count")
                )
                ->where('tanggal_transaksi', '>=', now()->subMonths(11)->startOfMonth()->toDateTimeString())
                ->groupBy('month_year')
                ->get()
                ->pluck('count', 'month_year');

                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $monthKey = $month->format('Y-m');

                    $chartLabels[] = $month->format('M Y');
                    $chartData[] = (int) ($sales->get($monthKey) ?? 0);
                }
                $chartType = 'line';
                $datasetLabel = 'Total Transaksi (Bulanan)';
                break;

            case 'tahunan':
                // Tahunan: 1 optimized query
                $sales = Transaksi::select(
                    DB::raw("YEAR(tanggal_transaksi) as year_num"),
                    DB::raw("COUNT(id) as count")
                )
                ->where('tanggal_transaksi', '>=', now()->subYears(4)->startOfYear()->toDateTimeString())
                ->groupBy('year_num')
                ->get()
                ->pluck('count', 'year_num');

                for ($i = 4; $i >= 0; $i--) {
                    $year = now()->subYears($i);
                    $yearKey = $year->format('Y');

                    $chartLabels[] = $yearKey;
                    $chartData[] = (int) ($sales->get($yearKey) ?? 0);
                }
                $chartType = 'bar';
                $datasetLabel = 'Total Transaksi (Tahunan)';
                break;

            case 'obat_terlaris':
                // Obat Terlaris: Top 10 items
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
                // Pendapatan: 1 optimized query for monthly revenue sum
                $sales = Transaksi::select(
                    DB::raw("DATE_FORMAT(tanggal_transaksi, '%Y-%m') as month_year"),
                    DB::raw("SUM(total_harga) as revenue")
                )
                ->where('tanggal_transaksi', '>=', now()->subMonths(11)->startOfMonth()->toDateTimeString())
                ->groupBy('month_year')
                ->get()
                ->pluck('revenue', 'month_year');

                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $monthKey = $month->format('Y-m');

                    $chartLabels[] = $month->format('M Y');
                    $chartData[] = (float) ($sales->get($monthKey) ?? 0);
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
