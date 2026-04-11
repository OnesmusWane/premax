<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Service;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // All published items eager-loading service
        $allItems = GalleryItem::with('service')
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->get();

        // Daily hero: seed with today's date so it changes per day
        // but is consistent for all visitors on the same day
        $heroPool = $allItems->filter(fn($i) => $i->image_path)->values();
        $heroImage = $heroPool->isNotEmpty()
            ? $heroPool->get((int) date('z') % $heroPool->count())
            : null;

        // Group by service (null = Uncategorised)
        $grouped = $allItems->groupBy(function ($item) {
            return $item->service?->name ?? 'Uncategorised';
        });

        // All service names for filter tabs (put "All" first)
        $categories = $grouped->keys()->sort()->values()->prepend('All');

        return view('pages.gallery', compact('heroImage', 'grouped', 'categories', 'allItems'));
    }
}
