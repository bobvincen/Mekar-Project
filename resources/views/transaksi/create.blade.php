@extends('layouts.app')

@section('title', 'Tambah Transaksi POS')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('transaksi.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Tambah Transaksi POS</h1>
            <p class="text-xs text-slate-500 mt-0.5">Buat entri transaksi penjualan obat offline baru</p>
        </div>
    </div>

    <!-- Alerts -->
    @if($errors->any())
        <div class="bg-rose-50 text-rose-600 border border-rose-200 px-4 py-3.5 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <ul class="list-disc list-inside text-xs font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 text-rose-600 border border-rose-200 px-4 py-3.5 rounded-2xl flex items-center gap-3 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="font-semibold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('transaksi.store') }}" method="POST" class="m-0">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            {{-- Kiri: Info & Pembayaran --}}
            <div class="space-y-6">
                <!-- Info Transaksi -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-5 space-y-4">
                    <h2 class="text-sm font-extrabold text-slate-800 border-b border-slate-50 pb-2.5">Info Transaksi</h2>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Pelanggan <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <select name="pelanggan_id"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-750 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">— Pelanggan Umum —</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_pelanggan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Tanggal Transaksi <span class="text-rose-500">*</span>
                        </label>
                        <input type="datetime-local" name="tanggal_transaksi"
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-750 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_transaksi') border-rose-300 bg-rose-50/20 @enderror"
                               value="{{ old('tanggal_transaksi', now()->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>

                <!-- Pembayaran -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-5 space-y-4">
                    <h2 class="text-sm font-extrabold text-slate-800 border-b border-slate-50 pb-2.5">Pembayaran</h2>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Total Harga</label>
                        <div class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-extrabold text-slate-800 text-lg" id="display_total">
                            Rp 0
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Bayar <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="bayar" id="bayar"
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-750 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('bayar') border-rose-300 bg-rose-50/20 @enderror"
                               value="{{ old('bayar', 0) }}" min="0" step="1000"
                               oninput="hitungKembalian()">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kembalian</label>
                        <div class="w-full bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-3 font-extrabold text-emerald-700 text-lg" id="display_kembalian">
                            Rp 0
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <button type="submit" class="w-full px-5 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition">
                        Simpan Transaksi
                    </button>
                    <a href="{{ route('transaksi.index') }}" class="block w-full text-center py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-xs transition">
                        Batal
                    </a>
                </div>
            </div>

            {{-- Kanan: Item Obat --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-5">
                    
                    <div class="flex justify-between items-center border-b border-slate-50 pb-4 mb-4">
                        <h2 class="text-sm font-extrabold text-slate-800">Item Obat</h2>
                        <button type="button" onclick="tambahBaris()" class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 rounded-xl font-bold text-xs transition flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Baris
                        </button>
                    </div>

                    {{-- Header Table --}}
                    <div class="grid grid-cols-12 gap-2.5 mb-3 text-xs font-bold text-slate-400 uppercase tracking-wider px-1">
                        <div class="col-span-6">Nama Obat & Harga</div>
                        <div class="col-span-2 text-center">Kuantitas (Qty)</div>
                        <div class="col-span-3 text-right">Subtotal</div>
                        <div class="col-span-1"></div>
                    </div>

                    <!-- Items container -->
                    <div id="item-container" class="space-y-4"></div>

                    <p id="empty-msg" class="text-center text-slate-400 py-12 text-xs font-medium">
                        Belum ada obat ditambahkan. Silakan klik tombol "+ Tambah Baris" di atas.
                    </p>

                    {{-- Total Bawah --}}
                    <div class="border-t border-slate-100 mt-6 pt-4 flex justify-between items-center">
                        <span class="font-bold text-slate-500 text-sm">Grand Total</span>
                        <span class="text-2xl font-extrabold text-slate-900" id="display_total_bawah">Rp 0</span>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
const obats = @json($obats);
let barisIndex = 0;
let totalHarga = 0;

function tambahBaris(obatId = '', jumlah = 1, errorMsg = '') {
    document.getElementById('empty-msg').style.display = 'none';
    const idx = barisIndex++;

    const options = obats.map(o =>
        `<option value="${o.id}" data-harga="${o.harga_jual}" data-stok="${o.stok}"
            ${o.id == obatId ? 'selected' : ''}>
            ${o.nama_obat} (Stok: ${o.stok}) — Rp ${Number(o.harga_jual).toLocaleString('id-ID')}
        </option>`
    ).join('');

    const errorClass = errorMsg ? 'border-rose-300 bg-rose-50/20' : 'border-slate-200';

    const html = `
    <div class="baris-item space-y-1" id="baris-${idx}">
        <div class="grid grid-cols-12 gap-2.5 items-center">
            <div class="col-span-6">
                <select name="obat_id[]" onchange="updateSubtotal(${idx})"
                        class="w-full border ${errorClass} rounded-xl px-3 py-2 text-xs font-semibold text-slate-750 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Obat --</option>
                    ${options}
                </select>
            </div>
            <div class="col-span-2">
                <input type="number" name="jumlah[]" value="${jumlah}" min="1"
                       id="jumlah-${idx}"
                       oninput="updateSubtotal(${idx})"
                       class="w-full border ${errorClass} rounded-xl px-3 py-2 text-xs font-semibold text-center text-slate-750 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="col-span-3 text-right font-bold text-xs text-slate-750 bg-slate-50 border border-slate-100 rounded-xl px-3 py-2.5"
                 id="subtotal-${idx}">Rp 0</div>
            <div class="col-span-1 text-center">
                <button type="button" onclick="hapusBaris(${idx})"
                        class="bg-rose-50 hover:bg-rose-100 text-rose-500 p-2 rounded-xl transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        ${errorMsg ? `<p class="text-rose-500 text-[10px] px-1 font-bold">${errorMsg}</p>` : ''}
    </div>`;

    document.getElementById('item-container').insertAdjacentHTML('beforeend', html);
    if (obatId) updateSubtotal(idx);
}

function hapusBaris(idx) {
    document.getElementById(`baris-${idx}`)?.remove();
    hitungTotal();
    if (document.querySelectorAll('.baris-item').length === 0) {
        document.getElementById('empty-msg').style.display = 'block';
    }
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
        const select  = baris.querySelector('select');
        const jumlahEl = baris.querySelector('input[type=number]');
        const harga   = parseFloat(select?.options[select?.selectedIndex]?.dataset?.harga || 0);
        const jumlah  = parseInt(jumlahEl?.value || 0);
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
        el.className = 'w-full bg-rose-50 border border-rose-100 rounded-xl px-4 py-3 font-extrabold text-rose-600 text-lg';
    } else {
        el.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
        el.className = 'w-full bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-3 font-extrabold text-emerald-700 text-lg';
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
        tambahBaris();
    @endif
});
</script>
@endpush
@endsection