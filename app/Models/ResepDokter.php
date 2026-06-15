<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepDokter extends Model
{
    protected $fillable = [
        'nama',
        'whatsapp',
        'catatan',
        'foto_resep',
    ];
}
