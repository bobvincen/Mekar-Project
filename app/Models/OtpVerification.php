<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtpVerification extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'expired_at',
        'verified_at',
        'attempts',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the OTP verification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
