<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota - {{ $transaksi->kode_transaksi }}</title>
    <style>
        @page {
            margin: 8px;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 9px;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .header {
            margin-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 8px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }
        .meta-info {
            font-size: 8.5px;
            margin-bottom: 4px;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 1px 0;
            vertical-align: top;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .items-table th {
            border-bottom: 1px dashed #000;
            padding: 3px 0;
            font-size: 8.5px;
            text-align: left;
        }
        .items-table td {
            padding: 4px 0;
            font-size: 8.5px;
            vertical-align: top;
            page-break-inside: avoid;
        }
        .totals-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .totals-table td {
            padding: 2px 0;
            font-size: 8.5px;
        }
        .footer {
            margin-top: 12px;
            font-size: 8px;
            line-height: 1.3;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="header text-center">
        <h1>Mekar Pharmacy</h1>
        <p>Jl. Raya Kopo No. 123, Bandung</p>
        <p>Tel: (022) 543-2109 | WA: 0812-3456-7890</p>
        <p>Email: info@mekarpharmacy.com</p>
    </div>

    <div class="divider"></div>

    <!-- Meta Info Section -->
    <div class="meta-info">
        <table class="meta-table">
            <tr>
                <td width="35%">No. Nota:</td>
                <td class="bold">{{ $transaksi->kode_transaksi }}</td>
            </tr>
            <tr>
                <td>Tanggal:</td>
                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Pelanggan:</td>
                <td>{{ $transaksi->pelanggan->nama_pelanggan ?? 'Pelanggan Umum' }}</td>
            </tr>
            <tr>
                <td>Kasir:</td>
                <td>{{ $transaksi->user->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="divider"></div>

    <!-- Items Table Section -->
    <table class="items-table">
        <thead>
            <tr>
                <th width="50%">Nama Obat</th>
                <th width="15%" class="text-center">Qty</th>
                <th width="35%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksis as $detail)
                <tr>
                    <td>
                        {{ $detail->obat->nama_obat ?? '-' }}
                        <div style="font-size: 7.5px; color: #555;">
                            @ Rp {{ number_format($detail->harga, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="text-center" style="vertical-align: middle;">{{ $detail->jumlah }}</td>
                    <td class="text-right" style="vertical-align: middle;">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <!-- Totals Section -->
    <table class="totals-table">
        <tr>
            <td width="60%" class="bold">Total Belanja:</td>
            <td width="40%" class="text-right bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Pembayaran Tunai:</td>
            <td class="text-right">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
        </tr>
        <tr class="bold">
            <td>Kembalian:</td>
            <td class="text-right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Footer Section -->
    <div class="footer text-center">
        <p class="bold">** LEKAS SEMBUH **</p>
        <p>Terima kasih telah berbelanja di Mekar Pharmacy.</p>
        <p>Struk ini merupakan bukti pembayaran sah.</p>
    </div>

</body>
</html>
