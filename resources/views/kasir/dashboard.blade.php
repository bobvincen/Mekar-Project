@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')

{{-- Welcome Section --}}
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
            Selamat Datang, {{ Auth::user()->name }}! 👋
        </h1>
        <p class="text-slate-500 mt-1">
            Pantau aktivitas penjualan dan sediaan obat apotek hari ini.
        </p>
    </div>
    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl shadow-sm text-sm font-medium flex items-center gap-2">
        <span>📅</span> {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>

{{-- Quick Statistics --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">Status Shift</p>
            <h3 class="text-lg font-bold text-slate-700 mt-1">Shift Aktif</h3>
            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-green-50 text-green-600 rounded-full">
                Petugas Kasir
            </span>
        </div>
        <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-xl">
            🕒
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">Laci Kasir</p>
            <h3 class="text-lg font-bold text-slate-700 mt-1">Rp 1.500.000</h3>
            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-blue-50 text-blue-600 rounded-full">
                Modal Awal Aman
            </span>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-xl">
            💼
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">Sistem Server</p>
            <h3 class="text-lg font-bold text-slate-700 mt-1">Online</h3>
            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-cyan-50 text-cyan-600 rounded-full">
                Sinkronisasi Aktif
            </span>
        </div>
        <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-xl">
            ⚡
        </div>
    </div>
</div>

{{-- Features Section --}}
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Fitur & Hak Akses Kasir</h2>
    <p class="text-slate-400 text-sm mt-0.5">Daftar modul aplikasi yang didelegasikan untuk menunjang pekerjaan Anda:</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Card 1: POS --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:border-blue-200 transition-all duration-300 flex flex-col justify-between group">
        <div>
            <div class="w-12 h-12 bg-blue-50 border border-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.7 2.766-7.254m-14.71 7.254L4.765 4.5H2.25m3.75 0h14.25M7.5 14.25v2.25M16.5 14.25v2.25m-9-2.25h9M7.5 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm9 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Input Transaksi Baru (POS)</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed mb-6">
                Modul kasir utama untuk memproses pembayaran belanja obat pelanggan, menghitung diskon/promo, kalkulasi kembalian uang, dan mencetak struk belanja fisik maupun digital.
            </p>
        </div>
        <div>
            <a href="#" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5">
                <span>🛒</span> Buka Menu Transaksi (Hubungi Admin)
            </a>
        </div>
    </div>

    {{-- Card 2: Stock Check --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 flex flex-col justify-between group">
        <div>
            <div class="w-12 h-12 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Cek Stok Obat</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed mb-6">
                Cari sediaan obat apotek secara instan. Menampilkan detail nama obat, klasifikasi kategori (terbatas/bebas), sisa kuantitas stok di laci/rak apotek, serta masa kedaluwarsa produk.
            </p>
        </div>
        <div>
            <a href="#" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5">
                <span>💊</span> Periksa Persediaan Obat (Hubungi Admin)
            </a>
        </div>
    </div>

    {{-- Card 3: Customers --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:border-cyan-200 transition-all duration-300 flex flex-col justify-between group">
        <div>
            <div class="w-12 h-12 bg-cyan-50 border border-cyan-100 text-cyan-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Manajemen Pelanggan</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed mb-6">
                Daftarkan pelanggan baru ke program loyalitas apotek secara langsung saat checkout. Cari nomor kontak pelanggan, periksa riwayat obat mereka, serta kelola poin reward.
            </p>
        </div>
        <div>
            <a href="#" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5">
                <span>👥</span> Kelola Anggota Pelanggan (Hubungi Admin)
            </a>
        </div>
    </div>

    {{-- Card 4: Reports --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:border-slate-300 transition-all duration-300 flex flex-col justify-between group">
        <div>
            <div class="w-12 h-12 bg-slate-50 border border-slate-200 text-slate-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-slate-700 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Laporan & Rekap Penjualan Shift</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed mb-6">
                Lihat dan ekspor total omzet penjualan bersih yang berhasil Anda bukukan selama shift aktif berlangsung untuk memudahkan perhitungan serah terima modal laci kasir.
            </p>
        </div>
        <div>
            <a href="#" class="w-full bg-slate-700 hover:bg-slate-800 text-white text-xs font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5">
                <span>📊</span> Unduh Rekap Harian (Hubungi Admin)
            </a>
        </div>
    </div>

</div>

@endsection
