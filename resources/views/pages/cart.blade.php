@php
    $pageTitle       = 'Shopping Cart | Premax Boutique';
    $pageDescription = 'Your Premax shopping bag.';
    $pageKeyWords    = '';
    $pageNoIndex     = true;

    $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
    $shipping = ($subtotal > 10000 || $subtotal == 0) ? 0 : 800;
    $total    = $subtotal + $shipping;
@endphp

@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-36 pb-24 px-6">
    <div class="max-w-6xl mx-auto">

        <div class="mb-12">
            <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">Your Bag</span>
            <h1 class="text-4xl md:text-5xl font-bold text-white">Shopping Cart</h1>
            <p class="text-white/40 mt-3 text-sm" id="cart-summary-text">
                {{ count($cart) === 0 ? 'Your bag is empty' : array_sum(array_column($cart, 'qty')) . ' ' . Str::plural('item', array_sum(array_column($cart, 'qty'))) . ' in your bag' }}
            </p>
        </div>

        @if(empty($cart))

        {{-- Empty state --}}
        <div class="text-center py-32 border border-white/5 rounded-2xl bg-[#1a1a1a]">
            <svg class="w-14 h-14 text-white/15 mx-auto mb-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <p class="text-white/30 mb-6">Nothing here yet.</p>
            <a href="{{ route('shop.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-custom-primary text-white font-medium rounded-md
                      hover:bg-red-700 transition-colors no-underline text-sm">
                Browse the boutique
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        @else

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8">

            {{-- ── CART ITEMS ── --}}
            <div id="cart-items" class="space-y-4">
                @foreach($cart as $slug => $item)
                <div class="cart-row flex items-center gap-4 bg-[#1a1a1a] border border-white/10 rounded-2xl p-5
                             hover:border-white/20 transition-colors" data-slug="{{ $slug }}">

                    {{-- Image --}}
                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-[#222] shrink-0">
                        @if($item['image'])
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="text-[10px] uppercase tracking-widest text-white/30 mb-0.5">{{ $item['category_label'] }}</div>
                        <h3 class="text-white font-semibold text-sm truncate">{{ $item['name'] }}</h3>
                        <div class="text-white/60 text-sm mt-1">KES {{ number_format($item['price']) }}</div>
                    </div>

                    {{-- Qty controls --}}
                    <div class="flex items-center gap-1 bg-[#111] border border-white/10 rounded-lg shrink-0">
                        <button type="button"
                                class="qty-btn w-9 h-9 flex items-center justify-center text-white/50 hover:text-white transition-colors"
                                data-slug="{{ $slug }}" data-delta="-1" aria-label="Decrease">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                            </svg>
                        </button>
                        <span class="qty-value w-8 text-center text-white text-sm font-medium tabular-nums select-none">
                            {{ $item['qty'] }}
                        </span>
                        <button type="button"
                                class="qty-btn w-9 h-9 flex items-center justify-center text-white/50 hover:text-white transition-colors"
                                data-slug="{{ $slug }}" data-delta="1" aria-label="Increase">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Item total --}}
                    <div class="text-white font-semibold text-sm tabular-nums shrink-0 hidden sm:block item-total"
                         data-slug="{{ $slug }}">
                        KES {{ number_format($item['price'] * $item['qty']) }}
                    </div>

                    {{-- Remove --}}
                    <button type="button"
                            class="remove-btn w-8 h-8 flex items-center justify-center text-white/30 hover:text-white
                                   rounded-md hover:bg-white/5 transition-colors shrink-0"
                            data-slug="{{ $slug }}" aria-label="Remove">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                @endforeach

                <a href="{{ route('shop.index') }}"
                   class="inline-flex items-center gap-2 text-white/40 hover:text-white transition-colors no-underline text-sm mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Continue shopping
                </a>
            </div>

            {{-- ── ORDER SUMMARY ── --}}
            <aside class="lg:sticky lg:top-32 self-start">
                <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-8">
                    <h2 class="text-lg font-semibold text-white mb-6">Order Summary</h2>

                    <dl class="space-y-3 mb-6">
                        <div class="flex items-center justify-between text-sm">
                            <dt class="text-white/50">Subtotal</dt>
                            <dd class="text-white font-medium" id="subtotal-display">KES {{ number_format($subtotal) }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <dt class="text-white/50">Shipping</dt>
                            <dd class="text-white font-medium" id="shipping-display">
                                {{ $shipping === 0 ? 'Free' : 'KES ' . number_format($shipping) }}
                            </dd>
                        </div>
                    </dl>

                    <div class="border-t border-white/10 pt-5 mb-7">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase tracking-widest text-white/30">Total</span>
                            <span class="text-2xl font-bold text-white" id="total-display">KES {{ number_format($total) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}"
                       class="block w-full text-center px-6 py-4 bg-custom-primary text-white font-semibold
                              rounded-md hover:bg-red-700 transition-colors no-underline mb-3
                              shadow-[0_4px_14px_rgba(211,30,36,0.30)]">
                        Proceed to Checkout →
                    </a>
                    <p class="text-center text-[10px] text-white/25">Secure checkout · Encrypted payment</p>
                </div>
            </aside>

        </div>

        @endif

    </div>
</div>

@push('scripts-stack')
<script>
(function () {
    const CSRF = document.querySelector('meta[name=csrf-token]')?.content ?? '';

    async function post(url, body) {
        const res  = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body:    JSON.stringify(body),
        });
        return res.json();
    }

    function updateBadge(count) {
        document.querySelectorAll('[data-cart-count]').forEach(el => {
            el.textContent = count;
            el.classList.toggle('hidden', count === 0);
        });
    }

    function updateTotals(data) {
        const sub  = document.getElementById('subtotal-display');
        const ship = document.getElementById('shipping-display');
        const tot  = document.getElementById('total-display');
        if (sub)  sub.textContent  = 'KES ' + data.subtotal;
        if (ship) ship.textContent = data.shipping_label;
        if (tot)  tot.textContent  = 'KES ' + data.total;
        updateBadge(data.count);
    }

    // Qty buttons
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const row   = btn.closest('.cart-row');
            const slug  = btn.dataset.slug;
            const delta = parseInt(btn.dataset.delta);
            const span  = row.querySelector('.qty-value');
            const cur   = parseInt(span.textContent);
            const next  = cur + delta;

            if (next <= 0) {
                // treat as remove
                const data = await post('{{ route('cart.remove') }}', { slug });
                row.style.transition = 'opacity 0.25s, transform 0.25s';
                row.style.opacity    = '0';
                row.style.transform  = 'translateX(-10px)';
                setTimeout(() => row.remove(), 260);
                updateTotals(data);
                if (data.empty) location.reload();
                return;
            }

            span.textContent = next;
            const itemTotalEl = row.querySelector('.item-total');
            const unitPrice   = parseFloat(row.querySelector('.item-total')?.dataset.price || 0);

            const data = await post('{{ route('cart.update') }}', { slug, qty: next });
            updateTotals(data);
            if (data.item_total && itemTotalEl) {
                itemTotalEl.textContent = 'KES ' + data.item_total;
            }

            const summaryText = document.getElementById('cart-summary-text');
            if (summaryText) summaryText.textContent = data.count + ' item' + (data.count !== 1 ? 's' : '') + ' in your bag';
        });
    });

    // Remove buttons
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const row  = btn.closest('.cart-row');
            const slug = btn.dataset.slug;

            const data = await post('{{ route('cart.remove') }}', { slug });
            row.style.transition = 'opacity 0.25s, transform 0.25s';
            row.style.opacity    = '0';
            row.style.transform  = 'translateX(-10px)';
            setTimeout(() => row.remove(), 260);
            updateTotals(data);
            if (data.empty) setTimeout(() => location.reload(), 300);
        });
    });
})();
</script>
@endpush

@endsection
