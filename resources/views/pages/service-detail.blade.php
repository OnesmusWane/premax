@php
    $pageTitle       = $service->name . ' | Premax Automotive Studio';
    $pageDescription = $service->description ?? 'Premium ' . $service->name . ' service at Premax Automotive Studio, Nairobi.';
    $pageKeyWords    = strtolower($service->name) . ', ' . strtolower($service->serviceCategory->name ?? '') . ', nairobi';

    // Duration string
    $durationStr = null;
    if ($service->duration_minutes) {
        if ($service->duration_minutes < 60) {
            $durationStr = $service->duration_minutes . ' mins';
        } elseif ($service->duration_minutes % 60 === 0) {
            $hrs = $service->duration_minutes / 60;
            $durationStr = $hrs . ' ' . Str::plural('hour', $hrs);
        } else {
            $durationStr = floor($service->duration_minutes / 60) . '-' . ceil($service->duration_minutes / 60) . ' hours';
        }
    }

    // Price string
    $priceStr = null;
    if ($service->price_from) {
        $priceStr = 'KES ' . number_format($service->price_from);
        if ($service->price_to) {
            $priceStr .= ' – ' . number_format($service->price_to);
        }
    }

    $features = is_string($service->features) ? json_decode($service->features, true) : ($service->features ?? []);
    $process  = is_string($service->process)  ? json_decode($service->process,  true) : ($service->process  ?? []);

    // Hero image — use service image or alternating fallback
    $heroImage = $service->image ? asset($service->image) : asset('assets/images/hero/home-clinic.webp');
    $pageImage = $heroImage;
@endphp

@extends('layouts.default-menu-page')

@section('head-tags')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Service",
  "name": "{{ addslashes($service->name) }}",
  "description": "{{ addslashes($service->description ?? '') }}",
  "url": "{{ route('services.show', $service->slug) }}",
  "image": "{{ $heroImage }}",
  "provider": {
    "@type": "AutoRepair",
    "name": "Premax Automotive Studio",
    "url": "{{ url('/') }}",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Nairobi",
      "addressCountry": "KE"
    }
  }@if($service->price_from),
  "offers": {
    "@type": "Offer",
    "priceCurrency": "KES",
    "price": "{{ $service->price_from }}",
    "availability": "https://schema.org/InStock"
  }@endif
}
</script>
@endsection

@section('content')

<div class="bg-[#111111]">

{{-- ── PAGE HERO (full-bleed image) ── --}}
<section class="relative h-[55vh] min-h-[420px] flex items-end overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ $heroImage }}" alt="{{ $service->name }}"
             class="w-full h-full object-cover scale-105" loading="eager" fetchpriority="high" decoding="async">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#111111] via-[#111111]/40 to-transparent"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12 pb-16 md:pb-24">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-white/40 mb-6">
            <a href="{{ url('/') }}" class="hover:text-white/70 transition-colors no-underline">Home</a>
            <svg class="w-3 h-3 text-white/25" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ url('/services') }}" class="hover:text-white/70 transition-colors no-underline">Services</a>
            <svg class="w-3 h-3 text-white/25" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white/70">{{ $service->name }}</span>
        </nav>

        <span class="block text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4">Service</span>
        <h1 class="text-4xl md:text-6xl font-bold text-white max-w-3xl leading-[1.05] tracking-tight">
            {{ $service->name }}
        </h1>
        @if($service->description)
        <p class="text-white/70 text-lg max-w-2xl mt-5 leading-relaxed font-light">
            {{ $service->description }}
        </p>
        @endif
    </div>
</section>


{{-- ── OVERVIEW + SIDEBAR ── --}}
<section class="py-24 md:py-32 px-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-16">

        {{-- ── MAIN CONTENT (2/3) ── --}}
        <div class="lg:col-span-2 space-y-0">

            {{-- Overview --}}
            <div class="mb-12">
                <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">Overview</span>
                <p class="text-white/75 text-lg md:text-xl leading-relaxed">
                    {{ $service->long_description ?: $service->description }}
                </p>
            </div>

            {{-- What's Included --}}
            @if(is_array($features) && count($features) > 0)
            <div class="pt-12 border-t border-white/10 mb-12">
                <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-6 block">
                    What's Included
                </span>
                <ul class="space-y-4">
                    @foreach($features as $feature)
                    <li class="flex items-start gap-4 text-white/75">
                        <div class="w-6 h-6 rounded-full bg-custom-primary/10 border border-custom-primary/40 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="leading-relaxed">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Our Approach --}}
            @if(is_array($process) && count($process) > 0)
            <div class="pt-12 border-t border-white/10">
                <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-6 block">
                    Our Approach
                </span>
                <div class="space-y-6">
                    @foreach($process as $i => $step)
                    <div class="grid gap-6 items-start" style="grid-template-columns: auto 1fr">
                        <span class="font-bold text-custom-primary text-2xl leading-none pt-0.5">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <div>
                            <h4 class="font-semibold text-white text-lg mb-1">{{ $step['title'] ?? $step['step'] ?? '' }}</h4>
                            <p class="text-white/55 leading-relaxed">{{ $step['detail'] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- ── SIDEBAR (1/3, sticky) ── --}}
        <aside class="lg:sticky lg:top-32 self-start">
            <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-8">

                {{-- Icon --}}
                <div class="w-14 h-14 rounded-full bg-[#111111] border border-white/10 flex items-center justify-center mb-6 text-custom-primary">
                    @include('components.service-icon', ['icon' => $service->icon])
                </div>

                <h3 class="font-semibold text-white text-xl mb-6">Service Summary</h3>

                <dl class="space-y-5 mb-8">
                    @if($durationStr)
                    <div class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-custom-primary mt-1 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                        </svg>
                        <div>
                            <dt class="text-[10px] uppercase tracking-widest text-white/30 mb-1">Duration</dt>
                            <dd class="text-white text-sm">{{ $durationStr }}</dd>
                        </div>
                    </div>
                    @endif

                    @if($priceStr)
                    <div class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-custom-primary mt-1 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <div>
                            <dt class="text-[10px] uppercase tracking-widest text-white/30 mb-1">Starting From</dt>
                            <dd class="text-white text-sm">{{ $priceStr }}</dd>
                        </div>
                    </div>
                    @endif
                </dl>

                <a href="{{ route('booking.index', ['service' => $service->id]) }}"
                   class="block w-full text-center px-6 py-3.5 bg-custom-primary text-white font-medium
                          rounded-md hover:bg-red-700 transition-colors no-underline mb-3
                          shadow-[0_4px_14px_rgba(211,30,36,0.30)]">
                    Book this service
                </a>
                <a href="{{ url('/services') }}"
                   class="flex items-center justify-center gap-2 w-full text-center px-6 py-3.5 bg-transparent
                          border border-white/15 text-white font-medium rounded-md hover:bg-white/5
                          transition-colors no-underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    All services
                </a>

            </div>
        </aside>

    </div>
</section>


{{-- ── RELATED SERVICES ── --}}
<section class="py-24 px-6 bg-[#0a0a0a] border-t border-white/5">
    <div class="max-w-7xl mx-auto">

        <div class="flex items-end justify-between mb-12">
            <div>
                <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
                    Further Care
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Related Services</h2>
            </div>
            <a href="{{ url('/services') }}"
               class="hidden md:inline-flex items-center gap-2 text-white/60 hover:text-white transition-colors
                      no-underline text-sm">
                View all
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($related as $rel)
            <a href="{{ route('services.show', $rel->slug) }}"
               class="group bg-[#1a1a1a] border border-white/5 rounded-2xl p-8
                      hover:border-white/15 transition-colors no-underline block">
                <div class="w-12 h-12 rounded-full bg-[#111111] border border-white/10 flex items-center justify-center mb-6
                            text-custom-primary group-hover:-translate-y-1 transition-transform duration-300">
                    @include('components.service-icon', ['icon' => $rel->icon])
                </div>
                <h3 class="font-semibold text-white text-xl mb-3 leading-snug">{{ $rel->name }}</h3>
                <p class="text-white/50 text-sm leading-relaxed mb-6">
                    {{ Str::limit($rel->description, 100) }}
                </p>
                <span class="inline-flex items-center text-sm text-white/40 group-hover:text-white transition-colors duration-200">
                    Learn more
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </span>
            </a>
            @empty
            {{-- No same-category services — fall back to any 3 services --}}
            @php
                $fallback = \App\Models\Service::where('id', '!=', $service->id)
                    ->where('is_active', true)->limit(3)->get();
            @endphp
            @foreach($fallback as $rel)
            <a href="{{ route('services.show', $rel->slug) }}"
               class="group bg-[#1a1a1a] border border-white/5 rounded-2xl p-8
                      hover:border-white/15 transition-colors no-underline block">
                <div class="w-12 h-12 rounded-full bg-[#111111] border border-white/10 flex items-center justify-center mb-6
                            text-custom-primary group-hover:-translate-y-1 transition-transform duration-300">
                    @include('components.service-icon', ['icon' => $rel->icon])
                </div>
                <h3 class="font-semibold text-white text-xl mb-3 leading-snug">{{ $rel->name }}</h3>
                <p class="text-white/50 text-sm leading-relaxed mb-6">
                    {{ Str::limit($rel->description, 100) }}
                </p>
                <span class="inline-flex items-center text-sm text-white/40 group-hover:text-white transition-colors duration-200">
                    Learn more
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </span>
            </a>
            @endforeach
            @endforelse
        </div>

    </div>
</section>


{{-- ── BOOKING ── --}}
<x-quick-booking />

</div>

@endsection
