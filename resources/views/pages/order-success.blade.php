@php
    $pageTitle       = 'Order Confirmed | Premax Boutique';
    $pageDescription = 'Your order has been placed successfully.';
    $pageKeyWords    = '';
    $pageNoIndex     = true;
    $totalQty        = $order->items->sum('qty');
@endphp

@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-36 pb-24 px-6 flex items-center justify-center">
    <div class="max-w-2xl w-full">

        {{-- ── Header ─────────────────────────────────────────────────────────── --}}
        <div class="text-center mb-12" id="os-header" style="opacity:0;transform:translateY(20px)">
            <div class="w-20 h-20 rounded-full bg-custom-primary/10 border-2 border-custom-primary
                        flex items-center justify-center mx-auto mb-8" id="os-icon">
                <svg class="w-8 h-8 text-custom-primary" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
                Order Placed
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight">
                Thank you for your order.
            </h1>
            <p class="text-white/55 text-lg max-w-xl mx-auto">
                A confirmation has been sent to your inbox. We're preparing your order for dispatch.
            </p>
        </div>

        {{-- ── Stat counters ────────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-3 gap-3 mb-6" id="os-stats" style="opacity:0;transform:translateY(16px)">

            <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-5 text-center">
                <div class="text-[10px] uppercase tracking-widest text-white/25 mb-2">Items ordered</div>
                <div class="text-3xl font-bold text-white tabular-nums" id="stat-items" data-target="{{ $totalQty }}">
                    {{ $totalQty }}
                </div>
            </div>

            <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-5 text-center">
                <div class="text-[10px] uppercase tracking-widest text-white/25 mb-2">Total paid</div>
                <div class="text-2xl font-bold text-white tabular-nums leading-tight" id="stat-total" data-target="{{ (int) $order->total }}">
                    {{ number_format($order->total) }}
                </div>
                <div class="text-[10px] text-white/25 mt-0.5">KES</div>
            </div>

            <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-5 text-center">
                <div class="text-[10px] uppercase tracking-widest text-white/25 mb-2">Products</div>
                <div class="text-3xl font-bold text-white tabular-nums" id="stat-products" data-target="{{ $order->items->count() }}">
                    {{ $order->items->count() }}
                </div>
            </div>

        </div>

        {{-- ── Order card ──────────────────────────────────────────────────────── --}}
        <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-8 mb-6" id="os-card" style="opacity:0;transform:translateY(16px)">

            {{-- Reference + status --}}
            <div class="flex items-start justify-between pb-6 border-b border-white/8 mb-6">
                <div>
                    <div class="text-[10px] uppercase tracking-widest text-white/30 mb-1">Reference</div>
                    <div class="font-bold text-white text-2xl tabular-nums font-mono">{{ $order->order_number }}</div>
                </div>
                <div class="text-right">
                    <div class="text-[10px] uppercase tracking-widest text-white/30 mb-1">Status</div>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-custom-primary/10 border border-custom-primary/30
                                 rounded-full text-custom-primary text-[10px] uppercase tracking-widest font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-custom-primary animate-pulse"></span>
                        Processing
                    </span>
                </div>
            </div>

            {{-- Item list --}}
            <ul class="space-y-3 mb-6" id="os-items">
                @foreach($order->items as $index => $item)
                <li class="os-item flex items-center gap-4" style="opacity:0;transform:translateX(-8px)"
                    data-index="{{ $index }}" data-qty="{{ $item->qty }}" data-total="{{ $totalQty }}">

                    {{-- Thumb --}}
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-[#252525] shrink-0 border border-white/5">
                        @if($item->product?->image)
                            <img src="{{ asset($item->product->image) }}"
                                 alt="{{ $item->product_name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white/15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Name + unit price --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-medium truncate">{{ $item->product_name }}</p>
                        <p class="text-white/35 text-xs mt-0.5">KES {{ number_format($item->unit_price) }} each</p>
                    </div>

                    {{-- Animated qty — counts DOWN from totalQty to item qty --}}
                    <div class="flex items-center gap-1.5 shrink-0">
                        <span class="text-white/25 text-sm">×</span>
                        <span class="item-qty-count text-xl font-bold text-white tabular-nums w-6 text-center">
                            {{ $item->qty }}
                        </span>
                    </div>

                    {{-- Line total --}}
                    <div class="text-white text-sm font-semibold tabular-nums shrink-0 w-28 text-right">
                        KES {{ number_format($item->subtotal) }}
                    </div>

                </li>
                @endforeach
            </ul>

            {{-- Totals --}}
            <dl class="space-y-2 border-t border-white/8 pt-5 text-sm">
                <div class="flex justify-between">
                    <dt class="text-white/40">Subtotal</dt>
                    <dd class="text-white tabular-nums">KES {{ number_format($order->subtotal) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-white/40">Shipping</dt>
                    <dd class="text-white">{{ $order->shipping > 0 ? 'KES ' . number_format($order->shipping) : 'Free' }}</dd>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-white/8">
                    <dt class="text-[10px] uppercase tracking-widest text-white/30">Total</dt>
                    <dd class="text-xl font-bold text-white tabular-nums">KES {{ number_format($order->total) }}</dd>
                </div>
            </dl>

        </div>

        {{-- ── Actions ─────────────────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center" id="os-actions" style="opacity:0;transform:translateY(12px)">
            <a href="{{ route('account') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-custom-primary text-white font-semibold
                      rounded-md hover:bg-red-700 transition-colors shadow-[0_4px_14px_rgba(211,30,36,0.28)]">
                View in your account
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <!-- <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center px-8 py-3.5 border border-white/15 text-white font-semibold
                      rounded-md hover:bg-white/5 transition-colors">
                Back to home
            </a> -->
        </div>

    </div>
</div>

@push('scripts-stack')
<script>
(function () {
    // Ease-out cubic
    function easeOut(t) { return 1 - Math.pow(1 - t, 3); }

    function animateTo(el, from, to, duration, fmt) {
        const startTime = performance.now();
        (function tick(now) {
            const t   = Math.min((now - startTime) / duration, 1);
            const val = Math.round(from + (to - from) * easeOut(t));
            el.textContent = fmt ? val.toLocaleString() : String(val);
            if (t < 1) requestAnimationFrame(tick);
        })(startTime);
    }

    function fadeIn(el, delay, dy) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            el.style.opacity    = '1';
            el.style.transform  = dy ? 'translateY(0)' : 'translateX(0)';
        }, delay);
    }

    // ── Fade in blocks ───────────────────────────────────────────────────
    fadeIn(document.getElementById('os-header'),  60,  true);
    fadeIn(document.getElementById('os-stats'),   200, true);
    fadeIn(document.getElementById('os-card'),    360, true);
    fadeIn(document.getElementById('os-actions'), 480, true);

    // ── Stat counters (start from 0, count UP) ───────────────────────────
    setTimeout(function () {
        var items    = document.getElementById('stat-items');
        var total    = document.getElementById('stat-total');
        var products = document.getElementById('stat-products');

        animateTo(items,    0, parseInt(items.dataset.target),    900, false);
        animateTo(products, 0, parseInt(products.dataset.target), 900, false);
        animateTo(total,    0, parseInt(total.dataset.target),   1400, true);
    }, 350);

    // ── Item rows: slide in then qty counts DOWN from totalQty → itemQty ─
    document.querySelectorAll('.os-item').forEach(function (row) {
        var delay  = 550 + parseInt(row.dataset.index) * 130;
        var qtyEl  = row.querySelector('.item-qty-count');
        var itemQty = parseInt(row.dataset.qty);
        var startFrom = parseInt(row.dataset.total);   // counts DOWN from order total

        // Start at startFrom (hidden)
        qtyEl.textContent = String(startFrom);

        // Fade row in
        setTimeout(function () {
            row.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            row.style.opacity    = '1';
            row.style.transform  = 'translateX(0)';

            // Then animate qty down to item's actual qty
            setTimeout(function () {
                animateTo(qtyEl, startFrom, itemQty, 700, false);
            }, 200);
        }, delay);
    });
})();
</script>
@endpush

@endsection
