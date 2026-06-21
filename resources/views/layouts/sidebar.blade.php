<aside class="fixed left-0 top-0 w-72 h-screen bg-gradient-to-b from-blue-900 via-blue-800 to-cyan-500 text-white flex flex-col">

    <!-- Logo -->
    <div class="p-8">
        <h1 class="text-4xl font-bold text-cyan-300">
            MEKAR
        </h1>
        <p class="text-lg text-gray-200">
            Pharmacy
        </p>
    </div>

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto custom-scrollbar px-4 pb-6">
        
        <!-- Dashboard -->
        <a href="{{ Auth::user()->getDashboardUrl() }}"
           class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-4 mt-2
           {{ (request()->routeIs('dashboard') || request()->routeIs('kasir.dashboard') || request()->routeIs('apoteker.dashboard')) ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 11V9m0 12h6" />
            </svg>
            Dashboard
        </a>

        <!-- Master Data Group -->
        @if(auth()->user()->can('Kelola Kategori') || auth()->user()->can('Kelola Supplier') || auth()->user()->can('Kelola Obat') || auth()->user()->can('Lihat Stok Obat'))
            <div class="px-5 py-2 text-xs font-bold text-cyan-200/60 uppercase tracking-wider mt-4 mb-1">
                Master Data
            </div>

            @can('Kelola Kategori')
                <a href="{{ route('kategori.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('kategori.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                    Kategori
                </a>
            @endcan

            @can('Kelola Supplier')
                <a href="{{ route('supplier.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('supplier.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6M3 7h18M5 17h2m10 0h2"/>
                    </svg>
                    Supplier
                </a>
            @endcan

            @if(auth()->user()->can('Kelola Obat') || auth()->user()->can('Lihat Stok Obat'))
                @php
                    $isObatActive = request()->routeIs('obat.*') || request()->routeIs('apoteker.obat.*');
                    $obatUrl = auth()->user()->can('Kelola Obat') ? route('obat.index') : route('apoteker.obat.index');
                @endphp
                <a href="{{ $obatUrl }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ $isObatActive ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14L21 3m0 0h-6m6 0v6M3 21l7-7"/>
                    </svg>
                    Obat
                </a>
            @endif
        @endif

        <!-- Pengguna Group -->
        @if(auth()->user()->can('Kelola Pelanggan') || auth()->user()->can('Kelola User') || auth()->user()->can('Kelola Role') || auth()->user()->can('Kelola Permission'))
            <div class="px-5 py-2 text-xs font-bold text-cyan-200/60 uppercase tracking-wider mt-4 mb-1">
                Pengguna
            </div>

            @can('Kelola Pelanggan')
                <a href="{{ route('pelanggan.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('pelanggan.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-8 0v2m8 0H9m4-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Pelanggan
                </a>
            @endcan

            @can('Kelola User')
                <a href="{{ route('user.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('user.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    User Management
                </a>
            @endcan

            @can('Kelola Role')
                <a href="{{ route('role.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('role.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Role Management
                </a>
            @endcan

            @can('Kelola Permission')
                <a href="{{ route('permission.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('permission.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m-5 4a3 3 0 10-6 0 3 3 0 006 0zm7-5a2 2 0 11-4 0 2 2 0 014 0zM12 11l4.5 4.5M16.5 15.5l1.5-1.5M15.5 16.5l1.5 1.5" />
                    </svg>
                    Permission Management
                </a>
            @endcan
        @endif

        <!-- Transaksi Group -->
        @if(auth()->user()->can('Kelola Transaksi') || auth()->user()->can('Verifikasi Resep') || auth()->user()->can('Kelola Pesanan Online') || auth()->user()->role === 'admin')
            <div class="px-5 py-2 text-xs font-bold text-cyan-200/60 uppercase tracking-wider mt-4 mb-1">
                Transaksi
            </div>

            @can('Kelola Transaksi')
                <a href="{{ route('transaksi.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('transaksi.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.12-3 2.5S10.343 13 12 13s3-1.12 3-2.5S13.657 8 12 8zm0 0V6m0 7v2m0 0c1.657 0 3 1.12 3 2.5S13.657 20 12 20s-3-1.12-3-2.5S10.343 15 12 15z"/>
                    </svg>
                    Transaksi (POS)
                </a>
            @endcan

            @can('Kelola Laporan')
                <a href="{{ route('laporan.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('laporan.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h4v6m4 0V7H5v10m14 4H3"/>
                    </svg>
                    Laporan
                </a>
            @endcan

            @if(auth()->user()->role === 'admin' || auth()->user()->can('Verifikasi Resep'))
                @php
                    $isResepActive = request()->routeIs('admin.resep.*') || request()->routeIs('apoteker.resep.*');
                    $resepUrl = auth()->user()->role === 'admin' ? route('admin.resep.index') : route('apoteker.resep.index');
                @endphp
                <a href="{{ $resepUrl }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ $isResepActive ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Resep Dokter
                </a>
            @endif

            @can('Kelola Pesanan Online')
                <a href="{{ route('admin.transaksi-online.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('admin.transaksi-online.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 1.5l8 4v13l-8 4-8-4v-13l8-4zm0 2.236l-6 3v10.528l6 3 6-3V6.736l-6-3zM13.5 14a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/>
                    </svg>
                    Pesanan Online
                </a>
            @endcan

            @can('Kelola Pesanan Online')
                <a href="{{ route('admin.feedback-layanan.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('admin.feedback-layanan.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                    </svg>
                    Penilaian Layanan
                </a>
            @endcan

        @elseif(Auth::user()->role === 'kasir')
            <!-- Kasir Navigation -->
            <a href="/kasir/dashboard"
               class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
               {{ request()->is('kasir/dashboard') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 11V9m0 12h6" />
                </svg>
                Dashboard Kasir
            </a>

            @can('Kelola Transaksi')
                <a href="{{ route('transaksi.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('transaksi.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.12-3 2.5S10.343 13 12 13s3-1.12 3-2.5S13.657 8 12 8zm0 0V6m0 7v2m0 0c1.657 0 3 1.12 3 2.5S13.657 20 12 20s-3-1.12-3-2.5S10.343 15 12 15z"/>
                    </svg>
                    Transaksi
                </a>
            @endcan

            @if(auth()->user()->role === 'admin' || auth()->user()->can('Verifikasi Resep'))
                @php
                    $isResepActive = request()->routeIs('admin.resep.*') || request()->routeIs('apoteker.resep.*');
                    $resepUrl = auth()->user()->role === 'admin' ? route('admin.resep.index') : route('apoteker.resep.index');
                @endphp
                <a href="{{ $resepUrl }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ $isResepActive ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Resep Dokter
                </a>
            @endif

            @can('Kelola Pesanan Online')
                <a href="{{ route('admin.transaksi-online.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-xl transition mb-1
                   {{ request()->routeIs('admin.transaksi-online.*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 1.5l8 4v13l-8 4-8-4v-13l8-4zm0 2.236l-6 3v10.528l6 3 6-3V6.736l-6-3zM13.5 14a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/>
                    </svg>
                    Pesanan Online
                </a>
            @endcan
        @endif

    </nav>

    <!-- User Section -->
    <div class="p-6">
        <div class="bg-white/10 rounded-2xl p-4 flex flex-col gap-3">
            <div>
                <h3 class="font-semibold text-white truncate">
                    {{ Auth::user()->name }}
                </h3>
                <p class="text-xs text-gray-200 truncate">
                    {{ Auth::user()->email }}
                </p>
                <span class="inline-block mt-1.5 px-2 py-0.5 text-[9px] font-bold bg-cyan-400/30 text-cyan-200 rounded-full uppercase tracking-wider">
                    {{ Auth::user()->role }}
                </span>
            </div>
            
            <hr class="border-white/10 my-0.5">
            
            <div class="flex flex-col gap-1.5">
                <a href="{{ route('profile.edit') }}" class="text-xs text-gray-200 hover:text-white transition flex items-center gap-1.5 py-0.5">
                    <svg class="w-3.5 h-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Edit Profil
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full text-left text-xs text-red-200 hover:text-red-100 font-medium transition flex items-center gap-1.5 py-0.5 focus:outline-none">
                        <svg class="w-3.5 h-3.5 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

</aside>
