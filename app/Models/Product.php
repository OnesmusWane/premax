<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'category', 'description', 'long_description',
        'features', 'gallery', 'price', 'sale_price',
        'image', 'is_featured', 'is_sold_out', 'is_active',
        'sort_order', 'stock_qty', 'reorder_level',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'sale_price'  => 'decimal:2',
        'is_featured' => 'boolean',
        'is_sold_out' => 'boolean',
        'is_active'   => 'boolean',
        'features'    => 'array',
        'gallery'     => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'care_kits'   => 'Care Kits',
            'accessories' => 'Accessories',
            'apparel'     => 'Apparel',
            'lifestyle'   => 'Lifestyle',
            default       => ucfirst($this->category),
        };
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->sale_price ?? $this->price);
    }

    public function getGalleryImagesAttribute(): array
    {
        $g = $this->gallery ?? [];
        return !empty($g) ? $g : ($this->image ? [$this->image] : []);
    }
}
