<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'service_id',
        'service_name',
        'vehicle_reg',
        'vehicle_make_model',
        'booking_date',
        'booking_time',
        'scheduled_at',
        'customer_name',
        'customer_phone',
        'customer_email',
        'source',
        'status',
        'cancellation_reason',
        'customer_notes',
        'staff_notes',
        'estimated_duration_minutes',
        'price_quoted',
        'price_charged',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'booking_date'  => 'date',
        'scheduled_at'  => 'datetime',
        'confirmed_at'  => 'datetime',
        'completed_at'  => 'datetime',
        'cancelled_at'  => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopePending($query)   { return $query->where('status', 'pending'); }
    public function scopeConfirmed($query) { return $query->where('status', 'confirmed'); }
    public function scopeCompleted($query) { return $query->where('status', 'completed'); }
    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed'])
                     ->where('scheduled_at', '>=', now());
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Generate a human-readable booking reference.
     * e.g.  PX-20240115-0042
     */
    public static function generateReference(): string
    {
        $date    = now()->format('Ymd');
        $last    = static::whereDate('created_at', today())->count() + 1;
        return sprintf('PX-%s-%04d', $date, $last);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'yellow',
            'confirmed'   => 'blue',
            'in_progress' => 'orange',
            'completed'   => 'green',
            'cancelled'   => 'red',
            'no_show'     => 'gray',
            default       => 'gray',
        };
    }
}