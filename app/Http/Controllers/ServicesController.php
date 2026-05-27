<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServicesController extends Controller
{
    private const PAGE_SIZE = 4;

    public function index(Request $request)
    {
        $categorySlug = $request->query('category', 'all');

        // All categories for the filter bar (cached 1h)
        $categories = Cache::remember('service_categories_active', now()->addHour(), function () {
            return ServiceCategory::with([
                'services' => fn($q) => $q->where('is_active', true),
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        });

        // Build paginated service query
        $query = Service::with('serviceCategory')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($categorySlug !== 'all') {
            $category = $categories->firstWhere('slug', $categorySlug);
            if ($category) {
                $query->where('service_category_id', $category->id);
            }
        }

        $services  = $query->paginate(self::PAGE_SIZE)->withQueryString();
        $totalAll  = Service::where('is_active', true)->count();

        return view('pages.services', compact('services', 'categories', 'categorySlug', 'totalAll'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->with('serviceCategory')
            ->firstOrFail();

        $related = Service::where('service_category_id', $service->service_category_id)
            ->where('id', '!=', $service->id)
            ->where('is_active', true)
            ->limit(3)
            ->get();

        return view('pages.service-detail', compact('service', 'related'));
    }
}
