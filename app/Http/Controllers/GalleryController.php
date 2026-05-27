<?php

namespace App\Http\Controllers;

use App\Models\MediaLibrary;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $allItems = MediaLibrary::with('service')
            ->where('type', 'image')
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        // Daily hero: rotates each day, consistent for all visitors
        $heroPool = $allItems->filter(fn($i) => $i->url)->values();
        $heroImage = $heroPool->isNotEmpty()
            ? $heroPool->get((int) date('z') % $heroPool->count())
            : null;

        $grouped = $allItems->groupBy(fn($item) => $item->service?->name ?? 'Uncategorised');

        $categories = $grouped->keys()->sort()->values()->prepend('All');

        return view('pages.gallery', compact('heroImage', 'grouped', 'categories', 'allItems'));
    }
}
