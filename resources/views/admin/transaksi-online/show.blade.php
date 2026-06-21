@extends('layouts.app')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0 flex items-center gap-3">
                <a href="{{ route('admin.transaksi-online.index') }}"
                    class="p-2 rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Detail Pesanan:
                        {{ $transaksi->kode_transaksi }}</h1>
                    <p class="text-slate-500 text-sm mt-1">Dibuat pada
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @php
                    $statusColor = match ($transaksi->status) {
                        'Menunggu Konfirmasi' => 'bg-slate-100 text-slate-600 border-slate-200',
                        'Diproses' => 'bg-blue-50 text-blue-600 border-blue-200',
                        'Dikirim' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                        'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                        'Dibatalkan' => 'bg-red-50 text-red-600 border-red-200',
                        default => 'bg-slate-100 text-slate-600 border-slate-200',
                    };
                @endphp
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold border shadow-sm {{ $statusColor }}">
                    Status: {{ $transaksi->status }}
                </span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Left Column: Order details & Items -->
        <div class="xl:col-span-2 space-y-6">
            
            <!-- Items Card -->
            <div class="bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 font-semibold text-slate-800">
                    Produk yang Dipesan
                </div>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-xs uppercase text-slate-400 bg-slate-50">
                            <tr>
                                <th class="px-5 py-3 font-semibold text-left">Produk</th>
                                <th class="px-5 py-3 font-semibold text-center">Harga</th>
                                <th class="px-5 py-3 font-semibold text-center">Qty</th>
                                <th class="px-5 py-3 font-semibold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200">
                            @foreach ($transaksi->detailTransaksis as $detail)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-medium text-slate-800">{{ $detail->obat->nama_obat ?? 'Produk tidak ditemukan' }}</div>
                                    <div class="text-xs text-slate-500">Kategori: {{ $detail->obat->kategori->nama_kategori ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    {{ $detail->jumlah }}
                                </td>
                                <td class="px-5 py-4 text-right font-medium text-slate-800">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-slate-50 px-5 py-4 flex justify-end">
                    <div class="w-full max-w-sm space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Subtotal Produk:</span>
                            <span class="font-medium text-slate-800">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Ongkos Kirim:</span>
                            <span class="font-medium text-slate-800">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-base border-t border-slate-200 pt-3">
                            <span class="font-bold text-slate-800">Total Pembayaran:</span>
                            <span class="font-bold text-blue-600">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Notes Card -->
                @if ($transaksi->catatan)
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-amber-800 mb-1">Catatan Pelanggan</h3>
                                <p class="text-sm text-amber-700 leading-relaxed">{{ $transaksi->catatan }}</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Column: Customer info & Actions -->
            <div class="space-y-6">

                <!-- Update Status Card -->
                <div class="bg-white shadow-sm border border-slate-200 rounded-xl p-5">
                    <h2 class="font-semibold text-slate-800 mb-4">Ubah Status Pesanan</h2>
                    <form action="{{ route('admin.transaksi-online.update-status', $transaksi->id) }}" method="POST"
                        class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <select name="status"
                                class="w-full text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="Menunggu Konfirmasi"
                                    {{ $transaksi->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi
                                </option>
                                <option value="Diproses" {{ $transaksi->status == 'Diproses' ? 'selected' : '' }}>Diproses
                                    (Persiapan)</option>
                                <option value="Dikirim" {{ $transaksi->status == 'Dikirim' ? 'selected' : '' }}>Dikirim /
                                    Siap Diambil</option>
                                <option value="Selesai" {{ $transaksi->status == 'Selesai' ? 'selected' : '' }}>Selesai
                                    (Stok akan dikurangi)</option>
                                <option value="Dibatalkan" {{ $transaksi->status == 'Dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                            <p class="text-xs text-slate-500 mt-2">Pilih <b>Selesai</b> untuk mengonfirmasi bahwa pesanan
                                telah diterima pelanggan dan stok obat akan dikurangi dari sistem.</p>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Perbarui Status
                        </button>
                    </form>

                    <div class="mt-4 pt-4 border-t border-slate-200">
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $transaksi->whatsapp) }}" target="_blank"
                            class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.06-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                <path
                                    d="M12 0c-6.627 0-12 5.373-12 12 0 2.126.553 4.135 1.547 5.904l-1.547 5.666 5.81-1.524c1.728.938 3.69 1.454 5.75 1.454 6.627 0 12-5.373 12-12s-5.373-12-12-12zm0 21.905c-1.848 0-3.615-.477-5.203-1.385l-.373-.213-3.414.896.91-3.327-.234-.383c-1.004-1.64-1.531-3.535-1.531-5.493 0-5.464 4.442-9.905 9.905-9.905 5.464 0 9.906 4.441 9.906 9.905 0 5.463-4.442 9.905-9.905 9.905z" />
                            </svg>
                            Hubungi Pelanggan
                        </a>
                    </div>
                </div>

                <!-- Customer Info Card -->
                <div class="bg-white shadow-sm border border-slate-200 rounded-xl p-5 space-y-4">
                    <h2 class="font-semibold text-slate-800 border-b border-slate-100 pb-2">Informasi Pemesan</h2>

                    <div>
                        <div class="text-xs text-slate-500 mb-1">Nama Lengkap</div>
                        <div class="text-sm font-medium text-slate-800">{{ $transaksi->nama_pelanggan }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-slate-500 mb-1">WhatsApp</div>
                        <div class="text-sm font-medium text-slate-800">{{ $transaksi->whatsapp }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-slate-500 mb-1">Metode Pengambilan</div>
                        <div class="text-sm font-medium text-slate-800 flex items-center gap-1.5">
                            @if ($transaksi->metode_pengambilan == 'Ambil di Apotek')
                                <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            @endif
                            {{ $transaksi->metode_pengambilan }}
                        </div>
                    </div>

                    @if ($transaksi->metode_pengambilan != 'Ambil di Apotek')
                        <div>
                            <div class="text-xs text-slate-500 mb-1">Alamat Pengiriman</div>
                            <div class="text-sm font-medium text-slate-800 leading-relaxed">{{ $transaksi->alamat }}</div>
                            @if ($transaksi->jarak)
                                <div class="text-xs text-slate-500 mt-1">Jarak: {{ number_format($transaksi->jarak, 2) }}
                                    KM</div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Map Card (if lat lng exists) -->
                @if ($transaksi->latitude && $transaksi->longitude)
                    <div class="bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden">
                        <div
                            class="px-5 py-4 border-b border-slate-200 font-semibold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Lokasi Peta
                        </div>
                        <div class="w-full h-48 bg-slate-100">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?q={{ $transaksi->latitude }},{{ $transaksi->longitude }}&hl=es;z=14&amp;output=embed">
                            </iframe>
                        </div>
                        <div class="p-3 bg-slate-50 border-t border-slate-200">
                            <a href="https://maps.google.com/?q={{ $transaksi->latitude }},{{ $transaksi->longitude }}"
                                target="_blank"
                                class="text-sm text-blue-600 font-medium hover:underline flex items-center justify-center gap-1">
                                Buka di Google Maps
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
