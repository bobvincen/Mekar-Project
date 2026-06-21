@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="pelanggan-card">
            <div class="pelanggan-header">
                <h3>Detail Pengguna</h3>
                <p>ID Pengguna: #{{ $pelanggan->id }}</p>
            </div>

            <div class="pelanggan-body">
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Nama Lengkap</label>
                    <p class="fs-5 fw-bold m-0">{{ $pelanggan->nama_pelanggan }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Nomor HP</label>
                    <p class="fs-5 m-0">{{ $pelanggan->no_hp }}</p>
                </div>

                <div class="mb-1">
                    <label class="text-muted small fw-bold text-uppercase">Alamat</label>
                    <p class="m-0 text-secondary">{{ $pelanggan->alamat }}</p>
                </div>
            </div>

            <div class="pelanggan-footer">
                <a href="{{ url('pelanggan') }}" class="btn btn-batal text-decoration-none">Kembali</a>
                <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-edit text-decoration-none">Edit
                    Data</a>
            </div>
        </div>
    </div>

    <style>
        /* KARTU TIMBUL MINIMALIS */
        .pelanggan-card {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .pelanggan-header {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .pelanggan-header h3 {
            margin: 0;
            font-weight: 700;
            color: #0f172a;
        }

        .pelanggan-header p {
            margin: 4px 0 0;
            color: #94a3b8;
            font-size: 14px;
        }

        .pelanggan-body {
            padding: 20px;
        }

        .pelanggan-footer {
            padding: 15px 20px;
            background: #fafcfe;
            border-top: 1px solid #f1f5f9;
            text-align: right;
        }

        /* TOMBOL */
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
        }

        .btn-batal {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-batal:hover {
            background: #e2e8f0;
        }

        .btn-edit {
            background: #0f172a;
            color: #ffffff;
            margin-left: 8px;
        }

        .btn-edit:hover {
            background: #1e293b;
            color: #ffffff;
        }
    </style>
@endsection
