<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mekar Pharmacy - Apotek online terpercaya. Dapatkan obat, vitamin, dan produk kesehatan berkualitas dengan mudah.">
    <title>@yield('title', 'Mekar Pharmacy') - Apotek Online Terpercaya</title>
    
    <!-- Google Fonts: Plus Jakarta Sans for a thin, elegant, modern look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AlpineJS for interactive elements -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            font-weight: 300;
        }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .font-medium { font-weight: 500; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-slate-100 text-slate-700 antialiased selection:bg-blue-100 selection:text-blue-900">

    {{-- ===== STICKY NAVBAR ===== --}}
    <nav class="bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-100/80 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-4">
                
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 shrink-0 group">
                    <img
                        src="/logo.png"
                        alt="Mekar Pharmacy Logo"
                        class="w-10 h-10 object-contain transition-all duration-300 group-hover:scale-105 drop-shadow-sm"
                    >
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-xl font-bold tracking-tight text-blue-600">MEKAR</span>
                        <span class="text-base font-normal tracking-wide text-slate-400">Pharmacy</span>
                    </div>
                </a>

                <!-- Navigation Links (Desktop) — Segmented Pill -->
                @php
                    $navIsHome    = request()->is('/') || request()->is('marketplace') || request()->routeIs('marketplace.home');
                    $navIsProduct = request()->is('products') || request()->is('products/*') || request()->routeIs('marketplace.products') || request()->routeIs('marketplace.showProduct') || request()->routeIs('marketplace.category');
                @endphp
                <div class="hidden lg:flex items-center p-1 bg-slate-100/80 rounded-full gap-0.5">
                    <a
                        href="/"
                        class="px-5 py-2 rounded-full text-sm font-semibold tracking-wide transition-all duration-300 {{ $navIsHome ? 'bg-blue-600 text-white shadow-md shadow-blue-600/25' : 'text-slate-500 hover:text-slate-700 hover:bg-white/70' }}"
                    >
                        Home
                    </a>
                    <a
                        href="/products"
                        class="px-5 py-2 rounded-full text-sm font-semibold tracking-wide transition-all duration-300 {{ $navIsProduct ? 'bg-blue-600 text-white shadow-md shadow-blue-600/25' : 'text-slate-500 hover:text-slate-700 hover:bg-white/70' }}"
                    >
                        Produk
                    </a>
                </div>

                <!-- Central Search Bar -->
                <div class="flex-1 max-w-md mx-2 sm:mx-6">
                    <form action="/products" method="GET" class="relative">
                        <input 
                            type="text" 
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari obat, vitamin, suplemen..." 
                            class="w-full pl-10 pr-4 py-2 sm:py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-100 rounded-xl focus:outline-none focus:ring-1 focus:ring-blue-200 focus:border-blue-300 focus:bg-white transition-all duration-300 text-slate-700 placeholder-slate-400"
                        >
                        <div class="absolute left-3.5 top-2.5 sm:top-3 text-slate-400">
                            <!-- Clean minimal search icon -->
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                    </form>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-2.5 sm:gap-4 shrink-0">
                    
                    <!-- Cart -->
                    <a href="/cart" class="relative flex items-center gap-2 px-4 py-2 bg-blue-50 border border-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition-all duration-300 group shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span class="hidden sm:inline font-semibold text-sm">Keranjang</span>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-[10px] font-bold text-white rounded-full flex items-center justify-center border-2 border-white shadow-sm">{{ $cartCount }}</span>
                        @endif
                    </a>

                </div>
            </div>
        </div>
    </nav>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-white border-t border-slate-100/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 sm:gap-8">
                
                <div class="md:col-span-2">
                    <a href="/" class="flex items-center gap-2 mb-5 group w-fit">
                        <img
                            src="/logo.png"
                            alt="Mekar Pharmacy Logo"
                            class="w-9 h-9 object-contain transition-all duration-300 group-hover:scale-105 drop-shadow-sm"
                        >
                        <div class="flex items-baseline gap-0.5">
                            <span class="text-lg font-bold tracking-tight text-blue-600">MEKAR</span>
                            <span class="text-sm font-normal tracking-wide text-slate-400">Pharmacy</span>
                        </div>
                    </a>
                    <p class="text-slate-400 text-sm max-w-sm leading-relaxed mb-6 font-light">
                        Penyedia layanan kesehatan digital dan apotek daring dengan standar mutu modern. Kami menghadirkan solusi higienis dan terorganisir untuk keluarga Anda.
                    </p>
                    <p class="text-xs text-slate-300 font-light">Developed by Hexa Team</p>
                </div>

                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-[13px] font-medium text-slate-500">
                        <li><a href="#" class="hover:text-blue-500 transition-colors">Home</a></li>
                        <li><a href="#kategori" class="hover:text-blue-500 transition-colors">Kategori</a></li>
                        <li><a href="#produk" class="hover:text-blue-500 transition-colors">Produk Terlaris</a></li>
                        <li><a href="#" class="hover:text-blue-500 transition-colors">Layanan Konsultasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2.5 text-[13px] font-light text-slate-500">
                        <li class="flex items-center gap-2">
                            <span>📍</span> Jakarta Selatan, Indonesia
                        </li>
                        <li class="flex items-center gap-2">
                            <span>✉️</span> hello@mekarpharmacy.id
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📞</span> +62 (21) 500-1122
                        </li>
                    </ul>
                </div>

            </div>
            
            <div class="border-t border-slate-100 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-400 font-light">
                <span>&copy; 2026 Mekar Pharmacy. Hak Cipta Dilindungi.</span>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-blue-500 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-blue-500 transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')

</body>
</html>
