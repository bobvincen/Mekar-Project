@extends('layouts.app')

@section('content')
    <div class="pelanggan-dashboard">
        <header class="dashboard-header text-center mb-4">
            <h2 class="dash-title">Manajemen Pengguna</h2>
            <p class="dash-subtitle">Kelola data hak akses member sistem apotek anda</p>
        </header>

        @if (session('success'))
            <div class="alert alert-custom animate-fade-in mb-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <section class="stat-section mb-4">
            <div class="stat-card">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total Pengguna</span>
                    <h3 class="stat-value">
                        {{ method_exists($pelanggan, 'total') ? $pelanggan->total() : $pelanggan->count() }}
                    </h3>
                </div>
            </div>
        </section>

        <section class="dash-card">
            <div class="card-top-bar">
                <h4 class="table-title">Daftar Pengguna</h4>

                <div class="action-wrapper">
                    <div class="filter-box">
                        <select id="roleFilter" class="form-control-filter" onchange="filterByRole()">
                            <option value="">— Semua Role —</option>
                            <option value="Admin">Admin</option>
                            <option value="Kasir">Kasir</option>
                            <option value="Pelanggan">Pelanggan</option>
                        </select>
                    </div>

                    <div class="search-box">
                        <span class="search-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" id="searchInput" placeholder="Cari nama atau No HP..."
                            class="form-control-search" onkeyup="searchTable()">
                    </div>

                    <a href="{{ route('pelanggan.create') }}" class="btn-add-data text-decoration-none">
                        <i class="fa-solid fa-plus"></i> <span>Tambah Pengguna</span>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table custom-dash-table align-middle mb-0" id="userTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">NO</th>
                            <th class="text-start" style="width: 250px;">NAMA</th>
                            <th class="text-start" style="width: 160px;">NO HP</th>
                            <th class="text-start">ALAMAT</th>
                            <th class="text-center" style="width: 140px;">ROLE</th>
                            <th class="text-center" style="width: 160px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggan as $index => $item)
                            @php
                                $currentRole = strtolower($item->role ?? 'pelanggan');
                            @endphp
                            <tr class="user-row" data-role="{{ ucfirst($currentRole) }}">
                                <td class="text-center id-column">
                                    {{ method_exists($pelanggan, 'firstItem') ? $pelanggan->firstItem() + $index : $index + 1 }}
                                </td>

                                <td class="text-start">
                                    <div class="customer-profile">
                                        <div class="avatar-icon avatar-{{ $currentRole }}">
                                            @if ($currentRole == 'admin')
                                                <i class="fa-solid fa-user-shield"></i>
                                            @elseif($currentRole == 'kasir')
                                                <i class="fa-solid fa-user-tie"></i>
                                            @else
                                                <i class="fa-solid fa-user"></i>
                                            @endif
                                        </div>
                                        <span class="customer-name text-truncate" title="{{ $item->nama_pelanggan }}">
                                            {{ $item->nama_pelanggan }}
                                        </span>
                                    </div>
                                </td>

                                <td class="text-start fw-medium text-secondary">
                                    {{ $item->no_hp }}
                                </td>

                                <td class="text-start text-muted text-wrap-address">
                                    {{ $item->alamat }}
                                </td>

                                <td class="text-center">
                                    <span class="badge-role bg-role-{{ $currentRole }}">
                                        {{ ucfirst($currentRole) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="action-buttons-group">
                                        <a href="{{ route('pelanggan.show', $item->id) }}" class="btn-action-icon view-btn"
                                            title="Lihat">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('pelanggan.edit', $item->id) }}" class="btn-action-icon edit-btn"
                                            title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('pelanggan.destroy', $item->id) }}" method="POST"
                                            class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon delete-btn"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-row-state text-center py-5">
                                    <i class="fa-solid fa-folder-open d-block mb-2 text-muted fs-3"></i>
                                    <span class="text-secondary fw-medium">Data Pengguna Belum Tersedia.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($pelanggan, 'links'))
                <div class="card-footer-bar">
                    <div class="footer-info">
                        Menampilkan <b>{{ $pelanggan->firstItem() ?? 0 }}</b> sampai
                        <b>{{ $pelanggan->lastItem() ?? 0 }}</b> dari <b>{{ $pelanggan->total() }}</b> pelanggan
                    </div>
                    <div class="footer-pagination">
                        {{ $pelanggan->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </section>
    </div>

    <script>
        function filterByRole() {
            let filter = document.getElementById("roleFilter").value;
            let rows = document.querySelectorAll(".user-row");

            rows.forEach(row => {
                let role = row.getAttribute("data-role");
                if (filter === "" || role === filter) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll(".user-row");

            rows.forEach(row => {
                let name = row.querySelector(".customer-name").innerText.toLowerCase();
                let phone = row.querySelector(".fw-medium").innerText.toLowerCase();

                if (name.includes(input) || phone.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>

    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        .pelanggan-dashboard {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            min-height: 100vh;
            color: #0F172A;
            padding: 1.5rem;
        }

        .dash-title {
            font-size: 1.625rem;
            font-weight: 700;
            color: #0F172A;
            letter-spacing: -0.02em;
        }

        .dash-subtitle {
            font-size: 0.875rem;
            color: #64748B;
            margin-top: 0.25rem;
        }

        .alert-custom {
            background-color: #F0FDF4;
            border: 1px solid #DCFCE7;
            color: #15803D;
            border-radius: 12px;
            padding: 0.875rem 1.2rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .alert-custom i {
            color: #16A34A;
            font-size: 1rem;
        }

        .stat-card {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            display: inline-flex;
            align-items: center;
            gap: 1.25rem;
            min-width: 280px;
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background-color: #EFF6FF;
            color: #2563EB;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748B;
            display: block;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            line-height: 1;
        }

        .dash-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .card-top-bar {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #F1F5F9;
            background: #ffffff;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
        }

        .action-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .form-control-filter {
            height: 40px;
            padding: 0 12px;
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #475569;
            font-weight: 500;
            outline: none;
            cursor: pointer;
        }

        .search-box {
            position: relative;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }

        .form-control-search {
            width: 240px;
            height: 40px;
            padding: 8px 12px 8px 38px;
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #334155;
        }

        .btn-add-data {
            background-color: #0F172A;
            color: #ffffff !important;
            font-size: 0.875rem;
            font-weight: 600;
            height: 40px;
            padding: 0 16px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .custom-dash-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-dash-table thead th {
            background-color: #F8FAFC;
            color: #475569;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #E2E8F0;
        }

        .custom-dash-table tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.875rem;
        }

        .id-column {
            font-weight: 500;
            color: #94A3B8;
        }

        .customer-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .customer-name {
            font-weight: 600;
            color: #1E293B;
            max-width: 180px;
            display: inline-block;
        }

        .text-wrap-address {
            max-width: 250px;
            white-space: normal;
            word-break: break-word;
        }

        .avatar-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .avatar-admin,
        .bg-role-admin {
            background-color: #FEE2E2;
            color: #DC2626;
        }

        .avatar-kasir,
        .bg-role-kasir {
            background-color: #EFF6FF;
            color: #2563EB;
        }

        .avatar-pelanggan,
        .bg-role-pelanggan {
            background-color: #F1F5F9;
            color: #475569;
        }

        .badge-role {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .action-buttons-group {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .btn-action-icon {
            width: 34px;
            height: 34px;
            background: #ffffff;
            border: 1px solid #E2E8F0;
            color: #64748B;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .card-footer-bar {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #ffffff;
            border-top: 1px solid #E2E8F0;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-info {
            font-size: 0.875rem;
            color: #64748B;
        }

        .footer-info b {
            color: #0F172A;
        }
    </style>
@endsection
