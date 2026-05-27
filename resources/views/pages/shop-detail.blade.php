@php
    $pageTitle       = $product->name . ' | Premax Boutique';
    $pageDescription = $product->description ?? $product->name;
    $pageKeyWords    = strtolower($product->name) . ', ' . strtolower($product->category_label) . ', nairobi';
    $galleryImages   = $product->gallery_images;
    $effectivePrice  = $product->effective_price;
    $pageImage       = $product->image ? asset($product->image) : null;
@endphp

@extends('layouts.default-menu-page')

@section('head-tags')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ addslashes($product->name) }}",
  "description": "{{ addslashes($product->description ?? '') }}",
  "url": "{{ route('shop.show', $product->slug) }}",
  @if($product->image)"image": "{{ asset($product->image) }}",@endif
  "brand": { "@type": "Brand", "name": "Premax Automotive Studio" },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "KES",
    "price": "{{ $effectivePrice }}",
    "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
    "url": "{{ route('shop.show', $product->slug) }}"
  }
}
</script>
@endsection

@section('content')

<div class="bg-[#111111]">

{{-- ── PRODUCT DETAIL ── --}}
<section class="pt-36 pb-16 px-6">
    <div class="max-w-7xl mx-auto">

        {{-- Back --}}
        <a href="{{ route('shop.index') }}"
           class="inline-flex items-center gap-2 text-[10px] uppercase tracking-widest text-white/40
                  hover:text-white transition-colors no-underline mb-10 group">
            <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Shop
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">

            {{-- ── GALLERY ── --}}
            <div>
                <div class="aspect-square rounded-2xl overflow-hidden bg-[#1a1a1a] border border-white/5 mb-4"
                     id="main-image-wrap">
                    @if(count($galleryImages))
                    <img id="main-image"
                         src="{{ asset($galleryImages[0]) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover transition-opacity duration-300">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    @endif
                </div>

                @if(count($galleryImages) > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach($galleryImages as $i => $img)
                    <button type="button"
                            data-src="{{ asset($img) }}"
                            class="thumb-btn aspect-square rounded-lg overflow-hidden border transition-all
                                   {{ $i === 0 ? 'border-custom-primary' : 'border-white/10 hover:border-white/30' }}">
                        <img src="{{ asset($img) }}" alt="" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ── INFO ── --}}
            <div>
                <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-3 block">
                    {{ $product->category_label }}
                </span>
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-5 leading-tight">
                    {{ $product->name }}
                </h1>

                <div class="flex items-baseline gap-3 mb-8">
                    <span class="font-bold text-white text-3xl">
                        KES {{ number_format($effectivePrice) }}
                    </span>
                    @if($product->sale_price)
                    <span class="text-white/35 text-xl line-through">
                        KES {{ number_format($product->price) }}
                    </span>
                    @endif
                </div>

                <p class="text-white/65 text-lg leading-relaxed mb-8">
                    {{ $product->long_description ?: $product->description }}
                </p>

                @if(!$product->is_sold_out)

                {{-- Qty + Add to cart --}}
                <div class="flex items-center gap-4 mb-5">
                    <div class="flex items-center bg-[#1a1a1a] border border-white/15 rounded-md">
                        <button type="button" id="qty-dec"
                                class="w-12 h-12 flex items-center justify-center text-white/60 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                            </svg>
                        </button>
                        <span id="qty-display" class="w-12 text-center text-white font-semibold tabular-nums select-none">1</span>
                        <button type="button" id="qty-inc"
                                class="w-12 h-12 flex items-center justify-center text-white/60 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                    <button type="button" id="add-to-cart-btn"
                            data-product-id="{{ $product->id }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 h-12 px-8
                                   bg-custom-primary text-white font-semibold rounded-md
                                   hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Add to Cart
                    </button>
                </div>

                <a href="{{ route('checkout') }}"
                   id="buy-now-btn"
                   class="block w-full text-center h-12 leading-[3rem] px-8 mb-10
                          bg-transparent border border-white/20 text-white font-semibold rounded-md
                          hover:bg-white/5 transition-colors no-underline">
                    Buy it now
                </a>

                @else
                <div class="mb-10 px-5 py-3.5 bg-white/5 border border-white/10 rounded-md text-center">
                    <span class="text-white/50 text-sm">This item is sold out</span>
                </div>
                @endif

                {{-- What's Included --}}
                @if($product->features && count($product->features) > 0)
                <div class="border-t border-white/10 pt-8 mb-8">
                    <h3 class="text-[10px] uppercase tracking-widest text-white/30 mb-5">What's Included</h3>
                    <ul class="space-y-3">
                        @foreach($product->features as $f)
                        <li class="flex items-start gap-3 text-white/75">
                            <svg class="w-4 h-4 text-custom-primary mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm leading-relaxed">{{ $f }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Trust badges --}}
                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-white/10">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-custom-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <div>
                            <div class="text-white text-sm font-medium">Free Nairobi delivery</div>
                            <div class="text-white/35 text-xs">On orders over KES 10,000</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-custom-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div>
                            <div class="text-white text-sm font-medium">Studio-tested</div>
                            <div class="text-white/35 text-xs">Used in our facility</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>


{{-- ── RELATED PRODUCTS ── --}}
@if($related->isNotEmpty())
<section class="py-24 px-6 bg-[#0a0a0a] border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-12">You may also like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $rel)
            <div class="group flex flex-col bg-[#1a1a1a] border border-white/5 rounded-2xl overflow-hidden
                        hover:border-white/15 transition-colors duration-300">
                <a href="{{ route('shop.show', $rel->slug) }}" class="no-underline block">
                    <div class="relative aspect-square bg-[#222] overflow-hidden">
                        @if($rel->image)
                        <img src="{{ asset($rel->image) }}" alt="{{ $rel->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                        <div class="absolute top-3 left-3">
                            @if($rel->is_sold_out)
                            <span class="px-2.5 py-1 bg-black/80 text-white/60 text-[10px] font-bold uppercase tracking-widest rounded">Sold Out</span>
                            @elseif($rel->sale_price)
                            <span class="px-2.5 py-1 bg-custom-primary text-white text-[10px] font-bold uppercase tracking-widest rounded">Sale</span>
                            @endif
                        </div>
                    </div>
                </a>
                <div class="p-5 flex flex-col flex-1">
                    <div class="text-[10px] text-white/25 uppercase tracking-widest mb-1.5">{{ $rel->category_label }}</div>
                    <a href="{{ route('shop.show', $rel->slug) }}"
                       class="text-sm font-semibold text-white mb-1.5 leading-snug no-underline hover:text-white/80 transition-colors block">
                        {{ $rel->name }}
                    </a>
                    <p class="text-xs text-white/40 leading-relaxed flex-1 mb-4">{{ Str::limit($rel->description, 65) }}</p>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-base font-bold {{ $rel->sale_price ? 'text-custom-primary' : 'text-white' }}">
                            KES {{ number_format($rel->effective_price) }}
                        </span>
                        @if(!$rel->is_sold_out)
                        <button type="button"
                                data-product-id="{{ $rel->id }}"
                                data-product-name="{{ $rel->name }}"
                                class="cart-add-btn w-8 h-8 rounded-full bg-white/5 hover:bg-custom-primary border border-white/10
                                       hover:border-custom-primary text-white flex items-center justify-center transition-all duration-200"
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
    </div>
</section>
@endif

</div>

@push('scripts-stack')
<script>
(function () {
    const CSRF = document.querySelector('meta[name=csrf-token]')?.content ?? '';

    // Gallery thumbnails
    const mainImg = document.getElementById('main-image');
    document.querySelectorAll('.thumb-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (mainImg) {
                mainImg.style.opacity = '0';
                setTimeout(() => { mainImg.src = btn.dataset.src; mainImg.style.opacity = '1'; }, 150);
            }
            document.querySelectorAll('.thumb-btn').forEach(b => {
                b.classList.toggle('border-custom-primary', b === btn);
                b.classList.toggle('border-white/10', b !== btn);
            });
        });
    });

    // Quantity
    let qty = 1;
    const qtyDisplay = document.getElementById('qty-display');
    document.getElementById('qty-dec')?.addEventListener('click', () => {
        qty = Math.max(1, qty - 1);
        if (qtyDisplay) qtyDisplay.textContent = qty;
    });
    document.getElementById('qty-inc')?.addEventListener('click', () => {
        qty = Math.min(99, qty + 1);
        if (qtyDisplay) qtyDisplay.textContent = qty;
    });

    // Add to cart
    async function addToCart(productId, qtyToAdd) {
        try {
            const res  = await fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body:    JSON.stringify({ product_id: productId, qty: qtyToAdd }),
            });
            const data = await res.json();
            if (data.success) {
                document.querySelectorAll('[data-cart-count]').forEach(el => {
                    el.textContent = data.count;
                    el.classList.toggle('hidden', data.count === 0);
                });
                return true;
            }
        } catch {}
        return false;
    }

    // Main add-to-cart button
    const mainBtn = document.getElementById('add-to-cart-btn');
    mainBtn?.addEventListener('click', async () => {
        const id   = parseInt(mainBtn.dataset.productId);
        const orig = mainBtn.innerHTML;

        mainBtn.disabled   = true;
        mainBtn.innerHTML  = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Adding…';

        const ok = await addToCart(id, qty);

        if (ok) {
            mainBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Added to cart';
            setTimeout(() => { mainBtn.innerHTML = orig; mainBtn.disabled = false; }, 2000);
        } else {
            mainBtn.innerHTML = orig;
            mainBtn.disabled  = false;
        }
    });

    // Buy-it-now button
    document.getElementById('buy-now-btn')?.addEventListener('click', async (e) => {
        e.preventDefault();
        const id = mainBtn ? parseInt(mainBtn.dataset.productId) : null;
        if (id) await addToCart(id, qty);
        window.location.href = '{{ route('checkout') }}';
    });

    // Related product quick-add
    document.querySelectorAll('.cart-add-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            btn.disabled = true;
            const ok = await addToCart(parseInt(btn.dataset.productId), 1);
            if (ok) {
                const orig = btn.innerHTML;
                btn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
                setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; }, 1800);
            } else {
                btn.disabled = false;
            }
        });
    });
})();
</script>
@endpush

@endsection
