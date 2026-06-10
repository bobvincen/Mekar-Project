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
                        <div class="alert alert-danger mx-4 mt-3 mb-0">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pelanggan-body">
                        <div class="form-group mb-4">
                            <label class="form-label-custom">Nama Pengguna</label>
                            <div class="input-icon-wrapper">
                                <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="nama_pelanggan" class="form-input"
                                    placeholder="Masukkan nama lengkap pengguna" value="{{ old('nama_pelanggan') }}"
                                    required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Nomor Handphone (HP)</label>
                            <div class="input-icon-wrapper">
                                <span class="input-icon"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="no_hp" class="form-input" placeholder="Contoh: 081234567890"
                                    value="{{ old('no_hp') }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Alamat Tempat Tinggal</label>
                            <div class="input-icon-wrapper align-items-start">
                                <span class="input-icon mt-2.5"><i class="fa-solid fa-location-dot"></i></span>
                                <textarea name="alamat" class="form-input textarea-custom" rows="4"
                                    placeholder="Masukkan alamat lengkap rumah saat ini..." required>{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label-custom">Role / Hak Akses</label>
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
            color: #0F172A;
        }

        /* KARTU TIMBUL (FIGMA EMERGENCE CARD) */
        .pelanggan-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #E2E8F0;
            box-shadow:
                0 20px 25px -5px rgba(0, 0, 0, 0.05),
                0 8px 10px -6px rgba(0, 0, 0, 0.05),
                0 0 0 1px rgba(0, 0, 0, 0.01);
            overflow: hidden;
        }

        /* HEADER KARTU */
        .pelanggan-header {
            background: #ffffff;
            padding: 1.75rem 2rem;
            border-bottom: 1px solid #F1F5F9;
        }

        .form-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .form-subtitle {
            font-size: 0.85rem;
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
            color: #334155;
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
            height: 44px;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 8px 12px 8px 40px;
            font-size: 0.875rem;
            color: #334155;
            background-color: #F8FAFC;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input::placeholder {
            color: #94A3B8;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563EB;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .textarea-custom {
            height: auto !important;
            resize: none;
            padding-top: 10px;
        }

        /* FOOTER KARTU */
        .pelanggan-footer {
            background-color: #FAFCFE;
            border-top: 1px solid #F1F5F9;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        /* TOMBOL MODERN KONTEMPORER */
        .btn-custom {
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0 20px;
            height: 42px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-reset {
            background-color: #F1F5F9;
            color: #475569;
        }

        .btn-reset:hover {
            background-color: #E2E8F0;
            color: #1E293B;
        }

        .btn-simpan {
            background-color: #0F172A;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.2);
        }

        .btn-simpan:hover {
            background-color: #1E293B;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.25);
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
