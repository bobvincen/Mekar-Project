<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori_id',
        'supplier_id',
        'kode_obat',
        'nama_obat',
        'stok',
        'harga_jual',
        'tanggal_kadaluarsa',
        'deskripsi',
        'image_path'
    ];

    public function getImageUrlAttribute()
    {
        try {
            if ($this->image_path) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->image_path)) {
                    return \Illuminate\Support\Facades\Storage::disk('public')->url($this->image_path);
                } else {
                    \Illuminate\Support\Facades\Log::warning("File gambar obat tidak ditemukan di storage: " . $this->image_path, [
                        'obat_id' => $this->id,
                        'nama_obat' => $this->nama_obat
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Gagal mendapatkan URL gambar obat: " . $e->getMessage(), [
                'obat_id' => $this->id,
                'image_path' => $this->image_path,
                'exception' => $e
            ]);
        }

        // Fallback premium berdasarkan kategori
        $kategoriName = strtolower($this->kategori->nama_kategori ?? '');
        if (str_contains($kategoriName, 'vitamin')) {
            return asset('premium_supplement_bottle.png');
        }
        return asset('premium_medicine_box.png');
    }

    public function getImageAttribute()
    {
        return $this->image_url;
    }

    public function getGambarAttribute()
    {
        return $this->image_url;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}