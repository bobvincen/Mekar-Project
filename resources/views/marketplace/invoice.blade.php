@extends('marketplace.layouts.app')

@section('title', 'Detail Invoice ' . $transaksi->kode_transaksi)

@section('content')
    @php
        $formatRp = fn(int $amount): string => 'Rp ' . number_format($amount, 0, ',', '.');
    @endphp

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12" x-data="{ cancelModalOpen: false }">

        {{-- Breadcrumb --}}
        <div class="mb-6 flex items-center gap-2 text-sm text-slate-400">
            <a href="/" class="hover:text-blue-600 transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
            @auth
                <a href="{{ route('marketplace.pesanan-saya') }}" class="hover:text-blue-600 transition-colors">Pesanan Saya</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            @endauth
            <span class="text-blue-600 font-medium">Invoice</span>
        </div>

        {{-- Status Banner Alert --}}
        @if (session('success'))
            <div
                class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-2xl border border-emerald-100 flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->has('error'))
            <div
                class="mb-6 bg-rose-50 text-rose-700 p-4 rounded-2xl border border-rose-100 flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-medium text-sm">{{ $errors->first('error') }}</p>
            </div>
        @endif

        @if ($transaksi->status === 'Ditolak')
            <div class="mb-6 bg-rose-50 border border-rose-100 rounded-3xl p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                        <span class="text-lg">❌</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-rose-950 text-base">Pembayaran Ditolak</h3>
                        <p class="text-sm text-rose-700 mt-1 leading-relaxed">
                            Mohon maaf, bukti pembayaran yang Anda unggah sebelumnya ditolak oleh admin dengan alasan:
                        </p>
                        <div
                            class="mt-2.5 p-3.5 bg-white border border-rose-100 rounded-xl text-rose-800 font-mono text-sm font-semibold">
                            &ldquo;{{ $transaksi->verifikasi_catatan ?? 'Tidak ada alasan khusus.' }}&rdquo;
                        </div>
                        <p class="text-xs text-rose-600 mt-3">Silakan lakukan transfer ulang atau unggah bukti transfer yang
                            valid di bawah.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

            {{-- Left: Invoice & Items (60%) --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Struk/Invoice --}}
                <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
                    <div class="p-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">No. Invoice</span>
                            <h2 class="text-lg font-bold text-slate-800 font-mono">{{ $transaksi->kode_transaksi }}</h2>
                        </div>
                        @php
                            $statusBadge = match ($transaksi->status) {
                                'Menunggu Pembayaran' => 'bg-amber-50 text-amber-600 border-amber-200',
                                'Menunggu Verifikasi' => 'bg-blue-50 text-blue-600 border-blue-200',
                                'Ditolak' => 'bg-rose-50 text-rose-600 border-rose-250',
                                'Diproses' => 'bg-sky-50 text-sky-600 border-sky-200',
                                'Siap Diambil' => 'bg-indigo-50 text-indigo-650 border-indigo-200',
                                'Sedang Diantar' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'Dibatalkan' => 'bg-slate-50 text-slate-500 border-slate-200',
                                default => 'bg-slate-50 text-slate-500 border-slate-200',
                            };

                            $statusText = match ($transaksi->status) {
                                'Menunggu Pembayaran' => 'Menunggu Pembayaran',
                                'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                                'Ditolak' => 'Pembayaran Ditolak',
                                'Diproses' => 'Lunas - Sedang Diproses',
                                'Siap Diambil' => 'Lunas - Siap Diambil',
                                'Sedang Diantar' => 'Lunas - Sedang Dikirim',
                                'Selesai' => 'Lunas - Selesai',
                                'Dibatalkan' => 'Dibatalkan',
                                default => $transaksi->status,
                            };
                        @endphp
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold border shadow-sm {{ $statusBadge }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    {{-- Detail Pelanggan --}}
                    <div class="p-6 border-b border-slate-50 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-slate-400 font-light block">Pembeli</span>
                            <span class="font-semibold text-slate-800 block mt-0.5">{{ $transaksi->nama_pelanggan }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-light block">No. HP / WhatsApp</span>
                            <span class="font-semibold text-slate-800 block mt-0.5">{{ $transaksi->whatsapp }}</span>
                        </div>
                        @if ($transaksi->metode_pengambilan !== 'Ambil di Apotek')
                            <div class="col-span-2 pt-2 border-t border-slate-50">
                                <span class="text-slate-400 font-light block">Alamat Pengiriman</span>
                                <span
                                    class="font-medium text-slate-700 block mt-0.5 leading-relaxed">{{ $transaksi->alamat }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Items Table --}}
                    <div class="p-6 space-y-4">
                        <h3 class="font-bold text-slate-800 text-sm tracking-tight mb-2">Daftar Obat</h3>
                        <div class="divide-y divide-slate-100">
                            @foreach ($transaksi->detailTransaksis as $detail)
                                <div class="py-3 flex justify-between items-center text-sm">
                                    <div>
                                        <span
                                            class="font-semibold text-slate-800 block">{{ $detail->obat->nama_obat ?? 'Produk tidak ditemukan' }}</span>
                                        <span class="text-xs text-slate-400 font-light block">{{ $detail->jumlah }} x
                                            {{ $formatRp($detail->harga) }}</span>
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $formatRp($detail->subtotal) }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Summary --}}
                        <div class="border-t border-slate-100 pt-4 space-y-2.5">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-light">Subtotal</span>
                                <span class="font-semibold text-slate-800">{{ $formatRp($transaksi->subtotal) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-light">Ongkos Kirim</span>
                                <span class="font-semibold text-slate-800">{{ $formatRp($transaksi->ongkir) }}</span>
                            </div>
                            <div
                                class="flex justify-between items-center text-base border-t border-dashed border-slate-200 pt-3">
                                <span class="font-bold text-slate-900">Total Pembayaran</span>
                                <span
                                    class="text-lg font-bold text-blue-600">{{ $formatRp($transaksi->total_harga) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timeline Status --}}
                @if (in_array($transaksi->status, ['Diproses', 'Siap Diambil', 'Sedang Diantar', 'Selesai']))
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-sm tracking-tight mb-4">Lacak Status Pesanan</h3>
                        <div class="relative pl-6 border-l-2 border-slate-100 space-y-6">

                            {{-- Selesai --}}
                            <div class="relative">
                                <div
                                    class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-white {{ $transaksi->status === 'Selesai' ? 'bg-emerald-500 ring-4 ring-emerald-500/20' : 'bg-slate-300' }}">
                                </div>
                                <h4
                                    class="text-sm font-semibold {{ $transaksi->status === 'Selesai' ? 'text-slate-900' : 'text-slate-400' }}">
                                    Pesanan Selesai</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Transaksi selesai dan obat telah diterima pembeli.
                                </p>
                            </div>

                            {{-- Siap Diambil / Sedang Diantar --}}
                            <div class="relative">
                                @php
                                    $isDeliveryStage = in_array($transaksi->status, [
                                        'Siap Diambil',
                                        'Sedang Diantar',
                                        'Selesai',
                                    ]);
                                @endphp
                                <div
                                    class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-white {{ $isDeliveryStage ? ($transaksi->status === 'Selesai' ? 'bg-slate-300' : 'bg-blue-500 ring-4 ring-blue-500/20') : 'bg-slate-300' }}">
                                </div>
                                <h4
                                    class="text-sm font-semibold {{ $isDeliveryStage ? 'text-slate-900' : 'text-slate-400' }}">
                                    {{ $transaksi->metode_pengambilan === 'Ambil di Apotek' ? 'Siap Diambil' : 'Sedang Diantar' }}
                                </h4>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $transaksi->metode_pengambilan === 'Ambil di Apotek' ? 'Silakan kunjungi apotek untuk mengambil pesanan Anda.' : 'Kurir kami sedang menuju alamat pengiriman Anda.' }}
                                </p>
                            </div>

                            {{-- Diproses --}}
                            <div class="relative">
                                @php
                                    $isProcessedStage = in_array($transaksi->status, [
                                        'Diproses',
                                        'Siap Diambil',
                                        'Sedang Diantar',
                                        'Selesai',
                                    ]);
                                @endphp
                                <div
                                    class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-white {{ $isProcessedStage ? (in_array($transaksi->status, ['Siap Diambil', 'Sedang Diantar', 'Selesai']) ? 'bg-slate-300' : 'bg-blue-500 ring-4 ring-blue-500/20') : 'bg-slate-300' }}">
                                </div>
                                <h4
                                    class="text-sm font-semibold {{ $isProcessedStage ? 'text-slate-900' : 'text-slate-400' }}">
                                    Sedang Diproses</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Apoteker kami sedang menyiapkan dan membungkus obat
                                    Anda.</p>
                            </div>

                        </div>
                    </div>
                @endif

            </div>

            {{-- Right: Payment Instructions & Upload Bukti (40%) --}}
            <div class="space-y-6">                {{-- Rekening Transfer & QRIS --}}
                @if (in_array($transaksi->status, ['Menunggu Pembayaran', 'Ditolak']))
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-5">
                        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-50 pb-3 flex items-center gap-2">
                            💳 Metode Pembayaran
                        </h3>

                    @php
                        $categories = [
                            'bank_transfer' => [
                                'name' => 'Transfer Bank',
                                'icon' => '🏦',
                                'methods' => $paymentMethods->where('type', 'bank_transfer')
                            ],
                            'e_wallet' => [
                                'name' => 'E-Wallet',
                                'icon' => '📱',
                                'methods' => $paymentMethods->where('type', 'e_wallet')
                            ],
                            'qris' => [
                                'name' => 'QRIS',
                                'icon' => '📷',
                                'methods' => $paymentMethods->where('type', 'qris')
                            ]
                        ];

                        $activeCategories = collect($categories)->filter(function($cat) {
                            return $cat['methods']->isNotEmpty();
                        });
                    @endphp

                    @if($activeCategories->isNotEmpty())
                        <div x-data="{
                            selectedCategory: '{{ $activeCategories->keys()->first() }}',
                            selectedMethodIds: {
                                @foreach($activeCategories as $key => $cat)
                                    '{{ $key }}': '{{ $cat['methods']->first()?->id }}',
                                @endforeach
                            },
                            categoryDropdownOpen: false,
                            methodDropdownOpen: false
                        }" class="space-y-4">

                            <!-- Langkah 1: Kategori Pembayaran Custom Dropdown -->
                            <div class="space-y-1.5 relative">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pilih Metode</label>
                                
                                <!-- Toggle Button -->
                                <button type="button" @click="categoryDropdownOpen = !categoryDropdownOpen; methodDropdownOpen = false" 
                                        @click.outside="categoryDropdownOpen = false"
                                        class="w-full flex items-center justify-between px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm font-semibold text-slate-700 shadow-sm hover:border-blue-400 transition-all focus:outline-none">
                                    <span class="flex items-center gap-2">
                                        <template x-if="selectedCategory === 'bank_transfer'">
                                            <span>🏦 Transfer Bank</span>
                                        </template>
                                        <template x-if="selectedCategory === 'e_wallet'">
                                            <span>📱 E-Wallet</span>
                                        </template>
                                        <template x-if="selectedCategory === 'qris'">
                                            <span>📷 QRIS</span>
                                        </template>
                                    </span>
                                    <svg class="w-4 h-4 text-slate-500 transition-transform duration-200" :class="categoryDropdownOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="categoryDropdownOpen" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform translate-y-[-8px] scale-[0.98]"
                                     x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 transform translate-y-[-8px] scale-[0.98]"
                                     class="absolute z-30 w-full mt-1.5 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden py-1"
                                     style="display: none;">
                                    
                                    @foreach($activeCategories as $key => $cat)
                                        <button type="button" 
                                                @click="selectedCategory = '{{ $key }}'; categoryDropdownOpen = false;"
                                                class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium hover:bg-slate-50 transition-colors"
                                                :class="selectedCategory === '{{ $key }}' ? 'text-blue-600 bg-blue-50/30 font-semibold' : 'text-slate-700'">
                                            <span class="flex items-center gap-2">
                                                <span>{{ $cat['icon'] }}</span>
                                                <span>{{ $cat['name'] }}</span>
                                            </span>
                                            <template x-if="selectedCategory === '{{ $key }}'">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </template>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Langkah 2: Metode Pembayaran (Dropdown Kedua, jika metode > 1) -->
                            @foreach($activeCategories as $key => $cat)
                                @if($cat['methods']->count() > 1)
                                    <div x-show="selectedCategory === '{{ $key }}'" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform translate-y-[-8px]"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 transform translate-y-0"
                                         x-transition:leave-end="opacity-0 transform translate-y-[-8px]"
                                         class="space-y-1.5 relative">
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                            @if($key === 'bank_transfer')
                                                Pilih Bank
                                            @elseif($key === 'e_wallet')
                                                Pilih E-Wallet
                                            @else
                                                Pilih Metode ({{ $cat['name'] }})
                                            @endif
                                        </label>
                                        
                                        <!-- Toggle Button -->
                                        @php
                                            $methodsList = $cat['methods'];
                                        @endphp
                                        <button type="button" @click="methodDropdownOpen = !methodDropdownOpen; categoryDropdownOpen = false" 
                                                @click.outside="methodDropdownOpen = false"
                                                class="w-full flex items-center justify-between px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm font-semibold text-slate-700 shadow-sm hover:border-blue-400 transition-all focus:outline-none">
                                            <span class="flex items-center gap-2">
                                                @foreach($methodsList as $method)
                                                    <template x-if="selectedMethodIds['{{ $key }}'] == '{{ $method->id }}'">
                                                        <span class="flex items-center gap-2">
                                                            @if($method->image_path)
                                                                <img src="{{ $method->image_url }}" alt="{{ $method->name }}" class="h-4 w-auto object-contain max-w-[50px]">
                                                            @endif
                                                            <span>{{ $method->name }}</span>
                                                        </span>
                                                    </template>
                                                @endforeach
                                            </span>
                                            <svg class="w-4 h-4 text-slate-500 transition-transform duration-200" :class="methodDropdownOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="methodDropdownOpen" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 transform translate-y-[-8px] scale-[0.98]"
                                             x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
                                             x-transition:leave-end="opacity-0 transform translate-y-[-8px] scale-[0.98]"
                                             class="absolute z-20 w-full mt-1.5 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden py-1"
                                             style="display: none;">
                                            
                                            @foreach($methodsList as $method)
                                                <button type="button" 
                                                        @click="selectedMethodIds['{{ $key }}'] = '{{ $method->id }}'; methodDropdownOpen = false;"
                                                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium hover:bg-slate-50 transition-colors"
                                                        :class="selectedMethodIds['{{ $key }}'] == '{{ $method->id }}' ? 'text-blue-600 bg-blue-50/30 font-semibold' : 'text-slate-700'">
                                                    <span class="flex items-center gap-2">
                                                        @if($method->image_path)
                                                            <img src="{{ $method->image_url }}" alt="{{ $method->name }}" class="h-4 w-auto object-contain max-w-[50px] bg-white p-0.5 rounded border border-slate-100">
                                                        @endif
                                                        <span>{{ $method->name }}</span>
                                                    </span>
                                                    <template x-if="selectedMethodIds['{{ $key }}'] == '{{ $method->id }}'">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </template>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <!-- Detail Metode Pembayaran Terpilih -->
                            <div class="pt-2">
                                @foreach($activeCategories as $key => $cat)
                                    @foreach($cat['methods'] as $method)
                                        @php
                                            $isOnlyOne = $cat['methods']->count() === 1;
                                        @endphp
                                        <div x-show="selectedCategory === '{{ $key }}' && ({{ $isOnlyOne ? 'true' : "selectedMethodIds['$key'] == '$method->id'" }})" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 transform translate-y-2 scale-[0.99]"
                                             x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                                             class="p-5 rounded-3xl border space-y-4 shadow-sm transition-all duration-200
                                                    {{ $key === 'qris' ? 'bg-purple-50/50 border-purple-100/60' : 'bg-blue-50/50 border-blue-100/60' }}"
                                             style="display: none;">
                                            
                                            <!-- Header Kartu -->
                                            <div class="flex items-center justify-between pb-3 border-b {{ $key === 'qris' ? 'border-purple-100/50' : 'border-blue-100/50' }}">
                                                <span class="text-xs font-bold {{ $key === 'qris' ? 'text-purple-700' : 'text-blue-700' }} tracking-wide uppercase">
                                                    {{ $method->name }}
                                                </span>
                                                @if($method->image_path)
                                                    <img src="{{ $method->image_url }}" alt="{{ $method->name }}" class="h-6 w-auto object-contain max-w-[80px] rounded p-0.5 bg-white border border-slate-100">
                                                @endif
                                            </div>

                                            <!-- Body Rincian -->
                                            @if($method->type === 'qris')
                                                <div class="flex flex-col items-center justify-center py-2 space-y-3">
                                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Scan Kode QRIS di Bawah Ini</span>
                                                    @if($method->image_path)
                                                        <img src="{{ $method->image_url }}" alt="{{ $method->name }}" class="w-44 h-44 object-contain rounded-2xl shadow-md border border-slate-100 bg-white p-1">
                                                    @else
                                                        <svg class="w-40 h-40 text-slate-350 bg-white rounded-xl border p-2" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="2">
                                                            <rect x="10" y="10" width="80" height="80" rx="6" fill="white" stroke="#e2e8f0" />
                                                            <rect x="15" y="15" width="20" height="20" rx="2" fill="#0284c7" />
                                                            <rect x="65" y="15" width="20" height="20" rx="2" fill="#0284c7" />
                                                            <rect x="15" y="65" width="20" height="20" rx="2" fill="#0284c7" />
                                                            <path d="M45 15h10v10H45zM45 35h10v10H45zM45 55h10v10H45zM45 75h10v10H45zM25 45h10v10H25zM65 45h10v10H65z" fill="#475569" />
                                                            <circle cx="50" cy="50" r="4" fill="#ef4444" />
                                                        </svg>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="space-y-3">
                                                    <div class="flex justify-between items-center bg-white px-4 py-2.5 rounded-xl border border-slate-100 shadow-inner">
                                                        <span class="text-xl font-bold text-slate-800 font-mono tracking-tight">{{ $method->account_number }}</span>
                                                        <button
                                                            type="button"
                                                            onclick="navigator.clipboard.writeText('{{ $method->account_number }}'); alert('Nomor disalin!');"
                                                            class="text-xs font-bold text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 px-3 py-1.5 rounded-xl border border-blue-200 transition-all shadow-sm">
                                                            Salin
                                                        </button>
                                                    </div>
                                                    <div class="flex justify-between items-center text-xs text-slate-500 px-1">
                                                        <span>Nama Pemilik</span>
                                                        <strong class="text-slate-800 font-bold">{{ $method->account_owner }}</strong>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Petunjuk Tambahan -->
                                            @if($method->description)
                                                <div class="text-[10px] text-slate-450 leading-relaxed border-t {{ $key === 'qris' ? 'border-purple-100/50' : 'border-blue-100/50' }} pt-2.5">
                                                    {{ $method->description }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endif

                        @if($paymentMethods->isEmpty())
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center text-xs text-slate-450 font-medium">
                                Belum ada metode pembayaran yang terdaftar. Hubungi admin untuk detail pembayaran.
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-50 pb-3 flex items-center gap-2">
                            💳 Status Pembayaran
                        </h3>
                        
                        @if($transaksi->status === 'Menunggu Verifikasi')
                            <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 space-y-2 text-center">
                                <span class="text-2xl block">⏳</span>
                                <p class="font-bold text-blue-950 text-xs">Pembayaran sedang diverifikasi Admin.</p>
                                <p class="text-[11px] text-blue-700 leading-relaxed font-semibold">Silakan menunggu hasil verifikasi.</p>
                            </div>
                        @elseif(in_array($transaksi->status, ['Diproses', 'Siap Diambil', 'Sedang Diantar']))
                            <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100 space-y-2 text-center">
                                <span class="text-2xl block text-emerald-500">✔</span>
                                <p class="font-bold text-emerald-950 text-xs">Pembayaran telah diverifikasi.</p>
                                @if($transaksi->status === 'Diproses')
                                    <p class="text-[11px] text-emerald-700 leading-relaxed font-semibold">Pesanan sedang diproses oleh apoteker.</p>
                                @elseif($transaksi->status === 'Siap Diambil')
                                    <p class="text-[11px] text-emerald-750 font-bold leading-relaxed">Pesanan siap diambil.</p>
                                @elseif($transaksi->status === 'Sedang Diantar')
                                    <p class="text-[11px] text-emerald-700 leading-relaxed font-semibold">Pesanan sedang diantar.</p>
                                @endif
                            </div>
                        @elseif($transaksi->status === 'Selesai')
                            <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100 space-y-2 text-center">
                                <span class="text-2xl block text-emerald-500">✔</span>
                                <p class="font-bold text-emerald-950 text-xs">Pembayaran selesai.</p>
                                <p class="text-[11px] text-emerald-700 leading-relaxed font-semibold">Terima kasih telah berbelanja di Mekar Pharmacy.</p>
                            </div>
                        @elseif($transaksi->status === 'Dibatalkan')
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-center">
                                <span class="text-2xl block">🛑</span>
                                <p class="font-bold text-slate-800 text-xs">Pesanan telah dibatalkan.</p>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($transaksi->status !== 'Dibatalkan')
                    {{-- Form Upload Bukti --}}
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-50 pb-3 flex items-center gap-2">
                            📁 Bukti Pembayaran
                        </h3>

                        @if (in_array($transaksi->status, ['Menunggu Pembayaran', 'Ditolak']))
                            <form action="{{ route('marketplace.invoice.upload-bukti', $transaksi->kode_transaksi) }}"
                                method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf

                                <div x-data="{ fileName: '' }" class="space-y-3">
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Unggah
                                        Bukti Transfer</label>
                                    <div
                                        class="relative group border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-2xl p-6 transition-all bg-slate-50 cursor-pointer flex flex-col items-center justify-center">
                                        <input type="file" name="bukti_transfer" required accept="image/*"
                                            @change="fileName = $event.target.files[0].name"
                                            class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                        <span class="text-3xl">📷</span>
                                        <span class="text-xs font-bold text-blue-600 mt-2 block"
                                            x-text="fileName ? 'Ganti File' : 'Pilih Foto / Gambar'"></span>
                                        <span class="text-[10px] text-slate-400 font-light mt-1 text-center"
                                            x-text="fileName || 'Format: JPEG, PNG, JPG (Maks. 5MB)'"></span>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3.5 px-4 rounded-xl shadow-md transition-colors uppercase tracking-wider">
                                    🚀 Kirim Bukti Transfer
                                </button>
                            </form>

                            @if ($transaksi->status === 'Menunggu Pembayaran')
                                <hr class="border-slate-150 my-4">
                                
                                <button type="button" @click="cancelModalOpen = true"
                                    class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs py-3.5 px-4 rounded-xl shadow-md transition-colors uppercase tracking-wider text-center">
                                    🛑 Batalkan Pesanan
                                </button>
                            @endif
                        @elseif($transaksi->status === 'Menunggu Verifikasi')
                            <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 text-center space-y-3">
                                <span class="text-2xl block">⏳</span>
                                <h4 class="font-bold text-blue-950 text-xs">Menunggu Verifikasi Admin</h4>
                                <p class="text-[11px] text-blue-700 leading-relaxed">
                                    Bukti pembayaran telah berhasil dikirimkan. Mohon tunggu proses pengecekan oleh
                                    administrator apotek.
                                </p>
                            </div>
                            @if ($transaksi->bukti_transfer)
                                <div class="pt-2">
                                    <label
                                        class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Bukti
                                        yang Dikirim</label>
                                    <div
                                        class="rounded-xl overflow-hidden border border-slate-200 max-h-48 bg-slate-50 flex items-center justify-center">
                                        <img src="{{ asset('storage/' . $transaksi->bukti_transfer) }}" alt="Bukti Transfer"
                                            class="object-contain max-h-48">
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-center space-y-2">
                                <span class="text-2xl block">✓</span>
                                <h4 class="font-bold text-emerald-950 text-xs">Pembayaran Terverifikasi</h4>
                                <p class="text-[11px] text-emerald-700 leading-relaxed">
                                    Pembayaran telah diverifikasi secara penuh oleh administrator.
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Download PDF Button --}}
                @auth
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 w-full mt-4">

                        <a href="{{ route('marketplace.invoice.download', $transaksi->kode_transaksi) }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs py-3 px-5 rounded-xl shadow-sm transition-colors uppercase tracking-wider whitespace-nowrap">

                            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>

                            <span>Unduh Struk Pembayaran (PDF)</span>
                        </a>

                    </div>
                @endauth

            </div>

        </div>

        {{-- Modal Konfirmasi Batal Pesanan --}}
        <div x-show="cancelModalOpen" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="cancelModalOpen = false"></div>

            {{-- Modal Content --}}
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="cancelModalOpen"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                     class="relative transform overflow-hidden rounded-3xl bg-white p-6 text-left shadow-2xl transition-all max-w-md w-full border border-slate-100">
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center shrink-0 text-lg text-rose-600">
                            ⚠️
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-base font-bold text-slate-900 leading-6">Batalkan Pesanan?</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Pesanan yang dibatalkan tidak dapat dipulihkan.
                            </p>
                            <p class="text-xs text-slate-500 leading-relaxed font-semibold">
                                Anda harus melakukan checkout ulang apabila ingin membeli obat ini kembali.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button type="button" @click="cancelModalOpen = false"
                            class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                            Kembali
                        </button>
                        
                        <form action="{{ route('marketplace.invoice.cancel', $transaksi->kode_transaksi) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-xs font-bold text-white transition-colors shadow-sm">
                                Ya, Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
