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
<body class="bg-[#f8fafc] text-slate-700 antialiased selection:bg-blue-100 selection:text-blue-900">

    {{-- ===== STICKY NAVBAR ===== --}}
    <nav class="bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-100/80 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-4">
                
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2.5 shrink-0">
                    <div class="w-9 h-9 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center">
                        <!-- Thin line cross icon -->
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <span class="text-lg font-semibold tracking-tight text-slate-900">Mekar<span class="text-blue-500 font-normal">Pharmacy</span></span>
                </a>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden lg:flex items-center gap-6 text-[13px] font-medium tracking-wide uppercase text-slate-500">
                    <a href="/" class="text-blue-500 hover:text-blue-600 transition-colors">Home</a>
                    <a href="#kategori" class="hover:text-blue-500 transition-colors">Kategori</a>
                    <a href="#produk" class="hover:text-blue-500 transition-colors">Produk</a>
                </div>

                <!-- Central Search Bar -->
                <div class="flex-1 max-w-md mx-2 sm:mx-6">
                    <form action="#" method="GET" class="relative">
                        <input 
                            type="text" 
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
                    <a href="/cart" class="relative p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50/50 rounded-xl transition-all duration-300">
                        <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-blue-500 text-[9px] font-bold text-white rounded-full flex items-center justify-center">2</span>
                    </a>

                    <!-- Notifications -->
                    <a href="#" class="relative p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50/50 rounded-xl transition-all duration-300">
                        <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a9.049 9.049 0 01-5.12-.135m0 0a3.003 3.003 0 12-5.961-1.425m5.961 1.425a3.003 3.003 0 006.185-1.806m-9.042-4.148c0-2.317 1.258-4.28 3.204-5.289m4.846 5.29c0 2.317-1.258 4.28-3.204 5.289m-6.236-4.664A9.016 9.016 0 009 12.25v1.5m6-1.5v1.5m-6-1.5a9.03 9.03 0 015.072-4.148m0 0A9.015 9.015 0 0115 12.25v1.5" />
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                    </a>

                    <!-- User Profile / Login -->
                    @guest
                        <a href="{{ route('login') }}" class="flex items-center gap-2 bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-600 px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-medium transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span class="hidden sm:inline">Masuk</span>
                        </a>
                    @else
                        <!-- Profile Dropdown (AlpineJS) -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-600 px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-medium transition-all duration-300 focus:outline-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg py-1 z-50 origin-top-right"
                                 style="display: none;">
                                
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs text-slate-400 font-light">Masuk sebagai</p>
                                    <p class="text-sm font-semibold text-slate-700 truncate">{{ Auth::user()->name }}</p>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 text-[10px] font-medium bg-blue-50 text-blue-600 rounded-full capitalize">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>
                                
                                @if(Auth::user()->role !== 'pelanggan')
                                    <a href="{{ Auth::user()->getDashboardUrl() }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M7.5 9.75h9M3.375 19.5h17.25" />
                                        </svg>
                                        Dashboard
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    Edit Profile
                                </a>

                                <hr class="border-slate-100 my-1">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                        <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest

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
                    <a href="/" class="flex items-center gap-2.5 mb-5">
                        <div class="w-8 h-8 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <span class="text-base font-semibold tracking-tight text-slate-900">Mekar<span class="text-blue-500 font-normal">Pharmacy</span></span>
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
