@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div class="flex items-center gap-3">
            <a href="{{ route('transaksi.index') }}"
               class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl text-gray-600">
                &larr; Kembali
            </a>
            <div>
                <h1 class="text-2xl font-bold">Detail Transaksi</h1>
                <p class="text-gray-500 font-mono">{{ $transaksi->kode_transaksi }}</p>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('transaksi.edit', $transaksi) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl">
                Edit
            </a>
            <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Yakin hapus transaksi ini? Stok obat akan dikembalikan.')"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl">
                    Hapus
                </button>
            </form>
        </div>

    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 p-4 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kiri: Info & Pembayaran --}}
        <div class="space-y-6">

            <div class="border rounded-2xl p-5">
                <h2 class="text-lg font-bold mb-4">Info Transaksi</h2>
                <table class="w-full text-sm">
                    <tr class="border-b">
                        <td class="py-2 text-gray-500">Kode</td>
                        <td class="py-2 font-mono font-semibold text-blue-600 text-right">
                            {{ $transaksi->kode_transaksi }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-500">Tanggal</td>
                        <td class="py-2 font-semibold text-right">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-500">Pelanggan</td>
                        <td class="py-2 font-semibold text-right">
                            {{ $transaksi->pelanggan->nama_pelanggan ?? '— Umum —' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 text-gray-500">Kasir</td>
                        <td class="py-2 font-semibold text-right">
                            {{ $transaksi->user->name ?? '-' }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border rounded-2xl p-5">
                <h2 class="text-lg font-bold mb-4">Pembayaran</h2>
                <table class="w-full text-sm">
                    <tr class="border-b">
                        <td class="py-2 text-gray-500">Total Harga</td>
                        <td class="py-2 font-bold text-right">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-500">Bayar</td>
                        <td class="py-2 font-semibold text-right">
                            Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 text-gray-500 font-bold">Kembalian</td>
                        <td class="py-2 font-bold text-green-600 text-right text-lg">
                            Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        {{-- Kanan: Item Obat --}}
        <div class="lg:col-span-2">

            <div class="border rounded-2xl overflow-hidden">

                <div class="p-5 border-b flex items-center gap-2">
                    <h2 class="text-lg font-bold">Item Obat</h2>
                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $transaksi->detailTransaksis->count() }} item
                    </span>
                </div>

                <table class="w-full">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left px-5 py-3">Nama Obat</th>
                            <th class="text-right px-5 py-3">Harga Satuan</th>
                            <th class="text-center px-5 py-3">Jumlah</th>
                            <th class="text-right px-5 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->detailTransaksis as $detail)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-5 py-3 font-medium">
                                {{ $detail->obat->nama_obat ?? '-' }}
                            </td>
                            <td class="px-5 py-3 text-right text-gray-600">
                                Rp {{ number_format($detail->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    {{ $detail->jumlah }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right font-semibold">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-5 py-4 text-right font-bold text-gray-700">
                                Total
                            </td>
                            <td class="px-5 py-4 text-right font-bold text-gray-900 text-lg">
                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>

    </div>

</div>

@endsection