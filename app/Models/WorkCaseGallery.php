<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class WorkCaseGallery extends Model
{
    protected $table = 'work_case_gallery';

    protected $fillable = ['work_case_id', 'image_path', 'caption', 'sort_order'];

    public function workCase(): BelongsTo
    {
        return $this->belongsTo(WorkCase::class);
    }

    public function getImageUrlAttribute(): string
    {
        return Str::startsWith($this->image_path, ['http://', 'https://'])
            ? $this->image_path
            : asset($this->image_path);
    }
}
