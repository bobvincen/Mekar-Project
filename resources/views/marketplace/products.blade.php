@extends('marketplace.layouts.app')

@section('title', 'Daftar Produk')

@section('content')

{{-- ===== MODAL PILIH JUMLAH OBAT ===== --}}
<div id="qty-modal" class="hidden fixed inset-0 z-[200] flex items-center justify-center px-4">
    <div id="modal-backdrop" class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
    <div id="qty-modal-box" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 z-10">
        <button id="modal-close" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="flex items-center gap-4 mb-6">
            <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0 overflow-hidden">
                <img id="modal-product-img" src="" alt="" class="w-16 h-16 object-contain">
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold text-blue-500 uppercase tracking-wider mb-1" id="modal-product-category"></p>
                <h3 class="text-sm font-bold text-slate-800 leading-snug line-clamp-2" id="modal-product-name"></h3>
                <p class="text-blue-600 text-base font-black mt-1" id="modal-product-price"></p>
            </div>
        </div>
        <div class="mb-6">
            <p class="text-xs font-semibold text-slate-500 mb-3">Jumlah Pembelian</p>
            <div class="flex items-center gap-3">
                <button id="modal-qty-minus" class="w-11 h-11 rounded-xl border-2 border-slate-200 flex items-center justify-center text-slate-600 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-all font-bold text-xl">−</button>
                <input id="modal-qty-input" type="number" min="1" max="99" value="1"
                    class="flex-1 h-11 text-center text-lg font-bold text-slate-800 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:bg-blue-50 transition-all"
                    style="-moz-appearance:textfield;-webkit-appearance:none;">
                <button id="modal-qty-plus" class="w-11 h-11 rounded-xl border-2 border-slate-200 flex items-center justify-center text-slate-600 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-all font-bold text-xl">+</button>
            </div>
        </div>
        <div class="bg-blue-50 rounded-2xl px-4 py-3 mb-5 flex items-center justify-between">
            <span class="text-xs text-slate-500 font-medium">Total</span>
            <span class="text-sm font-black text-blue-600" id="modal-subtotal">Rp 0</span>
        </div>
        <button id="modal-submit-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3.5 rounded-2xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-300 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
            </svg>
            <span id="modal-submit-text">Tambah ke Keranjang</span>
        </button>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

    {{-- ===== BREADCRUMBS & HEADER ===== --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="/" class="text-slate-400 hover:text-blue-600 transition-colors text-sm font-light">Beranda</a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-blue-600 text-sm font-medium">Produk Kesehatan</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                @if(isset($selectedCategory))
                    Kategori: <span class="text-blue-600">{{ $selectedCategory->nama_kategori }}</span>
                @else
                    Semua Produk Kesehatan
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 font-light mt-1">
                Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
            </p>
        </div>

        {{-- SEARCH FORM TOP --}}
        <form action="/products" method="GET" class="w-full md:w-80">
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            <div class="relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari obat, suplemen..."
                    class="w-full text-xs sm:text-sm pl-4 pr-10 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-500 text-slate-700 placeholder-slate-400 bg-white shadow-sm transition-all duration-200"
                >
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    {{-- ===== TWO-COLUMN FILTER LAYOUT ===== --}}
    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- LEFT COLUMN: SIDEBAR FILTERS (25%) --}}
        <div class="w-full lg:w-64 shrink-0 bg-white border border-slate-100 rounded-3xl p-6 shadow-md">
            <div class="mb-6 pb-5 border-b border-slate-50">
                <h3 class="text-sm font-bold text-slate-800 tracking-wide uppercase">Filter Kategori</h3>
            </div>
            <div class="space-y-1">
                <a
                    href="/products{{ request('search') ? '?search=' . request('search') : '' }}"
                    class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ !request('category_id') && !isset($selectedCategory) ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}"
                >
                    <span>Semua Kategori</span>
                    <span class="text-[10px] bg-slate-100 text-slate-400 px-2 py-0.5 rounded-md font-bold">
                        {{ \App\Models\Obat::count() }}
                    </span>
                </a>
                @foreach($kategoris as $k)
                    @php
                        $isActive = request('category_id') == $k->id || (isset($selectedCategory) && $selectedCategory->id == $k->id);
                    @endphp
                    <a
                        href="/products?category_id={{ $k->id }}{{ request('search') ? '&search=' . request('search') : '' }}"
                        class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium transition-all duration-200 {{ $isActive ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}"
                    >
                        <span class="truncate pr-2">{{ $k->nama_kategori }}</span>
                        <span class="text-[10px] {{ $isActive ? 'bg-blue-100 text-blue-600' : 'bg-slate-50 text-slate-400' }} px-2 py-0.5 rounded-md font-bold shrink-0">
                            {{ $k->obats_count }}
                        </span>
                    </a>
                @endforeach
            </div>
            @if(request()->anyFilled(['search', 'category_id']) || isset($selectedCategory))
                <div class="mt-6 pt-5 border-t border-slate-50">
                    <a
                        href="/products"
                        class="w-full inline-flex items-center justify-center gap-1.5 border border-slate-200 hover:border-red-200 hover:bg-red-50 hover:text-red-600 text-slate-500 font-medium text-xs py-2.5 rounded-xl transition-all duration-200"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset Filter
                    </a>
                </div>
            @endif
        </div>

        {{-- RIGHT COLUMN: PRODUCT GRID (75%) --}}
        <div class="flex-1 w-full">
            @if($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center bg-white border border-slate-100 rounded-[32px] p-8">
                    <div class="w-20 h-20 bg-blue-50 border border-blue-100/60 rounded-3xl flex items-center justify-center mb-5">
                        <svg class="w-10 h-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Produk Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-400 font-light max-w-xs leading-relaxed mb-6">
                        Maaf, tidak ada produk obat yang cocok dengan pencarian atau filter Anda.
                    </p>
                    <a href="/products" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-6 py-3 rounded-xl transition-all duration-300">
                        Lihat Semua Produk
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($products as $p)
                        @php
                            $imgFallback = str_contains(strtolower($p->kategori->nama_kategori ?? ''), 'vitamin')
                                ? '/premium_supplement_bottle.png'
                                : '/premium_medicine_box.png';
                            $image = $p->image ?? $p->gambar ?? $imgFallback;
                            $formattedPrice = 'Rp ' . number_format($p->harga_jual, 0, ',', '.');
                            $rating = number_format(4.6 + (($p->id * 5) % 4) / 10, 1);
                            $sold = ($p->id * 19) % 200 + 10;
                        @endphp
                        <div class="group bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                            <div class="relative">
                                @if($p->stok <= 0)
                                    <div class="absolute left-4 top-4 z-10">
                                        <span class="bg-red-50 text-red-600 border border-red-100/60 text-[10px] font-semibold px-2.5 py-1 rounded-lg">Habis</span>
                                    </div>
                                @elseif($p->stok < 5)
                                    <div class="absolute left-4 top-4 z-10">
                                        <span class="bg-amber-50 text-amber-600 border border-amber-100/60 text-[10px] font-semibold px-2.5 py-1 rounded-lg">Sisa {{ $p->stok }}</span>
                                    </div>
                                @endif

                                <a href="/products/{{ $p->id }}" class="block bg-slate-50/40 h-48 flex items-center justify-center p-6 relative overflow-hidden transition-colors group-hover:bg-blue-50/10">
                                    <img src="{{ $image }}" alt="{{ $p->nama_obat }}" class="h-32 object-contain transition-transform duration-500 group-hover:scale-105">
                                </a>

                                <div class="p-5">
                                    <span class="inline-block bg-blue-50/50 text-blue-600 text-[10px] font-medium px-2 py-0.5 rounded-md mb-2">
                                        {{ $p->kategori->nama_kategori ?? 'Obat' }}
                                    </span>
                                    <a href="/products/{{ $p->id }}" class="block">
                                        <h3 class="text-xs sm:text-sm font-medium text-slate-800 mb-2 line-clamp-2 h-10 leading-relaxed group-hover:text-blue-600 transition-colors">
                                            {{ $p->nama_obat }}
                                        </h3>
                                    </a>
                                    <div class="mb-2 flex items-center">
                                        @if($p->stok > 0)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Habis
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="p-5 pt-0">
                                <div class="text-blue-600 text-base sm:text-lg font-bold mb-4">{{ $formattedPrice }}</div>
                                @if($p->stok > 0)
                                    <button type="button"
                                        class="add-to-cart-btn w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-3 rounded-xl shadow-sm shadow-blue-600/10 hover:shadow-md hover:shadow-blue-600/20 transition-all duration-300 flex items-center justify-center gap-1.5"
                                        data-product-id="{{ $p->id }}"
                                        data-product-name="{{ $p->nama_obat }}"
                                        data-product-price="{{ $p->harga_jual }}"
                                        data-product-category="{{ $p->kategori->nama_kategori ?? 'Obat' }}"
                                        data-product-image="{{ $image }}">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span class="btn-text">Keranjang</span>
                                    </button>
                                @else
                                    <button disabled class="w-full bg-slate-100 text-slate-400 text-xs font-semibold py-3 rounded-xl cursor-not-allowed flex items-center justify-center">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="mt-12">
                    {{ $products->links('pagination::tailwind') }}
                </div>
            @endif
        </div>

    </div>
</div>

{{-- ===== SCRIPT MODAL + ADD TO CART (AJAX) ===== --}}
@push('scripts')
<style>
    #qty-modal { transition: opacity 0.2s ease; }
    #qty-modal.hidden { opacity: 0; pointer-events: none; }
    #qty-modal-box { transition: transform 0.2s ease, opacity 0.2s ease; }
    #qty-modal.hidden #qty-modal-box { transform: scale(0.95); opacity: 0; }
    #modal-qty-input::-webkit-inner-spin-button,
    #modal-qty-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal      = document.getElementById('qty-modal');
    const backdrop   = document.getElementById('modal-backdrop');
    const closeBtn   = document.getElementById('modal-close');
    const qtyInput   = document.getElementById('modal-qty-input');
    const minusBtn   = document.getElementById('modal-qty-minus');
    const plusBtn    = document.getElementById('modal-qty-plus');
    const subtotalEl = document.getElementById('modal-subtotal');
    const submitBtn  = document.getElementById('modal-submit-btn');
    const submitText = document.getElementById('modal-submit-text');

    let activeProductId = null;
    let activeProductPrice = 0;

    function formatRp(amount) {
        return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
    }

    function updateSubtotal() {
        const qty = parseInt(qtyInput.value) || 1;
        subtotalEl.textContent = formatRp(activeProductPrice * qty);
    }

    function openModal(btn) {
        activeProductId    = btn.dataset.productId;
        activeProductPrice = parseInt(btn.dataset.productPrice) || 0;

        document.getElementById('modal-product-img').src                  = btn.dataset.productImage || '';
        document.getElementById('modal-product-name').textContent         = btn.dataset.productName || '';
        document.getElementById('modal-product-category').textContent     = btn.dataset.productCategory || '';
        document.getElementById('modal-product-price').textContent        = formatRp(activeProductPrice);

        qtyInput.value = 1;
        updateSubtotal();

        submitText.textContent = 'Tambah ke Keranjang';
        submitBtn.disabled = false;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        activeProductId = null;
    }

    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    minusBtn.addEventListener('click', () => {
        let v = parseInt(qtyInput.value) || 1;
        if (v > 1) { qtyInput.value = v - 1; updateSubtotal(); }
    });
    plusBtn.addEventListener('click', () => {
        let v = parseInt(qtyInput.value) || 1;
        if (v < 99) { qtyInput.value = v + 1; updateSubtotal(); }
    });
    qtyInput.addEventListener('input', () => {
        let v = parseInt(qtyInput.value);
        if (isNaN(v) || v < 1) qtyInput.value = 1;
        if (v > 99) qtyInput.value = 99;
        updateSubtotal();
    });

    submitBtn.addEventListener('click', function () {
        if (!activeProductId) return;

        const qty = parseInt(qtyInput.value) || 1;
        submitBtn.disabled = true;
        submitText.textContent = 'Menambahkan...';

        fetch(`/cart/add/${activeProductId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ qty: qty })
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
                submitText.textContent = 'Berhasil Ditambahkan ✓';
                const cartBadge = document.querySelector('#cart-count');
                if (cartBadge) {
                    cartBadge.textContent = data.cartCount;
                    cartBadge.classList.remove('hidden');
                }
                setTimeout(() => { closeModal(); }, 900);
            } else {
                alert(data.message || 'Gagal menambahkan ke keranjang');
                submitText.textContent = 'Tambah ke Keranjang';
                submitBtn.disabled = false;
            }
        })
        .catch(() => {
            alert('Terjadi kesalahan, coba lagi.');
            submitText.textContent = 'Tambah ke Keranjang';
            submitBtn.disabled = false;
        });
    });

    // Buka modal saat tombol keranjang diklik
    document.querySelectorAll('.add-to-cart-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            openModal(btn);
        });
    });

});
</script>
@endpush

@endsection