<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $transaksi->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            background-color: #fff;
        }
        .header-table, .info-table, .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header-table td {
            vertical-align: top;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #0284c7;
        }
        .title {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #475569;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info-label {
            color: #64748b;
            font-weight: bold;
            width: 120px;
        }
        .items-table th {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            color: #475569;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .total-row td {
            border-top: 2px solid #e2e8f0;
            font-weight: bold;
            padding-top: 15px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .status-pending { background-color: #fef3c7; color: #d97706; }
        .status-process { background-color: #dbeafe; color: #2563eb; }
        .status-success { background-color: #d1fae5; color: #059669; }
        .status-danger { background-color: #fee2e2; color: #dc2626; }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td>
                <div class="logo">Mekar Pharmacy</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Apotek & Obat Terpercaya Anda</div>
            </td>
            <td>
                <div class="title">INVOICE</div>
                <div style="text-align: right; font-size: 12px; color: #64748b; margin-top: 4px;">
                    Invoice ID: <strong>{{ $transaksi->kode_transaksi }}</strong>
                </div>
            </td>
        </tr>
    </table>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;">

    <!-- Info Section -->
    <table class="info-table">
        <tr>
            <td style="width: 50%;">
                <h4 style="margin: 0 0 8px 0; color: #475569;">Informasi Pemesan:</h4>
                <table>
                    <tr>
                        <td class="info-label">Nama:</td>
                        <td>{{ $transaksi->nama_pelanggan }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">WhatsApp:</td>
                        <td>{{ $transaksi->whatsapp }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Metode:</td>
                        <td>{{ $transaksi->metode_pengambilan }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <h4 style="margin: 0 0 8px 0; color: #475569;">Detail Transaksi:</h4>
                <table>
                    <tr>
                        <td class="info-label">Tanggal:</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Status:</td>
                        <td>
                            @php
                                $statusClass = match($transaksi->status) {
                                    'Menunggu Pembayaran', 'Menunggu Verifikasi' => 'status-pending',
                                    'Diproses', 'Siap Diambil', 'Sedang Diantar' => 'status-process',
                                    'Selesai' => 'status-success',
                                    'Ditolak', 'Dibatalkan' => 'status-danger',
                                    default => 'status-pending'
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $transaksi->status }}</span>
                        </td>
                    </tr>
                    @if($transaksi->metode_pengambilan != 'Ambil di Apotek')
                    <tr>
                        <td class="info-label">Alamat:</td>
                        <td>{{ $transaksi->alamat }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <br>

    <!-- Items Section -->
    <table class="items-table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th class="text-center" style="width: 100px;">Harga Satuan</th>
                <th class="text-center" style="width: 60px;">Jumlah</th>
                <th class="text-right" style="width: 120px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksis as $detail)
            <tr>
                <td>
                    <strong>{{ $detail->obat->nama_obat ?? 'Produk tidak ditemukan' }}</strong>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                        Kategori: {{ $detail->obat->kategori->nama_kategori ?? '-' }}
                    </div>
                </td>
                <td class="text-center">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td class="text-center">{{ $detail->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            <!-- Summary Rows -->
            <tr>
                <td colspan="2"></td>
                <td class="text-center" style="font-weight: bold; padding-top: 15px;">Subtotal:</td>
                <td class="text-right" style="font-weight: bold; padding-top: 15px;">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="text-center" style="font-weight: bold;">Ongkir:</td>
                <td class="text-right" style="font-weight: bold;">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2"></td>
                <td class="text-center" style="font-size: 16px; color: #0284c7;">TOTAL:</td>
                <td class="text-right" style="font-size: 16px; color: #0284c7;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Terima kasih telah berbelanja di Mekar Pharmacy.</p>
        <p>Layanan Pelanggan: +62 822-4043-2990 | mekar-pharmacy@support.com</p>
    </div>
</div>

</body>
</html>
