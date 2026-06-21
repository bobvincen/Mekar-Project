<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'waktu',
        'sumber',
        'ip_pengunjung'
    ];
    
    // Disable laravel's default created_at / updated_at if we use 'waktu' explicitly
    // Or we can just use the default timestamps, but user requested 'waktu'
    public $timestamps = false;
}
