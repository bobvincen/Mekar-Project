<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'no_hp',
        'alamat',
        'role'
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
