<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Mekar Pharmacy</title>
    <style>
        @page {
            size: a4 landscape;
            margin: 1.2cm 1.5cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1f2937;
            font-size: 9pt;
            line-height: 1.4;
        }
        /* Header styling */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-logo-text {
            font-size: 22pt;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: -0.5px;
            line-height: 1;
        }
        .header-subtext {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 3px;
        }
        .header-right {
            text-align: right;
            font-size: 8pt;
            color: #4b5563;
        }
        .header-right strong {
            color: #1f2937;
        }
        /* Report Title */
        .report-title-container {
            margin-bottom: 20px;
        }
        .report-title {
            font-size: 14pt;
            font-weight: 700;
            color: #111827;
            margin: 0;
            text-transform: uppercase;
        }
        .report-period {
            font-size: 9pt;
            color: #4b5563;
            margin-top: 2px;
        }
        /* Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .data-table th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 7.5pt;
            padding: 8px 10px;
            border: 1px solid #1e3a8a;
            letter-spacing: 0.5px;
        }
        .data-table td {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
        }
        .data-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-mono {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 7.5pt;
            font-weight: bold;
            border-radius: 4px;
            text-align: center;
        }
        .badge-pos {
            background-color: #eff6ff;
            color: #1e40af;
        }
        .badge-online {
            background-color: #faf5ff;
            color: #6b21a8;
        }
        .badge-success {
            background-color: #ecfdf5;
            color: #065f46;
        }
        .badge-danger {
            background-color: #fef2f2;
            color: #991b1b;
        }
        .badge-warning {
            background-color: #fffbeb;
            color: #92400e;
        }
        /* Summary Section */
        .summary-table {
            width: 100%;
            margin-top: 15px;
        }
        .summary-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 15px;
            text-align: center;
            width: 18%;
        }
        .summary-card-title {
            font-size: 7.5pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .summary-card-value {
            font-size: 13pt;
            font-weight: 800;
            color: #0f172a;
        }
        /* Footer/Sign-off */
        .footer {
            position: fixed;
            bottom: -0.6cm;
            left: 0;
            right: 0;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            font-size: 7.5pt;
            color: #9ca3af;
        }
        .footer-left {
            float: left;
        }
        .footer-right {
            float: right;
            text-align: right;
        }
        .footer-right .page-num:after {
            content: counter(page);
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td>
                <div class="header-logo-text">MEKAR PHARMACY</div>
                <div class="header-subtext">Sistem Manajemen Apotek dan Distribusi Obat Terbaik</div>
            </td>
            <td class="header-right">
                Aplikasi: <strong>Mekar Pharmacy App</strong><br>
                Tanggal Cetak: <strong>{{ now()->translatedFormat('d F Y H:i') }}</strong>
            </td>
        </tr>
    </table>

    <!-- Title -->
    <div class="report-title-container">
        <h2 class="report-title">Laporan Penjualan Penjualan Obat</h2>
        <div class="report-period">
            Periode: 
            @if($request->filled('start_date') && $request->filled('end_date'))
                <strong>{{ \Carbon\Carbon::parse($request->start_date)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($request->end_date)->translatedFormat('d F Y') }}</strong>
            @elseif($request->filled('start_date'))
                Mulai <strong>{{ \Carbon\Carbon::parse($request->start_date)->translatedFormat('d F Y') }}</strong>
            @elseif($request->filled('end_date'))
                Sampai <strong>{{ \Carbon\Carbon::parse($request->end_date)->translatedFormat('d F Y') }}</strong>
            @else
                <strong>Semua Periode (Keseluruhan)</strong>
            @endif
        </div>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Kode Transaksi</th>
                <th width="13%">Tanggal</th>
                <th width="18%">Pelanggan</th>
                <th width="15%">Kasir</th>
                <th width="10%">Jenis</th>
                <th class="text-right" width="13%">Total Harga</th>
                <th class="text-center" width="12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $t)
                @php
                    $tanggal = \Carbon\Carbon::parse($t->tanggal_transaksi)->translatedFormat('d M Y H:i');
                    $pelanggan = $t->pelanggan->nama_pelanggan ?? ($t->nama_pelanggan ?? 'Umum');
                    $kasir = $t->user->name ?? '-';
                    $jenis = $t->nama_pelanggan ? 'Online' : 'POS';
                    $status = $t->user_id ? ($t->status === 'Dibatalkan' ? 'Dibatalkan' : 'Selesai') : $t->status;
                @endphp
                <tr>
                    <td class="text-center" style="color: #6b7280; font-weight: bold;">{{ $loop->iteration }}</td>
                    <td class="font-mono" style="color: #2563eb;">{{ $t->kode_transaksi }}</td>
                    <td style="color: #4b5563;">{{ $tanggal }}</td>
                    <td style="font-weight: bold; color: #111827;">{{ $pelanggan }}</td>
                    <td>{{ $kasir }}</td>
                    <td class="text-center">
                        <span class="badge {{ $t->nama_pelanggan ? 'badge-online' : 'badge-pos' }}">
                            {{ $jenis }}
                        </span>
                    </td>
                    <td class="text-right" style="font-weight: bold; color: #111827;">
                        Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $status === 'Selesai' ? 'badge-success' : ($status === 'Dibatalkan' || $status === 'Ditolak' ? 'badge-danger' : 'badge-warning') }}">
                            {{ $status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #9ca3af;">
                        Tidak ada data transaksi yang sesuai filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary KPI Block -->
    <h3 style="font-size: 10pt; font-weight: bold; text-transform: uppercase; color: #1e3a8a; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 10px;">Ringkasan Data Laporan</h3>
    <table class="summary-table">
        <tr>
            <td class="summary-card">
                <div class="summary-card-title">Jumlah Transaksi</div>
                <div class="summary-card-value">{{ $totalTransaksi }}</div>
            </td>
            <td width="2%"></td>
            <td class="summary-card">
                <div class="summary-card-title">Total Pendapatan</div>
                <div class="summary-card-value" style="color: #059669;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </td>
            <td width="2%"></td>
            <td class="summary-card">
                <div class="summary-card-title">Rata-rata Transaksi</div>
                <div class="summary-card-value">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
            </td>
            <td width="2%"></td>
            <td class="summary-card">
                <div class="summary-card-title">Transaksi Selesai</div>
                <div class="summary-card-value" style="color: #2563eb;">{{ $totalSelesai }}</div>
            </td>
            <td width="2%"></td>
            <td class="summary-card">
                <div class="summary-card-title">Transaksi Dibatalkan</div>
                <div class="summary-card-value" style="color: #dc2626;">{{ $totalDibatalkan }}</div>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-left">
            Dicetak oleh: <strong>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</strong> pada {{ now()->translatedFormat('l, d F Y H:i') }}
        </div>
        <div class="footer-right">
            Halaman <span class="page-num"></span>
        </div>
    </div>

</body>
</html>
