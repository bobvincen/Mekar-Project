@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">WhatsApp Diagnostic</h2>
            <p class="text-sm text-slate-500 mt-1">Status integrasi, konfigurasi token, dan alat pengujian Fonnte API</p>
        </div>
    </div>

    {{-- Session Alerts --}}
    @if(session('success'))
    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl border border-emerald-200 flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <p class="font-medium text-sm">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->has('error'))
    <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-200 flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <p class="font-medium text-sm">{{ $errors->first('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Column 1: Configuration Status --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-6">
            <h3 class="font-bold text-slate-800 text-lg border-b border-slate-100 pb-3 flex items-center gap-2">
                ⚙️ Status Konfigurasi & Koneksi
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Token Status --}}
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex flex-col justify-between">
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Token Fonnte</span>
                    <span class="text-sm font-bold text-slate-700 mt-2 font-mono">{{ $maskedToken }}</span>
                    <span class="mt-2 text-xs font-bold px-2 py-0.5 w-fit rounded {{ $tokenStatus ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                        {{ $tokenStatus ? '✓ Terbaca' : '✗ Kosong (.env)' }}
                    </span>
                </div>

                {{-- Connection Status --}}
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex flex-col justify-between">
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Status Koneksi</span>
                    <span class="text-sm font-bold text-slate-700 mt-2">{{ $connectionStatus }}</span>
                    @php
                        $isOnline = str_contains(strtolower($connectionStatus), 'online') || str_contains(strtolower($connectionStatus), 'sukses');
                        $isWarning = str_contains(strtolower($connectionStatus), 'error api');
                    @endphp
                    <span class="mt-2 text-xs font-bold px-2 py-0.5 w-fit rounded {{ $isOnline ? 'bg-emerald-100 text-emerald-800' : ($isWarning ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                        {{ $isOnline ? 'Active' : ($isWarning ? 'Warning' : 'Offline / Error') }}
                    </span>
                </div>
            </div>

            <div class="space-y-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Fonnte API URL</label>
                    <div class="mt-1.5 p-3 rounded-lg bg-slate-50 border border-slate-200 text-sm font-mono text-slate-600 truncate">
                        {{ $baseUrl }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Nomor Admin (Default Penerima)</label>
                    <div class="mt-1.5 p-3 rounded-lg bg-slate-50 border border-slate-200 text-sm font-mono text-slate-600">
                        {{ $adminPhone }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Column 2: Send Test Message --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-6 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-lg border-b border-slate-100 pb-3 flex items-center gap-2">
                    💬 Kirim Pesan Test
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Kirim pesan uji coba instan melalui Fonnte API untuk memverifikasi apakah perangkat pengirim WhatsApp Anda sudah terhubung secara online dengan benar.
                </p>

                <form action="{{ route('admin.whatsapp-diagnostic.test') }}" method="POST" class="space-y-4 mt-6">
                    @csrf
                    <div>
                        <label for="target" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">Nomor WhatsApp Tujuan Test</label>
                        <div class="mt-2 relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm font-semibold select-none">
                                📞
                            </span>
                            <input type="text" name="target" id="target" required value="{{ old('target', $adminPhone) }}"
                                class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all text-sm font-mono"
                                placeholder="Contoh: 6281234567890">
                        </div>
                        @error('target')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all uppercase tracking-wider">
                        🚀 Kirim Pesan Test Sekarang
                    </button>
                </form>
            </div>
            
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mt-4">
                <span class="text-xs font-bold text-amber-800 flex items-center gap-1.5">
                    ⚠ Perhatian
                </span>
                <p class="text-[11px] text-amber-700 leading-relaxed mt-1 font-medium">
                    Pastikan nomor tujuan menggunakan format kode negara tanpa simbol '+' (misal: 6282240432990).
                </p>
            </div>
        </div>

    </div>

    {{-- Row 3: Last API Response Log Details --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                📋 Rincian Respons Terakhir Fonnte API
            </h3>
            <span class="text-xs text-slate-400 font-mono font-medium">response_log</span>
        </div>
        <div class="p-6 bg-slate-900 text-slate-200 font-mono text-xs overflow-x-auto select-all max-h-[300px] leading-relaxed">
            <pre>{{ $responseDetails }}</pre>
        </div>
    </div>

</div>
@endsection
