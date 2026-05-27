<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Product;
use App\Models\WorkCase;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $services = Service::where('is_active', true)->get(['slug', 'updated_at']);
        $products = Product::where('is_active', true)->get(['slug', 'updated_at']);
        $cases    = WorkCase::where('is_active', true)->get(['slug', 'updated_at']);

        $content = view('sitemap', compact('services', 'products', 'cases'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
