<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'pelanggan_id',
        'tanggal_transaksi',
        'total_harga',
        'bayar',
        'kembalian',
        
        // Marketplace fields
        'nama_pelanggan',
        'whatsapp',
        'alamat',
        'metode_pengambilan',
        'latitude',
        'longitude',
        'jarak',
        'ongkir',
        'subtotal',
        'catatan',
        'status',
        'bukti_transfer',
        'verifikasi_catatan',
        'verifikator_id',
        'tanggal_verifikasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    
}
