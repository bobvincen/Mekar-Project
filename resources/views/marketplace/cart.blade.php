@extends('marketplace.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

@php
    $cartItems = $cartItems ?? session()->get('cart', []);
    $subtotal  = $subtotal ?? 0;
    $total     = $total ?? 0;
    $itemCount = count($cartItems);

    // Use a closure to avoid "Cannot redeclare function" on refresh
    $formatRp = fn(int $amount): string => 'Rp ' . number_format($amount, 0, ',', '.');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-1">
            <a href="/" class="text-slate-400 hover:text-blue-600 transition-colors text-sm font-light">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-blue-600 text-sm font-medium">Keranjang</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
            Keranjang Belanja
            <span id="header-count" class="text-blue-600">({{ $itemCount }} Produk)</span>
        </h1>
        <p class="text-sm text-slate-400 font-light mt-1">Periksa kembali produk sebelum melanjutkan pembayaran</p>
    </div>

    @if($itemCount > 0)

    {{-- ===== TWO-COLUMN LAYOUT ===== --}}
    <div class="flex flex-col lg:flex-row gap-8 items-start" x-data="cartPage()">

        {{-- =================== LEFT COLUMN (70%) =================== --}}
        <div class="w-full lg:w-[70%] flex flex-col gap-4">

            {{-- SELECT ALL BAR --}}
            <div class="bg-white border border-slate-100 rounded-2xl px-5 py-4 flex items-center justify-between shadow-sm">
                <label class="flex items-center gap-3 cursor-pointer select-none group">
                    <div class="relative">
                        <input
                            type="checkbox"
                            id="select-all"
                            x-model="allSelected"
                            @change="toggleAll()"
                            class="sr-only peer"
                        >
                        <div class="w-5 h-5 rounded-md border-2 border-slate-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-slate-800 group-hover:text-blue-600 transition-colors">Pilih Semua Produk</span>
                </label>
                <span class="text-xs text-slate-400 font-light" x-text="selectedCount + ' item dipilih'"></span>
            </div>

            {{-- PRODUCT CARDS --}}
            @foreach($cartItems as $index => $item)
            <div class="group bg-white border border-slate-100 hover:border-blue-200 rounded-3xl shadow-sm hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300 p-5 sm:p-6">
                <div class="flex items-start gap-4">

                    {{-- CHECKBOX --}}
                    <div class="pt-1 shrink-0">
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                class="sr-only peer"
                                x-model="selected[{{ $loop->index }}]"
                            >
                            <div class="w-5 h-5 rounded-md border-2 border-slate-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </div>
                        </label>
                    </div>

                    {{-- PRODUCT IMAGE --}}
                    <div class="shrink-0 w-20 h-20 sm:w-24 sm:h-24 bg-blue-50/30 rounded-2xl flex items-center justify-center overflow-hidden">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 sm:w-20 sm:h-20 object-contain transition-transform duration-300 group-hover:scale-105">
                    </div>

                    {{-- PRODUCT INFO --}}
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

                            {{-- RIGHT SIDE: QTY + SUBTOTAL + DELETE --}}
                            <div class="flex sm:flex-col items-center sm:items-end gap-3 sm:gap-4 shrink-0">

                                {{-- DELETE BUTTON --}}
                                <a
                                    href="/cart/remove/{{ $item['id'] }}"
                                    class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-200 order-last sm:order-first"
                                    title="Hapus produk"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                </a>

                                {{-- QTY COUNTER --}}
                                <div class="flex items-center gap-0 border border-slate-200 rounded-xl overflow-hidden">
                                    <button
                                        type="button"
                                        @click="items[{{ $loop->index }}].qty = Math.max(1, items[{{ $loop->index }}].qty - 1); updateQty({{ $loop->index }}, {{ $item['id'] }}, items[{{ $loop->index }}].qty)"
                                        class="w-9 h-9 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 font-semibold text-lg"
                                    >−</button>
                                    <span
                                        x-text="items[{{ $loop->index }}].qty"
                                        class="w-10 text-center text-sm font-bold text-slate-800 border-x border-slate-200 py-2"
                                    ></span>
                                    <button
                                        type="button"
                                        @click="items[{{ $loop->index }}].qty = Math.min(99, items[{{ $loop->index }}].qty + 1); updateQty({{ $loop->index }}, {{ $item['id'] }}, items[{{ $loop->index }}].qty)"
                                        class="w-9 h-9 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 font-semibold text-lg"
                                    >+</button>
                                </div>

                                {{-- SUBTOTAL --}}
                                <div class="text-right hidden sm:block">
                                    <p class="text-[10px] text-slate-400 font-light mb-0.5">Subtotal</p>
                                    <p class="text-sm font-bold text-slate-900" x-text="formatRp(items[{{ $loop->index }}].qty * items[{{ $loop->index }}].price)"></p>
                                </div>

                            </div>
                        </div>

                        {{-- MOBILE SUBTOTAL --}}
                        <div class="sm:hidden mt-3 pt-3 border-t border-slate-50 flex justify-between items-center">
                            <span class="text-xs text-slate-400 font-light">Subtotal</span>
                            <span class="text-sm font-bold text-slate-900" x-text="formatRp(items[{{ $loop->index }}].qty * items[{{ $loop->index }}].price)"></span>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach

            {{-- CONTINUE SHOPPING LINK --}}
            <div class="mt-2">
                <a href="/" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors group">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    Lanjutkan Belanja
                </a>
            </div>

        </div>
        {{-- END LEFT COLUMN --}}

        {{-- =================== RIGHT COLUMN (30%) =================== --}}
        <div class="w-full lg:w-[30%] lg:sticky lg:top-24 flex flex-col gap-4">

            {{-- ORDER SUMMARY CARD --}}
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

                {{-- CHECKOUT BUTTON --}}
                <button
                    @click="proceedToCheckout()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-4 rounded-2xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-300 flex items-center justify-center gap-2 group"
                >
                    <svg class="w-4.5 h-4.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                    Lanjut ke Checkout
                </button>

                {{-- SECURITY BADGES --}}
                <div class="flex items-center justify-center gap-4 mt-4 pt-4 border-t border-slate-50">
                    <div class="flex items-center gap-1 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751A11.956 11.956 0 0112 2.714z"/>
                        </svg>
                        <span class="text-[10px] font-light">Transaksi Aman</span>
                    </div>
                    <div class="flex items-center gap-1 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                        </svg>
                        <span class="text-[10px] font-light">100% Original</span>
                    </div>
                    <div class="flex items-center gap-1 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-[10px] font-light">Pengiriman Cepat</span>
                    </div>
                </div>
            </div>

        </div>
        {{-- END RIGHT COLUMN --}}

    </div>

    @else

    {{-- ===== EMPTY STATE ===== --}}
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
        <a
            href="/"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-8 py-4 rounded-2xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-300 flex items-center gap-2 group"
        >
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
        
        init() {
            this.$watch('selected', () => this.logDebug());
            this.$watch('items', () => this.logDebug(), { deep: true });
            
            // Initial log
            this.logDebug();
        },
        
        logDebug() {
            console.log('Subtotal:', this.subtotal);
            console.log('Total:', this.total);
        },
        
        get allSelected() {
            return this.selected.length > 0 && this.selected.every(v => v);
        },
        get selectedCount() {
            return this.selected.filter(v => v).length;
        },
        get subtotal() {
            let total = 0;
            this.items.forEach((item, index) => {
                if (this.selected[index]) {
                    total += (item.qty * item.price);
                }
            });
            return total;
        },
        get total() {
            return this.subtotal > 0 ? this.subtotal : 0;
        },
        toggleAll() {
            const val = this.allSelected;
            this.selected = this.selected.map(() => !val);
        },
        formatRp(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        },
        updateQty(index, itemId, newQty) {
            this.items[index].qty = newQty;
            fetch('/cart/update?id=' + itemId + '&qty=' + newQty, {
                headers: { 'Accept': 'application/json' }
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    const headerCount = document.getElementById('header-count');
                    if (headerCount) {
                        headerCount.innerText = '(' + data.itemCount + ' Produk)';
                    }
                }
            });
        },
        proceedToCheckout() {
            let selectedIds = [];
            this.items.forEach((item, index) => {
                if (this.selected[index]) {
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
