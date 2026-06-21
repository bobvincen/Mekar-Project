@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Penilaian Layanan</h2>
            <p class="text-sm text-slate-500 mt-1">Daftar ulasan dan saran dari pelanggan Mekar Pharmacy</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl border border-emerald-200 flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <p class="font-medium text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center justify-center">
            <p class="text-slate-500 text-sm font-semibold mb-2">Total Penilaian</p>
            <p class="text-4xl font-bold text-blue-600">{{ $totalPenilaian }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center justify-center">
            <p class="text-slate-500 text-sm font-semibold mb-2">Rata-rata Rating</p>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-bold text-amber-500">{{ number_format($rataRata, 1) }}</span>
                <span class="text-slate-400 mb-1">/ 5.0</span>
            </div>
            <div class="flex mt-2">
                @for($i=1; $i<=5; $i++)
                    @if($i <= round($rataRata))
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @else
                        <svg class="w-5 h-5 text-slate-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endif
                @endfor
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm font-semibold mb-3">Distribusi Rating</p>
            <div class="space-y-2 text-sm">
                @foreach([5 => $bintang5, 4 => $bintang4, 3 => $bintang3, 2 => $bintang2, 1 => $bintang1] as $star => $count)
                <div class="flex items-center gap-3">
                    <span class="w-12 text-slate-600 font-medium flex items-center gap-1">{{ $star }} <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></span>
                    <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                        @php $percentage = $totalPenilaian > 0 ? ($count / $totalPenilaian) * 100 : 0; @endphp
                        <div class="bg-amber-400 h-full rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="w-8 text-right text-slate-500">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Tabel Penilaian --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-lg">Daftar Penilaian</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 font-medium">
                    <tr>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4 w-1/3">Komentar</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($feedbacks as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">{{ $item->nama_pelanggan ?: 'Anonim' }}</div>
                            <div class="text-slate-500 text-xs">{{ $item->whatsapp ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-amber-400">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $item->rating)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @else
                                        <svg class="w-4 h-4 text-slate-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-slate-600 line-clamp-3">{{ $item->komentar }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.feedback-layanan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penilaian ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            <p>Belum ada penilaian layanan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
