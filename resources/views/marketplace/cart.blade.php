@extends('marketplace.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

@php
    $cartItems = $cartItems ?? session()->get('cart', []);
    $subtotal  = $subtotal ?? 0;
    $total     = $total ?? 0;
    $itemCount = count($cartItems);
    $formatRp  = fn(int $amount): string => 'Rp ' . number_format($amount, 0, ',', '.');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

    {{-- ===== HEADER ===== --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-1">
            <a href="/" class="text-slate-400 hover:text-blue-600 transition-colors text-sm font-light">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-blue-600 text-sm font-medium">Keranjang</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    Keranjang Belanja
                    <span id="header-count" class="text-blue-600">({{ $itemCount }} Produk)</span>
                </h1>
                <p class="text-sm text-slate-400 font-light mt-1">Periksa kembali produk sebelum melanjutkan pembayaran</p>
            </div>

            {{-- TOMBOL KOSONGKAN KERANJANG --}}
            @if($itemCount > 0)
            <a href="#"
                onclick="event.preventDefault(); if(confirm('Yakin ingin mengosongkan semua keranjang?')) window.location.href='/cart/clear'"
                class="hidden sm:flex items-center gap-1.5 text-xs font-semibold text-red-400 hover:text-red-600 hover:bg-red-50 border border-red-100 hover:border-red-200 px-3 py-2 rounded-xl transition-all duration-200">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                </svg>
                Kosongkan Keranjang
            </a>
            @endif
        </div>
    </div>

    @if($itemCount > 0)

    {{-- ===== LAYOUT DUA KOLOM ===== --}}
    <div class="flex flex-col lg:flex-row gap-8 items-start" x-data="cartPage()">

        {{-- ===== KOLOM KIRI (70%) ===== --}}
        <div class="w-full lg:w-[70%] flex flex-col gap-4">

            {{-- SELECT ALL BAR + HAPUS DIPILIH --}}
            <div class="bg-white border border-slate-100 rounded-2xl px-5 py-4 flex items-center justify-between shadow-sm">
                <label class="flex items-center gap-3 cursor-pointer select-none group">
                    <div class="relative">
                        <input type="checkbox" id="select-all" x-model="allSelected" @change="toggleAll()" class="sr-only peer">
                        <div class="w-5 h-5 rounded-md border-2 border-slate-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-slate-800 group-hover:text-blue-600 transition-colors">Pilih Semua Produk</span>
                </label>

                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400 font-light" x-text="selectedCount + ' item dipilih'"></span>

                    {{-- TOMBOL HAPUS DIPILIH (muncul kalau ada yang dicentang) --}}
                    <button
                        type="button"
                        x-show="selectedCount > 0"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        @click="deleteSelected()"
                        class="flex items-center gap-1.5 text-xs font-semibold text-red-500 hover:text-white hover:bg-red-500 border border-red-200 hover:border-red-500 px-3 py-1.5 rounded-xl transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                        Hapus Dipilih
                    </button>
                </div>
            </div>

            {{-- PRODUCT CARDS --}}
            @foreach($cartItems as $index => $item)
            <div class="group bg-white border border-slate-100 hover:border-blue-200 rounded-3xl shadow-sm hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300 p-5 sm:p-6"
                 x-show="!deletedItems.includes({{ $loop->index }})"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                <div class="flex items-start gap-4">

                    {{-- CHECKBOX --}}
                    <div class="pt-1 shrink-0">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" x-model="selected[{{ $loop->index }}]">
                            <div class="w-5 h-5 rounded-md border-2 border-slate-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                        </label>
                    </div>

                    {{-- GAMBAR --}}
                    <div class="shrink-0 w-20 h-20 sm:w-24 sm:h-24 bg-blue-50/30 rounded-2xl flex items-center justify-center overflow-hidden">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 sm:w-20 sm:h-20 object-contain transition-transform duration-300 group-hover:scale-105">
                    </div>

                    {{-- INFO PRODUK --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                            <div class="min-w-0">
                                <span class="inline-block bg-blue-50 text-blue-600 border border-blue-100/60 text-[10px] font-semibold px-2 py-0.5 rounded-lg mb-2">
                                    {{ $item['category'] }}
                                </span>
                                <h3 class="text-sm sm:text-base font-semibold text-slate-900 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    {{ $item['name'] }}
                                </h3>
                                <p class="text-blue-600 text-base sm:text-lg font-bold mt-1">
                                    {{ $formatRp($item['price']) }}
                                </p>
                            </div>

                            {{-- QTY + SUBTOTAL + HAPUS --}}
                            <div class="flex sm:flex-col items-center sm:items-end gap-3 sm:gap-4 shrink-0">

                                {{-- TOMBOL HAPUS ITEM --}}
                                <button type="button"
                                    @click="deleteSingle({{ $loop->index }}, {{ $item['id'] }})"
                                    class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-200 order-last sm:order-first"
                                    title="Hapus produk">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                </button>

                                {{-- QTY COUNTER: bisa ketik + tombol +/- --}}
                                <div class="flex items-center gap-0 border border-slate-200 rounded-xl overflow-hidden">
                                    <button type="button"
                                        @click="decrementQty({{ $loop->index }}, {{ $item['id'] }})"
                                        class="w-9 h-9 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 font-semibold text-lg">
                                        −
                                    </button>
                                    <input
                                        type="number"
                                        min="1"
                                        max="99"
                                        x-model.number="items[{{ $loop->index }}].qty"
                                        @change="onQtyInput({{ $loop->index }}, {{ $item['id'] }})"
                                        @blur="onQtyInput({{ $loop->index }}, {{ $item['id'] }})"
                                        class="w-12 text-center text-sm font-bold text-slate-800 border-x border-slate-200 py-2 focus:outline-none focus:bg-blue-50 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    >
                                    <button type="button"
                                        @click="incrementQty({{ $loop->index }}, {{ $item['id'] }})"
                                        class="w-9 h-9 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 font-semibold text-lg">
                                        +
                                    </button>
                                </div>

                                {{-- SUBTOTAL (Desktop) --}}
                                <div class="text-right hidden sm:block">
                                    <p class="text-[10px] text-slate-400 font-light mb-0.5">Subtotal</p>
                                    <p class="text-sm font-bold text-slate-900"
                                        x-text="formatRp(items[{{ $loop->index }}].qty * items[{{ $loop->index }}].price)">
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- SUBTOTAL (Mobile) --}}
                        <div class="sm:hidden mt-3 pt-3 border-t border-slate-50 flex justify-between items-center">
                            <span class="text-xs text-slate-400 font-light">Subtotal</span>
                            <span class="text-sm font-bold text-slate-900"
                                x-text="formatRp(items[{{ $loop->index }}].qty * items[{{ $loop->index }}].price)">
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach

            {{-- PESAN KERANJANG KOSONG (setelah semua dihapus via JS) --}}
            <div x-show="visibleCount === 0"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="flex flex-col items-center justify-center py-16 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                <svg class="w-12 h-12 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                </svg>
                <p class="text-slate-400 font-medium text-sm mb-4">Keranjang kamu sudah kosong</p>
                <a href="/" class="text-xs font-bold text-blue-600 hover:text-blue-700 underline underline-offset-2">Belanja lagi</a>
            </div>

            {{-- LANJUTKAN BELANJA --}}
            <div class="mt-2" x-show="visibleCount > 0">
                <a href="/" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors group">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    Lanjutkan Belanja
                </a>
            </div>

        </div>
        {{-- END KOLOM KIRI --}}

        {{-- ===== KOLOM KANAN (30%) ===== --}}
        <div class="w-full lg:w-[30%] lg:sticky lg:top-24 flex flex-col gap-4">

            <div class="bg-white border border-slate-100 rounded-3xl shadow-sm p-5">
                <h3 class="text-base font-bold text-slate-900 mb-5 pb-4 border-b border-slate-50">
                    Ringkasan Belanja
                </h3>

                <div class="space-y-3 mb-5">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500 font-light">Subtotal (<span x-text="selectedCount"></span> Produk)</span>
                        <span class="text-sm font-semibold text-slate-800" x-text="formatRp(subtotal)"></span>
                    </div>
                </div>

                <div class="border-t border-dashed border-slate-100 pt-4 mb-5">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-900">Total Pembayaran</span>
                        <span class="text-xl font-bold text-blue-600" x-text="formatRp(total)"></span>
                    </div>
                    <p class="text-[10px] text-slate-400 font-light mt-1 text-right">Sudah termasuk pajak & biaya layanan</p>
                </div>

                <button @click="proceedToCheckout()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-4 rounded-2xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-300 flex items-center justify-center gap-2 group">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                    Lanjut ke Checkout
                </button>

                {{-- TOMBOL KOSONGKAN (Mobile) --}}
                <button type="button"
                    onclick="if(confirm('Yakin ingin mengosongkan semua keranjang?')) window.location.href='/cart/clear'"
                    class="sm:hidden w-full mt-3 flex items-center justify-center gap-1.5 text-xs font-semibold text-red-400 hover:text-red-600 border border-red-100 hover:border-red-200 py-2.5 rounded-xl transition-all duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                    Kosongkan Keranjang
                </button>

                <div class="flex items-center justify-center gap-4 mt-4 pt-4 border-t border-slate-50">
                    <div class="flex items-center gap-1 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751A11.956 11.956 0 0112 2.714z"/></svg>
                        <span class="text-[10px] font-light">Transaksi Aman</span>
                    </div>
                    <div class="flex items-center gap-1 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                        <span class="text-[10px] font-light">100% Original</span>
                    </div>
                    <div class="flex items-center gap-1 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-[10px] font-light">Pengiriman Cepat</span>
                    </div>
                </div>
            </div>

        </div>
        {{-- END KOLOM KANAN --}}

    </div>

    @else

    {{-- ===== KERANJANG KOSONG ===== --}}
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="w-28 h-28 bg-blue-50 border border-blue-100/60 rounded-[32px] flex items-center justify-center mb-6">
            <svg class="w-14 h-14 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Keranjang Masih Kosong</h2>
        <p class="text-slate-400 font-light text-sm max-w-xs leading-relaxed mb-8">
            Yuk mulai belanja kebutuhan kesehatan Anda dari apotek terpercaya kami.
        </p>
        <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-8 py-4 rounded-2xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-300 flex items-center gap-2 group">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
            </svg>
            Belanja Sekarang
        </a>
    </div>

    @endif

</div>

@endsection

@push('scripts')
<script>
function cartPage() {
    return {
        selected: Array({{ count($cartItems) }}).fill(true),
        items: {!! json_encode(array_values($cartItems)) !!},
        deletedItems: [],

        init() {
            this.$watch('items', () => {}, { deep: true });
        },

        get allSelected() {
            const visible = this.items.filter((_, i) => !this.deletedItems.includes(i));
            if (visible.length === 0) return false;
            return this.items.every((_, i) => this.deletedItems.includes(i) || this.selected[i]);
        },
        get selectedCount() {
            return this.selected.filter((v, i) => v && !this.deletedItems.includes(i)).length;
        },
        get visibleCount() {
            return this.items.length - this.deletedItems.length;
        },
        get subtotal() {
            let total = 0;
            this.items.forEach((item, index) => {
                if (this.selected[index] && !this.deletedItems.includes(index)) {
                    total += (item.qty * item.price);
                }
            });
            return total;
        },
        get total() {
            return this.subtotal > 0 ? this.subtotal : 0;
        },

        toggleAll() {
            const allVis = this.allSelected;
            this.selected = this.selected.map((_, i) =>
                this.deletedItems.includes(i) ? false : !allVis
            );
        },

        formatRp(amount) {
            return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
        },

        // Hapus satu item
        deleteSingle(index, itemId) {
            fetch('/cart/remove/' + itemId, { method: 'GET' })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                this.deletedItems.push(index);
                this.selected[index] = false;
                this.updateHeaderCount();
            });
        },

        // Hapus semua yang dicentang
        deleteSelected() {
            if (this.selectedCount === 0) return;
            if (!confirm('Hapus ' + this.selectedCount + ' produk yang dipilih?')) return;

            const toDelete = this.items
                .map((item, i) => ({ index: i, id: item.id }))
                .filter(({ index }) => this.selected[index] && !this.deletedItems.includes(index));

            const deleteNext = (i) => {
                if (i >= toDelete.length) {
                    this.updateHeaderCount();
                    return;
                }
                const { index, id } = toDelete[i];
                fetch('/cart/remove/' + id, { method: 'GET' })
                .then(res => {
                    if (res.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    this.deletedItems.push(index);
                    this.selected[index] = false;
                    deleteNext(i + 1);
                });
            };

            deleteNext(0);
        },

        updateHeaderCount() {
            const remaining = this.visibleCount;
            const headerCount = document.getElementById('header-count');
            if (headerCount) {
                headerCount.innerText = '(' + remaining + ' Produk)';
            }
            const cartBadge = document.querySelector('#cart-count');
            if (cartBadge) {
                if (remaining > 0) {
                    cartBadge.textContent = remaining;
                    cartBadge.classList.remove('hidden');
                } else {
                    cartBadge.classList.add('hidden');
                }
            }
        },

        updateQty(index, itemId, newQty) {
            this.items[index].qty = newQty;
            fetch('/cart/update?id=' + itemId + '&qty=' + newQty, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return null;
                }
                return res.json();
            })
            .then(data => {
                if (!data) return;
                if (data.success) {
                    this.items[index].qty = data.qty;
                    const headerCount = document.getElementById('header-count');
                    if (headerCount) {
                        headerCount.innerText = '(' + data.itemCount + ' Produk)';
                    }
                }
            });
        },

        decrementQty(index, itemId) {
            const newQty = Math.max(1, this.items[index].qty - 1);
            this.updateQty(index, itemId, newQty);
        },

        incrementQty(index, itemId) {
            const newQty = Math.min(99, this.items[index].qty + 1);
            this.updateQty(index, itemId, newQty);
        },

        onQtyInput(index, itemId) {
            let qty = parseInt(this.items[index].qty);
            if (isNaN(qty) || qty < 1) qty = 1;
            if (qty > 99) qty = 99;
            this.updateQty(index, itemId, qty);
        },

        proceedToCheckout() {
            let selectedIds = [];
            this.items.forEach((item, index) => {
                if (this.selected[index] && !this.deletedItems.includes(index)) {
                    selectedIds.push(item.id);
                }
            });
            if (selectedIds.length === 0) {
                alert('Pilih minimal satu produk untuk di-checkout.');
                return;
            }
            window.location.href = '/checkout?selected=' + selectedIds.join(',');
        }
    }
}
</script>
@endpush