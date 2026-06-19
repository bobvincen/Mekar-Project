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
    <nav class="mt-8 flex-1">

        @if(Auth::user()->role === 'admin')
            <!-- Admin Navigation -->
            <a href="/dashboard"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('dashboard') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7m-9 11V9m0 12h6" />
                </svg>
                Dashboard
            </a>

            <a href="/kategori"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('kategori*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
                Kategori
            </a>

            <a href="/supplier"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('supplier*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 17v-6h13v6M3 7h18M5 17h2m10 0h2"/>
                </svg>
                Supplier
            </a>

            <a href="/obat"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('obat*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14L21 3m0 0h-6m6 0v6M3 21l7-7"/>
                </svg>
                Obat
            </a>

            <a href="/pelanggan"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('pelanggan*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-8 0v2m8 0H9m4-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Pelanggan
            </a>

            <a href="/transaksi"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('transaksi*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8c-1.657 0-3 1.12-3 2.5S10.343 13 12 13s3-1.12 3-2.5S13.657 8 12 8zm0 0V6m0 7v2m0 0c1.657 0 3 1.12 3 2.5S13.657 20 12 20s-3-1.12-3-2.5S10.343 15 12 15z"/>
                </svg>
                Transaksi
            </a>

            <a href="/laporan"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('laporan*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 17v-6h4v6m4 0V7H5v10m14 4H3"/>
                </svg>
                Laporan
            </a>

            <a href="{{ route('admin.resep.index') }}"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('resep-dokter*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Resep Dokter
            </a>

            <a href="{{ route('admin.transaksi-online.index') }}"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('transaksi-online*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 1.5l8 4v13l-8 4-8-4v-13l8-4zm0 2.236l-6 3v10.528l6 3 6-3V6.736l-6-3zM13.5 14a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/>
                </svg>
                Pesanan Online
            </a>

            <a href="{{ route('admin.feedback-layanan.index') }}"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('feedback-layanan*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                </svg>
                Penilaian Layanan
            </a>


        @elseif(Auth::user()->role === 'kasir')
            <!-- Kasir Navigation -->
            <a href="/kasir/dashboard"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('kasir/dashboard') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7m-9 11V9m0 12h6" />
                </svg>
                Dashboard Kasir
            </a>

            <a href="/transaksi"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('transaksi*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8c-1.657 0-3 1.12-3 2.5S10.343 13 12 13s3-1.12 3-2.5S13.657 8 12 8zm0 0V6m0 7v2m0 0c1.657 0 3 1.12 3 2.5S13.657 20 12 20s-3-1.12-3-2.5S10.343 15 12 15z"/>
                </svg>
                Transaksi
            </a>

            <a href="/laporan"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('laporan*') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 17v-6h4v6m4 0V7H5v10m14 4H3"/>
                </svg>
                Laporan
            </a>

            <a href="/marketplace"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                </svg>
                Ke Marketplace
            </a>

        @elseif(Auth::user()->role === 'pelanggan')
            <!-- Pelanggan Navigation -->
            <a href="/home"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition
            {{ request()->is('home') ? 'bg-white text-blue-900 font-semibold shadow-lg' : 'hover:bg-white/20' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7m-9 11V9m0 12h6" />
                </svg>
                Beranda
            </a>

            <a href="/marketplace"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                </svg>
                Marketplace
            </a>

            <a href="/cart"
            class="flex items-center gap-3 mx-4 mb-2 px-5 py-3 rounded-xl transition hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.7 2.766-7.254m-14.71 7.254L4.765 4.5H2.25m3.75 0h14.25M7.5 14.25v2.25M16.5 14.25v2.25m-9-2.25h9M7.5 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm9 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                Keranjang Belanja
            </a>
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
