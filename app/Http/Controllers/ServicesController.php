<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Cache;

class ServicesController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('services.page', now()->addMinutes(60), function () {
            return ServiceCategory::with([
                'services' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        });

        return view('pages.services', compact('categories'));
    }
}
