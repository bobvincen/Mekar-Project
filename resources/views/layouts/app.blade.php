<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mekar Pharmacy</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#eef3f8]">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @if(Auth::user()->role !== 'pelanggan')
            @include('layouts.sidebar')
        @endif

        {{-- Content --}}
        <div class="flex-1 {{ Auth::user()->role !== 'pelanggan' ? 'ml-72' : '' }}">

            {{-- Navbar --}}
            @if(Auth::user()->role !== 'pelanggan')
                @include('layouts.navbar')
            @else
                {{-- Clean navbar for customer profile page --}}
                <nav class="bg-white shadow-sm px-8 py-5 flex justify-between items-center">
                    <div>
                        <a href="/marketplace" class="flex items-center gap-2 text-blue-600 hover:text-blue-700 transition-colors font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            Kembali ke Marketplace
                        </a>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-800">Edit Profil Mekar Pharmacy</span>
                    </div>
                    <div class="w-24"></div> {{-- Spacer --}}
                </nav>
            @endif

            {{-- Main Content --}}
            <main class="p-6">
                @if(Auth::user()->role === 'pelanggan')
                    <div class="max-w-4xl mx-auto">
                        @yield('content')
                        {{ $slot ?? '' }}
                    </div>
                @else
                    @yield('content')
                    {{ $slot ?? '' }}
                @endif
            </main>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
