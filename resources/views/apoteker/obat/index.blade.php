@extends('layouts.app')

@section('title', 'Ketersediaan Obat')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Ketersediaan Obat</h2>
        <p class="text-sm text-gray-500 mt-1">Cari obat dan periksa jumlah stok obat saat ini</p>
    </div>
    
    <!-- Filter Stok Rendah Quick Toggle -->
    <div>
        @if($stokRendah == '1')
            <a href="{{ route('apoteker.obat.index', ['search' => $search]) }}" class="bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <span>⚠️</span> Menampilkan Stok Rendah (Matikan Filter)
            </a>
        @else
            <a href="{{ route('apoteker.obat.index', ['stok_rendah' => 1, 'search' => $search]) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                <span>⚠️</span> Filter Stok Rendah (≤ 20)
            </a>
        @endif
    </div>
</div>

<!-- Search Panel -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <form action="{{ route('apoteker.obat.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <!-- Keep active filter value -->
        @if($stokRendah)
            <input type="hidden" name="stok_rendah" value="1">
        @endif
        
        <div class="flex-1 relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama obat atau kode obat..."
                class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <div class="absolute left-3.5 top-3.5 text-gray-400">
                🔍
            </div>
        </div>
        
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow transition">
            Cari Obat
        </button>
        
        @if($search || $stokRendah)
            <a href="{{ route('apoteker.obat.index') }}" class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-2.5 rounded-xl font-semibold transition flex items-center justify-center">
                Reset
            </a>
        @endif
    </form>
</div>

<!-- Medicines Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                    <th class="py-4 px-6 font-semibold">Kode</th>
                    <th class="py-4 px-6 font-semibold">Nama Obat</th>
                    <th class="py-4 px-6 font-semibold">Kategori</th>
                    <th class="py-4 px-6 font-semibold">Supplier</th>
                    <th class="py-4 px-6 font-semibold">Kadaluarsa</th>
                    <th class="py-4 px-6 font-semibold text-right">Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($obats as $obat)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-4 px-6 font-mono text-xs text-gray-500">
                        {{ $obat->kode_obat }}
                    </td>
                    <td class="py-4 px-6 font-semibold text-gray-900">
                        {{ $obat->nama_obat }}
                    </td>
                    <td class="py-4 px-6">
                        {{ $obat->kategori->nama_kategori ?? '-' }}
                    </td>
                    <td class="py-4 px-6 text-gray-500">
                        {{ $obat->supplier->nama_supplier ?? '-' }}
                    </td>
                    <td class="py-4 px-6 whitespace-nowrap">
                        @php
                            $expiryDate = \Carbon\Carbon::parse($obat->tanggal_kadaluarsa);
                            $isExpiredSoon = $expiryDate->isBefore(now()->addDays(30));
                        @endphp
                        <span class="{{ $isExpiredSoon ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                            {{ $expiryDate->format('d M Y') }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right whitespace-nowrap">
                        @if($obat->stok <= 20)
                            <span class="px-2 py-1 text-xs font-bold bg-red-50 text-red-600 rounded">
                                {{ $obat->stok }} Pcs
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-bold bg-green-50 text-green-700 rounded">
                                {{ $obat->stok }} Pcs
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-4">
                            <span class="text-4xl mb-3">🔍</span>
                            <p>Tidak ditemukan data obat yang sesuai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($obats->hasPages())
    <div class="mt-4">
        {{ $obats->links() }}
    </div>
@endif
@endsection
