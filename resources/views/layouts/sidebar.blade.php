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

    </nav>

    <!-- User -->
    <div class="p-6">

        <div class="bg-white/10 rounded-2xl p-4">

            <h3 class="font-semibold">
                Pengguna Admin
            </h3>

            <p class="text-sm text-gray-200">
                admin@mekar.com
            </p>

        </div>

    </div>

</aside>
