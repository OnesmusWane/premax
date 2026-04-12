<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class FeedbackToken extends Model
{
    protected $fillable = [
        'token', 'customer_name', 'customer_phone',
        'vehicle_reg', 'service', 'used', 'expires_at',
    ];

    protected $casts = [
        'used'       => 'boolean',   // ensures DB tinyint(1) → true/false
        'expires_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────

    public function feedback(): HasOne
    {
        return $this->hasOne(CustomerFeedback::class);
    }

    // ── Helpers ────────────────────────────────────

    public static function generate(array $prefill = []): self
    {
        return self::create(array_merge([
            'token'      => Str::random(48),
            'used'       => false,
            'expires_at' => now()->addDays(7),
        ], $prefill));
    }

    public function isValid(): bool
    {
        // used is cast to bool — double-check with === false to be explicit
        if ($this->used === true) {
            return false;
        }

        if ($this->expires_at !== null && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }
}