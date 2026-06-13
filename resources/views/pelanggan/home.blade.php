@extends('layouts.app')

@section('title', 'Beranda Pelanggan')

@section('content')

{{-- Welcome Section --}}
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
            Selamat Datang, {{ Auth::user()->name }}! 👋
        </h1>
        <p class="text-slate-500 mt-1">
            Temukan obat, vitamin, dan kelola kesehatan keluarga Anda dengan mudah di Mekar Pharmacy.
        </p>
    </div>
    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl shadow-sm text-sm font-medium flex items-center gap-2">
        <span>📅</span> {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>

{{-- Quick Statistics / Member Card --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Member Status --}}
    <div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white rounded-3xl p-6 shadow-md relative overflow-hidden">
        <div class="absolute right-0 bottom-0 opacity-10 text-9xl transform translate-x-8 translate-y-8 font-bold pointer-events-none">
            M
        </div>
        <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold bg-white/20 text-blue-100 rounded-full uppercase tracking-wider">
            Kartu Anggota
        </span>
        <h3 class="text-2xl font-bold mt-4 tracking-tight">Pelanggan Prioritas</h3>
        <p class="text-xs text-blue-200 mt-1 font-light">ID Anggota: MEKAR-{{ str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>

    {{-- Loyalty Points --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">Poin Loyalitas</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">150 Poin</h3>
            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-yellow-50 text-yellow-600 rounded-full">
                Tukar dengan Voucher Belanja
            </span>
        </div>
        <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-xl">
            🏆
        </div>
    </div>

    {{-- Account Status --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <p class="text-slate-400 text-sm font-medium">Status Akun</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">Terverifikasi</h3>
            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-green-50 text-green-600 rounded-full">
                Akun Aktif & Aman
            </span>
        </div>
        <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-xl">
            🛡️
        </div>
    </div>
</div>

{{-- Features Section --}}
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Fitur Layanan Pelanggan</h2>
    <p class="text-slate-400 text-sm mt-0.5">Semua fitur utama yang dapat Anda gunakan sebagai pelanggan Mekar Pharmacy:</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Card 1: Shop Marketplace --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:border-blue-200 transition-all duration-300 flex flex-col justify-between group">
        <div>
            <div class="w-12 h-12 bg-blue-50 border border-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Belanja Obat & Vitamin</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed mb-6">
                Jelajahi katalog obat apotek kami. Cari obat bebas, suplemen kesehatan, multivitamin harian, perlengkapan P3K, dan alat kesehatan dengan harga terbaik dan bersertifikat BPOM.
            </p>
        </div>
        <div>
            <a href="/marketplace" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5">
                <span>🏪</span> Mulai Belanja Sekarang
            </a>
        </div>
    </div>

    {{-- Card 2: Cart --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 flex flex-col justify-between group">
        <div>
            <div class="w-12 h-12 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.7 2.766-7.254m-14.71 7.254L4.765 4.5H2.25m3.75 0h14.25M7.5 14.25v2.25M16.5 14.25v2.25m-9-2.25h9M7.5 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm9 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Keranjang Belanja Anda</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed mb-6">
                Lihat daftar produk kesehatan yang telah Anda pilih. Periksa kuantitas item, masukkan voucher diskon, dan lakukan checkout untuk proses pembayaran yang mudah dan aman.
            </p>
        </div>
        <div>
            <a href="/cart" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5">
                <span>🛒</span> Buka Keranjang Belanja
            </a>
        </div>
    </div>

    {{-- Card 3: Purchase History --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:border-cyan-200 transition-all duration-300 flex flex-col justify-between group">
        <div>
            <div class="w-12 h-12 bg-cyan-50 border border-cyan-100 text-cyan-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Riwayat Transaksi Pembelian</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed mb-6">
                Pantau status pengiriman obat yang sedang berjalan, dan periksa kembali daftar transaksi pembelian obat sebelumnya. Simpan arsip resep digital secara terorganisir.
            </p>
        </div>
        <div>
            <a href="#" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5">
                <span>🧾</span> Riwayat Transaksi (Fitur Terbatas)
            </a>
        </div>
    </div>

    {{-- Card 4: Settings --}}
    <div class="bg-white border border-slate-100 rounded-3xl p-6 hover:shadow-xl hover:border-slate-300 transition-all duration-300 flex flex-col justify-between group">
        <div>
            <div class="w-12 h-12 bg-slate-50 border border-slate-200 text-slate-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-slate-700 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Ubah Data Profil & Alamat</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed mb-6">
                Perbarui alamat pengiriman obat utama Anda untuk kurir same-day, lengkapi nomor telepon aktif untuk konfirmasi kurir, serta ganti kata sandi keamanan berkala Anda.
            </p>
        </div>
        <div>
            <a href="/profile" class="w-full bg-slate-700 hover:bg-slate-800 text-white text-xs font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5">
                <span>👤</span> Kelola Profil & Alamat Pengiriman
            </a>
        </div>
    </div>

</div>

@endsection
