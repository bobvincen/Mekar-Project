@extends('layouts.app')

@section('title', 'Detail Transaksi POS')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('transaksi.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Detail Transaksi POS</h1>
                <p class="text-xs text-slate-500 mt-0.5 font-mono">{{ $transaksi->kode_transaksi }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('transaksi.edit', $transaksi) }}" class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white rounded-xl font-semibold text-xs shadow transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Stok obat akan dikembalikan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 rounded-xl font-bold text-xs transition inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Notification Alerts -->
    @if(session('success'))
        <div class="bg-green-50 text-green-600 border border-green-200 px-4 py-3.5 rounded-2xl flex items-center justify-between gap-3 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 font-bold text-xs p-1">✕</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        {{-- Kiri: Info & Pembayaran --}}
        <div class="space-y-6">
            <!-- Info Transaksi Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-5">
                <h2 class="text-sm font-extrabold text-slate-800 border-b border-slate-50 pb-2.5 mb-4">Info Transaksi</h2>
                <table class="w-full text-xs font-semibold text-slate-600 leading-relaxed">
                    <tbody class="divide-y divide-slate-50">
                        <tr>
                            <td class="py-2.5 text-slate-400">Kode Transaksi</td>
                            <td class="py-2.5 font-mono font-bold text-blue-600 text-right">{{ $transaksi->kode_transaksi }}</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-slate-400">Tanggal & Waktu</td>
                            <td class="py-2.5 text-right text-slate-800">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-slate-400">Pelanggan</td>
                            <td class="py-2.5 text-right text-slate-800 font-bold">{{ $transaksi->pelanggan->nama_pelanggan ?? '— Umum —' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-slate-400">Kasir Pencatat</td>
                            <td class="py-2.5 text-right text-slate-800 font-bold">{{ $transaksi->user->name ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pembayaran Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-5">
                <h2 class="text-sm font-extrabold text-slate-800 border-b border-slate-50 pb-2.5 mb-4">Rincian Pembayaran</h2>
                <table class="w-full text-xs font-semibold text-slate-600 leading-relaxed">
                    <tbody class="divide-y divide-slate-50">
                        <tr>
                            <td class="py-2.5 text-slate-400">Total Tagihan</td>
                            <td class="py-2.5 font-extrabold text-slate-900 text-right text-sm">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-slate-400">Tunai Dibayar</td>
                            <td class="py-2.5 text-right text-slate-800">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-slate-400 font-bold">Uang Kembalian</td>
                            <td class="py-2.5 font-extrabold text-emerald-600 text-right text-sm">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Kanan: Item Obat --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
                <div class="p-5 border-b border-slate-50 bg-slate-50/25 flex items-center gap-2">
                    <h2 class="text-sm font-extrabold text-slate-800">Item Obat Terbeli</h2>
                    <span class="px-2.5 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 rounded-lg">
                        {{ $transaksi->detailTransaksis->count() }} item
                    </span>
                </div>

                <table class="w-full text-sm text-left border-collapse table-auto">
                    <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                        <tr>
                            <th class="py-4 px-5">Nama Obat</th>
                            <th class="py-4 px-5 text-right w-36">Harga Satuan</th>
                            <th class="py-4 px-5 text-center w-24">Jumlah</th>
                            <th class="py-4 px-5 text-right w-36">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                        @foreach($transaksi->detailTransaksis as $detail)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-800">
                                    {{ $detail->obat->nama_obat ?? '-' }}
                                </td>
                                <td class="py-3.5 px-5 text-right text-slate-500 whitespace-nowrap">
                                    Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="px-2.5 py-0.5 text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200 rounded-lg">
                                        {{ $detail->jumlah }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-right font-bold text-slate-800 whitespace-nowrap">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50/50 border-t border-slate-150">
                        <tr>
                            <td colspan="3" class="py-4 px-5 text-right font-bold text-slate-500">Total Transaksi</td>
                            <td class="py-4 px-5 text-right font-extrabold text-slate-900 text-base whitespace-nowrap">
                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection