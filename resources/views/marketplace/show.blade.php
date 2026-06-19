@extends('marketplace.layouts.app')

@section('title', $product->nama_obat)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10" x-data="{ qty: 1, maxStock: {{ $product->stok }} }">

    {{-- ===== BREADCRUMBS ===== --}}
    <div class="mb-8 flex items-center gap-2">
        <a href="/" class="text-slate-400 hover:text-blue-600 transition-colors text-xs sm:text-sm font-light">Beranda</a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <a href="/products" class="text-slate-400 hover:text-blue-600 transition-colors text-xs sm:text-sm font-light">Produk</a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-blue-600 text-xs sm:text-sm font-medium truncate">{{ $product->nama_obat }}</span>
    </div>

    {{-- ===== PRODUCT DETAILS CONTAINER ===== --}}
    <div class="bg-white border border-slate-100 rounded-[32px] p-6 sm:p-8 md:p-10 shadow-sm mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 items-start">
            
            {{-- PRODUCT IMAGE LEFT (5 cols) --}}
            <div class="lg:col-span-5 w-full bg-slate-50/50 rounded-3xl p-8 sm:p-12 flex items-center justify-center border border-slate-100/50">
                @php
                    $imgFallback = str_contains(strtolower($product->kategori->nama_kategori ?? ''), 'vitamin') 
                        ? '/premium_supplement_bottle.png' 
                        : '/premium_medicine_box.png';
                    $image = $product->image ?? $product->gambar ?? $imgFallback;
                @endphp
                <img src="{{ $image }}" alt="{{ $product->nama_obat }}" class="w-64 h-64 sm:w-80 sm:h-80 object-contain">
            </div>

            {{-- PRODUCT INFO RIGHT (7 cols) --}}
            <div class="lg:col-span-7 flex flex-col justify-between">
                <div>
                    {{-- Category badge --}}
                    <span class="inline-block bg-blue-50 text-blue-600 border border-blue-100/60 text-xs font-semibold px-3 py-1 rounded-xl mb-4">
                        {{ $product->kategori->nama_kategori ?? 'Obat' }}
                    </span>
                    
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight mb-3">
                        {{ $product->nama_obat }}
                    </h1>

                    <div class="flex items-center gap-4 mb-6 text-xs sm:text-sm text-slate-400">
                        <span class="flex items-center gap-1">
                            <span class="text-yellow-400 text-lg">★</span>
                            <span class="text-slate-800 font-bold">4.8</span>
                        </span>
                        <span class="text-slate-200">|</span>
                        <span>Stok: 
                            @if($product->stok > 0)
                                <span class="text-emerald-600 font-bold">{{ $product->stok }} Pcs</span>
                            @else
                                <span class="text-red-500 font-bold">Habis</span>
                            @endif
                        </span>
                        @if($product->kode_obat)
                            <span class="text-slate-200">|</span>
                            <span>Kode: <span class="font-mono text-slate-600">{{ $product->kode_obat }}</span></span>
                        @endif
                    </div>

                    {{-- Price Tag --}}
                    <div class="bg-blue-50/30 border border-blue-100/50 rounded-2xl p-5 mb-6">
                        <p class="text-xs text-slate-400 font-light mb-1">Harga Spesial Marketplace</p>
                        <h2 class="text-3xl font-extrabold text-blue-600">
                            Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                        </h2>
                    </div>

                    {{-- Description --}}
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-slate-800 mb-2">Deskripsi Produk</h3>
                        <p class="text-xs sm:text-sm text-slate-400 font-light leading-relaxed">
                            {{ $product->deskripsi ?? 'Belum ada deskripsi lengkap mengenai produk kesehatan ini. Hubungi apoteker kami untuk berkonsultasi mengenai pemakaian obat.' }}
                        </p>
                    </div>

                    @if($product->supplier)
                        <div class="mb-8 text-xs text-slate-400 bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <span class="font-semibold text-slate-600">Distributor Resmi:</span> {{ $product->supplier->nama_supplier }}
                        </div>
                    @endif
                </div>

                {{-- Action / Add to Cart Section --}}
                @if($product->stok > 0)
                    <form action="/cart/add/{{ $product->id }}" method="POST" class="pt-6 border-t border-slate-100">
                        @csrf
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                            
                            {{-- QTY Selector --}}
                            <div class="flex items-center self-start border border-slate-200 rounded-xl overflow-hidden">
                                <button 
                                    type="button" 
                                    @click="qty = Math.max(1, qty - 1)" 
                                    class="w-12 h-12 flex items-center justify-center text-slate-500 hover:bg-slate-50 text-xl font-bold transition-all"
                                >−</button>
                                <input 
                                    type="number" 
                                    name="qty" 
                                    x-model="qty" 
                                    @input="qty = Math.max(1, Math.min(maxStock, parseInt($el.value) || 1))"
                                    class="w-14 text-center text-sm font-bold text-slate-800 focus:outline-none border-x border-slate-200 h-12 bg-transparent"
                                >
                                <button 
                                    type="button" 
                                    @click="qty = Math.min(maxStock, qty + 1)" 
                                    class="w-12 h-12 flex items-center justify-center text-slate-500 hover:bg-slate-50 text-xl font-bold transition-all"
                                >+</button>
                            </div>

                            {{-- Submit button --}}
                            <button 
                                type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-300 flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </form>
                @else
                    <div class="pt-6 border-t border-slate-100">
                        <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-4 rounded-xl cursor-not-allowed">
                            Stok Obat Habis
                        </button>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- ===== RELATED PRODUCTS ===== --}}
    @if(!$relatedProducts->isEmpty())
        <div>
            <h3 class="text-xl font-bold text-slate-900 mb-6">Produk Terkait Lainnya</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rp)
                    @php
                        $imgFallback = str_contains(strtolower($rp->kategori->nama_kategori ?? ''), 'vitamin') 
                            ? '/premium_supplement_bottle.png' 
                            : '/premium_medicine_box.png';
                        $image = $rp->image ?? $rp->gambar ?? $imgFallback;
                        $formattedPrice = 'Rp ' . number_format($rp->harga_jual, 0, ',', '.');
                        $rating = number_format(4.7 + (($rp->id * 2) % 3) / 10, 1);
                        $sold = ($rp->id * 21) % 150 + 10;
                    @endphp
                    <div class="group bg-white border border-slate-100 rounded-3xl overflow-hidden hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 flex flex-col justify-between">
                        <div class="relative">
                            <a href="/products/{{ $rp->id }}" class="block bg-slate-50/40 h-44 flex items-center justify-center p-6 relative overflow-hidden transition-colors group-hover:bg-blue-50/10">
                                <img src="{{ $image }}" alt="{{ $rp->nama_obat }}" class="h-28 object-contain transition-transform duration-500 group-hover:scale-105">
                            </a>

                            <div class="p-5">
                                <span class="inline-block bg-blue-50/50 text-blue-600 text-[10px] font-medium px-2 py-0.5 rounded-md mb-2">
                                    {{ $rp->kategori->nama_kategori ?? 'Obat' }}
                                </span>
                                <a href="/products/{{ $rp->id }}" class="block">
                                    <h3 class="text-xs sm:text-sm font-medium text-slate-800 mb-2 line-clamp-2 h-10 leading-relaxed group-hover:text-blue-600 transition-colors">
                                        {{ $rp->nama_obat }}
                                    </h3>
                                </a>
                                <div class="flex items-center gap-1 mb-2">
                                    <span class="text-yellow-400 text-xs">★</span>
                                    <span class="text-xs text-slate-500 font-semibold">{{ $rating }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 pt-0">
                            <div class="text-blue-600 text-base font-bold mb-4">{{ $formattedPrice }}</div>
                            <form action="/cart/add/{{ $rp->id }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center gap-1.5">
                                    Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
