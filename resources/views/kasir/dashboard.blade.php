@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Welcome Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau aktivitas penjualan langsung dan persediaan obat apotek hari ini.</p>
        </div>
        <div class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl shadow-sm text-xs font-bold inline-flex items-center gap-1.5">
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
            </svg>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <!-- Quick Statistics KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Status Shift -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Kerja</span>
                <h3 class="text-lg font-extrabold text-slate-800">Shift Aktif</h3>
                <span class="inline-block px-2 py-0.5 text-[10px] font-bold bg-green-50 text-green-600 border border-green-100 rounded-lg">
                    Petugas Kasir
                </span>
            </div>
            <div class="p-3 bg-green-50 text-green-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Laci Kasir -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laci Kasir</span>
                <h3 class="text-lg font-extrabold text-slate-800">Rp 1.500.000</h3>
                <span class="inline-block px-2 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 rounded-lg">
                    Modal Awal
                </span>
            </div>
            <div class="p-3 bg-blue-50 text-blue-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
        </div>

        <!-- Sistem Server -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Koneksi Sistem</span>
                <h3 class="text-lg font-extrabold text-slate-800">Online</h3>
                <span class="inline-block px-2 py-0.5 text-[10px] font-bold bg-cyan-50 text-cyan-600 border border-cyan-100 rounded-lg">
                    Sinkronisasi Realtime
                </span>
            </div>
            <div class="p-3 bg-cyan-50 text-cyan-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Features Section Grid -->
    <div>
        <div class="mb-4">
            <h2 class="text-lg font-extrabold text-slate-800">Fitur & Pintasan Layanan POS</h2>
            <p class="text-xs text-slate-450 mt-0.5">Akses cepat ke modul penjualan kasir untuk menunjang transaksi harian Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- POS Card -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between group hover:border-blue-200 transition duration-300">
                <div class="space-y-3">
                    <div class="w-11 h-11 bg-blue-50 border border-blue-100 text-blue-500 rounded-xl flex items-center justify-center transition-colors group-hover:bg-blue-600 group-hover:text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">Transaksi Kasir POS</h3>
                    <p class="text-xs text-slate-400 font-semibold leading-relaxed">
                        Input transaksi pembelian obat secara langsung (POS offline) untuk pelanggan umum atau terdaftar, hitung kembalian instan, dan cetak invoice struk.
                    </p>
                </div>
                <div class="mt-6">
                    <a href="{{ route('transaksi.create') }}" class="w-full py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-1.5">
                        Buka POS Penjualan
                    </a>
                </div>
            </div>

            <!-- Cek Stok Obat -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between group hover:border-indigo-200 transition duration-300">
                <div class="space-y-3">
                    <div class="w-11 h-11 bg-indigo-50 border border-indigo-100 text-indigo-500 rounded-xl flex items-center justify-center transition-colors group-hover:bg-indigo-600 group-hover:text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">Cek Persediaan Obat</h3>
                    <p class="text-xs text-slate-400 font-semibold leading-relaxed">
                        Cek data ketersediaan obat apotek secara cepat. Menampilkan detail sisa persediaan laci stok, harga jual satuan obat, serta info tanggal kadaluarsa.
                    </p>
                </div>
                <div class="mt-6">
                    <a href="{{ route('obat.index') }}" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-1.5">
                        Lihat Data Obat
                    </a>
                </div>
            </div>

            <!-- Customer Management -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between group hover:border-cyan-200 transition duration-300">
                <div class="space-y-3">
                    <div class="w-11 h-11 bg-cyan-50 border border-cyan-100 text-cyan-500 rounded-xl flex items-center justify-center transition-colors group-hover:bg-cyan-600 group-hover:text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">Manajemen Pelanggan</h3>
                    <p class="text-xs text-slate-400 font-semibold leading-relaxed">
                        Daftarkan pelanggan baru ke program marketplace apotek, periksa nomor kontak WhatsApp terdaftar, dan lihat riwayat registrasi.
                    </p>
                </div>
                <div class="mt-6">
                    <a href="{{ route('customer.index') }}" class="w-full py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-1.5">
                        Kelola Pelanggan
                    </a>
                </div>
            </div>

            <!-- Reports Check -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between group hover:border-slate-350 transition duration-300">
                <div class="space-y-3">
                    <div class="w-11 h-11 bg-slate-50 border border-slate-150 text-slate-500 rounded-xl flex items-center justify-center transition-colors group-hover:bg-slate-700 group-hover:text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h13v6M3 7h18M5 17h2m10 0h2" />
                        </svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">Laporan Penjualan POS</h3>
                    <p class="text-xs text-slate-400 font-semibold leading-relaxed">
                        Lihat rekapitulasi nominal pendapatan omset kotor kasir apotek dan riwayat order harian yang telah berhasil diselesaikan.
                    </p>
                </div>
                <div class="mt-6">
                    <a href="{{ route('laporan.index') }}" class="w-full py-2.5 bg-slate-750 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-1.5">
                        Lihat Laporan Penjualan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
