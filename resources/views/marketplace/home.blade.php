@extends('marketplace.layouts.app')

@section('title', 'Mekar Pharmacy - Layanan Apotek Digital Terpercaya')

@section('content')

{{-- ===== CSS KHUSUS ===== --}}
@push('scripts')
<style>
    /* Float animation for hero image & decorative capsules */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 5s ease-in-out infinite;
    }
    .animate-float-delayed {
        animation: float 6s ease-in-out infinite;
        animation-delay: 2s;
    }
    
    /* Glowing effect */
    .btn-glow {
        box-shadow: 0 0 15px rgba(37, 99, 235, 0.4);
    }
    .btn-glow:hover {
        box-shadow: 0 0 25px rgba(37, 99, 235, 0.6);
    }

    /* Auto Slider for Testimonials */
    .marquee-container {
        display: flex;
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    .marquee-content {
        display: flex;
        animation: marquee 30s linear infinite;
        gap: 1.25rem;
    }
    .marquee-container:hover .marquee-content {
        animation-play-state: paused;
    }
    @keyframes marquee {
        0% { transform: translateX(0%); }
        100% { transform: translateX(-50%); }
    }
</style>
@endpush

{{-- ===== HERO BANNER SECTION ===== --}}
<section class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10 mt-4 sm:mt-6 mb-12 relative">
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-800 border border-blue-400/30 flex flex-col items-center justify-center min-h-[550px] md:min-h-[650px] lg:min-h-[720px] p-6 sm:p-10 lg:p-16 shadow-2xl shadow-blue-900/20 group z-10" data-aos="zoom-in" data-aos-duration="700">
        
        <!-- Full Background Image -->
        <img src="/keluarga_baru.png" alt="Mekar Pharmacy Family" class="absolute inset-0 w-full h-full object-cover object-center opacity-75 mix-blend-overlay transition-transform duration-1000 group-hover:scale-105 pointer-events-none">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-blue-800/60 via-blue-700/40 to-indigo-900/70 pointer-events-none"></div>
        
        <!-- Background Abstract Elements -->
        <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none mix-blend-overlay"></div>
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[60%] rounded-full bg-blue-400/30 blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[60%] rounded-full bg-cyan-400/20 blur-[120px] pointer-events-none"></div>
        
        <!-- Decorative SVG Medical Crosses -->
        <div class="absolute top-16 left-[15%] text-white/20 w-12 h-12 animate-float-delayed pointer-events-none hidden md:block">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 10h-5V5h-4v5H5v4h5v5h4v-5h5v-4z"/></svg>
        </div>
        <div class="absolute bottom-32 right-[15%] text-white/10 w-16 h-16 animate-float pointer-events-none hidden md:block">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 10h-5V5h-4v5H5v4h5v5h4v-5h5v-4z"/></svg>
        </div>

        <!-- Main Content Center -->
        <div class="relative z-10 w-full max-w-4xl flex flex-col items-center text-center text-white mt-8 lg:mt-4">
            
            <!-- Badges -->
            <div class="flex flex-wrap justify-center gap-3 mb-6" data-aos="fade-down" data-aos-duration="600" data-aos-delay="100">
                <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[11px] font-bold tracking-wide uppercase px-4 py-2 rounded-full shadow-sm transition hover:bg-white/20 cursor-default">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Apotek Terpercaya
                </span>
                <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[11px] font-bold tracking-wide uppercase px-4 py-2 rounded-full shadow-sm transition hover:bg-white/20 cursor-default hidden sm:inline-flex">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span> Produk Original
                </span>
                <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[11px] font-bold tracking-wide uppercase px-4 py-2 rounded-full shadow-sm transition hover:bg-white/20 cursor-default">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span> Konsultasi Cepat
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-4xl sm:text-5xl lg:text-[4.25rem] font-extrabold tracking-tight leading-[1.15] mb-6 drop-shadow-lg" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                Lindungi Kesehatan <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-blue-200">Keluarga Tercinta Anda</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-blue-50 text-[15px] sm:text-lg font-light mb-10 leading-relaxed max-w-2xl mx-auto drop-shadow-md" data-aos="fade-up" data-aos-duration="700" data-aos-delay="300">
                Dapatkan obat, vitamin, dan produk kesehatan original dengan layanan konsultasi apoteker profesional serta pengiriman cepat langsung ke rumah Anda.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto" data-aos="fade-up" data-aos-duration="700" data-aos-delay="400">
                <a href="#produk" class="w-full sm:w-auto btn-glow bg-white text-blue-800 hover:text-blue-900 font-extrabold px-8 py-4 rounded-full text-[15px] transition-all duration-300 flex items-center justify-center gap-2 group transform hover:-translate-y-1 shadow-xl shadow-white/10">
                    Belanja Sekarang
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </a>
                @auth
                    <a href="{{ route('resep.create') }}" class="w-full sm:w-auto relative bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 text-slate-900 font-extrabold px-8 py-4 rounded-full text-[15px] transition-all duration-300 flex items-center justify-center gap-2 group transform hover:-translate-y-1 shadow-xl shadow-yellow-500/30 border border-yellow-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        Upload Resep Dokter
                        <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 border-2 border-white"></span>
                        </span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto relative bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 text-slate-900 font-extrabold px-8 py-4 rounded-full text-[15px] transition-all duration-300 flex items-center justify-center gap-2 group transform hover:-translate-y-1 shadow-xl shadow-yellow-500/30 border border-yellow-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        Upload Resep Dokter
                        <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 border-2 border-white"></span>
                        </span>
                    </a>
                @endauth
            </div>
        </div>

        <!-- Feature Bar (Glassmorphism) -->
        <div class="relative z-10 w-full max-w-5xl mt-16 pt-8 border-t border-white/10" data-aos="fade-up" data-aos-duration="700" data-aos-delay="500">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Feature 1 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex items-center gap-3 hover:bg-white/15 transition-colors">
                    <div class="bg-white/20 rounded-xl p-2.5 shrink-0 text-white">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-white text-[13px] sm:text-sm font-bold">Produk Original</h4>
                        <p class="text-blue-100 text-[10px] sm:text-xs mt-0.5 font-medium">100% Asli & Terjamin</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex items-center gap-3 hover:bg-white/15 transition-colors">
                    <div class="bg-white/20 rounded-xl p-2.5 shrink-0 text-white">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    </div>
                    <div>
                        <h4 class="text-white text-[13px] sm:text-sm font-bold">Pengiriman Cepat</h4>
                        <p class="text-blue-100 text-[10px] sm:text-xs mt-0.5 font-medium">Langsung ke Rumah</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex items-center gap-3 hover:bg-white/15 transition-colors">
                    <div class="bg-white/20 rounded-xl p-2.5 shrink-0 text-white">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-white text-[13px] sm:text-sm font-bold">Konsultasi Ahli</h4>
                        <p class="text-blue-100 text-[10px] sm:text-xs mt-0.5 font-medium">Apoteker Profesional</p>
                    </div>
                </div>
                <!-- Feature 4 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex items-center gap-3 hover:bg-white/15 transition-colors">
                    <div class="bg-white/20 rounded-xl p-2.5 shrink-0 text-white">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-white text-[13px] sm:text-sm font-bold">Pembayaran Aman</h4>
                        <p class="text-blue-100 text-[10px] sm:text-xs mt-0.5 font-medium">Transaksi Terenkripsi</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

{{-- ===== KATEGORI PRODUK ===== --}}
<section id="kategori" class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10 py-8 relative z-10">
    <div class="flex items-end justify-between mb-6" data-aos="fade-right">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Kategori Populer</h2>
            <p class="text-xs text-slate-500 mt-1 font-light">Eksplorasi kebutuhan kesehatan Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-10 gap-3">
        @php
            $svgs = [
                'vitamin' => 'M10.5 20.5 19 12a4.95 4.95 0 1 0-7-7L3.5 12a4.95 4.95 0 1 0 7 7Z M12 6.5l5.5 5.5', // pill
                'suplemen' => 'M10.5 20.5 19 12a4.95 4.95 0 1 0-7-7L3.5 12a4.95 4.95 0 1 0 7 7Z M12 6.5l5.5 5.5', // pill
                'perawatan' => 'M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z', // droplet
                'kulit' => 'M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z', // droplet
                'p3k' => 'M12 10v4m-2-2h4M4 8a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V8z', // first aid
                'bayi' => 'M10 2v7.31M14 2v7.31M8.5 2h7M7 9.31a4 4 0 0 0-1 2.62V18a4 4 0 0 0 4 4h4a4 4 0 0 0 4-4v-6.07a4 4 0 0 0-1-2.62L15 9.31', // baby bottle
                'anak' => 'M12 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z M5 14v7 M19 14v7 M12 21v-4 M10 14l-2.5-4L12 8l4.5 2-2.5 4 M12 11v6', // child
                'alat' => 'M16 11V7a4 4 0 0 0-8 0v4 M8 11c0 2.21 1.79 4 4 4h0c2.21 0 4-1.79 4-4v-4 M12 15v3c0 1.1-.9 2-2 2H8c-1.1 0-2-.9-2-2v-3 M20 10.5A2.5 2.5 0 0 0 17.5 8h-1A2.5 2.5 0 0 0 14 10.5v1A2.5 2.5 0 0 0 16.5 14h1A2.5 2.5 0 0 0 20 11.5v-1Z', // stethoscope
                'gigi' => 'M16.5 4A4.5 4.5 0 0 0 12 8.5 4.5 4.5 0 0 0 7.5 4c-2.5 0-4 1.5-4 4 0 5 3 6 4.5 12 .5 0 1-1 2-4 .5-1.5 1-3 2-3s1.5 1.5 2 3c1 3 1.5 4 2 4 1.5-6 4.5-7 4.5-12 0-2.5-1.5-4-4-4Z', // tooth
                'demam' => 'M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z M12 12v-5M12 15h.01', // thermometer
                'batuk' => 'M8 12c-2.5 0-4 1.5-4 4 0 5 3 6 4.5 12 .5 0 1-1 2-4 .5-1.5 1-3 2-3 M16 12c2.5 0 4 1.5 4 4 0 5-3 6-4.5 12-.5 0-1-1-2-4-.5-1.5-1-3-2-3', // lungs
                'flu' => 'M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242 M12 12v9', // nose/tissue (sneezing cloud)
                'kepala' => 'M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z M12 12v6', // brain
                'lambung' => 'M7 9a5 5 0 0 1 10 0c0 4-3 5-3 7v1a2 2 0 0 1-4 0v-1c0-2-3-3-3-7Z', // stomach
                'diare' => 'M7 9a5 5 0 0 1 10 0c0 4-3 5-3 7v1a2 2 0 0 1-4 0v-1c0-2-3-3-3-7Z', // stomach
                'alergi' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z M9 12l2 2 4-4', // shield
                'kesehatan' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z M12 8v8 M8 12h8', // medical shield
                'herbal' => 'M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12', // leaf
                'obat' => 'M10 4V2 M14 4V2 M8 6v14a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6 M6 6h12 M10 13h4', // medicine bottle (generic)
            ];
        @endphp
        @forelse($kategoris as $index => $k)
            @php
                $lowerName = strtolower($k->nama_kategori);
                $iconSvg = 'M10 4V2 M14 4V2 M8 6v14a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6 M6 6h12 M10 13h4'; // default bottle
                foreach ($svgs as $key => $path) {
                    if (str_contains($lowerName, $key)) {
                        $iconSvg = $path;
                        break;
                    }
                }
                $delay = $index * 30;
            @endphp
            <a href="/category/{{ $k->id }}" class="group flex flex-col items-center p-4 bg-white/80 backdrop-blur-xl border border-white shadow-modern hover:border-blue-200 hover:shadow-modern-hover hover:-translate-y-1 transition-all duration-300 text-center relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 bg-slate-50 border border-slate-100 text-slate-400 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 group-hover:scale-110 transition-all duration-300 relative z-10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconSvg }}" />
                    </svg>
                </div>
                <span class="text-[11px] leading-tight font-bold text-slate-600 group-hover:text-blue-700 transition-colors duration-300 relative z-10">{{ $k->nama_kategori }}</span>
            </a>
        @empty
            <p class="text-xs text-slate-400 col-span-full text-center">Belum ada kategori obat.</p>
        @endforelse
    </div>
</section>

<!-- Section Divider Wave -->
<div class="w-full overflow-hidden leading-none relative z-0 mt-[-2rem] mb-[-2rem] opacity-40">
    <svg class="relative block w-[calc(100%+1.3px)] h-[60px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#dbeafe"></path>
    </svg>
</div>

{{-- ===== LATEST PRODUCTS SECTION ===== --}}
<section id="produk" class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10 py-10 relative z-10">
    <!-- Abstract Medical Decoration -->
    <div class="absolute top-10 right-[10%] opacity-5 text-blue-800 pointer-events-none">
        <svg class="w-40 h-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
    </div>
    
    <div class="flex items-end justify-between mb-6 relative z-10" data-aos="fade-right">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Koleksi Terbaru</h2>
            <p class="text-xs text-slate-500 mt-1 font-light">Sediaan farmasi dan suplemen premium baru.</p>
        </div>
        <a href="/products" class="hidden sm:flex text-[13px] font-bold text-blue-600 hover:text-blue-800 transition-colors items-center gap-1 group">
            Lihat Semua 
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
        @forelse($latestProducts as $index => $p)
            @php
                $imgFallback = str_contains(strtolower($p->kategori->nama_kategori ?? ''), 'vitamin') 
                    ? '/premium_supplement_bottle.png' 
                    : '/premium_medicine_box.png';
                $image = $p->image ?? $p->gambar ?? $imgFallback;
                $formattedPrice = 'Rp ' . number_format($p->harga_jual, 0, ',', '.');
                $rating = number_format(4.7 + (($p->id * 7) % 4) / 10, 1);
                $sold = ($p->id * 23) % 150 + 12;
                $delay = $index * 40;
            @endphp
            <div class="group bg-white/90 backdrop-blur-xl border border-white rounded-2xl overflow-hidden shadow-modern hover:shadow-modern-hover hover:-translate-y-1.5 hover:border-blue-200 transition-all duration-400 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                <div class="relative">
                    <div class="absolute left-3 top-3 z-30">
                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-100/60 text-[9px] font-bold px-2 py-1 rounded-lg shadow-sm">
                            Baru
                        </span>
                    </div>

                    <a href="/products/{{ $p->id }}" class="block bg-slate-50/50 h-36 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-blue-50/20 transition-colors duration-400">
                        <!-- Abstract decorative circle in background -->
                        <div class="absolute w-24 h-24 bg-white rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700 ease-out"></div>
                        <img src="{{ $image }}" alt="{{ $p->nama_obat }}" class="relative z-10 h-24 object-contain transition-transform duration-500 ease-out group-hover:scale-110 drop-shadow-sm">
                    </a>

                    <div class="p-4 pb-1">
                        <span class="inline-block text-blue-500 text-[10px] font-bold tracking-wider uppercase mb-1.5">
                            {{ $p->kategori->nama_kategori ?? 'Obat' }}
                        </span>
                        <a href="/products/{{ $p->id }}" class="block">
                            <h3 class="text-[13px] font-bold text-slate-800 mb-1.5 line-clamp-2 h-9 leading-snug group-hover:text-blue-600 transition-colors">
                                {{ $p->nama_obat }}
                            </h3>
                        </a>
                        <div class="flex items-center gap-1 mb-1.5">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-[11px] font-bold text-slate-700">{{ $rating }}</span>
                            <span class="text-slate-300 text-[10px] mx-0.5">•</span>
                            <span class="text-[10px] text-slate-500 font-medium">{{ $sold }} terjual</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 pt-1">
                    <div class="text-blue-600 text-[15px] font-black mb-3">{{ $formattedPrice }}</div>
                    <button type="button"
                            data-product-id="{{ $p->id }}"
                            class="add-to-cart-btn w-full bg-slate-50 hover:bg-blue-600 border border-slate-200 hover:border-blue-600 text-slate-700 hover:text-white text-[11px] font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 cart-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="btn-text">Keranjang</span>
                    </button>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-400 col-span-full text-center py-6">Belum ada obat tersedia.</p>
        @endforelse
    </div>
</section>

<!-- Section Divider Wave -->
<div class="w-full overflow-hidden leading-none relative z-0 mt-[-2rem] mb-[-2rem] opacity-30 transform rotate-180 scale-x-[-1]">
    <svg class="relative block w-[calc(100%+1.3px)] h-[60px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#bae6fd"></path>
    </svg>
</div>

{{-- ===== BEST SELLERS SECTION ===== --}}
<section id="produk-terlaris" class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10 py-10 relative z-10">
    <!-- Abstract Molecular Decoration -->
    <div class="absolute bottom-20 left-[5%] opacity-[0.03] text-blue-900 pointer-events-none">
        <svg class="w-64 h-64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.5"><circle cx="12" cy="12" r="10" /><path d="M12 2v20 M2 12h20" /></svg>
    </div>
    
    <div class="flex items-end justify-between mb-6 relative z-10" data-aos="fade-right">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Produk Terlaris</h2>
            <p class="text-xs text-slate-500 mt-1 font-light">Sediaan medis yang paling banyak dipercaya pengguna.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
        @forelse($bestSellerProducts as $index => $p)
            @php
                $imgFallback = str_contains(strtolower($p->kategori->nama_kategori ?? ''), 'vitamin') 
                    ? '/premium_supplement_bottle.png' 
                    : '/premium_medicine_box.png';
                $image = $p->image ?? $p->gambar ?? $imgFallback;
                $formattedPrice = 'Rp ' . number_format($p->harga_jual, 0, ',', '.');
                $rating = number_format(4.8 + (($p->id * 3) % 2) / 10, 1);
                $sold = ($p->id * 41) % 400 + 150;
                $delay = $index * 40;
            @endphp
            <div class="group bg-white/90 backdrop-blur-xl border border-white rounded-2xl overflow-hidden shadow-modern hover:shadow-modern-hover hover:-translate-y-1.5 hover:border-blue-200 transition-all duration-400 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                <div class="relative">
                    <div class="absolute left-3 top-3 z-30">
                        <span class="bg-amber-100 text-amber-700 border border-amber-200 text-[9px] font-bold px-2 py-1 rounded-lg shadow-sm flex items-center gap-1">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" /></svg>
                            Terlaris
                        </span>
                    </div>

                    <a href="/products/{{ $p->id }}" class="block bg-slate-50/50 h-36 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-amber-50/20 transition-colors duration-400">
                        <div class="absolute w-24 h-24 bg-white rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700 ease-out"></div>
                        <img src="{{ $image }}" alt="{{ $p->nama_obat }}" class="relative z-10 h-24 object-contain transition-transform duration-500 ease-out group-hover:scale-110 drop-shadow-sm">
                    </a>

                    <div class="p-4 pb-1">
                        <span class="inline-block text-blue-500 text-[10px] font-bold tracking-wider uppercase mb-1.5">
                            {{ $p->kategori->nama_kategori ?? 'Obat' }}
                        </span>
                        <a href="/products/{{ $p->id }}" class="block">
                            <h3 class="text-[13px] font-bold text-slate-800 mb-1.5 line-clamp-2 h-9 leading-snug group-hover:text-blue-600 transition-colors">
                                {{ $p->nama_obat }}
                            </h3>
                        </a>
                        <div class="flex items-center gap-1 mb-1.5">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-[11px] font-bold text-slate-700">{{ $rating }}</span>
                            <span class="text-slate-300 text-[10px] mx-0.5">•</span>
                            <span class="text-[10px] text-slate-500 font-medium">{{ $sold }} terjual</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 pt-1">
                    <div class="text-blue-600 text-[15px] font-black mb-3">{{ $formattedPrice }}</div>
                    <button type="button"
                            data-product-id="{{ $p->id }}"
                            class="add-to-cart-btn w-full bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 text-[11px] font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 cart-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="btn-text">Keranjang</span>
                    </button>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-400 col-span-full text-center py-6">Belum ada obat terlaris.</p>
        @endforelse
    </div>
</section>

{{-- ===== STANDAR MUTU / VALUES ===== --}}
<section class="py-12 relative">
    <div class="absolute inset-0 bg-blue-600/5 skew-y-3 transform origin-bottom-left -z-10"></div>
    
    <div class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10" data-aos="fade-up">
        <div class="text-center mb-10">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Standar Mutu Mekar Pharmacy</h2>
            <div class="w-12 h-1 bg-blue-600 mx-auto mt-3 rounded-full mb-3"></div>
            <p class="text-xs text-slate-500 font-light">Layanan premium untuk kenyamanan Anda.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="group flex flex-col p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-blue-300 hover:shadow-lg hover:shadow-blue-500/10 hover:-translate-y-1.5 transition-all duration-300" data-aos="fade-up" data-aos-delay="0">
                <div class="w-10 h-10 bg-blue-50 border border-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 transition-transform duration-300 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                </div>
                <h3 class="text-[13px] font-bold text-slate-800 mb-2">100% Original</h3>
                <p class="text-[11px] text-slate-500 font-light leading-relaxed">Jaminan keaslian tersertifikasi BPOM, bersumber langsung dari distributor resmi.</p>
            </div>

            <div class="group flex flex-col p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-cyan-300 hover:shadow-lg hover:shadow-cyan-500/10 hover:-translate-y-1.5 transition-all duration-300" data-aos="fade-up" data-aos-delay="50">
                <div class="w-10 h-10 bg-cyan-50 border border-cyan-100 text-cyan-600 rounded-xl flex items-center justify-center mb-4 transition-transform duration-300 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-[13px] font-bold text-slate-800 mb-2">Pengiriman Instan</h3>
                <p class="text-[11px] text-slate-500 font-light leading-relaxed">Pengiriman same-day higienis, menjaga kualitas sediaan tetap prima sampai tujuan.</p>
            </div>

            <div class="group flex flex-col p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-indigo-300 hover:shadow-lg hover:shadow-indigo-500/10 hover:-translate-y-1.5 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-10 h-10 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4 transition-transform duration-300 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM15.008 12.008a.75.75 0 11-.75-.75.75.75 0 01.75.75zm-6.75 0a.75.75 0 11-.75-.75.75.75 0 01.75.75zM12 18.75a.75.75 0 100-1.5.75.75 0 000 1.5z" /></svg>
                </div>
                <h3 class="text-[13px] font-bold text-slate-800 mb-2">Apoteker Aktif</h3>
                <p class="text-[11px] text-slate-500 font-light leading-relaxed">Dukungan apoteker berlisensi untuk menjamin pemakaian obat rasional.</p>
            </div>

            <div class="group flex flex-col p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/10 hover:-translate-y-1.5 transition-all duration-300" data-aos="fade-up" data-aos-delay="150">
                <div class="w-10 h-10 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 transition-transform duration-300 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751A11.956 11.956 0 0112 2.714z" /></svg>
                </div>
                <h3 class="text-[13px] font-bold text-slate-800 mb-2">Transaksi Aman</h3>
                <p class="text-[11px] text-slate-500 font-light leading-relaxed">Enkripsi end-to-end terpercaya untuk melindungi data personal dan privasi Anda.</p>
            </div>

        </div>
    </div>
</section>

{{-- ===== KONSULTASI APOTEKER ===== --}}
<section id="konsultasi" class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-800 border border-blue-400/30 flex flex-col items-center justify-center min-h-[500px] md:min-h-[550px] p-6 sm:p-10 lg:p-16 shadow-2xl shadow-blue-900/20 group z-10" data-aos="fade-up">
        
        <!-- Full Background Image -->
        <img src="/apoteker_konsultasi.png" alt="Konsultasi Apoteker Mekar Pharmacy" class="absolute inset-0 w-full h-full object-cover object-center opacity-75 mix-blend-overlay transition-transform duration-1000 group-hover:scale-105 pointer-events-none">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-blue-800/60 via-blue-700/40 to-indigo-900/70 pointer-events-none"></div>
        
        <!-- Background Abstract Elements -->
        <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none mix-blend-overlay"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[60%] rounded-full bg-cyan-400/20 blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[60%] rounded-full bg-white/10 blur-[120px] pointer-events-none"></div>

        <!-- Main Content Center -->
        <div class="relative z-10 w-full max-w-3xl flex flex-col items-center text-center text-white mt-4">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[11px] font-bold tracking-wide uppercase px-4 py-2 rounded-full shadow-sm mb-6 cursor-default" data-aos="fade-down" data-aos-duration="600">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span> Tanya Apoteker
            </div>
            
            <!-- Title -->
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.15] mb-5 drop-shadow-lg" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                Konsultasi Langsung dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-blue-200">Apoteker</span>
            </h2>
            
            <!-- Subtitle -->
            <p class="text-blue-50 text-[15px] sm:text-lg font-light mb-8 leading-relaxed max-w-xl mx-auto drop-shadow-md" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                Bingung memilih obat? Konsultasikan keluhan kesehatan Anda langsung dengan apoteker Mekar Pharmacy melalui WhatsApp.
            </p>
            
            <!-- Features List Inline -->
            <div class="flex flex-wrap justify-center gap-4 sm:gap-8 mb-10" data-aos="fade-up" data-aos-duration="700" data-aos-delay="300">
                <div class="flex items-center gap-2 text-sm text-white font-medium">
                    <div class="w-6 h-6 rounded-full bg-cyan-400/20 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    </div>
                    Gratis konsultasi awal
                </div>
                <div class="flex items-center gap-2 text-sm text-white font-medium">
                    <div class="w-6 h-6 rounded-full bg-cyan-400/20 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    </div>
                    Respon cepat via WhatsApp
                </div>
                <div class="flex items-center gap-2 text-sm text-white font-medium">
                    <div class="w-6 h-6 rounded-full bg-cyan-400/20 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    </div>
                    Apoteker terpercaya
                </div>
            </div>

            <!-- CTA Button -->
            <div data-aos="fade-up" data-aos-duration="700" data-aos-delay="400">
                <button onclick="openKonsultasi('homepage')" class="group relative inline-flex items-center justify-center gap-2 bg-white text-blue-800 hover:text-blue-900 font-extrabold px-8 py-4 rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-white via-blue-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <svg class="w-5 h-5 text-green-500 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    <span class="relative z-10 text-[15px]">Konsultasi Sekarang</span>
                </button>
            </div>
        </div>
    </div>
</section>

{{-- ===== PENILAIAN PENGGUNA ===== --}}
<section class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10 py-12 mb-6 overflow-hidden">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-5 mb-8" data-aos="fade-right">
        <div class="max-w-xl">
            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-bold px-2.5 py-1 rounded-md mb-3">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Testimonial Pelanggan
            </span>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Apa Kata Pengguna Mekar Pharmacy?</h2>
        </div>
        
        <div class="flex gap-3">
            <div class="bg-white border border-slate-100 rounded-xl p-3 shadow-sm flex flex-col items-center justify-center min-w-[100px]">
                <div class="text-xl font-black text-slate-800">{{ number_format($rataRata, 1) }}<span class="text-xs text-slate-400 font-medium">/5</span></div>
                <div class="text-[9px] text-slate-500 font-bold uppercase tracking-wider mt-1">Rating</div>
            </div>
            <div class="bg-white border border-slate-100 rounded-xl p-3 shadow-sm flex flex-col items-center justify-center min-w-[100px]">
                <div class="text-xl font-black text-blue-600">{{ number_format($totalPenilaian, 0, ',', '.') }}+</div>
                <div class="text-[9px] text-slate-500 font-bold uppercase tracking-wider mt-1">Pesanan Puas</div>
            </div>
        </div>
    </div>

    @if($ulasanTerbaru->count() > 0)
    <div class="relative w-full" data-aos="fade-up" data-aos-delay="100">
        <!-- Gradient Masks -->
        <div class="absolute top-0 left-0 h-full w-12 md:w-24 bg-gradient-to-r from-slate-50 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute top-0 right-0 h-full w-12 md:w-24 bg-gradient-to-l from-slate-50 to-transparent z-10 pointer-events-none"></div>
        
        <div class="marquee-container py-2">
            <div class="marquee-content">
                @foreach($ulasanTerbaru->merge($ulasanTerbaru) as $ulasan)
                <div class="flex-shrink-0 w-[260px] md:w-[320px] bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col h-[180px]">
                    <div class="flex text-amber-400 mb-3">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= $ulasan->rating)
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5 text-slate-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                        @endfor
                    </div>
                    <p class="text-slate-600 text-[12px] leading-relaxed mb-4 flex-1 italic line-clamp-3">"{{ $ulasan->komentar }}"</p>
                    <div class="flex items-center gap-2 mt-auto">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-600 font-bold text-[11px] border border-blue-100">
                            {{ strtoupper(substr($ulasan->nama_pelanggan ?: 'P', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-[12px] font-bold text-slate-800">{{ $ulasan->nama_pelanggan ?: 'Pengguna Mekar Pharmacy' }}</div>
                            <div class="text-[9px] text-slate-400 font-medium">{{ $ulasan->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="flex flex-col items-center justify-center py-10 text-center bg-white rounded-2xl border border-dashed border-slate-200 shadow-sm" data-aos="fade-up">
        <svg class="w-10 h-10 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
        <p class="text-slate-500 font-medium text-[13px]">Belum ada penilaian pengguna.</p>
    </div>
    @endif
</section>

{{-- ===== SCRIPT ADD TO CART (AJAX) ===== --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-to-cart-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const productId = btn.dataset.productId;
            const btnTextEl = btn.querySelector('.btn-text');
            const originalText = btnTextEl.textContent;

            btn.disabled = true;
            btnTextEl.textContent = 'Menambahkan...';

            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ qty: 1 })
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return null;
                }
                return res.json();
            })
            .then(data => {
                if (!data) return;
                if (data.success) {
                    btnTextEl.textContent = 'Ditambahkan ✓';

                    // Update badge jumlah keranjang di navbar jika elemen ada
                    const cartBadge = document.querySelector('#cart-count');
                    if (cartBadge) {
                        cartBadge.textContent = data.cartCount;
                        cartBadge.classList.remove('hidden');
                    }

                    setTimeout(() => {
                        btnTextEl.textContent = originalText;
                        btn.disabled = false;
                    }, 1200);
                } else {
                    alert(data.message || 'Gagal menambahkan ke keranjang');
                    btnTextEl.textContent = originalText;
                    btn.disabled = false;
                }
            })
            .catch(() => {
                alert('Terjadi kesalahan, coba lagi.');
                btnTextEl.textContent = originalText;
                btn.disabled = false;
            });
        });
    });
});
</script>
@endpush

@endsection