@extends('layouts.app')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        Dashboard
    </h1>

    <p class="text-slate-500">
        Selamat datang di Mekar Pharmacy
    </p>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    {{-- Total Obat --}}
   <div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500">
                Total Obat
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-2">
                {{ $totalObat }}
            </h2>

        </div>

        <div class="bg-cyan-100 p-4 rounded-2xl">

            💊

        </div>

    </div>

    </div>

    {{-- Total Supplier --}}
    <div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500">
                Total Supplier
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-2">
                {{ $totalSupplier }}
            </h2>

        </div>

        <div class="bg-cyan-100 p-4 rounded-2xl">

            🚚

        </div>

    </div>

    </div>

    {{-- Total Pelanggan --}}
    <div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500">
                Total Pelanggan
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-2">
                {{ $totalPelanggan }}
            </h2>

        </div>

        <div class="bg-cyan-100 p-4 rounded-2xl">

            👥

        </div>

    </div>

    </div>

    {{-- Total Transaksi --}}
    <div class="bg-white rounded-3xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <p class="text-gray-500">
                Total Transaksi
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-2">
                {{ $totalTransaksi }}
            </h2>

        </div>

        <div class="bg-cyan-100 p-4 rounded-2xl">

            💰

        </div>

    </div>

    </div>

</div>

@endsection
