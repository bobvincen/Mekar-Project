@extends('layouts.app')

@section('title', 'Kelola Resep Dokter')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Kelola Resep Dokter</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar resep yang diunggah oleh pelanggan</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 text-green-600 border border-green-200 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                    <th class="py-4 px-6 font-semibold whitespace-nowrap">Tanggal</th>
                    <th class="py-4 px-6 font-semibold">Pelanggan</th>
                    <th class="py-4 px-6 font-semibold">Kontak WA</th>
                    <th class="py-4 px-6 font-semibold max-w-xs">Catatan</th>
                    <th class="py-4 px-6 font-semibold text-center">Foto Resep</th>
                    <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($reseps as $resep)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-4 px-6 whitespace-nowrap">
                        {{ $resep->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="py-4 px-6 font-medium text-gray-900">
                        {{ $resep->nama }}
                    </td>
                    <td class="py-4 px-6">
                        <a href="https://wa.me/{{ $resep->whatsapp }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            {{ $resep->whatsapp }}
                        </a>
                    </td>
                    <td class="py-4 px-6 max-w-xs truncate" title="{{ $resep->catatan }}">
                        {{ $resep->catatan ?: '-' }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        <a href="{{ asset('storage/'.$resep->foto_resep) }}" target="_blank" class="inline-block hover:opacity-80 transition">
                            <img src="{{ asset('storage/'.$resep->foto_resep) }}" alt="Resep {{ $resep->nama }}" class="h-14 w-auto rounded border border-gray-200 object-cover">
                        </a>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <form action="{{ route('admin.resep.destroy', $resep->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data resep ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>Belum ada data resep dokter.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
