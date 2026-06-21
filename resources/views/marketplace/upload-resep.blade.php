@extends('marketplace.layouts.app')

@section('title', 'Upload Resep Dokter')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">

    <div class="mb-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-blue-900 tracking-tight mb-3">Upload Resep Dokter</h1>
        <p class="text-slate-500 max-w-xl mx-auto font-light leading-relaxed">
            Kirimkan foto resep dokter Anda, admin kami akan segera menghubungi Anda melalui WhatsApp untuk proses pemesanan obat.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-start gap-4 shadow-sm" role="alert">
            <svg class="w-6 h-6 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="font-bold text-lg mb-1">Berhasil!</p>
                <p class="text-sm opacity-90">{{ session('success') }}</p>
            </div>
        </div>

        @if(session('waUrl'))
            <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-xl text-center">
                <p class="text-sm text-blue-700 mb-3">Membuka WhatsApp secara otomatis...</p>
                <a href="{!! session('waUrl') !!}" target="_blank" class="inline-block px-5 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg text-sm transition-colors">
                    Klik di sini jika WhatsApp tidak terbuka
                </a>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        window.location.href = "{!! session('waUrl') !!}";
                    }, 1500); // Redirect ke WA setelah 1.5 detik
                });
            </script>
        @endif
    @endif

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        
        <div class="p-6 sm:p-10">
            <form action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data" x-data="uploadResep()">
                @csrf

                <div class="space-y-6">
                    
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" required value="{{ old('nama') }}"
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all duration-300 @error('nama') border-red-500 bg-red-50 @enderror"
                            placeholder="Contoh: Budi Santoso">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label for="whatsapp" class="block text-sm font-semibold text-slate-700 mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp') }}"
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all duration-300 @error('whatsapp') border-red-500 bg-red-50 @enderror"
                            placeholder="Contoh: 08123456789">
                        @error('whatsapp')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label for="catatan" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Tambahan <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <textarea name="catatan" id="catatan" rows="3"
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all duration-300"
                            placeholder="Tuliskan keluhan atau detail lain jika ada...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Foto Resep --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Resep Dokter <span class="text-red-500">*</span></label>
                        
                        <div class="relative group mt-1 flex justify-center px-6 pt-10 pb-12 border-2 border-slate-300 border-dashed rounded-2xl hover:border-blue-500 hover:bg-blue-50/50 transition-all duration-300"
                             :class="{ 'border-blue-500 bg-blue-50/50': previewUrl !== null }">
                            
                            <!-- State: Belum ada file -->
                            <div class="space-y-2 text-center" x-show="previewUrl === null">
                                <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-blue-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="foto_resep" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload file</span>
                                        <input id="foto_resep" name="foto_resep" type="file" class="sr-only" required accept="image/jpeg,image/png,image/jpg" @change="previewImage">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-500">PNG, JPG, JPEG up to 5MB</p>
                            </div>

                            <!-- State: File Terpilih (Preview) -->
                            <div class="w-full flex flex-col items-center justify-center" x-show="previewUrl !== null" style="display: none;">
                                <img :src="previewUrl" alt="Preview" class="max-h-64 object-contain rounded-lg shadow-sm border border-slate-200">
                                
                                <div class="mt-4 flex gap-3">
                                    <button type="button" @click="removeImage" class="text-sm text-red-500 hover:text-red-700 font-medium px-4 py-2 bg-red-50 rounded-lg transition-colors">
                                        Hapus Foto
                                    </button>
                                    <label for="foto_resep" class="cursor-pointer text-sm text-blue-600 hover:text-blue-800 font-medium px-4 py-2 bg-blue-50 rounded-lg transition-colors">
                                        Ganti Foto
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('foto_resep')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-10">
                    <button type="submit" 
                        class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 uppercase tracking-widest">
                        Kirim Resep Sekarang
                    </button>
                </div>

            </form>
        </div>
        
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('uploadResep', () => ({
            previewUrl: null,
            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    // Validasi ukuran di sisi client (Max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert("Ukuran file terlalu besar! Maksimal 5MB.");
                        this.removeImage();
                        return;
                    }
                    this.previewUrl = URL.createObjectURL(file);
                }
            },
            removeImage() {
                this.previewUrl = null;
                document.getElementById('foto_resep').value = '';
            }
        }));
    });
</script>
@endsection
