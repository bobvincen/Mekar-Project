<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepDokterItem extends Model
{
    protected $fillable = [
        'resep_dokter_id',
        'obat_id',
        'qty',
        'status',
        'obat_pengganti_id',
        'catatan',
    ];

    public function resepDokter()
    {
        return $this->belongsTo(ResepDokter::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }

    public function obatPengganti()
    {
        return $this->belongsTo(Obat::class, 'obat_pengganti_id');
    }
}
