@extends('marketplace.layouts.app')

@section('content')

{{-- ===== HERO BANNER SECTION ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    <div class="relative rounded-[32px] overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 border border-blue-500/20 flex flex-col md:flex-row justify-between items-center min-h-[350px] sm:min-h-[400px] p-8 sm:p-12 group">
        <!-- Background subtle grid effect -->
        <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>
        
        <div class="relative z-10 max-w-xl flex flex-col justify-center h-full text-white">
            <span class="inline-block bg-white/10 border border-white/20 text-blue-100 text-[11px] font-semibold tracking-wider uppercase px-3.5 py-1.5 rounded-full mb-5 w-fit">Apotek Terpercaya</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight leading-tight mb-5">
                Kesehatan Keluarga,<br>
                <span class="text-blue-200 font-light">Prioritas Utama Kami.</span>
            </h1>
            <p class="text-blue-100/90 text-sm sm:text-base font-light mb-8 leading-relaxed max-w-md">
                Dapatkan produk kesehatan berkualitas tinggi, 100% orisinal, dan terverifikasi klinis dengan layanan pengiriman cepat langsung ke rumah Anda.
            </p>
            <div class="flex items-center gap-3">
                <a href="#produk" class="bg-white hover:bg-blue-50 text-blue-700 text-xs sm:text-sm font-semibold px-6 py-3.5 rounded-xl shadow-md shadow-blue-900/10 hover:shadow-lg transition-all duration-300">
                    Belanja Sekarang
                </a>
                <a href="#kategori" class="bg-blue-700/40 hover:bg-blue-700/60 border border-blue-400/30 text-white text-xs sm:text-sm font-medium px-6 py-3.5 rounded-xl transition-all duration-300">
                    Lihat Kategori
                </a>
            </div>
        </div>

        <div class="relative z-10 w-full md:w-1/2 h-[260px] md:h-[365px] mt-8 md:mt-0 opacity-95 pointer-events-none transition-transform duration-700 group-hover:scale-102 flex justify-center md:justify-end">
            <img src="/hero_family_banner.png" alt="Cheerful family healthcare" class="h-full object-contain object-bottom">
        </div>
    </div>
</section>

{{-- ===== QUICK CATEGORIES ===== --}}
<section id="kategori" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h2 class="text-xl font-bold text-slate-900 tracking-tight">Kategori Populer</h2>
        <p class="text-xs sm:text-sm text-slate-400 font-light mt-1">Pencarian produk berdasarkan klasifikasi kebutuhan medis</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
        @php
            $categoriesList = [
                ['Obat', 'M12 4.5v15m7.5-7.5h-15'],
                ['Vitamin', 'M12 3v18M3 12h18M5.3 5.3l13.4 13.4M5.3 18.7L18.7 5.3'],
                ['P3K', 'M9 12h6m-3-3v6m9-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['Perawatan', 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['Bayi', 'M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['Kesehatan', 'M4.5 12.75l6 6 9-13.5'],
                ['Alat Medis', 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751A11.956 11.956 0 0112 2.714z'],
                ['Gigi', 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z']
            ];
        @endphp
        @foreach($categoriesList as $item)
            <a href="#" class="group flex flex-col items-center justify-center p-5 bg-white border border-slate-100 rounded-2xl hover:border-blue-200 hover:shadow-md hover:shadow-blue-500/5 transition-all duration-300 text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 bg-blue-50/60 border border-blue-100/60 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item[1] }}" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-800 group-hover:text-blue-600 transition-colors">{{ $item[0] }}</span>
            </a>
        @endforeach
    </div>
</section>

{{-- ===== UIFIED PRODUCT CATALOG SECTION ===== --}}
<section id="produk" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Produk Unggulan Kami</h2>
            <p class="text-xs sm:text-sm text-slate-400 font-light mt-1">Daftar obat, vitamin, dan suplemen pilihan berkualitas tinggi</p>
        </div>
        <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1">
            Lihat Semua Produk
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @php
            $featuredProducts = [
                ['/premium_supplement_bottle.png', 'Mekar Multivitamin 60 Caps', 'Rp 115.000', '4.9', 320, 'Populer'],
                ['/premium_medicine_box.png', 'Mekar Paracetamol 500mg Box', 'Rp 28.000', '4.8', 840, null],
                ['/premium_supplement_bottle.png', 'Vitamin C 1000mg Pure White', 'Rp 65.000', '4.9', 150, 'Diskon 25%'],
                ['/premium_medicine_box.png', 'Antiseptik Cair 100ml', 'Rp 24.000', '4.7', 95, null],
                ['/premium_supplement_bottle.png', 'Mekar Vitamin D3 Liquid', 'Rp 75.000', '4.7', 240, null],
                ['/premium_medicine_box.png', 'Mekar Antasida Cair 150ml', 'Rp 18.000', '4.9', 410, 'Terlaris'],
                ['/premium_supplement_bottle.png', 'Omega-3 Fish Oil Pure', 'Rp 95.000', '4.8', 120, null],
                ['/premium_medicine_box.png', 'Mekar Masker Medis 3-ply', 'Rp 35.000', '4.8', 510, null]
            ];
        @endphp
        @foreach($featuredProducts as $p)
            <div class="group bg-white border border-slate-100 rounded-3xl overflow-hidden hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 flex flex-col justify-between">
                <div class="relative">
                    <!-- Badge -->
                    @if($p[5])
                        <div class="absolute left-4 top-4 z-10">
                            <span class="bg-blue-50 text-blue-600 border border-blue-100/60 text-[10px] font-semibold px-2.5 py-1 rounded-lg">
                                {{ $p[5] }}
                            </span>
                        </div>
                    @endif

                    <div class="bg-slate-50/40 h-48 flex items-center justify-center p-6 relative overflow-hidden transition-colors group-hover:bg-blue-50/10">
                        <img src="{{ $p[0] }}" alt="{{ $p[1] }}" class="h-32 object-contain transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <div class="p-5">
                        <h3 class="text-xs sm:text-sm font-medium text-slate-800 mb-2 line-clamp-2 h-10 leading-relaxed group-hover:text-blue-600 transition-colors">
                            {{ $p[1] }}
                        </h3>
                        <div class="flex items-center gap-1 mb-2">
                            <span class="text-yellow-400 text-xs">★</span>
                            <span class="text-xs text-slate-500 font-semibold">{{ $p[3] }}</span>
                            <span class="text-slate-200 text-xs mx-1">|</span>
                            <span class="text-xs text-slate-400 font-light">{{ $p[4] }} terjual</span>
                        </div>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <div class="text-blue-600 text-base sm:text-lg font-bold mb-4">{{ $p[2] }}</div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm shadow-blue-600/10 hover:shadow-md hover:shadow-blue-600/20 transition-all duration-300 flex items-center justify-center gap-1.5">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Keranjang
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ===== VALUES / ADVANTAGES ===== --}}
<section class="bg-blue-50/20 border-t border-blue-100/30 py-16 mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-slate-900 tracking-tight text-center mb-2">Standar Mutu Mekar Pharmacy</h2>
        <p class="text-xs sm:text-sm text-slate-400 font-light text-center mb-12">Layanan terbaik untuk menjamin kenyamanan dan kesehatan Anda</p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Value 1 -->
            <div class="flex flex-col items-center text-center p-6 bg-white border border-slate-100 rounded-3xl hover:border-blue-200 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300">
                <div class="w-14 h-14 bg-blue-50 border border-blue-100/60 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-800 mb-2">Produk Original</h3>
                <p class="text-xs text-slate-400 font-light leading-relaxed">Jaminan keaslian bersertifikasi resmi langsung dari distributor utama terdaftar BPOM.</p>
            </div>

            <!-- Value 2 -->
            <div class="flex flex-col items-center text-center p-6 bg-white border border-slate-100 rounded-3xl hover:border-blue-200 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300">
                <div class="w-14 h-14 bg-indigo-50 border border-indigo-100/60 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-800 mb-2">Pengiriman Cepat</h3>
                <p class="text-xs text-slate-400 font-light leading-relaxed">Layanan kurir langsung dan same-day delivery higienis untuk menjaga mutu sediaan obat.</p>
            </div>

            <!-- Value 3 -->
            <div class="flex flex-col items-center text-center p-6 bg-white border border-slate-100 rounded-3xl hover:border-blue-200 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300">
                <div class="w-14 h-14 bg-blue-50 border border-blue-100/60 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM15.008 12.008a.75.75 0 11-.75-.75.75.75 0 01.75.75zm-6.75 0a.75.75 0 11-.75-.75.75.75 0 01.75.75zM12 18.75a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-800 mb-2">Konsultasi Apoteker</h3>
                <p class="text-xs text-slate-400 font-light leading-relaxed">Komunikasi real-time 24/7 bersama apoteker berlisensi untuk pemakaian rasional obat.</p>
            </div>

            <!-- Value 4 -->
            <div class="flex flex-col items-center text-center p-6 bg-white border border-slate-100 rounded-3xl hover:border-blue-200 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300">
                <div class="w-14 h-14 bg-indigo-50 border border-indigo-100/60 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751A11.956 11.956 0 0112 2.714z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-800 mb-2">Pembayaran Aman</h3>
                <p class="text-xs text-slate-400 font-light leading-relaxed">Sistem enkripsi bersertifikat tinggi untuk transaksi perbankan dan data personal terjamin aman.</p>
            </div>

        </div>
    </div>
</section>

@endsection
