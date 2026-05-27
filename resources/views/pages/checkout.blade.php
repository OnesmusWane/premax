@php
    $pageTitle       = 'Checkout | Premax Boutique';
    $pageDescription = 'Complete your Premax order.';
    $pageKeyWords    = '';
    $pageNoIndex     = true;
    $errors ??= new Illuminate\Support\ViewErrorBag();
@endphp

@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-36 pb-24 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-10">

        {{-- ── FORMS ── --}}
        <div>
            <form id="checkout-form" class="space-y-6">
                @csrf

                {{-- Contact --}}
                <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-8">
                    <h2 class="text-lg font-semibold text-white mb-6">Contact</h2>
                    <div>
                        <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Email</label>
                        <input type="email" name="contact_email"
                               value="{{ old('contact_email', auth()->user()->email ?? '') }}"
                               required
                               class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm focus:outline-none focus:border-custom-primary transition-colors">
                    </div>
                </div>

                {{-- Delivery address --}}
                <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-8">
                    <h2 class="text-lg font-semibold text-white mb-6">Delivery Address</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                   class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm focus:outline-none focus:border-custom-primary transition-colors">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                   class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm focus:outline-none focus:border-custom-primary transition-colors">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" required
                                   placeholder="Estate, road or building name"
                                   class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm focus:outline-none focus:border-custom-primary transition-colors">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">City</label>
                            <input type="text" name="city" value="{{ old('city', 'Nairobi') }}" required
                                   class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm focus:outline-none focus:border-custom-primary transition-colors">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Phone</label>
                            <input type="tel" name="phone"
                                   value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                   required placeholder="+254..."
                                   class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm focus:outline-none focus:border-custom-primary transition-colors">
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-8">
                    <h2 class="text-lg font-semibold text-white mb-6 flex items-center gap-2">
                        Payment
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </h2>

                    <input type="hidden" name="payment_method" value="mpesa">

                    {{-- M-Pesa fields --}}
                    <div id="mpesa-fields" class="space-y-4">
                        <div class="flex items-center gap-3 px-5 py-4 rounded-xl border border-custom-primary bg-custom-primary/10">
                            <svg class="w-5 h-5 text-custom-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-white">M-PESA</p>
                                <p class="text-xs text-white/40">You'll receive a payment prompt on your phone</p>
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">M-PESA Phone Number</label>
                            <input type="tel" name="mpesa_phone" id="mpesa_phone"
                                   value="{{ old('mpesa_phone', auth()->user()->phone ?? '') }}"
                                   placeholder="+254 7XX XXX XXX"
                                   class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm focus:outline-none focus:border-custom-primary transition-colors">
                        </div>
                        <p class="text-white/40 text-xs leading-relaxed">
                            You will receive an M-PESA STK push to confirm payment of
                            <strong class="text-white">KES {{ number_format($total) }}</strong>.
                            Keep your phone nearby.
                        </p>
                    </div>

                </div>

                {{-- Error banner --}}
                <div id="error-banner" class="hidden bg-red-900/30 border border-red-500/40 rounded-2xl px-6 py-4">
                    <p class="text-red-300 text-sm font-semibold" id="error-message"></p>
                </div>

            </form>

            {{-- ── PAYMENT STATUS (shown after submission) ── --}}
            <div id="payment-status-section" class="hidden bg-[#1a1a1a] border border-white/10 rounded-2xl p-8 mt-6">

                {{-- M-Pesa pending --}}
                <div id="stk-pending-state" class="hidden text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center mx-auto animate-pulse">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold">Check Your Phone</p>
                        <p class="text-white/50 text-sm mt-1">M-PESA prompt sent to <span id="stk-phone-display" class="text-white font-semibold"></span></p>
                        <p class="text-white/30 text-xs mt-2">Enter your PIN to complete payment</p>
                    </div>
                    <div class="flex items-center justify-center gap-2 text-white/40 text-sm">
                        <svg class="w-4 h-4 animate-spin text-custom-primary" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        Waiting for confirmation…
                    </div>
                    <button type="button" onclick="cancelPayment()"
                        class="text-white/30 hover:text-white text-xs transition-colors">
                        Cancel &amp; try different payment
                    </button>
                </div>

                {{-- M-Pesa success --}}
                <div id="payment-success-state" class="hidden text-center space-y-3">
                    <div class="w-16 h-16 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-green-400 font-semibold">Payment Confirmed!</p>
                    <p class="text-white/40 text-sm">Redirecting to your order…</p>
                </div>

                {{-- M-Pesa failed --}}
                <div id="payment-failed-state" class="hidden text-center space-y-3">
                    <div class="w-16 h-16 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-custom-primary font-semibold">Payment Failed or Cancelled</p>
                    <p class="text-white/40 text-sm">No charge was made.</p>
                    <button type="button" onclick="cancelPayment()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white text-sm font-semibold rounded-xl transition-colors">
                        Try Again
                    </button>
                </div>

            </div>
        </div>

        {{-- ── ORDER SUMMARY ── --}}
        <aside class="lg:sticky lg:top-32 self-start">
            <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-8">
                <h2 class="text-lg font-semibold text-white mb-6">Order Summary</h2>

                {{-- Items --}}
                <ul class="space-y-4 mb-6">
                    @foreach($cart as $item)
                    <li class="flex items-center gap-3">
                        <div class="relative w-12 h-12 rounded-lg overflow-hidden bg-[#222] shrink-0">
                            @if(!empty($item['image']))
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            @endif
                            <span class="absolute -top-1 -right-1 w-4.5 h-4.5 rounded-full bg-white/20 text-white text-[9px]
                                         flex items-center justify-center font-bold tabular-nums">
                                {{ $item['qty'] }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-xs font-medium truncate">{{ $item['name'] }}</p>
                        </div>
                        <span class="text-white text-sm font-medium tabular-nums shrink-0">
                            KES {{ number_format($item['price'] * $item['qty']) }}
                        </span>
                    </li>
                    @endforeach
                </ul>

                <dl class="space-y-2.5 border-t border-white/10 pt-5 mb-5 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-white/50">Subtotal</dt>
                        <dd class="text-white">KES {{ number_format($subtotal) }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-white/50">Shipping</dt>
                        <dd class="text-white">{{ $shipping === 0 ? 'Free' : 'KES ' . number_format($shipping) }}</dd>
                    </div>
                </dl>

                <div class="flex items-center justify-between border-t border-white/10 pt-4 mb-7">
                    <span class="text-[10px] uppercase tracking-widest text-white/30">Total</span>
                    <span class="text-2xl font-bold text-white">KES {{ number_format($total) }}</span>
                </div>

                <button type="button" id="place-order-btn" onclick="placeOrder()"
                        class="block w-full text-center px-6 py-4 bg-custom-primary text-white font-semibold
                               rounded-md hover:bg-red-700 transition-colors
                               shadow-[0_4px_14px_rgba(211,30,36,0.30)] disabled:opacity-60">
                    <span id="btn-text" class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Place Order — KES {{ number_format($total) }}
                    </span>
                    <span id="btn-loading" class="hidden flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        Processing…
                    </span>
                </button>

                <p class="text-center text-[10px] text-white/20 mt-4">
                    By placing this order, you agree to our
                    <a href="{{ route('legal.show', 'terms-of-service') }}" class="text-white/40 hover:text-white transition-colors no-underline">Terms</a>
                    and
                    <a href="{{ route('legal.show', 'privacy-policy') }}" class="text-white/40 hover:text-white transition-colors no-underline">Privacy Policy</a>.
                </p>
            </div>
        </aside>

    </div>
</div>

@push('scripts-stack')
<script>
(function () {
    var pollTimer    = null;
    var checkoutUrl  = '{{ route("checkout.store") }}';
    var csrfToken    = '{{ csrf_token() }}';

    // ── State helpers ─────────────────────────────────────────────────────────
    function showState(id) {
        ['stk-pending-state', 'payment-success-state', 'payment-failed-state'].forEach(function (s) {
            var el = document.getElementById(s);
            if (el) el.classList.toggle('hidden', s !== id);
        });
        document.getElementById('payment-status-section').classList.remove('hidden');
    }

    function showError(msg) {
        var banner = document.getElementById('error-banner');
        document.getElementById('error-message').textContent = msg;
        banner.classList.remove('hidden');
        banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function resetBtn() {
        document.getElementById('btn-text').classList.remove('hidden');
        document.getElementById('btn-loading').classList.add('hidden');
        document.getElementById('place-order-btn').disabled = false;
    }

    // ── Polling ───────────────────────────────────────────────────────────────
    function startPolling(statusUrl, successUrl) {
        var maxPolls = 36, polls = 0;
        pollTimer = setInterval(async function () {
            if (++polls > maxPolls) { clearInterval(pollTimer); return; }
            try {
                var res  = await fetch(statusUrl, { headers: { Accept: 'application/json' } });
                var data = await res.json();
                if (data.payment_status === 'paid') {
                    clearInterval(pollTimer);
                    showState('payment-success-state');
                    setTimeout(function () { window.location.href = successUrl; }, 2000);
                } else if (data.payment_status === 'failed' || data.payment_status === 'cancelled') {
                    clearInterval(pollTimer);
                    showState('payment-failed-state');
                }
            } catch (e) { /* keep polling */ }
        }, 5000);
    }

    // ── Cancel / retry ────────────────────────────────────────────────────────
    window.cancelPayment = function () {
        if (pollTimer) clearInterval(pollTimer);
        document.getElementById('payment-status-section').classList.add('hidden');
        document.getElementById('error-banner').classList.add('hidden');
        resetBtn();
    };

    // ── Place order ───────────────────────────────────────────────────────────
    window.placeOrder = async function () {
        document.getElementById('error-banner').classList.add('hidden');
        document.getElementById('btn-text').classList.add('hidden');
        document.getElementById('btn-loading').classList.remove('hidden');
        document.getElementById('place-order-btn').disabled = true;

        var formData = new FormData(document.getElementById('checkout-form'));

        try {
            var response = await fetch(checkoutUrl, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: formData,
            });

            var data = await response.json();

            if (!response.ok) {
                var msg = data.message || 'Please check your details and try again.';
                if (data.errors) {
                    msg = Object.values(data.errors).flat().join(' ');
                }
                showError(msg);
                resetBtn();
                return;
            }

            document.getElementById('stk-phone-display').textContent = data.mpesa_phone || '';
            showState('stk-pending-state');
            startPolling(data.status_url, data.success_url);

        } catch (e) {
            showError('A network error occurred. Please try again.');
            resetBtn();
        }
    };
})();
</script>
@endpush

@endsection
