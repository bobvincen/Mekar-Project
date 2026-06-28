<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 12px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #1d4ed8;
        }
        .header p {
            margin: 4px 0 0;
            font-size: 11px;
            color: #6b7280;
        }
        .info-row {
            margin-bottom: 14px;
            font-size: 11px;
        }
        .info-row strong {
            color: #374151;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead tr {
            background-color: #2563eb;
            color: #ffffff;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            font-size: 10px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tfoot tr {
            background-color: #eff6ff;
            font-weight: bold;
        }
        .footer {
            margin-top: 24px;
            font-size: 9px;
            color: #9ca3af;
            text-align: right;
        }
        .summary {
            margin-top: 16px;
            margin-bottom: 16px;
            width: 100%;
        }
        .summary td {
            border: none;
            padding: 4px 8px;
        }
        .summary .box {
            background-color: #f3f4f6;
            border-radius: 4px;
            padding: 8px 12px;
        }
        .summary .label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
        }
        .summary .value {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN TRANSAKSI PENJUALAN</h1>
        <p>Mekar Pharmacy</p>
        <p>
            Periode:
            {{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }}
            &mdash;
            {{ \Carbon\Carbon::parse($tanggal_selesai)->translatedFormat('d F Y') }}
        </p>
    </div>

    <table class="summary">
        <tr>
            <td width="33%">
                <div class="box">
                    <div class="label">Total Transaksi</div>
                    <div class="value">{{ $totalTransaksi }}</div>
                </div>
            </td>
            <td width="33%">
                <div class="box">
                    <div class="label">Total Pendapatan</div>
                    <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
            </td>
            <td width="34%">
                <div class="box">
                    <div class="label">Rata-rata per Transaksi</div>
                    <div class="value">
                        Rp {{ number_format($totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0, 0, ',', '.') }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="16%">Kode Transaksi</th>
                <th width="10%">Tanggal</th>
                <th width="20%">Pelanggan</th>
                <th width="16%" class="text-right">Total Harga</th>
                <th width="16%" class="text-right">Bayar</th>
                <th width="18%" class="text-right">Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $t)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $t->kode_transaksi }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                <td>{{ $t->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                <td class="text-right">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($t->kembalian, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data transaksi pada periode ini</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($totalHargaSum, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalBayarSum, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalKembalianSum, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

</body>
</html>