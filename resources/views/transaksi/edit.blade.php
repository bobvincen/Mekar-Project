@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')

<div class="bg-white rounded-3xl shadow-lg p-6">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('transaksi.show', $transaksi) }}"
           class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl text-gray-600">
            &larr; Kembali
        </a>
        <div>
            <h1 class="text-2xl font-bold">Edit Transaksi</h1>
            <p class="text-gray-500 font-mono">{{ $transaksi->kode_transaksi }}</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-xl">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-xl">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('transaksi.update', $transaksi) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kiri: Info & Pembayaran --}}
        <div class="space-y-6">

            <div class="border rounded-2xl p-5">

                <h2 class="text-lg font-bold mb-4">Info Transaksi</h2>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pelanggan</label>
                    <select name="pelanggan_id"
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">— Pelanggan Umum —</option>
                        @foreach($pelanggans as $p)
                            <option value="{{ $p->id }}"
                                {{ old('pelanggan_id', $transaksi->pelanggan_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_pelanggan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="tanggal_transaksi"
                           class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('tanggal_transaksi') border-red-500 bg-red-50 @enderror"
                           value="{{ old('tanggal_transaksi', \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i')) }}">
                    @error('tanggal_transaksi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="border rounded-2xl p-5">

                <h2 class="text-lg font-bold mb-4">Pembayaran</h2>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Total Harga</label>
                    <div class="w-full bg-gray-50 border rounded-xl px-4 py-3 font-bold text-gray-800"
                         id="display_total">Rp 0</div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Bayar <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="bayar" id="bayar"
                           class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('bayar') border-red-500 bg-red-50 @enderror"
                           value="{{ old('bayar', $transaksi->bayar) }}" min="0" step="1000"
                           oninput="hitungKembalian()">
                    @error('bayar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kembalian</label>
                    <div class="w-full bg-green-50 border border-green-200 rounded-xl px-4 py-3 font-bold text-green-700"
                         id="display_kembalian">Rp 0</div>
                </div>

            </div>

            <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 rounded-xl">
                Perbarui Transaksi
            </button>

            <a href="{{ route('transaksi.show', $transaksi) }}"
               class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold py-3 rounded-xl">
                Batal
            </a>

        </div>

        {{-- Kanan: Item Obat --}}
        <div class="lg:col-span-2">

            <div class="border rounded-2xl p-5">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold">Item Obat</h2>
                    <button type="button" onclick="tambahBaris()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">
                        + Tambah Obat
                    </button>
                </div>

                <div class="grid grid-cols-12 gap-2 mb-2 text-sm font-semibold text-gray-500 px-1">
                    <div class="col-span-6">Nama Obat</div>
                    <div class="col-span-2 text-center">Qty</div>
                    <div class="col-span-3 text-right">Subtotal</div>
                    <div class="col-span-1"></div>
                </div>

                <div id="item-container" class="space-y-3"></div>

                <div class="border-t mt-4 pt-4 flex justify-between items-center">
                    <span class="font-semibold text-gray-700">Total</span>
                    <span class="text-xl font-bold text-gray-800" id="display_total_bawah">Rp 0</span>
                </div>

            </div>

        </div>

    </div>

    </form>

</div>

@push('scripts')
<script>
const obats      = @json($obats);
const detailLama = @json($transaksi->detailTransaksis);
let barisIndex   = 0;
let totalHarga   = 0;

function tambahBaris(obatId = '', jumlah = 1, errorMsg = '') {
    const idx = barisIndex++;
    const options = obats.map(o =>
        `<option value="${o.id}" data-harga="${o.harga_jual}" data-stok="${o.stok}"
            ${o.id == obatId ? 'selected' : ''}>
            ${o.nama_obat} (stok: ${o.stok}) — Rp ${Number(o.harga_jual).toLocaleString('id-ID')}
        </option>`
    ).join('');

    const errorClass = errorMsg ? 'border-red-500 bg-red-50' : 'border-gray-300';

    const html = `
    <div class="baris-item space-y-1 mb-3" id="baris-${idx}">
        <div class="grid grid-cols-12 gap-2 items-center">
            <div class="col-span-6">
                <select name="obat_id[]" onchange="updateSubtotal(${idx})"
                        class="w-full border ${errorClass} rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Obat --</option>
                    ${options}
                </select>
            </div>
            <div class="col-span-2">
                <input type="number" name="jumlah[]" value="${jumlah}" min="1"
                       id="jumlah-${idx}"
                       oninput="updateSubtotal(${idx})"
                       class="w-full border ${errorClass} rounded-xl px-3 py-2 text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="col-span-3 text-right font-semibold text-sm text-gray-700 bg-gray-50 border rounded-xl px-3 py-2"
                 id="subtotal-${idx}">Rp 0</div>
            <div class="col-span-1 text-center">
                <button type="button" onclick="hapusBaris(${idx})"
                        class="bg-red-100 hover:bg-red-200 text-red-600 px-2 py-2 rounded-xl text-sm">
                    ✕
                </button>
            </div>
        </div>
        ${errorMsg ? `<p class="text-red-500 text-xs px-1 font-semibold">${errorMsg}</p>` : ''}
    </div>`;

    document.getElementById('item-container').insertAdjacentHTML('beforeend', html);
    if (obatId) updateSubtotal(idx);
}

function hapusBaris(idx) {
    document.getElementById(`baris-${idx}`)?.remove();
    hitungTotal();
}

function updateSubtotal(idx) {
    const select   = document.querySelector(`#baris-${idx} select`);
    const jumlah   = parseInt(document.getElementById(`jumlah-${idx}`)?.value) || 0;
    const option   = select?.options[select.selectedIndex];
    const harga    = parseFloat(option?.dataset?.harga || 0);
    const subtotal = harga * jumlah;
    const el = document.getElementById(`subtotal-${idx}`);
    if (el) el.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    hitungTotal();
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.baris-item').forEach(baris => {
        const select   = baris.querySelector('select');
        const jumlahEl = baris.querySelector('input[type=number]');
        const harga    = parseFloat(select?.options[select?.selectedIndex]?.dataset?.harga || 0);
        const jumlah   = parseInt(jumlahEl?.value || 0);
        total += harga * jumlah;
    });
    totalHarga = total;
    const fmt = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('display_total').textContent = fmt;
    document.getElementById('display_total_bawah').textContent = fmt;
    hitungKembalian();
}

function hitungKembalian() {
    const bayar     = parseFloat(document.getElementById('bayar')?.value || 0);
    const kembalian = bayar - totalHarga;
    const el = document.getElementById('display_kembalian');
    if (kembalian < 0) {
        el.textContent = '⚠ Kurang Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
        el.className = 'w-full bg-red-50 border border-red-200 rounded-xl px-4 py-3 font-bold text-red-600';
    } else {
        el.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
        el.className = 'w-full bg-green-50 border border-green-200 rounded-xl px-4 py-3 font-bold text-green-700';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    @if(old('obat_id'))
        @foreach(old('obat_id') as $index => $oldObatId)
            @php
                $errorMsg = $errors->first('jumlah.'.$index) ?: $errors->first('obat_id.'.$index);
            @endphp
            tambahBaris('{{ $oldObatId }}', '{{ old('jumlah')[$index] ?? 1 }}', '{{ $errorMsg }}');
        @endforeach
    @else
        if (detailLama.length > 0) {
            detailLama.forEach(d => tambahBaris(d.obat_id, d.jumlah));
        } else {
            tambahBaris();
        }
    @endif
});
</script>
@endpush

@endsection