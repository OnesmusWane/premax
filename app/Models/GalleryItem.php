<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class GalleryItem extends Model
{
    protected $fillable = [
        'title', 'alt_text', 'description', 'image_path',
        'is_published', 'sort_order', 'user_id', 'service_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    // ── Relationships ────────────────────────────

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessors ────────────────────────────────

    /** Full public URL for the image */
    public function getImageUrlAttribute(): string
    {
        $path = (string) $this->image_path;

        if ($path === '') {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return rtrim(config('app.media_base_url'), '/') . '/' . ltrim($path, '/');
    }
}


// ════════════════════════════════════════════════
// ADD to routes/web.php
// ════════════════════════════════════════════════

// Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery');
