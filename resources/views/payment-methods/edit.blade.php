@extends('layouts.app')

@section('title', 'Edit Metode Pembayaran')

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-fade-in" x-data="{ type: '{{ old('type', $paymentMethod->type) }}' }">
    <!-- Header -->
    <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
        <a href="{{ route('admin.payment-methods.index') }}" class="p-2 bg-white hover:bg-slate-50 text-slate-600 rounded-xl border border-slate-200 shadow-sm transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Edit Metode Pembayaran</h1>
            <p class="text-xs text-slate-500 mt-0.5 font-semibold">Ubah konfigurasi metode pembayaran pelanggan</p>
        </div>
    </div>

    <!-- Errors Alert -->
    @if ($errors->any())
        <div class="bg-rose-50 text-rose-600 border border-rose-200 p-4 rounded-2xl space-y-1.5 shadow-sm text-xs font-semibold">
            <p class="font-bold text-sm">Harap perbaiki kesalahan berikut:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <form action="{{ route('admin.payment-methods.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Tipe Metode Pembayaran -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Pembayaran</label>
                <select name="type" x-model="type" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 bg-white">
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="qris">QRIS (Quick Response Code Indonesian Standard)</option>
                    <option value="e_wallet">E-Wallet (DANA/OVO/GoPay/dll.)</option>
                </select>
            </div>

            <!-- Nama Metode Pembayaran -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2" x-text="type === 'bank_transfer' ? 'Nama Bank' : (type === 'e_wallet' ? 'Nama E-Wallet' : 'Nama QRIS')">Nama Bank</label>
                <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" placeholder="Contoh: Bank BCA, DANA, QRIS ShopeePay" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400">
            </div>

            <!-- Field khusus Bank & E-Wallet -->
            <div x-show="type === 'bank_transfer' || type === 'e_wallet'" class="grid grid-cols-1 sm:grid-cols-2 gap-6" x-transition>
                <!-- Nomor Rekening / Nomor E-Wallet -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2" x-text="type === 'bank_transfer' ? 'Nomor Rekening' : 'Nomor HP E-Wallet'">Nomor Rekening</label>
                    <input type="text" name="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}" placeholder="Contoh: 1234567890"
                        ::required="type === 'bank_transfer' || type === 'e_wallet'"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400">
                </div>

                <!-- Nama Pemilik Rekening -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Pemilik</label>
                    <input type="text" name="account_owner" value="{{ old('account_owner', $paymentMethod->account_owner) }}" placeholder="Contoh: Mekar Pharmacy"
                        ::required="type === 'bank_transfer' || type === 'e_wallet'"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400">
                </div>
            </div>

            <!-- Deskripsi / Petunjuk Transfer (Optional) -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Petunjuk Pembayaran / Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Masukkan instruksi khusus atau catatan tambahan..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-slate-700 placeholder-slate-400">{{ old('description', $paymentMethod->description) }}</textarea>
            </div>

            <!-- Upload Logo / QRIS Image -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ganti Gambar/Logo (Opsional)</label>
                @if($paymentMethod->image_path)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $paymentMethod->image_url }}" alt="Logo Saat Ini" class="w-16 h-16 rounded-lg object-contain border border-slate-100 bg-slate-50 p-1">
                        <span class="text-[10px] text-slate-400 font-semibold">Logo saat ini</span>
                    </div>
                @endif
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white cursor-pointer">
                <p class="text-[10px] text-slate-400 mt-1.5 font-medium">Biarkan kosong jika tidak ingin mengubah logo saat ini. JPG, JPEG, PNG, WEBP. Maksimal 2MB.</p>
            </div>



            <!-- Status Aktif (Checkbox) -->
            <div class="flex items-center gap-3 pt-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                <label for="is_active" class="text-xs font-bold text-slate-655 cursor-pointer">Aktifkan Metode Pembayaran ini</label>
            </div>

            <!-- Buttons Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.payment-methods.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-150 hover:bg-slate-200 text-slate-750 font-bold transition text-xs uppercase tracking-wider border border-slate-250 shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold transition text-xs uppercase tracking-wider shadow">
                    Perbarui Metode
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
