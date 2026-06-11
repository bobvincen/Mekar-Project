@extends('layouts.app')

@section('content')
    <div class="pelanggan-form-wrapper">
        <div class="pelanggan-container">
            <div class="back-navigation mb-3">
                <a href="{{ url('pelanggan') }}" class="text-decoration-none btn-back-link">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pelanggan
                </a>
            </div>

            <div class="pelanggan-card">
                <div class="pelanggan-header">
                    <h3 class="form-title">Tambah Data Pengguna</h3>
                    <p class="form-subtitle">Lengkapi detail informasi untuk mendaftarkan pengguna baru sistem apotek</p>
                </div>

                <form action="{{ url('pelanggan') }}" method="POST" id="formPelanggan">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger mx-4 mt-3 mb-0"
                            style="background-color: #FEF2F2; border-left: 4px solid #EF4444; border-color: #FCA5A5; color: #991B1B; border-radius: 0 12px 12px 0;">
                            <div class="d-flex align-items-center mb-1 font-weight-bold" style="font-weight: 700;">
                                <i class="fa-solid fa-circle-xmark me-2" style="color: #EF4444;"></i> Terdapat kesalahan
                                input:
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
                                    placeholder="Masukkan nama lengkap pengguna" value="{{ old('nama_pelanggan') }}"
                                    required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Nomor Handphone (HP) <span
                                    style="color: #EF4444;">*</span></label>
                            <div class="input-icon-wrapper">
                                <span class="input-icon"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="no_hp" class="form-input" placeholder="Contoh: 081234567890"
                                    value="{{ old('no_hp') }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Alamat Tempat Tinggal <span
                                    style="color: #EF4444;">*</span></label>
                            <div class="input-icon-wrapper align-items-start">
                                <span class="input-icon mt-2.5"><i class="fa-solid fa-location-dot"></i></span>
                                <textarea name="alamat" class="form-input textarea-custom" rows="4"
                                    placeholder="Masukkan alamat lengkap rumah saat ini..." required>{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label-custom">Role / Hak Akses <span style="color: #EF4444;">*</span></label>
                            <div class="input-icon-wrapper">
                                <span class="input-icon"><i class="fa-solid fa-user-shield"></i></span>
                                <select name="role" class="form-input" style="padding-top: 2px;" required>
                                    <option value="" disabled {{ old('role') == '' ? 'selected' : '' }}>— Pilih Hak
                                        Akses —</option>
                                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin Apotek
                                    </option>
                                    <option value="Kasir" {{ old('role') == 'Kasir' ? 'selected' : '' }}>Kasir / Staff
                                    </option>
                                    <option value="Pelanggan" {{ old('role') == 'Pelanggan' ? 'selected' : '' }}>Pelanggan /
                                        Member</option>
                                </select>
                            </div>
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
        </div>
    </div>

    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        /* BASE WRAPPER */
        .pelanggan-form-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            min-height: 100vh;
            padding: 2rem 1rem;
            color: #0F172A;
        }

        .pelanggan-container {
            max-width: 680px;
            margin: 0 auto;
        }

        /* TOMBOL KEMBALI ATAS */
        .btn-back-link {
            color: #64748B;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s ease;
        }

        .btn-back-link:hover {
            color: #1E293B;
            /* Menyamakan hover link atas ke gray-900 */
        }

        /* KARTU TIMBUL (Disesuaikan Radius & Border dengan Supplier) */
        .pelanggan-card {
            background: #ffffff;
            border-radius: 24px;
            /* Menyesuaikan rounded-3xl (24px) */
            border: 1px solid #E2E8F0;
            box-shadow:
                0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* HEADER KARTU */
        .pelanggan-header {
            background: #ffffff;
            padding: 1.75rem 2rem;
            border-bottom: 1px solid #F1F5F9;
        }

        .form-title {
            font-size: 1.5rem;
            /* Ukuran teks 2xl sesuai supplier */
            font-weight: 700;
            color: #1E293B;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .form-subtitle {
            font-size: 0.875rem;
            color: #64748B;
            margin: 4px 0 0 0;
        }

        /* BODY & FORM INPUT */
        .pelanggan-body {
            padding: 2rem;
        }

        .form-label-custom {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            /* Warna teks gray-700 sesuai supplier */
            margin-bottom: 8px;
        }

        /* Input Group Ber-Icon */
        .input-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94A3B8;
            font-size: 0.9rem;
            pointer-events: none;
        }

        .mt-2.5 {
            margin-top: 12px;
        }

        .form-input {
            width: 100%;
            height: 48px;
            /* Disesuaikan tinggi padding input supplier */
            border: 1px solid #D1D5DB;
            /* Warna border gray-300 sesuai supplier */
            border-radius: 12px;
            /* Radius rounded-xl sesuai supplier */
            padding: 8px 12px 8px 40px;
            font-size: 0.875rem;
            color: #374151;
            background-color: #ffffff;
            transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input::placeholder {
            color: #9CA3AF;
            /* Placeholder gray-400 */
        }

        /* FOCUS RING DIUBAH MENJADI BIRU SESUAI SUPPLIER */
        .form-input:focus {
            outline: none;
            border-color: #3B82F6;
            /* Border Blue-500 */
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.25);
            /* Efek focus ring-4 blue-300 */
        }

        .textarea-custom {
            height: auto !important;
            resize: none;
            padding-top: 12px;
        }

        /* FOOTER KARTU */
        .pelanggan-footer {
            background-color: #ffffff;
            border-top: 1px solid #F3F4F6;
            /* Border gray-100 */
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        /* TOMBOL SEIRING DENGAN DESAIN SUPPLIER */
        .btn-custom {
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0 24px;
            height: 46px;
            border-radius: 12px;
            /* rounded-xl */
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 150ms ease;
            border: none;
            cursor: pointer;
        }

        /* WARNA RESET: MENGIKUTI TOMBOL KEMBALI ABU-ABU TIPIS SUPPLIER */
        .btn-reset {
            background-color: #F9FAFB;
            /* bg-gray-50 */
            color: #4B5563;
            /* text-gray-600 */
        }

        .btn-reset:hover {
            background-color: #F3F4F6;
            /* hover:bg-gray-100 */
            color: #111827;
            /* hover:text-gray-900 */
        }

        /* WARNA SIMPAN: DIUBAH MENJADI BIRU UTAMA (BLUE-600) SESUAI SUPPLIER */
        .btn-simpan {
            background-color: #2563EB;
            /* bg-blue-600 */
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        .btn-simpan:hover {
            background-color: #1D4ED8;
            /* hover:bg-blue-700 */
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
    </style>

    <script>
        function resetForm_Custom() {
            const form = document.getElementById('formPelanggan');

            // Mengosongkan text input dan textarea
            form.querySelectorAll('input[type="text"], textarea').forEach(input => {
                input.value = '';
            });

            // Mengembalikan select option ke pilihan pertama (disabled / kosong)
            form.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
            });
        }
    </script>
@endsection
