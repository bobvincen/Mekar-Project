@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1">Selamat datang kembali di Backoffice Mekar Pharmacy</p>
        </div>
        <div class="text-sm font-medium text-slate-400 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <!-- Urgent Alerts Section -->
    @if($pendingPembayaranCount > 0 || $pendingResepCount > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-fade-in">
            @if($pendingPembayaranCount > 0)
                <div class="flex items-center justify-between p-4 bg-amber-50 border border-amber-100 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="p-2.5 bg-amber-100 text-amber-700 rounded-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <div>
                            <h4 class="font-bold text-amber-900 text-sm">Pembayaran Menunggu Verifikasi</h4>
                            <p class="text-xs text-amber-700 mt-0.5">Ada <span class="font-bold">{{ $pendingPembayaranCount }}</span> bukti transfer baru yang butuh divalidasi.</p>
                        </div>
                    </div>
                    @can('Kelola Pesanan Online')
                        <a href="{{ route('admin.transaksi-online.index') }}" class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                            Tinjau
                        </a>
                    @endcan
                </div>
            @endif

            @if($pendingResepCount > 0)
                <div class="flex items-center justify-between p-4 bg-indigo-50 border border-indigo-100 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="p-2.5 bg-indigo-100 text-indigo-700 rounded-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <div>
                            <h4 class="font-bold text-indigo-900 text-sm">Resep Dokter Menunggu Review</h4>
                            <p class="text-xs text-indigo-700 mt-0.5">Ada <span class="font-bold">{{ $pendingResepCount }}</span> unggahan resep dokter yang butuh diperiksa.</p>
                        </div>
                    </div>
                    @if(auth()->user()->can('Verifikasi Resep'))
                        <a href="{{ route('apoteker.resep.index') }}" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                            Periksa
                        </a>
                    @elseif(auth()->user()->can('Kelola Pesanan Online'))
                        <a href="{{ route('admin.resep.index') }}" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                            Periksa
                        </a>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between hover:shadow-md transition">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
                <h3 class="text-2xl font-extrabold text-slate-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Transactions Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between hover:shadow-md transition">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Transaksi</span>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ number_format($totalTransaksi, 0, ',', '.') }}</h3>
            </div>
            <div class="p-3 bg-blue-50 text-blue-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>

        <!-- Medicines Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between hover:shadow-md transition">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Produk Obat</span>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ number_format($totalObat, 0, ',', '.') }}</h3>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between hover:shadow-md transition">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pelanggan</span>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ number_format($totalPelanggan, 0, ',', '.') }}</h3>
            </div>
            <div class="p-3 bg-cyan-50 text-cyan-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-8 0v2m8 0H9m4-10a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Graphics and Warnings Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sales Chart Card -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Ringkasan Analitik</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Grafik performa transaksi dan pendapatan</p>
                </div>
                <select id="filterAnalitik" class="border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-semibold text-slate-600 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer">
                    <option value="harian">Harian (30 Hari)</option>
                    <option value="mingguan">Mingguan (12 Minggu)</option>
                    <option value="bulanan" selected>Bulanan (12 Bulan)</option>
                    <option value="tahunan">Tahunan (5 Tahun)</option>
                    <option value="obat_terlaris">Obat Terlaris (Top 10)</option>
                    <option value="pendapatan">Pendapatan (12 Bulan)</option>
                </select>
            </div>
            <div class="relative w-full h-[280px]">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Low Stock Warning Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
            <div class="mb-4">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 bg-amber-500 rounded-full animate-pulse"></span>
                    Stok Menipis
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Obat dengan sisa stok &le; 20 unit</p>
            </div>
            <div class="space-y-2.5 max-h-[280px] overflow-y-auto pr-1 custom-scrollbar">
                @forelse($stokRendah as $obat)
                    <div class="flex items-center justify-between p-3 bg-amber-50/50 rounded-xl border border-amber-100/50">
                        <span class="text-sm font-semibold text-slate-700 truncate pr-2" title="{{ $obat->nama_obat }}">
                            {{ $obat->nama_obat }}
                        </span>
                        <span class="px-2.5 py-1 text-xs font-bold text-amber-700 bg-amber-100/60 rounded-lg whitespace-nowrap">
                            Sisa {{ $obat->stok }}
                        </span>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                        <svg class="w-10 h-10 stroke-emerald-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs font-medium text-emerald-600">Semua stok obat aman</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Expired Warning Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
            <div class="mb-4">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 bg-rose-500 rounded-full animate-pulse"></span>
                    Hampir Kadaluarsa
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Obat kadaluarsa dalam waktu &le; 30 hari</p>
            </div>
            <div class="space-y-2.5 max-h-[280px] overflow-y-auto pr-1 custom-scrollbar">
                @forelse($obatKadaluarsa as $obat)
                    <div class="flex items-center justify-between p-3 bg-rose-50/50 rounded-xl border border-rose-100/50">
                        <span class="text-sm font-semibold text-slate-700 truncate pr-2" title="{{ $obat->nama_obat }}">
                            {{ $obat->nama_obat }}
                        </span>
                        <span class="px-2 py-1 text-[11px] font-bold text-rose-700 bg-rose-100/60 rounded-lg whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d M Y') }}
                        </span>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                        <svg class="w-10 h-10 stroke-emerald-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs font-medium text-emerald-600">Semua obat terbebas dari kadaluarsa</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
        <div class="mb-5">
            <h3 class="font-bold text-slate-800 text-lg">Transaksi Terbaru</h3>
            <p class="text-xs text-slate-400 mt-0.5">Daftar transaksi terakhir yang dilakukan pelanggan</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-bold">
                        <th class="pb-3 whitespace-nowrap">Kode Invoice</th>
                        <th class="pb-3">Pelanggan</th>
                        <th class="pb-3">Total Harga</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($transaksiTerbaru as $trx)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 font-bold text-slate-900">
                                {{ $trx->kode_transaksi }}
                            </td>
                            <td class="py-3.5">
                                {{ $trx->user->name ?? $trx->pelanggan->nama_pelanggan ?? $trx->nama_pelanggan ?? '-' }}
                            </td>
                            <td class="py-3.5 text-emerald-600 font-semibold">
                                Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5">
                                @php
                                    $badgeStyle = match($trx->status) {
                                        'Menunggu Pembayaran' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'Menunggu Verifikasi' => 'bg-orange-50 text-orange-600 border-orange-100',
                                        'Diproses' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'Siap Diambil', 'Sedang Diantar' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'Ditolak', 'Dibatalkan' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100'
                                    };
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-bold border rounded-lg uppercase tracking-wide {{ $badgeStyle }}">
                                    {{ $trx->status }}
                                </span>
                            </td>
                            <td class="py-3.5 text-right text-slate-400">
                                {{ $trx->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">
                                Belum ada riwayat transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart');
    const filterAnalitik = document.getElementById('filterAnalitik');
    let salesChart = null;

    function renderChart(type, labels, data, datasetLabel, isCurrency) {
        if (salesChart) {
            salesChart.destroy();
        }

        const config = {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: datasetLabel,
                    data: data,
                    tension: 0.4,
                    borderColor: '#2563eb', // Indigo 600
                    backgroundColor: type === 'line' ? 'rgba(37, 99, 235, 0.05)' : '#3b82f6',
                    fill: type === 'line',
                    borderWidth: 2,
                    pointBackgroundColor: '#2563eb',
                    pointHoverRadius: 6,
                    pointRadius: type === 'line' ? 3 : 0,
                    borderRadius: type === 'bar' ? 6 : 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#f8fafc',
                        bodyColor: '#f8fafc',
                        padding: 10,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    if (isCurrency) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                                    } else {
                                        label += new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                        if (filterAnalitik.value === 'obat_terlaris') {
                                            label += ' Pcs';
                                        } else {
                                            label += ' Transaksi';
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f8fafc'
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 10, weight: '500' },
                            callback: function(value) {
                                if (isCurrency) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
                                    } else if (value >= 1000) {
                                        return 'Rp ' + (value / 1000).toFixed(0) + ' k';
                                    }
                                    return 'Rp ' + value;
                                } else {
                                    return new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 10, weight: '500' }
                        }
                    }
                }
            }
        };

        salesChart = new Chart(ctx, config);
    }

    // Initial Render
    renderChart('line', @json($chartLabels), @json($chartData), 'Total Transaksi (Bulanan)', false);

    function updateChart() {
        const filter = filterAnalitik.value;
        const url = `{{ route('api.sales-summary') }}?filter=${filter}`;

        ctx.style.opacity = 0.5;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.error || 'Gagal mengambil data') });
                }
                return response.json();
            })
            .then(data => {
                renderChart(data.chart_type, data.labels, data.data, data.dataset_label, data.is_currency);
                ctx.style.opacity = 1;
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                alert('Gagal mengambil data: ' + error.message);
                ctx.style.opacity = 1;
            });
    }

    filterAnalitik.addEventListener('change', updateChart);
});
</script>
@endpush

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection
