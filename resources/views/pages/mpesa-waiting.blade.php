@php
    $pageTitle       = 'Complete Payment | Premax Boutique';
    $pageDescription = 'Waiting for M-Pesa payment confirmation.';
    $pageKeyWords    = '';
    $pageNoIndex     = true;
@endphp

@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-36 pb-24 px-6 flex items-center justify-center">
    <div class="max-w-md w-full text-center">

        {{-- Animated phone icon --}}
        <div class="w-20 h-20 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center mx-auto mb-8 animate-pulse">
            <svg class="w-9 h-9 text-green-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3"/>
            </svg>
        </div>

        <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">M-PESA</span>
        <h1 class="text-3xl font-bold text-white mb-3">Check Your Phone</h1>
        <p class="text-white/50 text-sm leading-relaxed mb-2">
            An M-PESA payment request of
            <span class="text-white font-semibold">KES {{ number_format($order->total) }}</span>
            has been sent to <span class="text-white font-semibold">{{ $order->payment_reference }}</span>.
        </p>
        <p class="text-white/40 text-sm mb-10">Enter your M-PESA PIN to complete the purchase.</p>

        {{-- Status indicator --}}
        <div id="status-box" class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-6 mb-6">
            <div id="status-waiting" class="flex items-center justify-center gap-3 text-white/60">
                <svg class="w-4 h-4 animate-spin text-custom-primary" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                <span class="text-sm">Waiting for payment confirmation…</span>
            </div>
            <div id="status-paid" class="hidden flex-col items-center gap-2 text-green-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-semibold">Payment confirmed! Redirecting…</span>
            </div>
            <div id="status-failed" class="hidden flex-col items-center gap-2 text-custom-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-semibold">Payment failed or cancelled.</span>
            </div>
        </div>

        <p class="text-white/25 text-xs mb-6">Order <span class="font-mono">{{ $order->order_number }}</span></p>

        <a href="{{ route('account') }}" id="account-link"
           class="inline-flex items-center gap-2 text-white/30 hover:text-white transition-colors text-sm no-underline">
            Skip to my account
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>

    </div>
</div>

{{-- Data bridge: pre-render URLs server-side so the script stays linter-clean --}}
<div id="mpesa-data"
     data-status-url="{{ route('mpesa.status', $order->id) }}"
     data-success-url="{{ route('mpesa.success', $order->id) }}"
     style="display:none"></div>

@push('scripts-stack')
<script>
(function () {
    var mpesaData  = document.getElementById('mpesa-data').dataset;
    var statusUrl  = mpesaData.statusUrl;
    var successUrl = mpesaData.successUrl;
    var maxPolls = 36; // 3 minutes at 5-second intervals
    var polls    = 0;
    var interval;

    function show(id) {
        ['waiting','paid','failed'].forEach(s => {
            const el = document.getElementById('status-' + s);
            if (el) el.classList.toggle('hidden', s !== id);
            if (el && s === id) el.classList.add('flex');
        });
    }

    async function poll() {
        polls++;
        if (polls > maxPolls) {
            clearInterval(interval);
            return;
        }

        try {
            const res  = await fetch(statusUrl, { headers: { Accept: 'application/json' } });
            const data = await res.json();

            if (data.payment_status === 'paid') {
                clearInterval(interval);
                show('paid');
                setTimeout(function () { window.location.href = successUrl; }, 2000);
            } else if (data.payment_status === 'failed' || data.payment_status === 'cancelled') {
                clearInterval(interval);
                show('failed');
            }
        } catch (e) {
            // network error — keep polling
        }
    }

    interval = setInterval(poll, 5000);
    poll(); // immediate first check
})();
</script>
@endpush

@endsection
