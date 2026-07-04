<div x-data="{ open: false }" class="relative z-40">
    <!-- Trigger Button -->
    <button @click="open = !open" class="relative p-2.5 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-800 border border-slate-200 rounded-xl shadow-sm transition flex items-center justify-center focus:outline-none">
        <!-- Bell Icon -->
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        <!-- Unread Badge -->
        @php
            $newResepCount = \App\Models\ResepDokter::where('status', 'menunggu_verifikasi')->count();
            $revisiResepCount = \App\Models\ResepDokter::where('status', 'menunggu_revisi')->count();
            $newPembayaranCount = \App\Models\Transaksi::where('status', 'Menunggu Verifikasi')->count();
            $stokMenipisCount = \App\Models\Obat::where('stok', '<=', 20)->where('stok', '>', 0)->count();
            $kadaluarsaCount = \App\Models\Obat::whereDate('tanggal_kadaluarsa', '<=', now()->toDateString())->count();
            
            $totalUnread = $newResepCount + $revisiResepCount + $newPembayaranCount + $stokMenipisCount + $kadaluarsaCount;
        @endphp
        
        @if ($totalUnread > 0)
            <span class="absolute -top-1 -right-1 flex h-4.5 w-4.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-450 opacity-75"></span>
                <span class="relative inline-flex items-center justify-center rounded-full h-4.5 w-4.5 bg-rose-500 text-[9px] font-extrabold text-white">
                    {{ $totalUnread }}
                </span>
            </span>
        @endif
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" @click.away="open = false"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
         class="absolute right-0 mt-2.5 w-80 sm:w-96 bg-white border border-slate-100 rounded-2xl shadow-xl overflow-hidden"
         style="display: none;">
         
        <!-- Header -->
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Notifikasi Berjalan</span>
            <span class="px-2 py-0.5 bg-slate-200 border text-slate-700 text-[9px] font-bold rounded-full">
                {{ $totalUnread }} Aktif
            </span>
        </div>

        <!-- Notification List -->
        <div class="max-h-[350px] overflow-y-auto divide-y divide-slate-100 custom-scrollbar">
            {{-- 1. Resep Baru --}}
            @if ($newResepCount > 0)
                @php
                    $resepUrl = auth()->user()->can('Kelola Pesanan Online') ? route('admin.resep.index') : route('apoteker.resep.index');
                @endphp
                <a href="{{ $resepUrl }}"
                   class="flex gap-3 px-4 py-3.5 hover:bg-slate-50/75 transition">
                    <span class="text-xl shrink-0">📄</span>
                    <div class="flex-grow min-w-0">
                        <div class="text-xs font-bold text-slate-800">Resep Baru Menunggu Verifikasi</div>
                        <div class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">
                            Ada {{ $newResepCount }} resep baru diunggah pelanggan yang perlu diproses.
                        </div>
                    </div>
                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full shrink-0 self-center"></span>
                </a>
            @endif

            {{-- 2. Revisi Resep --}}
            @if ($revisiResepCount > 0)
                @php
                    $resepUrl = auth()->user()->can('Kelola Pesanan Online') ? route('admin.resep.index') : route('apoteker.resep.index');
                @endphp
                <a href="{{ $resepUrl }}"
                   class="flex gap-3 px-4 py-3.5 hover:bg-slate-50/75 transition">
                    <span class="text-xl shrink-0">🔄</span>
                    <div class="flex-grow min-w-0">
                        <div class="text-xs font-bold text-amber-700">Revisi Resep Diminta</div>
                        <div class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">
                            Ada {{ $revisiResepCount }} resep dokter yang meminta revisi draf obat dari apoteker.
                        </div>
                    </div>
                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full shrink-0 self-center"></span>
                </a>
            @endif

            {{-- 3. Pembayaran Baru --}}
            @if ($newPembayaranCount > 0)
                <a href="{{ route('admin.transaksi-online.index') }}"
                   class="flex gap-3 px-4 py-3.5 hover:bg-slate-50/75 transition">
                    <span class="text-xl shrink-0">💳</span>
                    <div class="flex-grow min-w-0">
                        <div class="text-xs font-bold text-slate-800">Pembayaran Baru</div>
                        <div class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">
                            Ada {{ $newPembayaranCount }} transaksi online yang menunggu verifikasi bukti pembayaran.
                        </div>
                    </div>
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full shrink-0 self-center"></span>
                </a>
            @endif

            {{-- 4. Stok Menipis --}}
            @if ($stokMenipisCount > 0)
                <a href="{{ route('obat.index') }}?stok_status=stok_rendah"
                   class="flex gap-3 px-4 py-3.5 hover:bg-slate-50/75 transition">
                    <span class="text-xl shrink-0">⚠️</span>
                    <div class="flex-grow min-w-0">
                        <div class="text-xs font-bold text-rose-700">Stok Produk Menipis</div>
                        <div class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">
                            Ada {{ $stokMenipisCount }} obat dengan ketersediaan stok menipis (≤ 20).
                        </div>
                    </div>
                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full shrink-0 self-center"></span>
                </a>
            @endif

            {{-- 5. Produk Kadaluarsa --}}
            @if ($kadaluarsaCount > 0)
                <a href="{{ route('obat.index') }}?sort=expiry"
                   class="flex gap-3 px-4 py-3.5 hover:bg-slate-50/75 transition">
                    <span class="text-xl shrink-0">⏰</span>
                    <div class="flex-grow min-w-0">
                        <div class="text-xs font-bold text-red-800">Produk Kadaluarsa</div>
                        <div class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">
                            Ada {{ $kadaluarsaCount }} obat yang telah melewati tanggal kadaluarsa.
                        </div>
                    </div>
                    <span class="w-1.5 h-1.5 bg-red-650 rounded-full shrink-0 self-center"></span>
                </a>
            @endif

            @if ($totalUnread == 0)
                <div class="py-10 text-center text-slate-400 text-xs font-medium">
                    🎉 Tidak ada notifikasi baru berjalan saat ini.
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-4 py-2.5 bg-slate-50/50 border-t border-slate-100 text-center">
            <span class="text-[10px] font-semibold text-slate-400">Pusat Notifikasi Mekar Pharmacy</span>
        </div>
    </div>
</div>
