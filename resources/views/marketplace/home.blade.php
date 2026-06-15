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

        <div class="relative z-10 w-full md:w-1/2 h-[260px] md:h-[365px] mt-8 md:mt-0 opacity-95 pointer-events-none transition-transform duration-700 group-hover:scale-102 flex justify-center md:justify-end overflow-hidden rounded-3xl">
            <img src="/keluarga.png" alt="Cheerful family healthcare" class="h-full object-cover object-center rounded-3xl">
        </div>
    </div>
</section>

{{-- ===== UPLOAD RESEP CTA ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4 sm:mb-8">
    <div class="bg-gradient-to-r from-blue-50 via-white to-cyan-50 rounded-3xl border border-blue-100 shadow-sm p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
        <!-- Decor -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5 relative z-10">
            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center shrink-0 border border-blue-100 text-blue-600">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg sm:text-xl font-bold text-blue-900 mb-1.5">Punya Resep Dokter?</h3>
                <p class="text-sm text-slate-600 font-light max-w-lg leading-relaxed">Pesan obat lebih mudah! Upload foto resep Anda, apoteker kami akan segera memproses pesanan dengan aman via WhatsApp.</p>
            </div>
        </div>

        <div class="relative z-10 shrink-0 w-full md:w-auto mt-2 md:mt-0">
            <a href="{{ route('resep.create') }}" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm sm:text-base px-8 py-4 rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 w-full md:w-auto group">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-y-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Upload Resep Sekarang
            </a>
        </div>
    </div>
</section>

{{-- ===== QUICK CATEGORIES ===== --}}
<section id="kategori" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100/80 p-6 sm:p-8">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900 tracking-tight">Kategori Populer</h2>
        <p class="text-xs sm:text-sm text-slate-400 font-light mt-1">Pencarian produk berdasarkan klasifikasi kebutuhan medis</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
        @php
            $svgs = [
                'obat' => 'M12 4.5v15m7.5-7.5h-15',
                'vitamin' => 'M12 3v18M3 12h18M5.3 5.3l13.4 13.4M5.3 18.7L18.7 5.3',
                'suplemen' => 'M12 3v18M3 12h18M5.3 5.3l13.4 13.4M5.3 18.7L18.7 5.3',
                'p3k' => 'M9 12h6m-3-3v6m9-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'perawatan' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'bayi' => 'M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'kesehatan' => 'M4.5 12.75l6 6 9-13.5',
                'alat' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751A11.956 11.956 0 0112 2.714z',
                'gigi' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
            ];
        @endphp
        @forelse($kategoris as $k)
            @php
                $lowerName = strtolower($k->nama_kategori);
                $iconSvg = 'M9 12h6m-3-3v6m9-3a9 9 0 11-18 0 9 9 0 0118 0z';
                foreach ($svgs as $key => $path) {
                    if (str_contains($lowerName, $key)) {
                        $iconSvg = $path;
                        break;
                    }
                }
            @endphp
            <a href="/category/{{ $k->id }}" class="group flex flex-col items-center justify-center p-5 bg-slate-50 border border-slate-100 rounded-2xl shadow-sm hover:border-blue-200 hover:shadow-md hover:shadow-blue-500/10 hover:-translate-y-0.5 transition-all duration-300 text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 bg-blue-50/60 border border-blue-100/60 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconSvg }}" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-800 group-hover:text-blue-600 transition-colors">{{ $k->nama_kategori }}</span>
            </a>
        @empty
            <p class="text-xs text-slate-400 col-span-full text-center">Belum ada kategori obat.</p>
        @endforelse
    </div>
    </div>{{-- end white card --}}
</section>

{{-- ===== LATEST PRODUCTS SECTION ===== --}}
<section id="produk" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100/80 p-6 sm:p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Produk Terbaru Kami</h2>
            <p class="text-xs sm:text-sm text-slate-400 font-light mt-1">Daftar obat, vitamin, dan suplemen baru masuk berkualitas tinggi</p>
        </div>
        <a href="/products" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1">
            Lihat Semua Produk
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($latestProducts as $p)
            @php
                $imgFallback = str_contains(strtolower($p->kategori->nama_kategori ?? ''), 'vitamin') 
                    ? '/premium_supplement_bottle.png' 
                    : '/premium_medicine_box.png';
                $image = $p->image ?? $p->gambar ?? $imgFallback;
                $formattedPrice = 'Rp ' . number_format($p->harga_jual, 0, ',', '.');
                $rating = number_format(4.7 + (($p->id * 7) % 4) / 10, 1);
                $sold = ($p->id * 23) % 150 + 12;
            @endphp
            <div class="group bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div class="relative">
                    <div class="absolute left-4 top-4 z-10">
                        <span class="bg-blue-50 text-blue-600 border border-blue-100/60 text-[10px] font-semibold px-2.5 py-1 rounded-lg">
                            Baru
                        </span>
                    </div>

                    <a href="/products/{{ $p->id }}" class="block bg-slate-50/40 h-48 flex items-center justify-center p-6 relative overflow-hidden transition-colors group-hover:bg-blue-50/10">
                        <img src="{{ $image }}" alt="{{ $p->nama_obat }}" class="h-32 object-contain transition-transform duration-500 group-hover:scale-105">
                    </a>

                    <div class="p-5">
                        <span class="inline-block bg-blue-50/50 text-blue-600 text-[10px] font-medium px-2 py-0.5 rounded-md mb-2">
                            {{ $p->kategori->nama_kategori ?? 'Obat' }}
                        </span>
                        <a href="/products/{{ $p->id }}" class="block">
                            <h3 class="text-xs sm:text-sm font-medium text-slate-800 mb-2 line-clamp-2 h-10 leading-relaxed group-hover:text-blue-600 transition-colors">
                                {{ $p->nama_obat }}
                            </h3>
                        </a>
                        <div class="flex items-center gap-1 mb-2">
                            <span class="text-yellow-400 text-xs">★</span>
                            <span class="text-xs text-slate-500 font-semibold">{{ $rating }}</span>
                            <span class="text-slate-200 text-xs mx-1">|</span>
                            <span class="text-xs text-slate-400 font-light">{{ $sold }} terjual</span>
                        </div>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <div class="text-blue-600 text-base sm:text-lg font-bold mb-4">{{ $formattedPrice }}</div>
                    <form action="/cart/add/{{ $p->id }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm shadow-blue-600/10 hover:shadow-md hover:shadow-blue-600/20 transition-all duration-300 flex items-center justify-center gap-1.5">
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Keranjang
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-400 col-span-full text-center py-8">Belum ada obat tersedia.</p>
        @endforelse
    </div>
    </div>{{-- end white card --}}
</section>

{{-- ===== BEST SELLERS SECTION ===== --}}
<section id="produk-terlaris" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100/80 p-6 sm:p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Produk Terlaris</h2>
            <p class="text-xs sm:text-sm text-slate-400 font-light mt-1">Daftar obat paling sering dicari dan dibutuhkan pelanggan</p>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($bestSellerProducts as $p)
            @php
                $imgFallback = str_contains(strtolower($p->kategori->nama_kategori ?? ''), 'vitamin') 
                    ? '/premium_supplement_bottle.png' 
                    : '/premium_medicine_box.png';
                $image = $p->image ?? $p->gambar ?? $imgFallback;
                $formattedPrice = 'Rp ' . number_format($p->harga_jual, 0, ',', '.');
                $rating = number_format(4.8 + (($p->id * 3) % 2) / 10, 1);
                $sold = ($p->id * 41) % 400 + 150;
            @endphp
            <div class="group bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div class="relative">
                    <div class="absolute left-4 top-4 z-10">
                        <span class="bg-blue-600 text-white text-[10px] font-semibold px-2.5 py-1 rounded-lg">
                            Terlaris
                        </span>
                    </div>

                    <a href="/products/{{ $p->id }}" class="block bg-slate-50/40 h-48 flex items-center justify-center p-6 relative overflow-hidden transition-colors group-hover:bg-blue-50/10">
                        <img src="{{ $image }}" alt="{{ $p->nama_obat }}" class="h-32 object-contain transition-transform duration-500 group-hover:scale-105">
                    </a>

                    <div class="p-5">
                        <span class="inline-block bg-blue-50/50 text-blue-600 text-[10px] font-medium px-2 py-0.5 rounded-md mb-2">
                            {{ $p->kategori->nama_kategori ?? 'Obat' }}
                        </span>
                        <a href="/products/{{ $p->id }}" class="block">
                            <h3 class="text-xs sm:text-sm font-medium text-slate-800 mb-2 line-clamp-2 h-10 leading-relaxed group-hover:text-blue-600 transition-colors">
                                {{ $p->nama_obat }}
                            </h3>
                        </a>
                        <div class="flex items-center gap-1 mb-2">
                            <span class="text-yellow-400 text-xs">★</span>
                            <span class="text-xs text-slate-500 font-semibold">{{ $rating }}</span>
                            <span class="text-slate-200 text-xs mx-1">|</span>
                            <span class="text-xs text-slate-400 font-light">{{ $sold }} terjual</span>
                        </div>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <div class="text-blue-600 text-base sm:text-lg font-bold mb-4">{{ $formattedPrice }}</div>
                    <form action="/cart/add/{{ $p->id }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm shadow-blue-600/10 hover:shadow-md hover:shadow-blue-600/20 transition-all duration-300 flex items-center justify-center gap-1.5">
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Keranjang
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-400 col-span-full text-center py-8">Belum ada obat terlaris.</p>
        @endforelse
    </div>
    </div>{{-- end white card --}}
</section>

{{-- ===== VALUES / ADVANTAGES ===== --}}
<section class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100/80 p-8 sm:p-10">
        <h2 class="text-xl font-bold text-slate-900 tracking-tight text-center mb-2">Standar Mutu Mekar Pharmacy</h2>
        <p class="text-xs sm:text-sm text-slate-400 font-light text-center mb-10">Layanan terbaik untuk menjamin kenyamanan dan kesehatan Anda</p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Value 1 -->
            <div class="flex flex-col items-center text-center p-6 bg-slate-50 border border-slate-100 rounded-3xl shadow-sm hover:border-blue-200 hover:shadow-lg hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300">
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
        </div>{{-- end white card --}}
    </div>
</section>

@endsection
