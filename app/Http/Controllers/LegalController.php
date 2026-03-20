<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use Illuminate\Support\Facades\Cache;

class LegalController extends Controller
{
    public function show(string $slug)
    {
        $page = Cache::remember("legal.{$slug}", now()->addHours(6), function () use ($slug) {
            return LegalPage::findBySlug($slug);
        });

        abort_if(! $page, 404);

        return view('pages.legal', compact('page'));
    }
}