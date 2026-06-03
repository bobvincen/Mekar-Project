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

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

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


</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

    <!-- Grafik -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow p-6">

        <h3 class="text-xl font-semibold mb-4">
            Ringkasan Penjualan
        </h3>

        <canvas id="salesChart"></canvas>

    </div>

    <!-- Stok Rendah -->
    <div class="bg-white rounded-3xl shadow p-6">

    <h3 class="text-xl font-semibold text-orange-600 mb-4">
        ⚠ Peringatan Stok Rendah
    </h3>

    <div class="space-y-3">

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

new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            'Jan','Feb','Mar','Apr',
            'Mei','Jun','Jul','Agu',
            'Sep','Okt','Nov','Des'
        ],
        datasets: [{
            label: 'Penjualan',
            data: [20,25,18,40,45,28,75,30,42,20,48,55],
            tension: 0.4
        }]
    }
});

</script>

@endpush

@endsection

