<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackLayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'whatsapp',
        'rating',
        'komentar',
    ];
}
