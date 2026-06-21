@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg p-6 md:p-8">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('obat.index') }}"
                class="p-2.5 bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-xl transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Tambah Obat Baru
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    Tambahkan informasi obat baru ke dalam sistem database Mekar Pharmacy
                </p>
            </div>
        </div>

        <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validasiObat()" class="m-0">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label for="kode_obat" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="kode_obat" name="kode_obat" value="{{ old('kode_obat') }}"
                        placeholder="Masukkan kode obat (misal: OBT-001)"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 
                        @error('kode_obat') border-red-500 focus:ring-red-100 bg-red-50/50 @else border-gray-300 focus:ring-blue-300 @enderror">
                    <p id="errorKode" class="text-red-500 text-xs mt-2 font-medium hidden"></p>
                    @error('kode_obat')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_obat" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}"
                        placeholder="Masukkan nama obat"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 
                        @error('nama_obat') border-red-500 focus:ring-red-100 bg-red-50/50 @else border-gray-300 focus:ring-blue-300 @enderror">
                    <p id="errorNama" class="text-red-500 text-xs mt-2 font-medium hidden"></p>
                    @error('nama_obat')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori_id" name="kategori_id"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 bg-white
                        @error('kategori_id') border-red-500 focus:ring-red-100 bg-red-50/50 @else border-gray-300 focus:ring-blue-300 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <p id="errorKategori" class="text-red-500 text-xs mt-2 font-medium hidden"></p>
                    @error('kategori_id')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="supplier_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Supplier <span class="text-red-500">*</span>
                    </label>
                    <select id="supplier_id" name="supplier_id"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 bg-white
                        @error('supplier_id') border-red-500 focus:ring-red-100 bg-red-50/50 @else border-gray-300 focus:ring-blue-300 @enderror">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                    <p id="errorSupplier" class="text-red-500 text-xs mt-2 font-medium hidden"></p>
                    @error('supplier_id')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
                        Stok Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="stok" name="stok" value="{{ old('stok') }}"
                        placeholder="Masukkan jumlah kuantitas stok"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 
                        @error('stok') border-red-500 focus:ring-red-100 bg-red-50/50 @else border-gray-300 focus:ring-blue-300 @enderror">
                    <p id="errorStok" class="text-red-500 text-xs mt-2 font-medium hidden"></p>
                    @error('stok')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga_jual" class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga Jual (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="harga_jual" min="1" name="harga_jual" value="{{ old('harga_jual') }}"
                        placeholder="Masukkan nominal harga jual"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 
                        @error('harga_jual') border-red-500 focus:ring-red-100 bg-red-50/50 @else border-gray-300 focus:ring-blue-300 @enderror">
                    <p id="errorHarga" class="text-red-500 text-xs mt-2 font-medium hidden"></p>
                    @error('harga_jual')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-2">
                        Gambar Obat <span class="text-gray-400 font-normal">(Opsional, Maksimal 2MB)</span>
                    </label>
                    <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="w-full border border-gray-300 focus:ring-blue-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150 bg-white @error('gambar') border-red-500 focus:ring-red-100 bg-red-50/50 @enderror"
                        onchange="previewImage(event)">
                    @error('gambar')
                        <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror

                    <!-- Preview Container -->
                    <div id="imagePreviewContainer" class="hidden mt-4">
                        <p class="text-xs text-gray-500 mb-2 font-semibold">Pratinjau Gambar:</p>
                        <img id="imagePreview" src="#" alt="Pratinjau Gambar" class="max-h-48 rounded-xl border border-gray-200 shadow-sm object-cover">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="tanggal_kadaluarsa" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal
                        Kadaluarsa</label>
                    <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa"
                        value="{{ old('tanggal_kadaluarsa') }}"
                        class="w-full border border-gray-300 focus:ring-blue-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150">
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Obat</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Tambahkan deskripsi atau catatan mengenai obat ini..."
                        class="w-full border border-gray-300 focus:ring-blue-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-4 transition duration-150">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('obat.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-center transition-colors text-sm text-decoration-none">
                    Batal
                </a>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md hover:shadow-lg transition-all text-sm">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const container = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                container.classList.add('hidden');
            }
        }

        function validasiObat() {
            let kode_obat = document.getElementById('kode_obat').value.trim();
            let nama_obat = document.getElementById('nama_obat').value.trim();
            let kategori_id = document.getElementById('kategori_id').value;
            let supplier_id = document.getElementById('supplier_id').value;
            let stok = document.getElementById('stok').value.trim();
            let harga_jual = document.getElementById('harga_jual').value.trim();

            let valid = true;

            // Reset Error
            document.querySelectorAll('[id^="error"]').forEach(el => el.classList.add('hidden'));

            if (kode_obat === '') {
                document.getElementById('errorKode').innerText = 'Kode obat wajib diisi';
                document.getElementById('errorKode').classList.remove('hidden');
                valid = false;
            }
            if (nama_obat === '') {
                document.getElementById('errorNama').innerText = 'Nama obat wajib diisi';
                document.getElementById('errorNama').classList.remove('hidden');
                valid = false;
            }
            if (kategori_id === '') {
                document.getElementById('errorKategori').innerText = 'Kategori wajib dipilih';
                document.getElementById('errorKategori').classList.remove('hidden');
                valid = false;
            }
            if (supplier_id === '') {
                document.getElementById('errorSupplier').innerText = 'Supplier wajib dipilih';
                document.getElementById('errorSupplier').classList.remove('hidden');
                valid = false;
            }
            if (stok === '') {
                document.getElementById('errorStok').innerText = 'Stok wajib diisi';
                document.getElementById('errorStok').classList.remove('hidden');
                valid = false;
            }
            if (harga_jual === '') {
                document.getElementById('errorHarga').innerText = 'Harga jual wajib diisi';
                document.getElementById('errorHarga').classList.remove('hidden');
                valid = false;
            }

            return valid;
        }
    </script>
@endsection
