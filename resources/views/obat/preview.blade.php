@extends('layouts.app')

@section('title', 'Preview Import Obat')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('obat.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Preview Import Data Obat</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tinjau data lembar kerja Excel dan lengkapi data supplier sebelum disimpan ke database</p>
        </div>
    </div>

    <!-- Summary KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Data -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Baris</span>
                <h3 class="text-xl font-extrabold text-slate-800">{{ $totalRows }}</h3>
            </div>
            <div class="p-3 bg-slate-50 text-slate-400 rounded-xl">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </div>
        </div>

        <!-- Valid Data -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Data Valid</span>
                <h3 class="text-xl font-extrabold text-emerald-600">{{ $validCount }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-500 rounded-xl">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Error Data -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Data Error</span>
                <h3 class="text-xl font-extrabold text-rose-600">{{ $errorCount }}</h3>
            </div>
            <div class="p-3 bg-rose-50 text-rose-500 rounded-xl">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Status Card -->
        <div class="p-5 rounded-2xl border flex items-center justify-between shadow-[0_4px_20px_rgba(0,0,0,0.02)] {{ $errorCount > 0 ? 'bg-amber-50 border-amber-100' : 'bg-blue-50 border-blue-100' }}">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider {{ $errorCount > 0 ? 'text-amber-500' : 'text-blue-500' }}">Status Dokumen</span>
                <h4 class="text-sm font-extrabold {{ $errorCount > 0 ? 'text-amber-800' : 'text-blue-800' }}">
                    {{ $errorCount > 0 ? 'Perlu Perbaikan' : 'Siap Import' }}
                </h4>
            </div>
            <div class="p-3 rounded-xl {{ $errorCount > 0 ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600' }}">
                @if($errorCount > 0)
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                @else
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
            </div>
        </div>
    </div>

    <!-- Error List Section -->
    @if($errorCount > 0)
        <div class="border border-rose-200 rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.02)] animate-shake">
            <div class="bg-rose-50 px-5 py-4 border-b border-rose-100">
                <h3 class="font-bold text-rose-800 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Daftar Kesalahan pada Baris Excel (Harus Diperbaiki)
                </h3>
                <p class="text-xs text-rose-600 mt-1 font-medium">Harap perbaiki data di bawah ini pada berkas Excel Anda, lalu unggah kembali.</p>
            </div>
            <div class="p-5 max-h-80 overflow-y-auto space-y-3 bg-rose-50/20 custom-scrollbar">
                @foreach($errors as $rowNum => $rowErrors)
                    <div class="flex items-start gap-3 bg-white p-3 rounded-xl border border-rose-100/50 shadow-sm">
                        <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-[10px] font-extrabold rounded-lg whitespace-nowrap">Baris {{ $rowNum }}</span>
                        <ul class="list-disc list-inside text-xs text-rose-600 space-y-1 font-semibold">
                            @foreach($rowErrors as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('obat.import') }}" method="POST" onsubmit="return validasiImport()" class="m-0 space-y-8">
        @csrf

        <!-- Split Layout Panel -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- PANEL 2: Data Supplier (Right/Left or 5-cols width to prioritize space) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
                    <div class="p-5 border-b border-slate-50 bg-slate-50/25">
                        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-8 0v2m8 0H9m4-10a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Panel 2: Data Supplier ({{ count($suppliersData) }})
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">Lengkapi informasi supplier di bawah ini. Field opsional diwarnai kuning jika masih kosong.</p>
                    </div>

                    <div class="p-6 space-y-8 max-h-[800px] overflow-y-auto custom-scrollbar">
                        @foreach($suppliersData as $index => $supData)
                            <div class="border border-slate-100 rounded-2xl p-5 bg-slate-50/20 space-y-4">
                                <!-- Heading and Badge -->
                                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                    <span class="font-bold text-slate-800 text-sm truncate max-w-[200px]" title="{{ $supData['name'] }}">
                                        {{ $supData['name'] }}
                                    </span>
                                    @if($supData['status'] === 'Lengkap')
                                        <span class="px-2.5 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg whitespace-nowrap">
                                            ✅ Supplier Ditemukan
                                        </span>
                                    @elseif($supData['status'] === 'Baru')
                                        <span class="px-2.5 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 rounded-lg whitespace-nowrap">
                                            ⚠ Supplier Baru
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100 rounded-lg whitespace-nowrap">
                                            ⚠ Data Supplier Belum Lengkap
                                        </span>
                                    @endif
                                </div>

                                <!-- Hidden supplier name -->
                                <input type="hidden" name="suppliers[{{ $index }}][nama_supplier]" value="{{ $supData['supplier']['nama_supplier'] }}">

                                @if($supData['status'] === 'Lengkap')
                                    <!-- Read-only Info -->
                                    <div class="grid grid-cols-2 gap-3 text-xs text-slate-500 pt-1 font-semibold">
                                        <div>
                                            <span class="text-slate-400 font-bold block">Nama Kontak:</span>
                                            {{ $supData['supplier']['kontak_pic'] ?: '-' }}
                                        </div>
                                        <div>
                                            <span class="text-slate-400 font-bold block">Nomor Telepon:</span>
                                            {{ $supData['supplier']['telepon'] ?: '-' }}
                                        </div>
                                        <div class="col-span-2">
                                            <span class="text-slate-400 font-bold block">Email:</span>
                                            {{ $supData['supplier']['email'] ?: '-' }}
                                        </div>
                                        <div>
                                            <span class="text-slate-400 font-bold block">Kota:</span>
                                            {{ $supData['supplier']['kota'] ?: '-' }}
                                        </div>
                                        <div class="col-span-2">
                                            <span class="text-slate-400 font-bold block">Alamat Lengkap:</span>
                                            {{ $supData['supplier']['alamat'] ?: '-' }}
                                        </div>
                                    </div>
                                @else
                                    <!-- Dynamic editing Form (Same layout as main Supplier form) -->
                                    <div class="space-y-4 pt-1">
                                        <!-- Kontak PIC -->
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Kontak / PIC</label>
                                            <input type="text" name="suppliers[{{ $index }}][kontak_pic]" value="{{ old("suppliers.{$index}.kontak_pic", $supData['supplier']['kontak_pic']) }}"
                                                placeholder="Contoh: Budi Santoso"
                                                class="w-full border border-slate-200 rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs font-semibold text-slate-700 placeholder-slate-400 bg-white">
                                        </div>

                                        <!-- Telepon -->
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp / Telepon</label>
                                            <input type="text" name="suppliers[{{ $index }}][telepon]" value="{{ old("suppliers.{$index}.telepon", $supData['supplier']['telepon']) }}"
                                                placeholder="Contoh: 081234567890" data-error-id="error_tel_{{ $index }}"
                                                class="input-telepon w-full border rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs font-semibold text-slate-700 placeholder-slate-400 bg-white {{ empty($supData['supplier']['telepon']) ? 'border-amber-300 bg-amber-50/10' : 'border-slate-200' }}">
                                            <p id="error_tel_{{ $index }}" class="supplier-error text-rose-500 text-[10px] mt-1 font-semibold hidden"></p>
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                                            <input type="text" name="suppliers[{{ $index }}][email]" value="{{ old("suppliers.{$index}.email", $supData['supplier']['email']) }}"
                                                placeholder="Contoh: supplier@domain.com" data-error-id="error_email_{{ $index }}"
                                                class="input-email w-full border rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs font-semibold text-slate-700 placeholder-slate-400 bg-white {{ empty($supData['supplier']['email']) ? 'border-amber-300 bg-amber-50/10' : 'border-slate-200' }}">
                                            <p id="error_email_{{ $index }}" class="supplier-error text-rose-500 text-[10px] mt-1 font-semibold hidden"></p>
                                        </div>

                                        <!-- Kota -->
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kota</label>
                                            <input type="text" name="suppliers[{{ $index }}][kota]" value="{{ old("suppliers.{$index}.kota", $supData['supplier']['kota']) }}"
                                                placeholder="Contoh: Jakarta"
                                                class="w-full border border-slate-200 rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs font-semibold text-slate-700 placeholder-slate-400 bg-white">
                                        </div>

                                        <!-- Alamat Lengkap -->
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap</label>
                                            <textarea name="suppliers[{{ $index }}][alamat]" rows="2" placeholder="Masukkan alamat lengkap distributor..."
                                                class="w-full border rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs font-semibold text-slate-700 placeholder-slate-400 bg-white {{ empty($supData['supplier']['alamat']) ? 'border-amber-300 bg-amber-50/10' : 'border-slate-200' }}">{{ old("suppliers.{$index}.alamat", $supData['supplier']['alamat']) }}</textarea>
                                        </div>

                                        <!-- Keterangan -->
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan</label>
                                            <textarea name="suppliers[{{ $index }}][keterangan]" rows="1" placeholder="Catatan tambahan..."
                                                class="w-full border border-slate-200 rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs font-semibold text-slate-700 placeholder-slate-400 bg-white">{{ old("suppliers.{$index}.keterangan", $supData['supplier']['keterangan']) }}</textarea>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- PANEL 1: Preview Data Obat (Left/Right - 7-cols width) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
                    <div class="p-5 border-b border-slate-50 bg-slate-50/25">
                        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Panel 1: Preview Data Obat ({{ $validCount }} Data)
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto max-h-[800px] overflow-y-auto custom-scrollbar">
                        <table class="w-full text-xs text-left border-collapse table-auto">
                            <thead class="bg-slate-50 text-slate-400 font-bold text-[10px] uppercase border-b border-slate-100 tracking-wider sticky top-0 z-10">
                                <tr>
                                    <th class="py-3.5 px-4 w-12 text-center">No</th>
                                    <th class="py-3.5 px-4">Nama Obat</th>
                                    <th class="py-3.5 px-4 text-center w-20">Gambar</th>
                                    <th class="py-3.5 px-4">Kategori</th>
                                    <th class="py-3.5 px-4">Supplier</th>
                                    <th class="py-3.5 px-4 text-center w-16">Stok</th>
                                    <th class="py-3.5 px-4 text-right w-28">Harga Jual</th>
                                    <th class="py-3.5 px-4 text-center w-28">Kadaluarsa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                                @forelse($validRows as $valRow)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3.5 px-4 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-800">{{ $valRow['nama_obat'] }}</td>
                                        <td class="py-3.5 px-4 text-center">
                                            @if(!empty($valRow['gambar_temp_path']))
                                                <img src="{{ asset('storage/' . $valRow['gambar_temp_path']) }}" alt="Preview" class="w-8 h-8 rounded-lg object-cover mx-auto border border-slate-100 shadow-sm">
                                                <span class="text-[8px] text-emerald-600 font-bold block mt-0.5">Sesuai ZIP</span>
                                            @elseif(!empty($valRow['gambar']))
                                                <div class="text-[9px] text-amber-600 font-bold leading-tight truncate max-w-[80px]" title="{{ $valRow['gambar'] }}">
                                                    {{ $valRow['gambar'] }}
                                                    <span class="text-[7px] text-amber-500 block font-medium mt-0.5">(Tidak di ZIP)</span>
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400 italic font-normal">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-500">{{ $valRow['kategori'] }}</td>
                                        <td class="py-3.5 px-4 text-slate-500 font-semibold">{{ $valRow['supplier'] }}</td>
                                        <td class="py-3.5 px-4 text-center font-bold text-slate-700">{{ $valRow['stok'] }}</td>
                                        <td class="py-3.5 px-4 text-right font-bold text-slate-800">Rp {{ number_format($valRow['harga_jual'], 0, ',', '.') }}</td>
                                        <td class="py-3.5 px-4 text-center font-mono text-[11px] text-slate-400">{{ $valRow['tanggal_kadaluarsa'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-8 text-slate-400 italic font-normal">Tidak ada data valid dalam file.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Footer -->
        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100 bg-white">
            <a href="{{ route('obat.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold transition text-sm">
                Batal
            </a>

            @if($errorCount === 0 && $validCount > 0)
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Konfirmasi Import
                </button>
            @else
                <button type="button" disabled class="px-5 py-2.5 rounded-xl bg-slate-200 text-slate-400 font-semibold cursor-not-allowed text-sm inline-flex items-center gap-1.5 border border-slate-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Tidak Dapat Diimport
                </button>
            @endif
        </div>
    </form>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<script>
    function validasiImport() {
        let isValid = true;
        
        // Sembunyikan semua error terdahulu
        document.querySelectorAll('.supplier-error').forEach(el => {
            el.innerText = '';
            el.classList.add('hidden');
        });

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^[0-9+\-\s()]*$/;

        // Validasi Email
        document.querySelectorAll('.input-email').forEach(el => {
            const val = el.value.trim();
            if (val !== '' && !emailRegex.test(val)) {
                const errId = el.getAttribute('data-error-id');
                const errEl = document.getElementById(errId);
                if (errEl) {
                    errEl.innerText = 'Format email tidak valid (contoh: supplier@domain.com).';
                    errEl.classList.remove('hidden');
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                isValid = false;
            }
        });

        // Validasi Telepon
        document.querySelectorAll('.input-telepon').forEach(el => {
            const val = el.value.trim();
            if (val !== '') {
                if (!phoneRegex.test(val) || val.length < 5) {
                    const errId = el.getAttribute('data-error-id');
                    const errEl = document.getElementById(errId);
                    if (errEl) {
                        errEl.innerText = 'Format nomor telepon tidak valid.';
                        errEl.classList.remove('hidden');
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    isValid = false;
                }
            }
        });

        return isValid;
    }
</script>
@endsection
