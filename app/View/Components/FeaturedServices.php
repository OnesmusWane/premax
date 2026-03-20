<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\Service;

class FeaturedServices extends Component
{
    public $services;

    public function __construct()
    {
        // Cache key is date-specific — automatically expires and rotates each day.
        // e.g. "featured_services.2024-01-15"
        $cacheKey = 'featured_services.' . now()->toDateString();

        $this->services = Cache::remember($cacheKey, now()->endOfDay(), function () {
            return Service::with('serviceCategory')
                ->where('is_active', true)
                ->inRandomOrder()
                ->limit(6)
                ->get();
        });
    }

    public function render(): View|Closure|string
    {
        return view('components.featured-services');
    }
}