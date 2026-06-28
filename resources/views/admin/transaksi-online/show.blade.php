@extends('layouts.app')

@section('title', 'Detail Pesanan Online')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.transaksi-online.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Detail Pesanan: {{ $transaksi->kode_transaksi }}</h1>
                <p class="text-xs text-slate-500 mt-0.5 font-semibold">Dibuat pada {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div>
            @php
                $statusColor = match ($transaksi->status) {
                    'Menunggu Pembayaran' => 'bg-amber-50 text-amber-600 border-amber-100',
                    'Menunggu Verifikasi' => 'bg-blue-50 text-blue-600 border-blue-100 animate-pulse',
                    'Ditolak' => 'bg-rose-50 text-rose-600 border-rose-100',
                    'Diproses' => 'bg-sky-50 text-sky-600 border-sky-100',
                    'Siap Diambil', 'Sedang Diantar' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                    'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                    'Dibatalkan' => 'bg-slate-50 text-slate-400 border-slate-200',
                    default => 'bg-slate-50 text-slate-500 border-slate-200',
                };
            @endphp
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs font-bold border shadow-sm {{ $statusColor }}">
                Status: {{ $transaksi->status }}
            </span>
        </div>
    </div>

    <!-- Notification Alerts -->
    @if(session('success'))
        <div class="bg-green-50 text-green-600 border border-green-200 px-4 py-3.5 rounded-2xl flex items-center justify-between gap-3 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 font-bold text-xs p-1">✕</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 text-red-600 border border-red-200 px-4 py-3.5 rounded-2xl flex items-center justify-between gap-3 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold text-xs p-1">✕</button>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">
        
        <!-- Left Column: Order details & Items -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Items Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
                <div class="p-5 border-b border-slate-50 font-bold text-slate-800 bg-slate-50/25">
                    Produk yang Dipesan
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse table-auto">
                        <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                            <tr>
                                <th class="px-5 py-3.5">Nama Produk</th>
                                <th class="px-5 py-3.5 text-center w-32">Harga Satuan</th>
                                <th class="px-5 py-3.5 text-center w-24">Kuantitas</th>
                                <th class="px-5 py-3.5 text-right w-36">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                            @foreach ($transaksi->detailTransaksis as $detail)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-slate-800">{{ $detail->obat->nama_obat ?? 'Produk tidak ditemukan' }}</div>
                                        <div class="text-[10px] text-slate-400 font-semibold mt-0.5">Golongan: {{ $detail->obat->kategori->nama_kategori ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-center text-slate-500 whitespace-nowrap">
                                        Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="px-2.5 py-0.5 text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200 rounded-lg">
                                            {{ $detail->jumlah }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right font-bold text-slate-850 whitespace-nowrap">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-slate-50/50 border-t border-slate-100 px-5 py-4 flex justify-end">
                    <div class="w-full max-w-xs space-y-2.5 text-xs font-semibold text-slate-600">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Subtotal Produk</span>
                            <span class="text-slate-800">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Ongkos Kirim</span>
                            <span class="text-slate-800">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm border-t border-slate-150 pt-2.5">
                            <span class="font-bold text-slate-900">Total Tagihan</span>
                            <span class="font-extrabold text-blue-600">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Card -->
            @if ($transaksi->catatan)
                <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-amber-100 text-amber-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-amber-900 mb-0.5">Catatan Khusus Pelanggan</h3>
                            <p class="text-xs text-amber-700/95 leading-relaxed font-semibold">{{ $transaksi->catatan }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Verification Card -->
            @if($transaksi->bukti_transfer)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 font-bold text-slate-800 flex justify-between items-center bg-slate-50/25">
                        <span>Bukti Transfer & Verifikasi Pembayaran</span>
                        <span class="text-xs text-slate-400 font-mono">Invoice Status: {{ $transaksi->status }}</span>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left: Image Preview -->
                        <div class="space-y-2">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Gambar Bukti Transfer</span>
                            <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center max-h-96 cursor-zoom-in"
                                 x-data="{ showModal: false }">
                                <img src="{{ asset('storage/' . $transaksi->bukti_transfer) }}" alt="Bukti Transfer" 
                                     @click="showModal = true" class="object-contain max-h-96 w-full hover:scale-102 transition duration-300">
                                
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold pointer-events-none">
                                    🔍 Klik untuk Memperbesar
                                </div>

                                <!-- Zoom Modal -->
                                <div x-show="showModal" @click.away="showModal = false" 
                                     class="fixed inset-0 z-[999] bg-black/80 flex items-center justify-center p-4"
                                     x-transition style="display: none;">
                                    <div class="relative max-w-3xl max-h-[90vh] bg-white rounded-2xl overflow-hidden p-2 flex flex-col">
                                        <button type="button" @click="showModal = false" class="absolute top-4 right-4 bg-black/60 hover:bg-black/85 text-white rounded-full p-2.5 transition z-50">
                                            ✕
                                        </button>
                                        <img src="{{ asset('storage/' . $transaksi->bukti_transfer) }}" alt="Bukti Transfer Zoom" class="object-contain max-h-[80vh] rounded-xl">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Verification Form or Details -->
                        <div class="flex flex-col justify-between">
                            @if($transaksi->status === 'Menunggu Verifikasi')
                                <form action="{{ route('admin.transaksi-online.verify', $transaksi->id) }}" method="POST" class="space-y-4 flex-1 flex flex-col justify-between m-0">
                                    @csrf
                                    <div class="space-y-3">
                                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Verifikasi Tindakan</label>
                                        <div class="grid grid-cols-2 gap-3" x-data="{ mode: 'terima' }">
                                            <label class="flex items-center justify-center gap-2 border-2 rounded-xl p-3 cursor-pointer transition"
                                                   :class="mode === 'terima' ? 'border-emerald-500 bg-emerald-50/50 text-emerald-700 font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                                <input type="radio" name="action" value="terima" x-model="mode" @change="mode = 'terima'" class="sr-only">
                                                <span>✓ Terima</span>
                                            </label>
                                            <label class="flex items-center justify-center gap-2 border-2 rounded-xl p-3 cursor-pointer transition"
                                                   :class="mode === 'tolak' ? 'border-rose-500 bg-rose-50/50 text-rose-700 font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                                <input type="radio" name="action" value="tolak" x-model="mode" @change="mode = 'tolak'" class="sr-only">
                                                <span>✕ Tolak</span>
                                            </label>
                                        </div>

                                        <div x-show="mode === 'tolak'" x-transition style="display: none;" class="mt-3">
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Alasan Penolakan <span class="text-rose-500">*</span></label>
                                            <textarea name="alasan" rows="3" placeholder="Contoh: Bukti transfer terpotong atau nominal tidak sesuai." required
                                                      class="w-full text-xs font-semibold text-slate-700 border-slate-200 border rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 p-3"></textarea>
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold text-xs py-3 px-4 rounded-xl shadow transition mt-4">
                                        Proses Verifikasi Pembayaran
                                    </button>
                                </form>
                            @else
                                <div class="space-y-4">
                                    <div>
                                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Status Pembayaran</span>
                                        @if($transaksi->status === 'Ditolak')
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                ❌ Pembayaran Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                ✓ Terverifikasi ({{ $transaksi->status }})
                                            </span>
                                        @endif
                                    </div>

                                    @if($transaksi->verifikator)
                                        <div>
                                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Petugas Verifikasi</span>
                                            <span class="text-xs font-bold text-slate-800">{{ $transaksi->verifikator->name }}</span>
                                        </div>
                                    @endif

                                    @if($transaksi->tanggal_verifikasi)
                                        <div>
                                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Waktu Verifikasi</span>
                                            <span class="text-xs font-semibold text-slate-650">{{ \Carbon\Carbon::parse($transaksi->tanggal_verifikasi)->format('d M Y, H:i') }}</span>
                                        </div>
                                    @endif

                                    @if($transaksi->verifikasi_catatan)
                                        <div class="bg-rose-50/40 border border-rose-100 p-4 rounded-xl">
                                            <span class="block text-xs font-bold text-rose-800 uppercase tracking-wider mb-1.5">Catatan Verifikasi Penolakan</span>
                                            <p class="text-xs text-rose-700 font-semibold leading-relaxed">&ldquo;{{ $transaksi->verifikasi_catatan }}&rdquo;</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Customer info & Actions -->
        <div class="space-y-6">
            <!-- Update Status Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-5">
                <h2 class="font-bold text-slate-850 text-sm border-b border-slate-50 pb-2.5 mb-4">Ubah Status Pesanan</h2>
                <form action="{{ route('admin.transaksi-online.update-status', $transaksi->id) }}" method="POST" class="space-y-4 m-0">
                    @csrf
                    @method('PATCH')

                    <div>
                        <select name="status"
                            class="w-full text-xs font-semibold border-slate-200 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="Menunggu Pembayaran" {{ $transaksi->status == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="Menunggu Verifikasi" {{ $transaksi->status == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="Ditolak" {{ $transaksi->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Diproses" {{ $transaksi->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Siap Diambil" {{ $transaksi->status == 'Siap Diambil' ? 'selected' : '' }}>Siap Diambil</option>
                            <option value="Sedang Diantar" {{ $transaksi->status == 'Sedang Diantar' ? 'selected' : '' }}>Sedang Diantar</option>
                            <option value="Selesai" {{ $transaksi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ $transaksi->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-2 font-semibold">Mengubah status ke <b>Diproses</b>, <b>Siap Diambil</b>, <b>Sedang Diantar</b>, atau <b>Selesai</b> otomatis memotong stok obat apotek.</p>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow transition flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Perbarui Status
                    </button>
                </form>

                <div class="mt-4 pt-4 border-t border-slate-100">
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $transaksi->whatsapp) }}" target="_blank"
                        class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow transition flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.06-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            <path d="M12 0c-6.627 0-12 5.373-12 12 0 2.126.553 4.135 1.547 5.904l-1.547 5.666 5.81-1.524c1.728.938 3.69 1.454 5.75 1.454 6.627 0 12-5.373 12-12s-5.373-12-12-12zm0 21.905c-1.848 0-3.615-.477-5.203-1.385l-.373-.213-3.414.896.91-3.327-.234-.383c-1.004-1.64-1.531-3.535-1.531-5.493 0-5.464 4.442-9.905 9.905-9.905 5.464 0 9.906 4.441 9.906 9.905 0 5.463-4.442 9.905-9.905 9.905z" />
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>

            <!-- Customer Info Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-5 space-y-4 text-xs font-semibold text-slate-655">
                <h2 class="font-bold text-slate-800 text-sm border-b border-slate-50 pb-2">Informasi Pemesan</h2>

                <div>
                    <div class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</div>
                    <div class="text-sm font-bold text-slate-800 leading-tight">{{ $transaksi->nama_pelanggan }}</div>
                </div>

                <div>
                    <div class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">No. WhatsApp</div>
                    <div class="text-sm text-slate-700 leading-tight font-mono">{{ $transaksi->whatsapp }}</div>
                </div>

                <div>
                    <div class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Metode Pengambilan</div>
                    <div class="text-sm text-slate-800 leading-tight flex items-center gap-1.5">
                        @if ($transaksi->metode_pengambilan == 'Ambil di Apotek')
                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v11m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        @endif
                        {{ $transaksi->metode_pengambilan }}
                    </div>
                </div>

                @if ($transaksi->metode_pengambilan != 'Ambil di Apotek')
                    <div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Alamat Pengiriman</div>
                        <div class="text-xs font-semibold text-slate-600 leading-relaxed">{{ $transaksi->alamat }}</div>
                        @if ($transaksi->jarak)
                            <div class="text-[10px] text-slate-400 mt-2 font-mono">Jarak Pengantaran: {{ number_format($transaksi->jarak, 2) }} KM</div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Map Card (if lat lng exists) -->
            @if ($transaksi->latitude && $transaksi->longitude)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-50 font-bold text-slate-800 bg-slate-50/25 flex items-center gap-2">
                        <svg class="w-4.5 h-4.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lokasi Peta Pengantaran
                    </div>
                    <div class="w-full h-44 bg-slate-100">
                        <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.com/maps?q={{ $transaksi->latitude }},{{ $transaksi->longitude }}&hl=id;z=14&amp;output=embed">
                        </iframe>
                    </div>
                    <div class="p-3 bg-slate-50/50 border-t border-slate-100">
                        <a href="https://maps.google.com/?q={{ $transaksi->latitude }},{{ $transaksi->longitude }}"
                            target="_blank"
                            class="text-xs text-blue-600 font-bold hover:underline flex items-center justify-center gap-1.5">
                            Buka di Google Maps
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
