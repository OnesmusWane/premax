<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\Review;

class Testimonials extends Component
{
    public $reviews;

    public function __construct()
    {
        $this->reviews = Cache::remember('testimonials.homepage', now()->addHours(2), function () {
            return Review::where('status', 'approved')
                ->where('show_on_website', true)
                ->orderByDesc('is_featured')  // featured ones first
                ->orderByDesc('rating')
                ->orderByDesc('reviewed_at')
                ->get();
        });
    }

    public function render(): View|Closure|string
    {
        return view('components.testimonials');
    }
}