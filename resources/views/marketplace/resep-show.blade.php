@extends('marketplace.layouts.app')

@section('title', 'Detail Resep #' . str_pad($resep->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ showRevisionForm: false }">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('resep.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Riwayat Resep
        </a>
    </div>

    <!-- Title and Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-blue-900 tracking-tight">Detail Resep #{{ str_pad($resep->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-slate-500 font-light text-sm mt-0.5">Tanggal Unggah: {{ $resep->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div>
            @php
                $statusColors = [
                    'menunggu_verifikasi' => 'bg-amber-50 text-amber-600 border-amber-200',
                    'sedang_diproses'     => 'bg-blue-50 text-blue-600 border-blue-200',
                    'menunggu_persetujuan' => 'bg-purple-50 text-purple-600 border-purple-200',
                    'siap_checkout'       => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                    'checkout'            => 'bg-sky-50 text-sky-600 border-sky-200',
                    'selesai'             => 'bg-green-50 text-green-600 border-green-200',
                    'ditolak'             => 'bg-red-50 text-red-600 border-red-200',
                ];

                $statusLabels = [
                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                    'sedang_diproses'     => 'Sedang Diproses',
                    'menunggu_persetujuan' => 'Menunggu Persetujuan',
                    'siap_checkout'       => 'Siap Checkout',
                    'checkout'            => 'Checkout',
                    'selesai'             => 'Selesai',
                    'ditolak'             => 'Ditolak',
                ];

                $colorClass = $statusColors[$resep->status] ?? 'bg-slate-50 text-slate-650 border-slate-200';
                $label = $statusLabels[$resep->status] ?? $resep->status;
            @endphp
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold border uppercase tracking-wider {{ $colorClass }}">
                {{ $label }}
            </span>
        </div>
    </div>

    <!-- Errors and Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-750 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri & Tengah: Timeline & Detail Obat Penawaran -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Timeline Status -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Status Resep</h2>
                
                <div class="relative pl-6 border-l-2 border-slate-100 space-y-8">
                    <!-- Step 1: Upload -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-blue-600 border-4 border-white shadow-sm"></div>
                        <h4 class="text-sm font-bold text-slate-800">Resep Dokter Dikirim</h4>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $resep->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-slate-500 mt-1">Dokumen resep telah disimpan dengan aman.</p>
                    </div>

                    <!-- Step 2: Proses Apoteker -->
                    <div class="relative">
                        @php
                            $isProcessed = in_array($resep->status, ['menunggu_persetujuan', 'siap_checkout', 'checkout', 'selesai']);
                            $dotColor = $isProcessed ? 'bg-blue-600' : 'bg-slate-300';
                            $titleColor = $isProcessed ? 'text-slate-800 font-bold' : 'text-slate-400 font-medium';
                        @endphp
                        <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full {{ $dotColor }} border-4 border-white shadow-sm"></div>
                        <h4 class="text-sm {{ $titleColor }}">Diverifikasi & Diproses Apoteker</h4>
                        @if($isProcessed)
                            <p class="text-xs text-slate-500 mt-1">Apoteker telah meninjau resep dan menyiapkan penawaran obat.</p>
                        @else
                            <p class="text-xs text-slate-400 mt-1">Menunggu Apoteker memverifikasi berkas resep.</p>
                        @endif
                    </div>

                    <!-- Step 3: Persetujuan Pelanggan -->
                    <div class="relative">
                        @php
                            $isApproved = in_array($resep->status, ['siap_checkout', 'checkout', 'selesai']);
                            $dotColorApprove = $isApproved ? 'bg-blue-600' : ($resep->status === 'menunggu_persetujuan' ? 'bg-purple-500 animate-pulse' : 'bg-slate-300');
                            $titleColorApprove = ($isApproved || $resep->status === 'menunggu_persetujuan') ? 'text-slate-800 font-bold' : 'text-slate-400 font-medium';
                        @endphp
                        <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full {{ $dotColorApprove }} border-4 border-white shadow-sm"></div>
                        <h4 class="text-sm {{ $titleColorApprove }}">Persetujuan Pelanggan</h4>
                        @if($resep->status === 'menunggu_persetujuan')
                            <p class="text-xs text-purple-600 font-medium mt-1">Menunggu konfirmasi persetujuan draf obat dari Anda.</p>
                        @elseif($isApproved)
                            <p class="text-xs text-slate-500 mt-1">Draf obat telah disetujui dan dimasukkan ke keranjang belanja Anda.</p>
                        @else
                            <p class="text-xs text-slate-400 mt-1">Draf obat akan muncul di sini setelah diproses apoteker.</p>
                        @endif
                    </div>

                    <!-- Step 4: Selesai -->
                    <div class="relative">
                        @php
                            $isFinished = in_array($resep->status, ['checkout', 'selesai']);
                            $dotColorFinish = $isFinished ? 'bg-green-600' : 'bg-slate-300';
                            $titleColorFinish = $isFinished ? 'text-slate-800 font-bold' : 'text-slate-400 font-medium';
                        @endphp
                        <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full {{ $dotColorFinish }} border-4 border-white shadow-sm"></div>
                        <h4 class="text-sm {{ $titleColorFinish }}">Checkout / Selesai</h4>
                        @if($resep->status === 'checkout')
                            <p class="text-xs text-slate-500 mt-1">Pesanan Anda sedang diproses pengirimannya.</p>
                        @elseif($resep->status === 'selesai')
                            <p class="text-xs text-green-600 font-semibold mt-1">Transaksi obat resep telah selesai dilakukan.</p>
                        @else
                            <p class="text-xs text-slate-400 mt-1">Selesaikan pembelian obat resep melalui halaman checkout.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detail Penawaran Obat (Draft Keranjang) -->
            @if(in_array($resep->status, ['menunggu_persetujuan', 'siap_checkout', 'checkout', 'selesai']))
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Draf Penawaran Obat</h2>
                    
                    @if($resep->catatan_verifikasi)
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-100 text-blue-800 rounded-2xl text-xs leading-relaxed">
                            <span class="font-bold block mb-1">Catatan Apoteker:</span>
                            {{ $resep->catatan_verifikasi }}
                        </div>
                    @endif

                    <div class="divide-y divide-slate-100">
                        @php $subtotal = 0; @endphp
                        @foreach($resep->items as $item)
                            <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <!-- Info Obat -->
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-bold text-slate-800 text-sm">
                                            {{ $item->obat->nama_obat ?? 'Obat' }}
                                        </h4>
                                        @if($item->status === 'tersedia')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-green-50 text-green-600 text-[10px] font-bold uppercase">
                                                ✔ Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-red-50 text-red-500 text-[10px] font-bold uppercase">
                                                ❌ Tidak Tersedia
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($item->status === 'tersedia')
                                        <p class="text-slate-400 text-xs">Harga: Rp {{ number_format($item->obat->harga_jual, 0, ',', '.') }} × {{ $item->qty }}</p>
                                        @php $subtotal += $item->obat->harga_jual * $item->qty; @endphp
                                    @else
                                        <!-- Obat Tidak Tersedia -->
                                        @if($item->catatan)
                                            <p class="text-amber-600 text-xs mt-1">Alasan: {{ $item->catatan }}</p>
                                        @endif
                                        
                                        @if($item->obatPengganti)
                                            <div class="mt-2.5 pl-3 border-l-2 border-blue-500 bg-slate-50/50 p-2 rounded-lg">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-xs text-blue-600 font-bold uppercase">Pengganti:</span>
                                                    <span class="text-xs font-bold text-slate-700">{{ $item->obatPengganti->nama_obat }}</span>
                                                </div>
                                                <p class="text-slate-400 text-[11px] mt-0.5">Harga: Rp {{ number_format($item->obatPengganti->harga_jual, 0, ',', '.') }} × {{ $item->qty }}</p>
                                            </div>
                                            @php $subtotal += $item->obatPengganti->harga_jual * $item->qty; @endphp
                                        @else
                                            <p class="text-slate-400 text-xs italic mt-1">Tidak ada obat pengganti.</p>
                                        @endif
                                    @endif
                                </div>

                                <!-- Subtotal per item -->
                                <div class="text-right">
                                    @if($item->status === 'tersedia')
                                        <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($item->obat->harga_jual * $item->qty, 0, ',', '.') }}</span>
                                    @elseif($item->status === 'tidak_tersedia' && $item->obatPengganti)
                                        <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($item->obatPengganti->harga_jual * $item->qty, 0, ',', '.') }}</span>
                                    @else
                                        <span class="font-medium text-slate-400 text-xs">-</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <!-- Total Biaya Penawaran -->
                        <div class="pt-5 mt-2 flex items-center justify-between font-bold text-base">
                            <span class="text-slate-800">Total Estimasi Harga Obat</span>
                            <span class="text-blue-700 text-lg">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Form Konfirmasi Pelanggan -->
                    @if($resep->status === 'menunggu_persetujuan')
                        <div class="mt-8 border-t border-slate-100 pt-6 flex flex-col sm:flex-row sm:items-center justify-end gap-3">
                            <button @click="showRevisionForm = !showRevisionForm" class="px-5 py-3 border border-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-50 transition w-full sm:w-auto">
                                ↺ Ajukan Revisi
                            </button>
                            
                            <form action="{{ route('resep.approve', $resep->id) }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition w-full">
                                    ✔ Setujui & Masukkan Keranjang
                                </button>
                            </form>
                        </div>
                        
                        <!-- Form Area Revisi -->
                        <div x-show="showRevisionForm" x-collapse class="mt-4 p-4 border border-slate-200 rounded-2xl bg-slate-50" style="display: none;">
                            <form action="{{ route('resep.revise', $resep->id) }}" method="POST">
                                @csrf
                                <label for="catatan_revisi" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tulis Masukan/Revisi Anda</label>
                                <textarea name="catatan_revisi" id="catatan_revisi" rows="3" required placeholder="Contoh: Obat pengganti paramex mohon dicancel saja, atau ganti obat demam sirup ke merek sanmol sirup..."
                                    class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition"></textarea>
                                <div class="mt-3 flex justify-end gap-2">
                                    <button type="button" @click="showRevisionForm = false" class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-200/50 rounded-lg">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow">Kirim Revisi</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Riwayat Catatan Revisi Sebelumnya -->
            @if($resep->catatan_revisi)
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 mb-2">Permintaan Revisi Terakhir Anda:</h2>
                    <p class="text-slate-600 text-xs italic bg-slate-50 p-3 rounded-xl border border-slate-100">{{ $resep->catatan_revisi }}</p>
                </div>
            @endif
        </div>

        <!-- Kolom Kanan: Foto Resep Medis -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm sticky top-24">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Berkas Foto Resep</h2>
                <div class="bg-slate-50 border border-dashed border-slate-200 p-2.5 rounded-2xl flex items-center justify-center overflow-hidden">
                    <a href="{{ route('resep.file', $resep->id) }}" target="_blank" class="hover:opacity-95 transition flex flex-col items-center">
                        <img src="{{ route('resep.file', $resep->id) }}" alt="Foto Resep Medis" class="max-h-[350px] w-auto rounded-lg shadow-sm border object-contain">
                        <span class="text-xs text-blue-600 font-semibold mt-3.5 flex items-center gap-1 hover:underline">
                            Buka Ukuran Penuh ↗
                        </span>
                    </a>
                </div>
                
                @if($resep->catatan)
                    <div class="mt-5 border-t border-slate-50 pt-4">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Catatan Tambahan Anda:</span>
                        <p class="text-xs text-slate-700 leading-relaxed">{{ $resep->catatan }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
