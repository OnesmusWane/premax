<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaLibrary extends Model
{
    protected $table = 'media_library';

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /** Alias for blade template compatibility (GalleryItem used `image_url`). */
    public function getImageUrlAttribute(): string
    {
        return $this->url ?? '';
    }

    /** Alias for blade template compatibility (GalleryItem used `title`). */
    public function getTitleAttribute(): string
    {
        return $this->name ?? '';
    }
}
