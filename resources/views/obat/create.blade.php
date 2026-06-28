@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('obat.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Tambah Obat Baru</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tambahkan data produk obat baru ke dalam persediaan apotek</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-6">
        <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validasiObat()" class="m-0 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Obat -->
                <div>
                    <label for="kode_obat" class="block text-sm font-semibold text-slate-700 mb-2">
                        Kode Obat <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="kode_obat" name="kode_obat" value="{{ old('kode_obat') }}"
                        placeholder="Contoh: OBT-001"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('kode_obat') border-rose-300 bg-rose-50/20 @enderror">
                    <p id="errorKode" class="text-rose-500 text-xs mt-1.5 font-semibold hidden"></p>
                    @error('kode_obat')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Obat -->
                <div>
                    <label for="nama_obat" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Obat <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}"
                        placeholder="Masukkan nama lengkap obat"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('nama_obat') border-rose-300 bg-rose-50/20 @enderror">
                    <p id="errorNama" class="text-rose-500 text-xs mt-1.5 font-semibold hidden"></p>
                    @error('nama_obat')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div x-data="{ isNewCategory: {{ old('kategori_baru') ? 'true' : 'false' }} }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <button type="button" @click="isNewCategory = !isNewCategory; if(isNewCategory){ $nextTick(() => $refs.kategori_baru.focus()) }" 
                            class="text-xs font-bold text-blue-600 hover:text-blue-700 transition"
                            x-text="isNewCategory ? '← Pilih Kategori Terdaftar' : '+ Kategori Baru'">
                        </button>
                    </div>
                    
                    <div x-show="!isNewCategory">
                        <select id="kategori_id" name="kategori_id"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 bg-white @error('kategori_id') border-rose-300 bg-rose-50/20 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="isNewCategory" style="display: none;">
                        <input type="text" id="kategori_baru" name="kategori_baru" x-ref="kategori_baru" value="{{ old('kategori_baru') }}"
                            placeholder="Ketik Kategori Baru"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('kategori_baru') border-rose-300 bg-rose-50/20 @enderror">
                    </div>

                    <p id="errorKategori" class="text-rose-500 text-xs mt-1.5 font-semibold hidden"></p>
                    @error('kategori_id')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                    @error('kategori_baru')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Supplier -->
                <div x-data="supplierCombobox()" class="relative">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Supplier <span class="text-rose-500">*</span>
                    </label>
                    
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input type="text" 
                                x-model="search"
                                @focus="open = true"
                                @click.away="open = false"
                                @keydown.escape="open = false"
                                placeholder="Ketik nama supplier..."
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400">
                            
                            <input type="hidden" id="supplier_id" name="supplier_id" :value="selectedId">
                            <input type="hidden" id="supplier_baru" name="supplier_baru" :value="!selectedId && search.trim() ? search.trim() : ''">

                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <button type="button" @click="openModal(search)"
                            class="px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 rounded-xl font-bold transition text-sm flex-shrink-0">
                            + Supplier Baru
                        </button>
                    </div>

                    <div x-show="open" 
                        style="display: none;"
                        class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                        
                        <template x-for="supplier in filteredSuppliers" :key="supplier.id">
                            <button type="button" 
                                @click="selectSupplier(supplier)"
                                class="w-full text-left px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition flex items-center justify-between">
                                <span x-text="supplier.name"></span>
                                <span x-show="selectedId == supplier.id" class="text-blue-500 font-bold">✓</span>
                            </button>
                        </template>

                        <div x-show="showCreateNew" class="px-4 py-2 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs text-slate-500 font-semibold">Tidak menemukan "<span x-text="search"></span>"</span>
                            <button type="button" @click="openModal(search)"
                                class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">
                                + Lengkapi Data
                            </button>
                        </div>
                    </div>

                    <p id="errorSupplier" class="text-rose-500 text-xs mt-1.5 font-semibold hidden"></p>
                    @error('supplier_id')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stok" class="block text-sm font-semibold text-slate-700 mb-2">
                        Stok Obat <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="stok" name="stok" value="{{ old('stok') }}"
                        placeholder="Jumlah kuantitas obat"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('stok') border-rose-300 bg-rose-50/20 @enderror">
                    <p id="errorStok" class="text-rose-500 text-xs mt-1.5 font-semibold hidden"></p>
                    @error('stok')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Jual -->
                <div>
                    <label for="harga_jual" class="block text-sm font-semibold text-slate-700 mb-2">
                        Harga Jual (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" id="harga_jual" min="1" name="harga_jual" value="{{ old('harga_jual') }}"
                        placeholder="Nominal harga jual produk"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400 @error('harga_jual') border-rose-300 bg-rose-50/20 @enderror">
                    <p id="errorHarga" class="text-rose-500 text-xs mt-1.5 font-semibold hidden"></p>
                    @error('harga_jual')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Kadaluarsa -->
                <div class="md:col-span-2">
                    <label for="tanggal_kadaluarsa" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kadaluarsa</label>
                    <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 bg-white">
                </div>

                <!-- Gambar Obat -->
                <div class="md:col-span-2">
                    <label for="gambar" class="block text-sm font-semibold text-slate-700 mb-2">
                        Gambar Obat <span class="text-slate-400 font-normal">(Opsional, Maksimal 2MB)</span>
                    </label>
                    <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 bg-white cursor-pointer @error('gambar') border-rose-300 bg-rose-50/20 @enderror"
                        onchange="previewImage(event)">
                    @error('gambar')
                        <p class="text-rose-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror

                    <!-- Preview Container -->
                    <div id="imagePreviewContainer" class="hidden mt-4">
                        <p class="text-xs text-slate-400 mb-2 font-semibold">Pratinjau Gambar:</p>
                        <img id="imagePreview" src="#" alt="Pratinjau Gambar" class="max-h-44 rounded-xl border border-slate-100 shadow-sm object-cover">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Obat</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        placeholder="Deskripsi khasiat obat, efek samping, dosis, atau catatan lainnya..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('obat.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold transition text-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-semibold shadow transition text-sm">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Lengkapi Data Supplier -->
    <div id="supplierModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeSupplierModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900" id="modal-title">Lengkapi Data Supplier Baru</h3>
                        <p class="text-xs text-slate-500">Isi detail informasi supplier baru yang belum terdaftar</p>
                    </div>
                    <button type="button" onclick="closeSupplierModal()" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="ajaxSupplierForm" onsubmit="submitAjaxSupplier(event)" class="m-0">
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="modal_nama_supplier" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Supplier <span class="text-rose-500">*</span></label>
                            <input type="text" id="modal_nama_supplier" name="nama_supplier" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="text-rose-500 text-xs font-semibold mt-1 block hidden" id="modal_error_nama_supplier"></span>
                        </div>

                        <div>
                            <label for="modal_kontak_pic" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Kontak / PIC</label>
                            <input type="text" id="modal_kontak_pic" name="kontak_pic"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="text-rose-500 text-xs font-semibold mt-1 block hidden" id="modal_error_kontak_pic"></span>
                        </div>

                        <div>
                            <label for="modal_telepon" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor WhatsApp / Telepon</label>
                            <input type="text" id="modal_telepon" name="telepon"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="text-rose-500 text-xs font-semibold mt-1 block hidden" id="modal_error_telepon"></span>
                        </div>

                        <div>
                            <label for="modal_email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                            <input type="email" id="modal_email" name="email"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="text-rose-500 text-xs font-semibold mt-1 block hidden" id="modal_error_email"></span>
                        </div>

                        <div>
                            <label for="modal_kota" class="block text-sm font-semibold text-slate-700 mb-1.5">Kota</label>
                            <input type="text" id="modal_kota" name="kota"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="text-rose-500 text-xs font-semibold mt-1 block hidden" id="modal_error_kota"></span>
                        </div>

                        <div>
                            <label for="modal_alamat" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap</label>
                            <textarea id="modal_alamat" name="alamat" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            <span class="text-rose-500 text-xs font-semibold mt-1 block hidden" id="modal_error_alamat"></span>
                        </div>

                        <div>
                            <label for="modal_keterangan" class="block text-sm font-semibold text-slate-700 mb-1.5">Keterangan</label>
                            <textarea id="modal_keterangan" name="keterangan" rows="1"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            <span class="text-rose-500 text-xs font-semibold mt-1 block hidden" id="modal_error_keterangan"></span>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2.5 rounded-b-2xl">
                        <button type="button" onclick="closeSupplierModal()" class="px-4 py-2 border border-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" id="modalSubmitBtn" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white rounded-xl text-sm font-semibold shadow transition flex items-center gap-1.5">
                            Simpan Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function supplierCombobox() {
        const suppliersList = [
            @foreach($suppliers as $supplier)
                { id: "{{ $supplier->id }}", name: "{{ addslashes($supplier->nama_supplier) }}" },
            @endforeach
        ];

        return {
            open: false,
            search: '',
            suppliers: suppliersList,
            selectedId: "{{ old('supplier_id') }}",

            init() {
                if (this.selectedId) {
                    const match = this.suppliers.find(s => s.id == this.selectedId);
                    if (match) {
                        this.search = match.name;
                    }
                }
            },

            get filteredSuppliers() {
                if (this.search === '') {
                    return this.suppliers;
                }
                return this.suppliers.filter(s => s.name.toLowerCase().includes(this.search.toLowerCase()));
            },

            get showCreateNew() {
                if (this.search.trim() === '') return false;
                return !this.suppliers.some(s => s.name.toLowerCase() === this.search.trim().toLowerCase());
            },

            selectSupplier(supplier) {
                this.selectedId = supplier.id;
                this.search = supplier.name;
                this.open = false;
                document.getElementById('errorSupplier').classList.add('hidden');
            },

            openModal(typedName) {
                this.open = false;
                openSupplierModal(typedName, (newSupplier) => {
                    this.suppliers.push({ id: newSupplier.id, name: newSupplier.nama_supplier });
                    this.selectedId = newSupplier.id;
                    this.search = newSupplier.nama_supplier;
                    this.open = false;
                });
            }
        };
    }

    let supplierSavedCallback = null;

    function openSupplierModal(typedName, callback) {
        supplierSavedCallback = callback;
        
        document.querySelectorAll('[id^="modal_error_"]').forEach(el => {
            el.innerText = '';
            el.classList.add('hidden');
        });
        
        document.getElementById('ajaxSupplierForm').reset();
        
        if (typedName) {
            document.getElementById('modal_nama_supplier').value = typedName;
        }
        
        const modal = document.getElementById('supplierModal');
        modal.classList.remove('hidden');
    }

    function closeSupplierModal() {
        const modal = document.getElementById('supplierModal');
        modal.classList.add('hidden');
    }

    function submitAjaxSupplier(event) {
        event.preventDefault();
        
        const form = document.getElementById('ajaxSupplierForm');
        const submitBtn = document.getElementById('modalSubmitBtn');
        
        submitBtn.disabled = true;
        submitBtn.innerText = 'Menyimpan...';
        
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => data[key] = value);
        
        document.querySelectorAll('[id^="modal_error_"]').forEach(el => {
            el.innerText = '';
            el.classList.add('hidden');
        });
        
        fetch("{{ route('supplier.store-ajax') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            return response.json().then(json => {
                if (!response.ok) {
                    return Promise.reject({ status: response.status, data: json });
                }
                return json;
            });
        })
        .then(res => {
            if (res.success && res.data) {
                if (supplierSavedCallback) {
                    supplierSavedCallback(res.data);
                }
                closeSupplierModal();
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Simpan Supplier';
            
            if (err.data && err.data.errors) {
                const errors = err.data.errors;
                for (const key in errors) {
                    const errorEl = document.getElementById(`modal_error_${key}`);
                    if (errorEl) {
                        errorEl.innerText = errors[key][0];
                        errorEl.classList.remove('hidden');
                    }
                }
            } else {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    }

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
        let kategori_baru = document.getElementById('kategori_baru') ? document.getElementById('kategori_baru').value.trim() : '';
        let supplier_id = document.getElementById('supplier_id').value;
        let supplier_baru = document.getElementById('supplier_baru') ? document.getElementById('supplier_baru').value.trim() : '';
        let stok = document.getElementById('stok').value.trim();
        let harga_jual = document.getElementById('harga_jual').value.trim();

        let valid = true;

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
        if (kategori_id === '' && kategori_baru === '') {
            document.getElementById('errorKategori').innerText = 'Kategori wajib dipilih atau diisi';
            document.getElementById('errorKategori').classList.remove('hidden');
            valid = false;
        }
        if (supplier_id === '' && supplier_baru === '') {
            document.getElementById('errorSupplier').innerText = 'Supplier wajib dipilih atau diisi';
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
