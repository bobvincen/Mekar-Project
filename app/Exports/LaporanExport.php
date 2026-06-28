<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'Tanggal',
            'Pelanggan',
            'Kasir',
            'Jenis Transaksi',
            'Total Harga',
            'Status'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $tanggal = Carbon::parse($row->tanggal_transaksi)->format('Y-m-d H:i');
        $pelanggan = $row->pelanggan->nama_pelanggan ?? ($row->nama_pelanggan ?? 'Umum');
        $kasir = $row->user->name ?? '-';
        $jenis = $row->nama_pelanggan ? 'Online' : 'POS';
        $status = $row->user_id ? ($row->status === 'Dibatalkan' ? 'Dibatalkan' : 'Selesai') : $row->status;

        return [
            $no,
            $row->kode_transaksi,
            $tanggal,
            $pelanggan,
            $kasir,
            $jenis,
            (float) $row->total_harga,
            $status
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E3A8A'] // Navy Blue background for professional look
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                ]
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => '"Rp"#,##0',
        ];
    }
}
