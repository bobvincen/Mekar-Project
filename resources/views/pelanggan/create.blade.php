@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-lg p-6 md:p-8">

        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('pelanggan.index') }}"
                class="p-2.5 bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-xl transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Tambah Pengguna Baru
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    Masukkan detail informasi pengguna baru
                </p>
            </div>
        </div>

        <form action="{{ url('pelanggan') }}" method="POST" id="formPelanggan">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger mx-4 mt-2 mb-3"
                    style="background-color: #FEF2F2; border-left: 4px solid #EF4444; border-color: #FCA5A5; color: #991B1B; border-radius: 0 12px 12px 0;">
                    <div class="d-flex align-items-center mb-1 font-weight-bold" style="font-weight: 700;">
                        <i class="fa-solid fa-circle-xmark me-2" style="color: #EF4444;"></i> Terdapat kesalahan input:
                    </div>
                    <ul class="mb-0 list-unstyled" style="padding-left: 20px; font-size: 0.875rem; color: #B91C1C;">
                        @foreach ($errors->all() as $error)
                            <li style="list-style-type: disc;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="pelanggan-body">
                <div class="form-group mb-4">
                    <label class="form-label-custom">Nama Pengguna <span style="color: #EF4444;">*</span></label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="nama_pelanggan" class="form-input"
                            placeholder="Masukkan nama lengkap pengguna" value="{{ old('nama_pelanggan') }}" required>
                    </div>
                    @error('nama_pelanggan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-label-custom">Nomor Handphone (HP) <span style="color: #EF4444;">*</span></label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="no_hp" class="form-input" placeholder="Contoh: 081234567890"
                            value="{{ old('no_hp') }}" required>
                    </div>
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-label-custom">Role / Hak Akses <span style="color: #EF4444;">*</span></label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fa-solid fa-user-shield"></i></span>
                        <select name="role" class="form-input bg-white" required>
                            <option value="" disabled {{ old('role') == '' ? 'selected' : '' }}>— Pilih Hak Akses —
                            </option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin Apotek</option>
                            <option value="Kasir" {{ old('role') == 'Kasir' ? 'selected' : '' }}>Kasir / Staff</option>
                            <option value="Pelanggan" {{ old('role') == 'Pelanggan' ? 'selected' : '' }}>Pelanggan / Member
                            </option>
                        </select>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-2">
                    <label class="form-label-custom">Alamat Tempat Tinggal <span style="color: #EF4444;">*</span></label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon textarea-icon"><i class="fa-solid fa-location-dot"></i></span>
                        <textarea name="alamat" class="form-input textarea-custom" rows="4"
                            placeholder="Masukkan alamat lengkap rumah saat ini..." required>{{ old('alamat') }}</textarea>
                    </div>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pelanggan-footer">
                <button type="button" class="btn-custom btn-reset" onclick="resetForm_Custom()">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-custom btn-simpan">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
            </div>
        </form>
    </div>

<style>
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .pelanggan-body {
        padding: 0 0 1rem 0;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label-custom {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .input-icon-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        color: #94A3B8;
        font-size: 0.9rem;
        pointer-events: none;
        z-index: 10;
    }

    .textarea-icon {
        top: 14px;
        transform: none;
    }

    .form-input {
        width: 100%;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        font-size: 0.875rem;
        color: #374151;
        background-color: #ffffff;
        outline: none;
        border: 1px solid #D1D5DB;
        transition: all 150ms ease-in-out;
    }

    .form-input:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.25);
    }

    .textarea-custom {
        height: auto !important;
        resize: none;
    }

    /* FOOTER & BUTTONS */
    .pelanggan-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid #F3F4F6;
    }

    .btn-custom {
        font-size: 0.875rem;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-radius: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 150ms ease;
        border: none;
        cursor: pointer;
    }

    .btn-reset {
        background-color: #F9FAFB;
        color: #4B5563;
    }

    .btn-reset:hover {
        background-color: #F3F4F6;
        color: #111827;
    }

    .btn-simpan {
        background-color: #2563EB;
        color: #ffffff;
        padding: 0.75rem 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1);
    }

    .btn-simpan:hover {
        background-color: #1D4ED8;
    }
</style>

<script>
    function resetForm_Custom() {
        const form = document.getElementById('formPelanggan');

        form.querySelectorAll('input[type="text"], textarea').forEach(input => {
            input.value = '';
        });

        form.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0;
        });
    }
</script>
@endsection
