@extends('layouts.app')

@section('title', 'WhatsApp Diagnostic')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">WhatsApp Diagnostic</h1>
            <p class="text-sm text-slate-500 mt-1">Status integrasi, konfigurasi token, dan alat pengujian Fonnte WhatsApp API</p>
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

    @if($errors->has('error'))
        <div class="bg-red-50 text-red-600 border border-red-200 px-4 py-3.5 rounded-2xl flex items-center justify-between gap-3 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="font-medium text-sm">{{ $errors->first('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold text-xs p-1">✕</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Column 1: Configuration Status --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] space-y-6">
            <h3 class="font-bold text-slate-800 text-sm border-b border-slate-50 pb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Status Konfigurasi & Koneksi Fonnte
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Token Status --}}
                <div class="p-4 rounded-xl bg-slate-50/50 border border-slate-100 flex flex-col justify-between">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Token Fonnte API</span>
                    <span class="text-xs font-bold text-slate-700 mt-2 font-mono truncate">{{ $maskedToken }}</span>
                    <span class="mt-3 text-[10px] font-bold px-2 py-0.5 w-fit rounded-lg border {{ $tokenStatus ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
                        {{ $tokenStatus ? '✓ Token Terbaca' : '✗ Token Kosong (.env)' }}
                    </span>
                </div>

                {{-- Connection Status --}}
                <div class="p-4 rounded-xl bg-slate-50/50 border border-slate-100 flex flex-col justify-between">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Status Koneksi Fonnte</span>
                    <span class="text-xs font-bold text-slate-700 mt-2">{{ $connectionStatus }}</span>
                    @php
                        $isOnline = str_contains(strtolower($connectionStatus), 'online') || str_contains(strtolower($connectionStatus), 'sukses');
                        $isWarning = str_contains(strtolower($connectionStatus), 'error api');
                    @endphp
                    <span class="mt-3 text-[10px] font-bold px-2 py-0.5 w-fit rounded-lg border {{ $isOnline ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : ($isWarning ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-rose-50 text-rose-600 border-rose-100') }}">
                        {{ $isOnline ? 'Active / Online' : ($isWarning ? 'Warning' : 'Error Koneksi') }}
                    </span>
                </div>
            </div>

            <div class="space-y-4 pt-2">
                <div>
                    <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-wider">Fonnte API Endpoint</label>
                    <div class="mt-1.5 p-3 rounded-xl bg-slate-50/55 border border-slate-100 text-xs font-mono text-slate-600 truncate">
                        {{ $baseUrl }}
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-wider">Nomor Admin Penerima default</label>
                    <div class="mt-1.5 p-3 rounded-xl bg-slate-50/55 border border-slate-100 text-xs font-mono text-slate-600">
                        {{ $adminPhone }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Column 2: Send Test Message --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
            <div class="space-y-4">
                <h3 class="font-bold text-slate-800 text-sm border-b border-slate-50 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Kirim Pesan Uji Coba (Test WA)
                </h3>
                <p class="text-xs text-slate-450 leading-relaxed font-medium">
                    Lakukan verifikasi pengiriman pesan WhatsApp secara realtime ke nomor tujuan tertentu menggunakan token Fonnte yang saat ini dikonfigurasi.
                </p>

                <form action="{{ route('admin.whatsapp-diagnostic.test') }}" method="POST" class="space-y-4 pt-2 m-0">
                    @csrf
                    <div>
                        <label for="target" class="block text-xs font-semibold text-slate-700 mb-2">Nomor HP Tujuan Test WA</label>
                        <input type="text" name="target" id="target" required value="{{ old('target', $adminPhone) }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-mono font-semibold text-slate-750 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50"
                            placeholder="Contoh: 6281234567890">
                        @error('target')
                            <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white rounded-xl font-bold text-xs shadow-md hover:shadow-lg transition">
                        Kirim Pesan Test WhatsApp
                    </button>
                </form>
            </div>
            
            <div class="bg-amber-50/50 border border-amber-100 rounded-xl p-4 mt-6">
                <span class="text-xs font-bold text-amber-800 flex items-center gap-1.5">
                    ⚠️ FORMAT NOMOR TELEPON
                </span>
                <p class="text-[10px] text-amber-700 leading-relaxed mt-1 font-semibold">
                    Pastikan nomor handphone tujuan menggunakan format kode negara Indonesia di awal tanpa tanda '+' (contoh: 62812xxxxxx).
                </p>
            </div>
        </div>

    </div>

    {{-- Row 3: Last API Response Log Details --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="p-5 border-b border-slate-50 bg-slate-50/25 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Rinsian Respons Terakhir Fonnte API
            </h3>
            <span class="text-[10px] text-slate-400 font-mono font-bold">API_RESPONSE_LOG</span>
        </div>
        <div class="p-5 bg-slate-900 text-slate-350 font-mono text-[10px] overflow-x-auto select-all max-h-[300px] leading-relaxed custom-scrollbar border-t border-slate-800">
            <pre>{{ $responseDetails }}</pre>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #475569;
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #64748b;
}
</style>
@endsection
