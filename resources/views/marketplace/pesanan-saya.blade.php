@extends('marketplace.layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
@php
    $formatRp = fn(int $amount): string => 'Rp ' . number_format($amount, 0, ',', '.');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

    {{-- 
        ========================================================
        HEADER HALAMAN
        Berisi breadcrumb navigasi dan judul halaman riwayat pesanan.
        ======================================================== 
    --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1 text-sm text-slate-400">
                <a href="/" class="hover:text-blue-600 transition-colors">Beranda</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-blue-600 font-medium">Pesanan Saya</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Riwayat Pesanan Anda</h1>
            <p class="text-sm text-slate-400 font-light mt-1">Lacak status pembayaran, verifikasi, dan pengiriman obat Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- 
            ========================================================
            KOLOM KIRI: DAFTAR TRANSAKSI
            Menampilkan loop seluruh transaksi pengguna dari yang terbaru.
            Jika kosong, akan menampilkan pesan 'Belum Ada Transaksi'.
            ======================================================== 
        --}}
        <div class="lg:col-span-2 space-y-4">
            <h2 class="font-bold text-slate-800 text-lg tracking-tight mb-2">Daftar Transaksi</h2>
            
            @forelse($transaksis as $trx)
            <div class="bg-white border border-slate-100 rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-200 space-y-4">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">No. Invoice</span>
                        <a href="{{ route('marketplace.invoice', $trx->kode_transaksi) }}" class="font-bold text-slate-800 font-mono text-base hover:text-blue-600 transition-colors">
                            {{ $trx->kode_transaksi }}
                        </a>
                        <span class="text-xs text-slate-400 block mt-1">
                            {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y, H:i') }}
                        </span>
                    </div>

                    @php
                        $statusBadge = match($trx->status) {
                            'Menunggu Pembayaran' => 'bg-amber-50 text-amber-600 border-amber-200',
                            'Menunggu Verifikasi' => 'bg-blue-50 text-blue-600 border-blue-200',
                            'Ditolak' => 'bg-red-50 text-red-600 border-red-200',
                            'Diproses' => 'bg-sky-50 text-sky-600 border-sky-200',
                            'Siap Diambil', 'Sedang Diantar' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                            'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                            'Dibatalkan' => 'bg-slate-50 text-slate-500 border-slate-200',
                            default => 'bg-slate-50 text-slate-500 border-slate-200',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusBadge }}">
                        {{ $trx->status }}
                    </span>
                </div>

                {{-- Ringkasan pesanan di dalam card transaksi (Metode Pengambilan & Total) --}}
                <div class="text-sm text-slate-600 bg-slate-50/50 rounded-2xl p-4 border border-slate-50">
                    <div class="flex justify-between items-center">
                        <span class="font-light text-xs uppercase tracking-wider text-slate-400">Metode</span>
                        <span class="font-semibold text-slate-800">{{ $trx->metode_pengambilan }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                        <span class="font-light text-xs uppercase tracking-wider text-slate-400">Total Pembayaran</span>
                        <span class="font-bold text-slate-800">{{ $formatRp($trx->total_harga) }}</span>
                    </div>
                </div>

                {{-- Tombol Aksi: Lihat Invoice Detail & Cetak PDF --}}
                <div class="flex flex-wrap gap-2 pt-2 justify-end">
                    <a href="{{ route('marketplace.invoice', $trx->kode_transaksi) }}"
                        class="bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 hover:border-blue-200 font-bold text-xs px-4 py-2.5 rounded-xl transition-all shadow-sm">
                        👁 Lihat Invoice / Upload Bukti
                    </a>
                    <a href="{{ route('marketplace.invoice.download', $trx->kode_transaksi) }}"
                        class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition-all shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        PDF
                    </a>
                </div>
            </div>
            @empty
            <div class="bg-white border border-slate-100 rounded-3xl p-12 text-center shadow-sm">
                <span class="text-4xl">📦</span>
                <h3 class="font-bold text-slate-800 mt-3 text-base">Belum Ada Transaksi</h3>
                <p class="text-sm text-slate-400 font-light mt-1">Anda belum melakukan pemesanan obat secara online.</p>
                <a href="/" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-6 py-3 rounded-2xl shadow-md transition-colors">
                    Mulai Belanja
                </a>
            </div>
            @endforelse
        </div>

        {{-- 
            ========================================================
            KOLOM KANAN: RIWAYAT PEMBELIAN OBAT (REORDER)
            Mengambil semua obat unik yang pernah dibeli pengguna 
            dari transaksi yang berstatus "Selesai", sehingga memudahkan
            pengguna untuk membeli obat yang sama secara berulang.
            ======================================================== 
        --}}
        <div class="space-y-6">
            <h2 class="font-bold text-slate-800 text-lg tracking-tight mb-2">Riwayat Pembelian Obat</h2>
            
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                @php
                    // Get all unique medicines from successfully completed orders
                    $completedTrxs = $transaksis->where('status', 'Selesai');
                    $purchasedObats = [];
                    foreach($completedTrxs as $trx) {
                        foreach($trx->detailTransaksis as $detail) {
                            if($detail->obat) {
                                $purchasedObats[$detail->obat->id] = [
                                    'nama' => $detail->obat->nama_obat,
                                    'kategori' => $detail->obat->kategori->nama_kategori ?? '-',
                                    'harga' => $detail->harga,
                                ];
                            }
                        }
                    }
                @endphp

                @forelse($purchasedObats as $id => $obat)
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50 last:border-0 last:pb-0">
                    <div>
                        <h4 class="font-semibold text-slate-800 text-sm">{{ $obat['nama'] }}</h4>
                        <span class="text-[10px] text-slate-400 font-medium block">Kategori: {{ $obat['kategori'] }}</span>
                    </div>
                    <a href="{{ route('marketplace.showProduct', $id) }}" 
                        class="text-xs font-bold text-blue-600 bg-blue-50/50 hover:bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100/50 transition-colors">
                        Beli Lagi
                    </a>
                </div>
                @empty
                <div class="text-center py-6 text-slate-400 text-sm">
                    <span class="text-2xl block mb-2">💊</span>
                    Belum ada obat yang selesai dibeli.
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
