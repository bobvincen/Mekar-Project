<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepDokter extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'whatsapp',
        'catatan',
        'foto_resep',
        'status',
        'catatan_verifikasi',
        'catatan_revisi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ResepDokterItem::class);
    }
}
