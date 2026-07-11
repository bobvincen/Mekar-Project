<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Mekar Pharmacy</title>
    <style>
        @page {
            size: a4 portrait;
            margin: 1.5cm 1.2cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 8.5pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        
        /* Page footer template - repeats on all pages */
        .page-footer {
            position: fixed;
            bottom: -0.9cm;
            left: 0;
            right: 0;
            height: 15px;
            font-size: 7.5pt;
            color: #64748b;
            border-top: 0.5px solid #cbd5e1;
            padding-top: 4px;
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

        /* Header styling */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .logo-container {
            vertical-align: middle;
        }
        .logo-plus {
            background-color: #ef4444;
            color: #ffffff;
            font-size: 13pt;
            font-weight: bold;
            padding: 2px 7px;
            border-radius: 3px;
            margin-right: 4px;
            font-family: monospace;
        }
        .logo-text {
            font-size: 15pt;
            font-weight: 800;
            color: #1e3a8a;
        }
        .header-subtext {
            font-size: 7.5pt;
            color: #64748b;
            margin-top: 3px;
        }
        .header-right {
            text-align: right;
            vertical-align: middle;
        }
        .report-title {
            font-size: 13pt;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .report-period {
            font-size: 8pt;
            color: #475569;
            margin-top: 3px;
        }

        /* Divider line */
        .divider {
            border-top: 1px solid #cbd5e1;
            margin-bottom: 12px;
        }

        /* Main Data Table */
        .data-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table thead {
            display: table-header-group;
        }
        .data-table th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 7.5pt;
            padding: 5px 6px;
            border: 0.5px solid #1e3a8a;
            letter-spacing: 0.3px;
        }
        .data-table td {
            padding: 4px 6px;
            border: 0.5px solid #cbd5e1;
            vertical-align: middle;
            font-size: 7.5pt;
        }
        .data-table tr {
            page-break-inside: avoid;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
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
        
        /* Colored text styles (high-performance) */
        .text-pos {
            color: #2563eb;
            font-weight: bold;
        }
        .text-online {
            color: #9333ea;
            font-weight: bold;
        }
        .text-success {
            color: #16a34a;
            font-weight: bold;
        }
        .text-danger {
            color: #dc2626;
            font-weight: bold;
        }
        .text-warning {
            color: #d97706;
            font-weight: bold;
        }

        /* Summary Section at the End */
        .summary-title {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #1e3a8a;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
            margin-bottom: 8px;
            margin-top: 15px;
            page-break-inside: avoid;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }
        .summary-card {
            background-color: #f8fafc;
            border: 0.5px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 12px;
            text-align: center;
        }
        .summary-card-title {
            font-size: 7.5pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .summary-card-value {
            font-size: 11pt;
            font-weight: 800;
            color: #0f172a;
        }
    </style>
</head>
<body>

    <!-- Static Page-Footer to repeat on all pages -->
    <div class="page-footer">
        <div class="footer-left">
            Dicetak oleh: <strong>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</strong> pada <strong>{{ now()->translatedFormat('d F Y') }}</strong> jam <strong>{{ now()->translatedFormat('H:i') }}</strong> WIB
        </div>
        <div class="footer-right">
            Halaman <span class="page-num"></span>
        </div>
    </div>

    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td width="50%">
                <div class="logo-container">
                    <span class="logo-plus">+</span>
                    <span class="logo-text">MEKAR PHARMACY</span>
                </div>
                <div class="header-subtext">Jl. Raya Kopo No. 123, Bandung | Tel: (022) 543-2109</div>
            </td>
            <td width="50%" class="header-right">
                <div class="report-title">Laporan Penjualan</div>
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
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="18%">Kode Transaksi</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Pelanggan</th>
                <th width="15%">Kasir</th>
                <th width="8%">Jenis</th>
                <th class="text-right" width="12%">Total</th>
                <th class="text-center" width="7%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $t)
                @php
                    $tanggal = \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y H:i');
                    $pelanggan = $t->pelanggan->nama_pelanggan ?? ($t->nama_pelanggan ?? 'Umum');
                    $kasir = $t->user->name ?? '-';
                    $jenis = $t->nama_pelanggan ? 'Online' : 'POS';
                    $status = $t->user_id ? ($t->status === 'Dibatalkan' ? 'Dibatalkan' : 'Selesai') : $t->status;
                @endphp
                <tr>
                    <td class="text-center" style="color: #64748b; font-weight: bold;">{{ $loop->iteration }}</td>
                    <td class="font-mono text-pos">{{ $t->kode_transaksi }}</td>
                    <td style="color: #475569;">{{ $tanggal }}</td>
                    <td style="font-weight: bold; color: #0f172a;">{{ $pelanggan }}</td>
                    <td style="color: #334155;">{{ $kasir }}</td>
                    <td class="text-center">
                        <span class="text-{{ $t->nama_pelanggan ? 'online' : 'pos' }}">
                            {{ $jenis }}
                        </span>
                    </td>
                    <td class="text-right" style="font-weight: bold; color: #0f172a;">
                        Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <span class="text-{{ $status === 'Selesai' ? 'success' : ($status === 'Dibatalkan' || $status === 'Ditolak' ? 'danger' : 'warning') }}">
                            {{ $status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 15px; color: #94a3b8; font-weight: bold;">
                        Tidak ada data transaksi yang sesuai filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($transaksis->count() > 0)
        <tfoot>
            <tr style="background-color: #f8fafc; font-weight: bold;">
                <td colspan="6" class="text-right" style="padding: 5px 6px; border: 0.5px solid #cbd5e1;">Total Keseluruhan</td>
                <td class="text-right" style="padding: 5px 6px; border: 0.5px solid #cbd5e1; color: #1e3a8a;">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </td>
                <td style="border: 0.5px solid #cbd5e1;"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Summary KPI Block at the end of report -->
    <div class="summary-title">Ringkasan Laporan</div>
    <table class="summary-table">
        <tr>
            <td class="summary-card" width="30%">
                <div class="summary-card-title">Total Transaksi</div>
                <div class="summary-card-value">{{ $totalTransaksi }}</div>
            </td>
            <td width="5%"></td>
            <td class="summary-card" width="30%">
                <div class="summary-card-title">Total Omzet</div>
                <div class="summary-card-value" style="color: #16a34a;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </td>
            <td width="5%"></td>
            <td class="summary-card" width="30%">
                <div class="summary-card-title">Rata-rata Transaksi</div>
                <div class="summary-card-value">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

</body>
</html>
