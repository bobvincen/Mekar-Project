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
            'nama_kontak',
            'telepon_supplier',
            'email_supplier',
            'kota',
            'alamat_supplier',
            'keterangan_supplier',
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
                'Budi Santoso',
                '081234567890',
                'kimiafarma@example.com',
                'Jakarta',
                'Jl. Kebon Jeruk No. 12',
                'Distributor Utama',
                100,
                5000,
                '2027-01-01',
                'paracetamol.jpg'
            ],
            [
                'Amoxicillin 250mg',
                'Herbal',
                'PT Kalbe Farma',
                '',
                '',
                '',
                '',
                '',
                '',
                50,
                10000,
                '2026-12-31',
                ''
            ]
        ];
    }
}
