<?php

namespace App\Http\Controllers;

use App\Models\WorkCase;
use Illuminate\Support\Facades\Cache;

class WorkController extends Controller
{
    public function index()
    {
        $cases = Cache::remember('work.cases', now()->addMinutes(30), function () {
            return WorkCase::active()
                ->with('metrics')
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->get();
        });

        return view('pages.work', compact('cases'));
    }

    public function show(string $slug)
    {
        $case = WorkCase::where('slug', $slug)
            ->where('is_active', true)
            ->with(['steps', 'metrics', 'gallery'])
            ->firstOrFail();

        $related = WorkCase::active()
            ->where('id', '!=', $case->id)
            ->where('category', $case->category)
            ->limit(3)
            ->get();

        return view('pages.work-detail', compact('case', 'related'));
    }
}
