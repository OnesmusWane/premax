<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'reference',
        'service_id',
        'vehicle_id',
        'scheduled_at',
        'customer_id',
        'booking_source_id',
        'booking_status_id',
        'cancellation_reason',
        'customer_notes',
        'staff_notes',
    ];

    protected $casts = [
       'scheduled_at' => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

     public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

     public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
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