@php
    $pageTitle       = 'The Boutique | Premax Automotive Studio';
    $pageDescription = 'Studio-approved automotive care kits, accessories, apparel and lifestyle goods from Premax Automotive Studio, Nairobi.';
    $pageKeyWords    = 'car care kits nairobi, automotive accessories, premax shop, detailing products nairobi';

    $categoryLabels = [
        'all'         => 'All',
        'care_kits'   => 'Care Kits',
        'accessories' => 'Accessories',
        'apparel'     => 'Apparel',
        'lifestyle'   => 'Lifestyle',
    ];

    $sortLabels = [
        'featured'   => 'Featured',
        'price-asc'  => 'Price: Low to High',
        'price-desc' => 'Price: High to Low',
        'name'       => 'Name A–Z',
    ];
@endphp

@extends('layouts.default-menu-page')

@section('head-tags')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Premax Boutique",
  "url": "{{ route('shop.index') }}",
  "itemListElement": [
    @foreach($products as $i => $prod)
    {
      "@type": "ListItem",
      "position": {{ $i + 1 }},
      "name": "{{ addslashes($prod->name) }}",
      "url": "{{ route('shop.show', $prod->slug) }}"
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endsection
@section('content')

<div class="bg-[#111111]">

{{-- ── HERO ── --}}
<section class="relative h-[55vh] min-h-[380px] flex items-end overflow-hidden">
    <div class="absolute inset-0 z-0">
        <x-responsive-image path="assets/images/hero/shop.webp"
             alt="Premax Boutique"
             class="w-full h-full object-cover scale-105" :priority="true" />
        <div class="absolute inset-0 bg-black/65"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#111111] via-[#111111]/40 to-transparent"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12 pb-16 md:pb-24">
        <nav class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-white/40 mb-6">
            <a href="{{ url('/') }}" class="hover:text-white/70 transition-colors no-underline">Home</a>
            <svg class="w-3 h-3 text-white/25" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white/70">Shop</span>
        </nav>

        <span class="block text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4">The Boutique</span>
        <h1 class="text-4xl md:text-6xl font-bold text-white max-w-2xl leading-[1.05] tracking-tight">
            Studio-Approved<br>Goods.
        </h1>
        <p class="text-white/70 text-lg max-w-xl mt-5 leading-relaxed font-light">
            A curated selection of care products, accessories, and lifestyle objects —
            chosen and tested by our master technicians.
        </p>
    </div>
</section>


{{-- ── STICKY FILTER BAR ── --}}
<div id="shop-nav"
     class="sticky top-[72px] z-30 bg-[#111111]/90 backdrop-blur-lg border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between py-5 gap-4">

            {{-- Category pills --}}
            <div class="flex items-center gap-2 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden -mx-1 px-1">
                @foreach($categoryLabels as $key => $label)
                <a href="{{ route('shop.index', array_filter(['category' => $key === 'all' ? null : $key, 'sort' => $sort !== 'featured' ? $sort : null])) }}"
                   class="whitespace-nowrap shrink-0 px-5 py-2.5 rounded-full text-xs uppercase tracking-widest
                          font-medium border transition-all no-underline
                          {{ $category === $key ? 'bg-custom-primary border-custom-primary text-white' : 'bg-transparent border-white/15 text-white/60 hover:border-white/40 hover:text-white' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            {{-- Sort select --}}
            <div class="flex items-center gap-3 shrink-0">
                <span class="text-xs uppercase tracking-widest text-white/30 hidden md:block">Sort</span>
                <select id="sort-select"
                        class="bg-[#1a1a1a] border border-white/15 text-white text-sm rounded-md
                               px-4 py-2.5 focus:outline-none focus:border-custom-primary cursor-pointer
                               hover:border-white/30 transition-colors appearance-none pr-8">
                    @foreach($sortLabels as $val => $lbl)
                    <option value="{{ $val }}" {{ $sort === $val ? 'selected' : '' }} class="bg-[#1a1a1a]">{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
</div>


{{-- ── PRODUCT GRID ── --}}
<section class="py-20 px-6">
    <div class="max-w-7xl mx-auto">

        @if($products->isEmpty())
        <div class="text-center py-32 border border-white/5 rounded-2xl bg-[#1a1a1a]">
            <p class="text-white/20 text-sm mb-2">No products in this category.</p>
            <a href="{{ route('shop.index') }}" class="text-white/40 text-xs hover:text-white transition-colors no-underline">View all →</a>
        </div>
        @else

        <div id="product-grid"
             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6
                    [animation:shopFadeIn_0.4s_ease_forwards]">
            @foreach($products as $product)
            <div class="group flex flex-col bg-[#1a1a1a] border border-white/5 rounded-2xl overflow-hidden
                        hover:border-white/15 transition-colors duration-300">

                {{-- Image --}}
                <a href="{{ route('shop.show', $product->slug) }}" class="no-underline block">
                    <div class="relative aspect-square bg-[#222] overflow-hidden">
                        @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy" decoding="async"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        @endif

                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                            @if($product->is_sold_out)
                            <span class="px-2.5 py-1 bg-black/80 text-white/60 text-[10px] font-bold uppercase tracking-widest rounded">Sold Out</span>
                            @elseif($product->sale_price)
                            <span class="px-2.5 py-1 bg-custom-primary text-white text-[10px] font-bold uppercase tracking-widest rounded">Sale</span>
                            @endif
                        </div>

                        {{-- Quick add --}}
                        @if(!$product->is_sold_out)
                        <button type="button"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                class="cart-add-btn absolute bottom-3 right-3 w-9 h-9 rounded-full bg-custom-primary text-white
                                       flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100
                                       translate-y-2 group-hover:translate-y-0 transition-all duration-300 hover:bg-red-700"
                                aria-label="Add {{ $product->name }} to cart">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        @endif
                    </div>
                </a>

                {{-- Info --}}
                <div class="p-5 flex flex-col flex-1">
                    <div class="text-[10px] text-white/25 uppercase tracking-widest mb-1.5">{{ $product->category_label }}</div>
                    <a href="{{ route('shop.show', $product->slug) }}"
                       class="text-sm font-semibold text-white mb-1.5 leading-snug no-underline hover:text-white/80 transition-colors block">
                        {{ $product->name }}
                    </a>
                    @if($product->description)
                    <p class="text-xs text-white/40 leading-relaxed flex-1 mb-4">{{ Str::limit($product->description, 70) }}</p>
                    @endif

                    <div class="flex items-center justify-between mt-auto">
                        <div class="flex items-center gap-2">
                            @if($product->sale_price)
                            <span class="text-base font-bold text-custom-primary">KES {{ number_format($product->sale_price) }}</span>
                            <span class="text-sm text-white/25 line-through">{{ number_format($product->price) }}</span>
                            @else
                            <span class="text-base font-bold text-white">KES {{ number_format($product->price) }}</span>
                            @endif
                        </div>
                        @if(!$product->is_sold_out)
                        <button type="button"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                class="cart-add-btn w-8 h-8 rounded-full bg-white/5 hover:bg-custom-primary border border-white/10
                                       hover:border-custom-primary text-white flex items-center justify-center
                                       transition-all duration-200"
                                aria-label="Add to cart">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>

            </div>
            @endforeach
        </div>


        {{-- ── PAGINATION ── --}}
        @if($products->lastPage() > 1)
        <nav aria-label="Shop pagination" class="flex items-center justify-center gap-2 mt-16">

            @if($products->onFirstPage())
            <span class="w-10 h-10 flex items-center justify-center rounded-full border border-white/10 text-white/25 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </span>
            @else
            <a href="{{ $products->previousPageUrl() }}#shop-nav"
               class="w-10 h-10 flex items-center justify-center rounded-full border border-white/15 text-white/60
                      hover:text-white hover:border-white/40 transition-colors no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            @endif

            <div class="flex items-center gap-1 mx-2">
                @php
                    $pages = [];
                    $delta = 1;
                    for ($i = 1; $i <= $products->lastPage(); $i++) {
                        if ($i === 1 || $i === $products->lastPage() ||
                            ($i >= $products->currentPage() - $delta && $i <= $products->currentPage() + $delta)) {
                            $pages[] = $i;
                        } elseif (end($pages) !== 'ellipsis') {
                            $pages[] = 'ellipsis';
                        }
                    }
                @endphp
                @foreach($pages as $p)
                    @if($p === 'ellipsis')
                    <span class="px-2 text-white/30 text-sm select-none">…</span>
                    @else
                    <a href="{{ $products->url($p) }}#shop-nav"
                       class="min-w-[40px] h-10 px-3 rounded-full text-sm font-medium transition-all no-underline
                              flex items-center justify-center
                              {{ $p === $products->currentPage() ? 'bg-custom-primary text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
                       aria-current="{{ $p === $products->currentPage() ? 'page' : 'false' }}">
                        {{ $p }}
                    </a>
                    @endif
                @endforeach
            </div>

            @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}#shop-nav"
               class="w-10 h-10 flex items-center justify-center rounded-full border border-white/15 text-white/60
                      hover:text-white hover:border-white/40 transition-colors no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
            @else
            <span class="w-10 h-10 flex items-center justify-center rounded-full border border-white/10 text-white/25 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </span>
            @endif

        </nav>
        @endif

        @endif
    </div>
</section>

</div>

@push('scripts-stack')
<style>
@keyframes shopFadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>
<script>
(function () {
    // Sort → navigate
    const sortSel = document.getElementById('sort-select');
    if (sortSel) {
        sortSel.addEventListener('change', () => {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sortSel.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    }

    // Add to cart
    const CSRF = document.querySelector('meta[name=csrf-token]')?.content ?? '';

    document.querySelectorAll('.cart-add-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();

            const id   = btn.dataset.productId;
            const name = btn.dataset.productName;
            const orig = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>';

            try {
                const res  = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    body:    JSON.stringify({ product_id: parseInt(id), qty: 1 }),
                });
                const data = await res.json();
                if (data.success) {
                    updateCartBadge(data.count);
                    btn.innerHTML = '<svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
                    setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; }, 1800);
                    return;
                }
            } catch {}

            btn.innerHTML = orig;
            btn.disabled  = false;
        });
    });

    function updateCartBadge(count) {
        document.querySelectorAll('[data-cart-count]').forEach(el => {
            el.textContent = count;
            el.classList.toggle('hidden', count === 0);
        });
    }
})();
</script>
@endpush

@endsection
