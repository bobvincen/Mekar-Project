<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObatTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'nama_obat',
            'kategori',
            'supplier',
            'stok',
            'harga_jual',
            'tanggal_kadaluarsa',
            'gambar'
        ];
    }

    public function array(): array
    {
        return [
            [
                'Paracetamol 500mg',
                'Obat Demam',
                'PT Kimia Farma',
                100,
                5000,
                '2027-01-01',
                'paracetamol.jpg'
            ],
            [
                'Amoxicillin 250mg',
                'Herbal',
                'PT Kalbe Farma',
                50,
                10000,
                '2026-12-31',
                ''
            ]
        ];
    }
}
