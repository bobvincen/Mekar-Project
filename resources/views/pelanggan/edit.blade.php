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
                    <h3 class="form-title">Edit Data Pengguna</h3>
                    <p class="form-subtitle">Perbarui detail informasi pengguna yang tersimpan dalam sistem apotek</p>
                </div>

                <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST" id="formPelanggan">
                    @csrf
                    @method('PUT')

                    <div class="pelanggan-body">
                        <div class="form-group mb-4">
                            <label class="form-label-custom">Nama Pengguna <span style="color: #EF4444;">*</span></label>
                            <div class="input-icon-wrapper">
                                <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="nama_pelanggan"
                                    class="form-input @error('nama_pelanggan') is-invalid @enderror"
                                    value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}"
                                    placeholder="Masukkan nama lengkap pengguna" required>
                            </div>
                            @error('nama_pelanggan')
                                <div class="text-danger small-error-msg mt-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Nomor Handphone (HP) <span style="color: #EF4444;">*</span></label>
                            <div class="input-icon-wrapper">
                                <span class="input-icon"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="no_hp" class="form-input @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp', $pelanggan->no_hp) }}" placeholder="Contoh: 081234567890"
                                    required>
                            </div>
                            @error('no_hp')
                                <div class="text-danger small-error-msg mt-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label-custom">Alamat Tempat Tinggal <span style="color: #EF4444;">*</span></label>
                            <div class="input-icon-wrapper align-items-start">
                                <span class="input-icon mt-2.5"><i class="fa-solid fa-location-dot"></i></span>
                                <textarea name="alamat" class="form-input textarea-custom @error('alamat') is-invalid @enderror" rows="4"
                                    placeholder="Masukkan alamat lengkap rumah saat ini..." required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                            </div>
                            @error('alamat')
                                <div class="text-danger small-error-msg mt-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label-custom">Role / Hak Akses <span style="color: #EF4444;">*</span></label>
                            <div class="input-icon-wrapper">
                                <span class="input-icon"><i class="fa-solid fa-user-shield"></i></span>
                                <select name="role" class="form-input @error('role') is-invalid @enderror"
                                    style="padding-top: 2px;" required>
                                    <option value="" disabled>— Pilih Hak Akses —</option>
                                    <option value="Admin" {{ old('role', $pelanggan->role) == 'Admin' ? 'selected' : '' }}>
                                        Admin Apotek</option>
                                    <option value="Kasir" {{ old('role', $pelanggan->role) == 'Kasir' ? 'selected' : '' }}>
                                        Kasir / Staff</option>
                                    <option value="Pelanggan"
                                        {{ old('role', $pelanggan->role) == 'Pelanggan' ? 'selected' : '' }}>Pelanggan /
                                        Member</option>
                                </select>
                            </div>
                            @error('role')
                                <div class="text-danger small-error-msg mt-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="pelanggan-footer">
                        <a href="{{ url('pelanggan') }}" class="btn-custom btn-batal text-decoration-none">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </a>
                        <button type="submit" class="btn-custom btn-simpan">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
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

        /* KARTU TIMBUL (RAISED CARD) */
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

        /* STYLE STRUKTUR VALIDASI ERROR BERWARNA MERAH */
        .form-input.is-invalid {
            border-color: #EF4444 !important;
            background-color: #FEF2F2 !important;
        }

        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
        }

        .small-error-msg {
            font-size: 0.775rem;
            font-weight: 500;
            color: #EF4444;
            display: flex;
            align-items: center;
            gap: 4px;
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
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-batal {
            background-color: #F1F5F9;
            color: #475569;
        }

        .btn-batal:hover {
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
@endsection
