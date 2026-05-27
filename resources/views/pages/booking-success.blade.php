@php
    $pageTitle       = 'Booking Confirmed | Premax';
    $pageDescription = 'Your service booking has been confirmed.';
    $pageKeyWords    = '';
    $pageNoIndex     = true;
@endphp

@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-36 pb-24 px-6 flex items-center justify-center">
    <div class="max-w-2xl w-full">

        {{-- ── Header ──────────────────────────────────────────────────────────── --}}
        <div class="text-center mb-12" id="bs-header" style="opacity:0;transform:translateY(20px)">
            <div class="w-20 h-20 rounded-full bg-custom-primary/10 border-2 border-custom-primary
                        flex items-center justify-center mx-auto mb-8">
                <svg class="w-8 h-8 text-custom-primary" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
                Booking Confirmed
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight">
                Reservation secured.
            </h1>
            <p class="text-white/55 text-lg max-w-xl mx-auto">
                A service advisor will reach out via WhatsApp and email shortly to confirm the details.
                Your reference is below.
            </p>
        </div>

        {{-- ── Reference card ──────────────────────────────────────────────────── --}}
        <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-8 mb-6"
             id="bs-card" style="opacity:0;transform:translateY(16px)">

            <div class="flex items-start justify-between pb-6 border-b border-white/8 mb-6">
                <div>
                    <div class="text-[10px] uppercase tracking-widest text-white/30 mb-1">Reference</div>
                    <div class="font-bold text-white text-2xl tabular-nums font-mono">{{ $booking->reference }}</div>
                </div>
                <div class="text-right">
                    <div class="text-[10px] uppercase tracking-widest text-white/30 mb-1">Status</div>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-custom-primary/10 border border-custom-primary/30
                                 rounded-full text-custom-primary text-[10px] uppercase tracking-widest font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-custom-primary animate-pulse"></span>
                        Pending Confirmation
                    </span>
                </div>
            </div>

            <dl class="space-y-0">

                <div class="flex items-center justify-between py-3.5 border-b border-white/5">
                    <dt class="text-xs uppercase tracking-widest text-white/30 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Service
                    </dt>
                    <dd class="text-white text-sm font-semibold text-right">
                        {{ $booking->service?->name ?? '—' }}
                    </dd>
                </div>

                <div class="flex items-center justify-between py-3.5 border-b border-white/5">
                    <dt class="text-xs uppercase tracking-widest text-white/30 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1m14-1h1l-3-9H13l3 9zM9 17l-2-1"/>
                        </svg>
                        Vehicle
                    </dt>
                    <dd class="text-right">
                        <div class="text-white text-sm font-bold font-mono">
                            {{ $booking->vehicle?->registration ?? '—' }}
                        </div>
                        @if($booking->vehicle && $booking->vehicle->make !== 'Unknown')
                        <div class="text-white/35 text-xs mt-0.5">
                            {{ $booking->vehicle->make }}
                            {{ $booking->vehicle->model !== 'Unknown' ? $booking->vehicle->model : '' }}
                        </div>
                        @endif
                    </dd>
                </div>

                <div class="flex items-center justify-between py-3.5 border-b border-white/5">
                    <dt class="text-xs uppercase tracking-widest text-white/30 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Date &amp; Time
                    </dt>
                    <dd class="text-white text-sm font-semibold text-right">
                        {{ $booking->scheduled_at?->format('D, d M Y') ?? '—' }}
                        <span class="text-white/40 font-normal">at</span>
                        {{ $booking->scheduled_at?->format('h:i A') ?? '—' }}
                    </dd>
                </div>

                <div class="flex items-start justify-between py-3.5">
                    <dt class="text-xs uppercase tracking-widest text-white/30 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Customer
                    </dt>
                    <dd class="text-right">
                        <div class="text-white text-sm font-semibold">{{ $booking->customer?->name ?? '—' }}</div>
                        <div class="text-white/35 text-xs mt-0.5">{{ $booking->customer?->phone ?? '—' }}</div>
                        @if($booking->customer?->email)
                        <div class="text-white/25 text-xs">{{ $booking->customer->email }}</div>
                        @endif
                    </dd>
                </div>

            </dl>
        </div>

        {{-- ── Actions ──────────────────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center" id="bs-actions" style="opacity:0;transform:translateY(12px)">

            @if($contact?->phone_whatsapp)
            <a href="https://wa.me/{{ ltrim($contact->phone_whatsapp_e164, '+') }}?text=Hi+Premax%2C+I+just+booked+a+{{ urlencode($booking->service?->name ?? 'service') }}+appointment.+My+reference+is+{{ $booking->reference }}."
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#25d366] text-white font-semibold
                      rounded-md hover:bg-[#1ebe5c] transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Confirm via WhatsApp
            </a>
            @endif

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
    function fadeIn(el, delay) {
        if (!el) return;
        setTimeout(function () {
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            el.style.opacity    = '1';
            el.style.transform  = 'translateY(0)';
        }, delay);
    }
    fadeIn(document.getElementById('bs-header'),  60);
    fadeIn(document.getElementById('bs-card'),    220);
    fadeIn(document.getElementById('bs-actions'), 380);
})();
</script>
@endpush

@endsection
