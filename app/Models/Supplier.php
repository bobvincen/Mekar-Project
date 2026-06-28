<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'telepon',
        'email',
        'kontak_pic',
        'kota',
        'keterangan',
    ];

    public function obats()
{
    return $this->hasMany(Obat::class);
}
}