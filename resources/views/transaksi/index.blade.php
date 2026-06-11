@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-bold">Data Transaksi</h1>
            <p class="text-gray-500">Kelola transaksi penjualan obat</p>
        </div>

        <a href="{{ route('transaksi.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">
            + Tambah Transaksi
        </a>

    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 p-4 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-xl">
        {{ session('error') }}
    </div>
    @endif

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>
                <tr class="border-b">
                    <th class="text-left py-4">No</th>
                    <th class="text-left py-4">Kode Transaksi</th>
                    <th class="text-left py-4">Tanggal</th>
                    <th class="text-left py-4">Pelanggan</th>
                    <th class="text-left py-4">Item</th>
                    <th class="text-left py-4">Total Harga</th>
                    <th class="text-left py-4">Bayar</th>
                    <th class="text-left py-4">Kembalian</th>
                    <th class="text-center py-4">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transaksis as $t)
                <tr class="border-b hover:bg-gray-50">

                    <td class="py-4">{{ $loop->iteration }}</td>

                    <td class="py-4 font-mono font-semibold text-blue-600">
                        {{ $t->kode_transaksi }}
                    </td>

                    <td class="py-4">
                        {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y') }}
                    </td>

                    <td class="py-4">
                        {{ $t->pelanggan->nama_pelanggan ?? 'Umum' }}
                    </td>

                    <td class="py-4">
                        <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $t->detailTransaksis->count() }} item
                        </span>
                    </td>

                    <td class="py-4 font-semibold">
                        Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                    </td>

                    <td class="py-4">
                        Rp {{ number_format($t->bayar, 0, ',', '.') }}
                    </td>

                    <td class="py-4 text-green-600 font-semibold">
                        Rp {{ number_format($t->kembalian, 0, ',', '.') }}
                    </td>

                    <td class="py-4 text-center">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('transaksi.show', $t) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                                Detail
                            </a>

                            <a href="{{ route('transaksi.edit', $t) }}"
                               class="bg-yellow-500 text-white px-4 py-2 rounded-lg">
                                Edit
                            </a>

                            <form action="{{ route('transaksi.destroy', $t) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus transaksi ini?')"
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500">
                        Belum ada data transaksi
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    @if($transaksis->hasPages())
    <div class="mt-4">
        {{ $transaksis->links() }}
    </div>
    @endif

</div>

@endsection