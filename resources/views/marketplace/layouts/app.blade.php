<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mekar Pharmacy - Apotek online terpercaya. Dapatkan obat, vitamin, dan produk kesehatan berkualitas dengan mudah.">
    <title>@yield('title', 'Mekar Pharmacy') - Apotek Online Terpercaya</title>
    
    <!-- Google Fonts: Plus Jakarta Sans for a thin, elegant, modern look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS for scroll animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
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
        
        /* Subtle Grid Pattern */
        .bg-grid-pattern {
            background-image: radial-gradient(circle, #e2e8f0 1px, transparent 1px);
            background-size: 32px 32px;
        }
        /* Animated Floating Blobs */
        @keyframes float-blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: float-blob 20s infinite ease-in-out;
        }
        .animate-blob-delayed {
            animation: float-blob 25s infinite ease-in-out;
            animation-delay: 5s;
        }
        .animate-blob-slow {
            animation: float-blob 30s infinite ease-in-out;
            animation-delay: 2s;
        }
        
        /* Modern Card Shadow */
        .shadow-modern {
            box-shadow: 0 10px 40px rgba(37,99,235,0.08);
        }
        .shadow-modern-hover:hover {
            box-shadow: 0 20px 50px rgba(37,99,235,0.15);
        }
    </style>
</head>
<body class="bg-[#f8fbff] text-slate-700 antialiased selection:bg-blue-200 selection:text-blue-900 relative min-h-screen flex flex-col" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Background Decoration -->
    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-[linear-gradient(180deg,#f8fbff_0%,#eef6ff_50%,#f8fbff_100%)]">
        <!-- Global Ambient Blobs -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-blue-400/10 blur-[120px] animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] rounded-full bg-cyan-400/10 blur-[150px] animate-blob-slow"></div>
        <div class="absolute top-[40%] left-[60%] w-[400px] h-[400px] rounded-full bg-indigo-400/5 blur-[120px] animate-blob-delayed"></div>
        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.15]"></div>
    </div>

    {{-- ===== STICKY NAVBAR ===== --}}
    <nav 
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b"
        :class="scrolled ? 'bg-white/90 backdrop-blur-xl border-slate-200/60 shadow-sm py-1.5' : 'bg-white/40 backdrop-blur-md border-transparent py-3'"
    >
        <div class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="flex items-center justify-between h-12 gap-6">
                
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 shrink-0 group">
                    <img
                        src="/logo.png"
                        alt="Mekar Pharmacy Logo"
                        class="w-8 h-8 object-contain transition-transform duration-300 group-hover:scale-105 drop-shadow-sm"
                    >
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-lg font-bold tracking-tight text-blue-700">MEKAR</span>
                        <span class="text-[13px] font-medium tracking-wide text-blue-900/60">Pharmacy</span>
                    </div>
                </a>

                <!-- Navigation Links (Desktop) -->
                @php
                    $navIsHome    = request()->is('/') || request()->is('marketplace') || request()->routeIs('marketplace.home');
                    $navIsProduct = request()->is('products') || request()->is('products/*') || request()->routeIs('marketplace.products') || request()->routeIs('marketplace.showProduct') || request()->routeIs('marketplace.category');
                @endphp
                <div class="hidden lg:flex items-center gap-5">
                    <a href="/" class="text-[13px] font-semibold transition-colors duration-300 relative group {{ $navIsHome ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                        Beranda
                        <span class="absolute -bottom-1 left-0 w-full h-[2px] bg-blue-600 rounded-full transition-transform duration-300 origin-left {{ $navIsHome ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                    </a>
                    <a href="/products" class="text-[13px] font-semibold transition-colors duration-300 relative group {{ $navIsProduct ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                        Semua Produk
                        <span class="absolute -bottom-1 left-0 w-full h-[2px] bg-blue-600 rounded-full transition-transform duration-300 origin-left {{ $navIsProduct ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                    </a>
                    <a href="/#konsultasi" class="text-[13px] font-semibold transition-colors duration-300 relative group text-slate-600 hover:text-blue-600">
                        Konsultasi Apoteker
                        <span class="absolute -bottom-1 left-0 w-full h-[2px] bg-blue-600 rounded-full transition-transform duration-300 origin-left scale-x-0 group-hover:scale-x-100"></span>
                    </a>
                </div>

                <!-- Central Search Bar -->
                <div class="hidden md:block flex-1 max-w-lg mx-auto">
                    <form action="/products" method="GET" class="relative group flex items-center">
                        <input 
                            type="text" 
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari obat, vitamin, suplemen..." 
                            class="w-full pl-5 pr-12 py-2 text-[13px] bg-white/70 border border-slate-200/80 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 focus:bg-white transition-all duration-300 text-slate-700 placeholder-slate-400 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] group-hover:shadow-md group-hover:bg-white"
                        >
                        <button type="submit" class="absolute right-1 top-1 bottom-1 w-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition-colors shadow-sm" title="Cari">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3 shrink-0">
                    
                    <!-- Search Icon (Mobile) -->
                    <a href="/products" class="md:hidden p-2 text-slate-500 hover:text-blue-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </a>

                    <!-- Upload Resep (Global Navbar) -->
                    <a href="{{ route('resep.create') }}" class="hidden md:flex items-center gap-1.5 bg-blue-50/80 hover:bg-blue-100 border border-blue-200/60 text-blue-700 px-3.5 py-1.5 rounded-full text-[13px] font-bold transition-all duration-300 group shadow-sm hover:shadow-md relative">
                        <svg class="w-4 h-4 text-blue-500 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        Upload Resep
                        <span class="absolute -top-1 -right-0.5 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                    </a>

                    <!-- Cart -->
                    <a href="/cart" class="relative flex items-center gap-2 bg-white border border-slate-200/80 hover:border-blue-200 text-slate-700 hover:text-blue-600 px-3.5 py-1.5 rounded-full text-[13px] font-bold transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="relative">
                            <svg class="w-4.5 h-4.5 transition-transform duration-300 group-hover:-translate-y-0.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            @php $cartCount = count(session('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1.5 -right-2 w-4 h-4 bg-red-500 text-[10px] font-bold text-white rounded-full flex items-center justify-center border border-white shadow-sm">{{ $cartCount }}</span>
                            @endif
                        </div>
                        <span class="hidden sm:inline">Keranjang</span>
                    </a>

                    <!-- User Profile / Login -->
                    @guest
                        <a href="{{ route('login') }}" class="flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-[13px] font-semibold transition-all duration-300 shadow-md shadow-blue-600/20 hover:shadow-lg hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span class="hidden sm:inline">Masuk</span>
                        </a>
                    @else
                        <!-- Profile Dropdown (AlpineJS) -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 bg-white border border-slate-200/80 hover:border-blue-200 text-slate-700 hover:text-blue-600 pl-1.5 pr-2.5 py-1 rounded-full text-[13px] font-medium transition-all duration-300 shadow-sm focus:outline-none group">
                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:inline font-semibold">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                <svg class="w-3 h-3 text-slate-400 group-hover:text-blue-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                                 class="absolute right-0 mt-3 w-52 bg-white border border-slate-100 rounded-xl shadow-xl py-1.5 z-50 origin-top-right"
                                 style="display: none;">
                                
                                <div class="px-4 py-2.5 border-b border-slate-50">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Akun Saya</p>
                                    <p class="text-[13px] font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-slate-500 truncate mb-1.5">{{ Auth::user()->email }}</p>
                                    <span class="inline-flex items-center px-1.5 py-0.5 text-[9px] font-bold bg-blue-50 text-blue-600 rounded uppercase">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>
                                
                                <div class="py-1">
                                    @if(Auth::user()->can('Dashboard'))
                                        <a href="{{ Auth::user()->getDashboardUrl() }}" class="flex items-center gap-2.5 px-4 py-2 text-[13px] font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M7.5 9.75h9M3.375 19.5h17.25" />
                                            </svg>
                                            Dashboard Sistem
                                        </a>
                                    @endif

                                    <a href="{{ route('marketplace.pesanan-saya') }}" class="flex items-center gap-2.5 px-4 py-2 text-[13px] font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        Pesanan Saya
                                    </a>

                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-[13px] font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        Pengaturan Profil
                                    </a>
                                </div>

                                <div class="px-2 pt-1.5 border-t border-slate-50 pb-0.5">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-[12px] font-bold hover:bg-red-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest

                </div>
            </div>
        </div>
    </nav>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 pt-20 pb-10 relative z-10 w-full max-w-[1536px] mx-auto">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 relative overflow-hidden mt-auto z-10">
        <!-- Abstract Footer Decoration -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-cyan-400 to-indigo-600"></div>
        <div class="absolute -top-[50%] -right-[10%] w-[50%] h-[150%] rounded-full bg-blue-900/30 blur-[100px] pointer-events-none"></div>
        
        <div class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-10 py-10 sm:py-14 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 sm:gap-6">
                
                <div class="md:col-span-4 pr-0 md:pr-10">
                    <a href="/" class="flex items-center gap-2 mb-4 group w-fit">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-lg shadow-white/10 group-hover:scale-105 transition-transform duration-300">
                            <img src="/logo.png" alt="Mekar Pharmacy Logo" class="w-5 h-5 object-contain">
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-bold tracking-tight text-white">MEKAR</span>
                            <span class="text-xs font-medium tracking-wide text-blue-400">Pharmacy</span>
                        </div>
                    </a>
                    <p class="text-slate-400 text-[13px] leading-relaxed mb-6 font-light">
                        Mekar Pharmacy adalah pelopor layanan kesehatan digital di Indonesia. Kami menghadirkan kemudahan akses terhadap sediaan farmasi berkualitas.
                    </p>
                    
                    <!-- Social Icons -->
                    <div class="flex gap-3">
                        <a href="#" class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <h4 class="text-[13px] font-bold text-white mb-4">Jelajahi</h4>
                    <ul class="space-y-2.5 text-[13px] font-medium text-slate-400">
                        <li><a href="/" class="hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Beranda</a></li>
                        <li><a href="/products" class="hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Semua Produk</a></li>
                        <li><a href="#kategori" class="hover:text-white transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Kategori Obat</a></li>
                    </ul>
                </div>

                <div class="md:col-span-5">
                    <h4 class="text-[13px] font-bold text-white mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-[13px] font-light text-slate-400">
                        <li class="flex items-start gap-2.5 group">
                            <div class="w-7 h-7 rounded-md bg-white/5 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            </div>
                            <span class="pt-1">Mekar Tower, Jl. Jend. Sudirman No. Kav 21, Jakarta</span>
                        </li>
                        <li class="flex items-center gap-2.5 group">
                            <div class="w-7 h-7 rounded-md bg-white/5 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            </div>
                            <span>hello@mekarpharmacy.id</span>
                        </li>
                        <li class="flex items-center gap-2.5 group">
                            <div class="w-7 h-7 rounded-md bg-white/5 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.273-3.974-6.869-6.869l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                            </div>
                            <span>+62 (21) 500-1122</span>
                        </li>
                    </ul>
                </div>

            </div>
            
            <div class="border-t border-white/10 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[11px] text-slate-500 font-medium">
                    &copy; {{ date('Y') }} Mekar Pharmacy. Hak Cipta Dilindungi.
                </p>
                <div class="flex gap-4 text-[11px] font-medium text-slate-500">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Consultation Button -->
    <button onclick="openKonsultasi('floating_button')" class="fixed bottom-6 right-6 z-[100] flex items-center justify-center w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-[0_8px_20px_rgba(34,197,94,0.3)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_25px_rgba(34,197,94,0.4)] group" title="Konsultasi Apoteker">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
        <span class="absolute right-full mr-4 bg-slate-800 text-white text-xs font-semibold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">Konsultasi Apoteker</span>
    </button>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        function openKonsultasi(sumber) {
            fetch('{{ route('konsultasi.log') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sumber: sumber })
            }).catch(err => console.error(err));
            
            const msg = "Halo Admin Mekar Pharmacy,\n\nSaya ingin berkonsultasi dengan apoteker mengenai kondisi kesehatan saya.\n\nKeluhan saya:\n....................................\n\nMohon bantuannya.\n\nTerima kasih.";
            window.open(`https://wa.me/6282240432990?text=${encodeURIComponent(msg)}`, '_blank');
        }

        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true,
                offset: 50,
                duration: 600,
                easing: 'ease-out-cubic',
            });
        });
    </script>
    
    @stack('scripts')

</body>
</html>
