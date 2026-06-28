<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'role', 'whatsapp'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'pelanggan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the dashboard URL based on user permissions.
     */
    public function getDashboardUrl(): string
    {
        if ($this->can('Lihat User')) {
            return route('dashboard', absolute: false);
        }
        if ($this->can('Verifikasi Resep')) {
            return route('apoteker.dashboard', absolute: false);
        }
        if ($this->can('Lihat Transaksi')) {
            return route('kasir.dashboard', absolute: false);
        }
        if ($this->can('Dashboard')) {
            return route('dashboard', absolute: false);
        }
        return '/marketplace';
    }
}
