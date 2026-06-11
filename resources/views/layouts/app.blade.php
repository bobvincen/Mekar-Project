<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mekar Pharmacy</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content --}}
    <div class="flex-1 ml-72">

        {{-- Navbar --}}
        @include('layouts.navbar')

        {{-- Main Content --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

@stack('scripts')

</body>
</html>
