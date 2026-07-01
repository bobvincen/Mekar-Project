@extends('layouts.app')

@section('title', 'Kelola Resep Dokter')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Kelola Resep Dokter</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar unggahan resep dokter dari pelanggan marketplace untuk dibaca dan disiapkan</p>
        </div>
    </div>

    <!-- Notification Alerts -->
    @if (session('success'))
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

    <!-- Table Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead class="bg-slate-50 text-slate-400 font-bold text-xs uppercase border-b border-slate-100 tracking-wider">
                    <tr>
                        <th class="py-4 px-6 w-44">Tanggal Unggah</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6 w-44">Kontak WA</th>
                        <th class="py-4 px-6 max-w-xs">Catatan</th>
                        <th class="py-4 px-6 text-center w-32">Foto Resep</th>
                        <th class="py-4 px-6 text-center w-32">Status</th>
                        <th class="py-4 px-6 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                    @forelse($reseps as $resep)
                        @php
                            $statusColors = [
                                'menunggu_verifikasi' => 'bg-amber-50 text-amber-600 border-amber-200',
                                'sedang_diproses'     => 'bg-blue-50 text-blue-600 border-blue-200',
                                'menunggu_persetujuan' => 'bg-purple-50 text-purple-600 border-purple-200',
                                'siap_checkout'       => 'bg-indigo-50 text-indigo-650 border-indigo-200',
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
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500">
                                {{ $resep->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $resep->nama }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $resep->whatsapp) }}" target="_blank"
                                    class="text-emerald-600 hover:text-emerald-700 flex items-center gap-1.5 font-bold">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.06-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                        <path d="M12 0c-6.627 0-12 5.373-12 12 0 2.126.553 4.135 1.547 5.904l-1.547 5.666 5.81-1.524c1.728.938 3.69 1.454 5.75 1.454 6.627 0 12-5.373 12-12s-5.373-12-12-12zm0 21.905c-1.848 0-3.615-.477-5.203-1.385l-.373-.213-3.414.896.91-3.327-.234-.383c-1.004-1.64-1.531-3.535-1.531-5.493 0-5.464 4.442-9.905 9.905-9.905 5.464 0 9.906 4.441 9.906 9.905 0 5.463-4.442 9.905-9.905 9.905z" />
                                    </svg>
                                    {{ $resep->whatsapp }}
                                </a>
                            </td>
                            <td class="py-4 px-6 text-slate-500 max-w-xs truncate" title="{{ $resep->catatan }}">
                                {{ $resep->catatan ?: '-' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('resep.file', $resep->id) }}" target="_blank"
                                    class="inline-block hover:opacity-90 transition rounded-xl overflow-hidden border border-slate-200 bg-slate-50 p-0.5">
                                    <img src="{{ route('resep.file', $resep->id) }}" alt="Resep {{ $resep->nama }}"
                                        class="h-12 w-12 object-cover rounded-lg">
                                </a>
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold border rounded-lg uppercase tracking-wider {{ $colorClass }}">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    @if(in_array($resep->status, ['menunggu_verifikasi', 'sedang_diproses', 'menunggu_persetujuan']))
                                        <a href="{{ route('resep.proses', $resep->id) }}" 
                                            class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-650 hover:text-blue-700 border border-blue-100 rounded-xl text-xs font-bold transition flex items-center gap-1" 
                                            title="Proses Resep">
                                            Proses
                                        </a>
                                    @endif
                                    
                                    <form action="{{ route('admin.resep.destroy', $resep->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data resep ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-medium bg-slate-50/10">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 stroke-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Belum ada data unggahan resep dokter dari pelanggan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
