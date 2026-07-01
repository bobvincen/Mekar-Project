@extends('layouts.app')

@section('title', 'Proses Resep Dokter')

@section('content')
<div class="space-y-6" x-data="prosesResep()">
    <!-- Header -->
    <div class="flex items-center gap-2">
        <a href="{{ auth()->user()->can('Kelola Pesanan Online') ? route('admin.resep.index') : route('apoteker.resep.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Resep
        </a>
    </div>

    <div>
        <h2 class="text-2xl font-bold text-gray-800">Proses Resep Dokter</h2>
        <p class="text-sm text-gray-500 mt-0.5">Pilih ketersediaan obat berdasarkan resep di bawah ini untuk dikirimkan kepada pelanggan</p>
    </div>

    <!-- Errors list -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-xs font-semibold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Panel Kiri: Foto Resep (Private) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-6">
                <h3 class="text-sm font-bold text-gray-800 mb-3 pb-2 border-b border-gray-50">Visualisasi Berkas Resep</h3>
                <div class="bg-slate-50 border border-dashed border-gray-200 rounded-xl p-3 flex items-center justify-center overflow-hidden">
                    <a href="{{ route('resep.file', $resep->id) }}" target="_blank" class="hover:opacity-95 transition flex flex-col items-center w-full">
                        <img src="{{ route('resep.file', $resep->id) }}" alt="Resep Medis" class="max-h-[400px] w-auto rounded border object-contain">
                        <span class="text-xs text-blue-600 font-semibold mt-3">Buka Gambar di Tab Baru ↗</span>
                    </a>
                </div>

                <div class="mt-5 space-y-3.5 text-xs">
                    <div>
                        <span class="block text-gray-400 font-semibold uppercase tracking-wider">Nama Pelanggan</span>
                        <span class="block text-gray-800 font-bold mt-0.5">{{ $resep->nama }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 font-semibold uppercase tracking-wider">WhatsApp</span>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $resep->whatsapp) }}" target="_blank" class="block text-blue-600 font-semibold hover:underline mt-0.5">
                            {{ $resep->whatsapp }} ↗
                        </a>
                    </div>
                    <div>
                        <span class="block text-gray-400 font-semibold uppercase tracking-wider">Catatan Pelanggan</span>
                        <p class="text-gray-700 mt-1 bg-gray-50 p-2.5 rounded-lg border border-gray-100 italic">{{ $resep->catatan ?: '-' }}</p>
                    </div>

                    @if($resep->catatan_revisi)
                        <div class="mt-4 p-3 bg-rose-50 border border-rose-100 text-rose-800 rounded-xl">
                            <span class="font-bold block mb-1">Catatan Permintaan Revisi Pelanggan:</span>
                            "{{ $resep->catatan_revisi }}"
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Pemrosesan Obat -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-50">Sediaan Obat Penawaran</h3>
                
                <!-- Main Drug Search Input -->
                <div class="mb-6 relative">
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Cari & Tambah Obat</label>
                    <div class="relative">
                        <input type="text" x-model="searchQuery" @input.debounce.300ms="searchObats()" placeholder="Masukkan nama obat atau kode obat..."
                            class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <span class="absolute left-3.5 top-3 text-gray-400">
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </span>
                    </div>

                    <!-- Search dropdown results -->
                    <div x-show="searchResults.length > 0" class="absolute left-0 right-0 mt-1 bg-white border border-gray-100 rounded-xl shadow-xl z-50 divide-y divide-gray-50 max-h-60 overflow-y-auto" style="display: none;">
                        <template x-for="obat in searchResults" :key="obat.id">
                            <button type="button" @click="addObat(obat)" class="w-full text-left px-4 py-3 hover:bg-blue-50/50 flex items-center justify-between transition-colors">
                                <div>
                                    <span class="block font-semibold text-gray-800 text-sm" x-text="obat.nama_obat"></span>
                                    <span class="block text-gray-400 text-xs" x-text="'Kode: ' + obat.kode_obat + ' | Stok: ' + obat.stok"></span>
                                </div>
                                <span class="text-blue-600 font-bold text-xs" x-text="obat.harga_formatted"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Forms to submit -->
                <form action="{{ route('resep.proses.submit', $resep->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Selected items list -->
                    <div class="border rounded-2xl border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-xs font-bold text-gray-400 uppercase border-b border-gray-100">
                                    <th class="py-3 px-4">Nama Obat</th>
                                    <th class="py-3 px-4 text-center w-24">Stok</th>
                                    <th class="py-3 px-4 text-center w-24">Qty</th>
                                    <th class="py-3 px-4 text-center w-40">Status</th>
                                    <th class="py-3 px-4 text-right w-16">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-150 text-sm">
                                <template x-if="selectedObats.length === 0">
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-400 font-medium italic">
                                            Belum ada obat yang dipilih. Silakan cari obat di atas.
                                        </td>
                                    </tr>
                                </template>
                                
                                <template x-for="(item, index) in selectedObats" :key="item.obat_id">
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3 px-4">
                                            <span class="block font-semibold text-gray-850" x-text="item.nama_obat"></span>
                                            <span class="block text-gray-400 text-xs" x-text="item.harga_formatted"></span>
                                            
                                            <!-- Inputs hidden to submit -->
                                            <input type="hidden" :name="'items['+index+'][obat_id]'" :value="item.obat_id">
                                            
                                            <!-- Replacement details if not available -->
                                            <div x-show="item.status === 'tidak_tersedia'" class="mt-2 pl-3 border-l-2 border-amber-500 bg-amber-50/40 p-2 rounded" style="display: none;">
                                                <span class="text-[10px] font-bold text-amber-700 block uppercase mb-1">Obat Pengganti (Opsional)</span>
                                                <div class="relative">
                                                    <input type="text" x-model="item.penggantiSearch" @input.debounce.300ms="searchReplacement(index)" placeholder="Cari obat pengganti..."
                                                        class="w-full border border-gray-250 bg-white rounded-lg px-2 py-1 text-xs focus:outline-none">
                                                    
                                                    <!-- Replacement dropdown results -->
                                                    <div x-show="item.penggantiResults.length > 0" class="absolute left-0 right-0 mt-1 bg-white border rounded-lg shadow-lg z-50 divide-y divide-gray-55 max-h-40 overflow-y-auto">
                                                        <template x-for="rep in item.penggantiResults" :key="rep.id">
                                                            <button type="button" @click="selectReplacement(index, rep)" class="w-full text-left px-2 py-1.5 hover:bg-blue-50 text-[11px] font-medium flex justify-between">
                                                                <span x-text="rep.nama_obat"></span>
                                                                <span class="text-gray-400" x-text="'Stok: ' + rep.stok"></span>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>

                                                <template x-if="item.obat_pengganti_id">
                                                    <div class="mt-1.5 flex items-center justify-between text-xs bg-blue-50 text-blue-700 rounded px-2 py-1">
                                                        <span x-text="item.obat_pengganti_nama"></span>
                                                        <button type="button" @click="removeReplacement(index)" class="text-red-500 font-bold hover:text-red-700">✕</button>
                                                    </div>
                                                </template>
                                                <input type="hidden" :name="'items['+index+'][obat_pengganti_id]'" :value="item.obat_pengganti_id">
                                                
                                                <!-- Catatan item -->
                                                <input type="text" :name="'items['+index+'][catatan]'" x-model="item.catatan" placeholder="Catatan apoteker untuk item ini..."
                                                    class="w-full border border-gray-250 bg-white rounded-lg px-2 py-1 text-xs focus:outline-none mt-2">
                                            </div>
                                        </td>
                                        
                                        <!-- Stock info -->
                                        <td class="py-3 px-4 text-center font-semibold text-gray-500" x-text="item.stok"></td>
                                        
                                        <!-- Qty input -->
                                        <td class="py-3 px-4">
                                            <input type="number" :name="'items['+index+'][qty]'" x-model="item.qty" min="1" :max="item.stok"
                                                class="w-16 border rounded-lg px-2 py-1 text-center font-bold text-gray-800 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </td>
                                        
                                        <!-- Availability status select -->
                                        <td class="py-3 px-4">
                                            <select :name="'items['+index+'][status]'" x-model="item.status" class="w-full border rounded-lg px-2 py-1 text-xs font-semibold focus:outline-none">
                                                <option value="tersedia">✔ Tersedia</option>
                                                <option value="tidak_tersedia">❌ Tidak Tersedia</option>
                                            </select>
                                        </td>
                                        
                                        <!-- Delete action -->
                                        <td class="py-3 px-4 text-right">
                                            <button type="button" @click="removeObat(index)" class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Overall note field -->
                    <div>
                        <label for="catatan_verifikasi" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Catatan Verifikasi Keseluruhan</label>
                        <textarea name="catatan_verifikasi" id="catatan_verifikasi" rows="3" placeholder="Tulis catatan, instruksi, atau informasi tambahan untuk pelanggan..."
                            class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">{{ old('catatan_verifikasi', $resep->catatan_verifikasi) }}</textarea>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-gray-50">
                        <!-- Reject form trigger -->
                        <button type="button" @click="rejectPrescription()" class="px-5 py-3 border border-red-200 text-red-650 hover:bg-red-50 font-bold text-xs uppercase tracking-wider rounded-xl transition w-full sm:w-auto text-center">
                            ✗ Tolak Resep
                        </button>
                        
                        <button type="submit" class="px-6 py-3 bg-blue-650 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition w-full sm:w-auto">
                            Kirim Penawaran Obat
                        </button>
                    </div>
                </form>

                <!-- Hidden form for reject action -->
                <form id="reject-form" action="{{ route('resep.proses.reject', $resep->id) }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="catatan_verifikasi" id="reject-notes-input">
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('prosesResep', () => ({
            searchQuery: '',
            searchResults: [],
            selectedObats: {!! $selectedObatsJson !!},

            async searchObats() {
                if (this.searchQuery.trim().length < 2) {
                    this.searchResults = [];
                    return;
                }

                try {
                    const response = await fetch(`/api/obats/search?q=${encodeURIComponent(this.searchQuery)}`);
                    if (response.ok) {
                        this.searchResults = await response.json();
                    }
                } catch (error) {
                    console.error('Error fetching medicines:', error);
                }
            },

            addObat(obat) {
                // Check if already selected
                const exists = this.selectedObats.some(item => item.obat_id === obat.id);
                if (exists) {
                    alert('Obat tersebut sudah dipilih!');
                    this.searchQuery = '';
                    this.searchResults = [];
                    return;
                }

                this.selectedObats.push({
                    obat_id: obat.id,
                    nama_obat: obat.nama_obat,
                    kode_obat: obat.kode_obat,
                    stok: obat.stok,
                    harga_jual: obat.harga_jual,
                    harga_formatted: obat.harga_formatted,
                    qty: 1,
                    status: 'tersedia',
                    obat_pengganti_id: null,
                    obat_pengganti_nama: null,
                    catatan: '',
                    penggantiSearch: '',
                    penggantiResults: []
                });

                this.searchQuery = '';
                this.searchResults = [];
            },

            removeObat(index) {
                this.selectedObats.splice(index, 1);
            },

            async searchReplacement(index) {
                const item = this.selectedObats[index];
                if (item.penggantiSearch.trim().length < 2) {
                    item.penggantiResults = [];
                    return;
                }

                try {
                    const response = await fetch(`/api/obats/search?q=${encodeURIComponent(item.penggantiSearch)}`);
                    if (response.ok) {
                        item.penggantiResults = await response.json();
                    }
                } catch (error) {
                    console.error('Error fetching replacements:', error);
                }
            },

            selectReplacement(index, rep) {
                const item = this.selectedObats[index];
                item.obat_pengganti_id = rep.id;
                item.obat_pengganti_nama = rep.nama_obat;
                item.penggantiSearch = '';
                item.penggantiResults = [];
            },

            removeReplacement(index) {
                const item = this.selectedObats[index];
                item.obat_pengganti_id = null;
                item.obat_pengganti_nama = null;
            },

            rejectPrescription() {
                const notes = document.getElementById('catatan_verifikasi').value.trim();
                if (!notes) {
                    alert('Harap tuliskan alasan penolakan resep pada kolom Catatan Verifikasi terlebih dahulu.');
                    return;
                }

                if (confirm('Apakah Anda yakin ingin menolak resep dokter ini?')) {
                    document.getElementById('reject-notes-input').value = notes;
                    document.getElementById('reject-form').submit();
                }
            }
        }));
    });
</script>
@endsection
