<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class WorkCase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'category', 'service_type', 'before_image', 'after_image',
        'brief', 'challenge', 'outcome', 'duration_days', 'completed_at',
        'client_type', 'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'completed_at' => 'date',
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(WorkCaseStep::class)->orderBy('step_number');
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(WorkCaseMetric::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(WorkCaseGallery::class)->orderBy('sort_order');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'detailing'   => 'Detailing',
            'performance' => 'Performance',
            'bodywork'    => 'Bodywork',
            'diagnostics' => 'Diagnostics',
            default       => ucfirst($this->category),
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getAfterImageUrlAttribute(): ?string
    {
        return $this->after_image
            ? (Str::startsWith($this->after_image, ['http://', 'https://']) ? $this->after_image : asset($this->after_image))
            : null;
    }

    public function getBeforeImageUrlAttribute(): ?string
    {
        return $this->before_image
            ? (Str::startsWith($this->before_image, ['http://', 'https://']) ? $this->before_image : asset($this->before_image))
            : null;
    }
}
