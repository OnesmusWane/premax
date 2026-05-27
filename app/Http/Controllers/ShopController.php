<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private const PAGE_SIZE = 8;

    private const VALID_SORTS = ['featured', 'price-asc', 'price-desc', 'name'];

    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        $sort     = in_array($request->query('sort'), self::VALID_SORTS)
                    ? $request->query('sort')
                    : 'featured';

        $query = Product::active();

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        match ($sort) {
            'price-asc'  => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'name'       => $query->orderBy('name'),
            default      => $query->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('name'),
        };

        $products = $query->paginate(self::PAGE_SIZE)->withQueryString();

        return view('pages.shop', compact('products', 'category', 'sort'));
    }

    public function show(string $slug)
    {
        $product = Product::active()->where('slug', $slug)->firstOrFail();

        $related = Product::active()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->orderByDesc('is_featured')
            ->limit(4)
            ->get();

        return view('pages.shop-detail', compact('product', 'related'));
    }
}
