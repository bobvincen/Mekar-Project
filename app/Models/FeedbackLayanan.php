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
        'transaksi_id',
        'user_id',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
