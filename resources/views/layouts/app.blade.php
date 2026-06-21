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
        @if (Auth::user()->can('Dashboard'))
            @include('layouts.sidebar')
        @endif

        {{-- Content --}}
        <div class="flex-1 {{ Auth::user()->can('Dashboard') ? 'ml-72' : '' }}">

            {{-- Navbar --}}
            @if (Auth::user()->can('Dashboard'))
                @include('layouts.navbar')
            @else
                {{-- Clean navbar for customer profile page --}}
                <nav class="bg-white shadow-sm px-8 py-5 flex justify-between items-center">
                    <div>
                        <a href="/marketplace"
                            class="flex items-center gap-2 text-blue-600 hover:text-blue-700 transition-colors font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
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
            {{-- Mengubah p-6 statis menjadi dinamis mengikuti breakpoints halaman data --}}
            <main class="p-4 sm:p-6 lg:p-8 w-full">
                @if (!Auth::user()->can('Dashboard'))
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
    <script>
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.toggle-password');
            if (btn) {
                const container = btn.parentElement;
                const input = container.querySelector('input');
                if (!input) return;

                const eyeIcon = btn.querySelector('.eye-icon');
                const eyeSlashIcon = btn.querySelector('.eye-slash-icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                    btn.setAttribute('aria-label', 'Sembunyikan Password');
                } else {
                    input.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                    btn.setAttribute('aria-label', 'Tampilkan Password');
                }
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
