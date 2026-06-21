@extends('layouts.app')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        Dashboard
    </h1>

    <p class="text-slate-500">
        Selamat datang di Mekar Pharmacy
    </p>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

    {{-- Total Obat --}}
   <div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500">
                Total Obat
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-2">
                {{ $totalObat }}
            </h2>

        </div>

        <div class="bg-cyan-100 p-4 rounded-2xl">

            💊

        </div>

    </div>

    </div>

    {{-- Total Supplier --}}
    <div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500">
                Total Supplier
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-2">
                {{ $totalSupplier }}
            </h2>

        </div>

        <div class="bg-cyan-100 p-4 rounded-2xl">

            🚚

        </div>

    </div>

    </div>

    {{-- Total Pelanggan --}}
    <div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500">
                Total Pelanggan
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-2">
                {{ $totalPelanggan }}
            </h2>

        </div>

        <div class="bg-cyan-100 p-4 rounded-2xl">

            👥

        </div>

    </div>

    </div>

    {{-- Total Transaksi --}}
    <div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500">
                Total Transaksi
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-2">
                {{ $totalTransaksi }}
            </h2>

        </div>

        <div class="bg-cyan-100 p-4 rounded-2xl">

            💰

        </div>

    </div>

    </div>


    {{-- Konsultasi Hari Ini --}}
    <div class="bg-white rounded-3xl shadow-md p-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500">Konsultasi Hari Ini</p>
                <h2 class="text-4xl font-bold text-slate-800 mt-2">{{ $totalKonsultasiHariIni }}</h2>
            </div>
            <div class="bg-blue-100 p-4 rounded-2xl">📱</div>
        </div>
    </div>

    {{-- Konsultasi Bulan Ini --}}
    <div class="bg-white rounded-3xl shadow-md p-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500">Konsultasi Bulan Ini</p>
                <h2 class="text-4xl font-bold text-slate-800 mt-2">{{ $totalKonsultasiBulanIni }}</h2>
            </div>
            <div class="bg-blue-100 p-4 rounded-2xl">💬</div>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-8">

    <!-- Grafik -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow p-6">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h3 class="text-xl font-semibold text-slate-800">
                Ringkasan Penjualan
            </h3>
            
            <div class="flex flex-wrap items-center gap-2">
                {{-- Dropdown Filter --}}
                <select id="filterAnalitik" class="border border-slate-200 rounded-xl px-3 py-1.5 text-sm font-medium text-slate-600 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="harian">Harian</option>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan" selected>Bulanan</option>
                    <option value="tahunan">Tahunan</option>
                    <option value="obat_terlaris">Obat Terlaris</option>
                    <option value="pendapatan">Pendapatan</option>
                </select>
            </div>
        </div>

        <div class="relative w-full" style="height: 300px;">
            <canvas id="salesChart"></canvas>
        </div>

    </div>

    <!-- Stok Rendah -->
    <div class="bg-white rounded-3xl shadow p-6">

        <h3 class="text-xl font-semibold text-orange-600 mb-4">
            ⚠ Peringatan Stok Rendah
        </h3>

        <div class="space-y-3 max-h-80 overflow-y-auto pr-2 custom-scrollbar">

            @forelse($stokRendah as $obat)

                <div class="bg-yellow-50 rounded-xl p-4">

                    <p class="font-semibold">
                        {{ $obat->nama_obat }}
                    </p>

                    <p class="text-sm text-gray-500">
                        Sisa stok:
                        <span class="font-bold text-red-600">
                            {{ $obat->stok }}
                        </span>
                    </p>

                </div>

            @empty

                <div class="bg-green-50 rounded-xl p-4">

                    <p class="text-green-700">
                        Semua stok masih aman
                    </p>

                </div>

            @endforelse

        </div>

    </div>

    <!-- Mendekati Kadaluarsa -->
    <div class="bg-white rounded-3xl shadow p-6">

        <h3 class="text-xl font-semibold text-red-600 mb-4">
            ⏰ Mendekati Kadaluarsa
        </h3>

        <div class="space-y-3 max-h-80 overflow-y-auto pr-2 custom-scrollbar">

            @forelse($obatKadaluarsa as $obat)

                <div class="bg-red-50 rounded-xl p-4">

                    <p class="font-semibold">
                        {{ $obat->nama_obat }}
                    </p>

                    <p class="text-sm text-gray-500">
                        Kadaluarsa:
                        <span class="font-bold text-red-600">
                            {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d M Y') }}
                        </span>
                    </p>

                </div>

            @empty

                <div class="bg-green-50 rounded-xl p-4">

                    <p class="text-green-700">
                        Semua obat masih aman dari kadaluarsa
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>
<div class="bg-white rounded-3xl shadow p-6 mt-8">

    <h3 class="text-xl font-semibold mb-4">
        🧾 Transaksi Terbaru
    </h3>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-left py-3">
                        Kode
                    </th>

                    <th class="text-left py-3">
                        Pelanggan
                    </th>

                    <th class="text-left py-3">
                        Total
                    </th>

                    <th class="text-left py-3">
                        Tanggal
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($transaksiTerbaru as $trx)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="py-3">
                            {{ $trx->kode_transaksi }}
                        </td>

                        <td class="py-3">
                            {{ $trx->pelanggan->nama_pelanggan ?? '-' }}
                        </td>

                        <td class="py-3 font-semibold text-green-600">
                            Rp {{ number_format($trx->total_harga,0,',','.') }}
                        </td>

                        <td class="py-3">
                            {{ $trx->created_at->format('d M Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="text-center py-4 text-gray-500">

                            Belum ada transaksi

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

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
                borderColor: '#0ea5e9', // Sky blue color matching a modern aesthetic
                backgroundColor: type === 'line' ? 'rgba(14, 165, 233, 0.1)' : '#0ea5e9',
                fill: type === 'line',
                borderWidth: 3,
                pointBackgroundColor: '#0ea5e9',
                pointHoverRadius: 6,
                pointRadius: type === 'line' ? 3 : 0,
                borderRadius: type === 'bar' ? 8 : 0 // Rounded corners for bars
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
                    backgroundColor: '#1e293b',
                    titleColor: '#f8fafc',
                    bodyColor: '#f8fafc',
                    padding: 12,
                    cornerRadius: 12,
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
                        color: '#f1f5f9'
                    },
                    ticks: {
                        color: '#64748b',
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
                        color: '#64748b'
                    }
                }
            }
        }
    };

    salesChart = new Chart(ctx, config);
}

// Setup dynamic AJAX filters
document.addEventListener('DOMContentLoaded', function() {
    // Initial Render: Bulanan (Total Transaksi per Bulan)
    renderChart('line', @json($chartLabels), @json($chartData), 'Total Transaksi (Bulanan)', false);

    function updateChart() {
        const filter = filterAnalitik.value;
        const url = `{{ route('api.sales-summary') }}?filter=${filter}`;

        // Apply loading opacity to canvas
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
                alert('Gagal mengambil data penjualan: ' + error.message);
                ctx.style.opacity = 1;
            });
    }

    filterAnalitik.addEventListener('change', updateChart);
});

</script>

@endpush

@endsection

