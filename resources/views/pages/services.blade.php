@php
    $pageTitle       = 'Our Services | Premax Automotive Studio — Nairobi';
    $pageDescription = 'A complete spectrum of services for luxury vehicles — diagnostics, detailing, tyres, alignment, oil change, panel beating and more. Book online today.';
    $pageKeyWords    = 'tyre services nairobi, wheel alignment nairobi, oil change nairobi, panel beating nairobi, car diagnostics, auto garage kiambu road';

    $activeCategoryObj = $categories->firstWhere('slug', $categorySlug);
    $activeCategoryName = $activeCategoryObj?->name ?? 'All Services';
    $activeCategoryDesc = $activeCategoryObj?->description ?? 'The complete catalogue.';
    $showingFrom = ($services->currentPage() - 1) * $services->perPage() + 1;
    $showingTo   = $showingFrom + $services->count() - 1;
    $totalShown  = $categorySlug === 'all' ? $totalAll : ($activeCategoryObj?->services->count() ?? 0);
@endphp

@extends('layouts.default-menu-page')

@section('head-tags')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Premax Automotive Studio Services",
  "url": "{{ route('services.index') }}",
  "itemListElement": [
    @foreach($services as $i => $svc)
    {
      "@type": "ListItem",
      "position": {{ $i + 1 }},
      "name": "{{ addslashes($svc->name) }}",
      "url": "{{ route('services.show', $svc->slug) }}"
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endsection

@section('content')

<div class="bg-[#111111]">

{{-- ── PAGE HERO (full-bleed image) ── --}}
<section class="relative h-[55vh] min-h-[420px] flex items-end overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('assets/images/hero/service.webp') }}"
             alt="Premax Automotive Studio services"
             class="w-full h-full object-cover scale-105">
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
            <span class="text-white/70">Services</span>
        </nav>

        <span class="block text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4">
            Our Expertise
        </span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white max-w-4xl leading-[1.05] tracking-tight">
            Services Crafted for the<br>Marques You Drive.
        </h1>
        <p class="text-white/70 text-lg md:text-xl max-w-2xl mt-6 leading-relaxed font-light">
            A complete spectrum of services for luxury vehicles, executed with
            manufacturer-level precision and presented with executive-level care.
        </p>
    </div>
</section>


{{-- ── STICKY CATEGORY FILTER BAR ── --}}
<div id="services-list-top"
     class="sticky top-[72px] z-30 bg-[#111111]/90 backdrop-blur-lg border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-3 py-5 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden -mx-1 px-1">

            {{-- All --}}
            <a href="{{ route('services.index') }}"
               class="group whitespace-nowrap shrink-0 px-5 py-2.5 rounded-full text-xs uppercase tracking-widest
                      font-medium border transition-all no-underline
                      {{ $categorySlug === 'all' ? 'bg-custom-primary border-custom-primary text-white' : 'bg-transparent border-white/15 text-white/60 hover:border-white/40 hover:text-white' }}">
                <span>All Services</span>
                <span class="ml-2 text-[10px] {{ $categorySlug === 'all' ? 'text-white/80' : 'text-white/30 group-hover:text-white/60' }}">{{ $totalAll }}</span>
            </a>

            @foreach($categories as $cat)
            <a href="{{ route('services.index', ['category' => $cat->slug]) }}"
               class="group whitespace-nowrap shrink-0 px-5 py-2.5 rounded-full text-xs uppercase tracking-widest
                      font-medium border transition-all no-underline
                      {{ $categorySlug === $cat->slug ? 'bg-custom-primary border-custom-primary text-white' : 'bg-transparent border-white/15 text-white/60 hover:border-white/40 hover:text-white' }}">
                <span>{{ $cat->name }}</span>
                <span class="ml-2 text-[10px] {{ $categorySlug === $cat->slug ? 'text-white/80' : 'text-white/30 group-hover:text-white/60' }}">{{ $cat->services->count() }}</span>
            </a>
            @endforeach

        </div>
    </div>
</div>


{{-- ── SERVICES CATALOGUE ── --}}
<section class="py-20 md:py-28 px-6">
    <div class="max-w-7xl mx-auto">

        {{-- Category context header --}}
        <div class="mb-16 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-3 block">
                    {{ $categorySlug === 'all' ? 'Catalogue' : 'Category' }}
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-white">
                    {{ $activeCategoryName }}
                </h2>
                @if($activeCategoryDesc)
                <p class="text-white/45 mt-2 text-sm">{{ $activeCategoryDesc }}</p>
                @endif
            </div>
            @if($services->count() > 0)
            <div class="text-sm text-white/30 shrink-0">
                Showing {{ $showingFrom }}–{{ $showingTo }} of {{ $services->total() }}
            </div>
            @endif
        </div>

        {{-- Service rows --}}
        @if($services->isEmpty())
        <div class="py-24 text-center border border-white/5 rounded-2xl bg-[#1a1a1a]">
            <p class="text-white/40">No services in this category yet.</p>
        </div>
        @else

        <div class="space-y-24 md:space-y-32">
            @foreach($services as $idx => $service)
            @php
                $globalIdx = ($services->currentPage() - 1) * $services->perPage() + $idx;
                $isReversed = $globalIdx % 2 === 1;
                $serviceImg = $service->image
                    ? asset($service->image)
                    : asset($globalIdx % 2 === 0 ? 'assets/images/hero/home-clinic.webp' : 'assets/images/hero/home-clinic.webp');
            @endphp
            <article class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

                {{-- Image panel --}}
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden {{ $isReversed ? 'lg:order-2' : '' }}">
                    <img src="{{ $serviceImg }}"
                         alt="{{ $service->name }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 border border-white/10 rounded-2xl pointer-events-none"></div>

                    {{-- Icon overlay --}}
                    <div class="absolute top-5 left-5 w-12 h-12 rounded-full bg-black/70 backdrop-blur-sm
                                border border-white/10 flex items-center justify-center text-custom-primary">
                        @include('components.service-icon', ['icon' => $service->icon])
                    </div>

                    {{-- Category badge --}}
                    <div class="absolute top-5 right-5 px-3 py-1.5 bg-black/70 backdrop-blur-sm
                                border border-white/10 rounded-full">
                        <span class="text-[10px] uppercase tracking-widest text-white/80">
                            {{ $service->serviceCategory->name ?? '' }}
                        </span>
                    </div>
                </div>

                {{-- Text panel --}}
                <div class="{{ $isReversed ? 'lg:order-1' : '' }}">
                    <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
                        {{ str_pad($globalIdx + 1, 2, '0', STR_PAD_LEFT) }} — Service
                    </span>
                    <h3 class="text-3xl md:text-4xl font-bold text-white mb-6 leading-tight">
                        {{ $service->name }}
                    </h3>
                    <p class="text-white/65 text-lg leading-relaxed mb-8">
                        {{ $service->long_description ?: $service->description }}
                    </p>

                    {{-- Duration + price meta --}}
                    <div class="flex flex-wrap gap-6 mb-10 text-sm">
                        @if($service->duration_minutes)
                        <div class="flex items-center gap-2 text-white/60">
                            <svg class="w-4 h-4 text-custom-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                            </svg>
                            @if($service->duration_minutes < 60)
                                {{ $service->duration_minutes }} mins
                            @elseif($service->duration_minutes % 60 === 0)
                                {{ $service->duration_minutes / 60 }} {{ Str::plural('hr', $service->duration_minutes / 60) }}
                            @else
                                {{ floor($service->duration_minutes / 60) }}-{{ ceil($service->duration_minutes / 60) }} hours
                            @endif
                        </div>
                        @endif
                        @if($service->price_from)
                        <div class="flex items-center gap-2 text-white/60">
                            <svg class="w-4 h-4 text-custom-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            From KES {{ number_format($service->price_from) }}
                        </div>
                        @endif
                    </div>

                    {{-- CTAs --}}
                    <div class="flex flex-col sm:flex-row gap-4">
                        @if($service->slug)
                        <a href="{{ route('services.show', $service->slug) }}"
                           class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white text-[#111111]
                                  font-semibold rounded-md hover:bg-white/90 transition-colors no-underline">
                            Full details
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        @endif
                        <a href="{{ route('booking.index', ['service' => $service->id]) }}"
                           class="inline-flex items-center justify-center px-6 py-3.5 bg-custom-primary text-white
                                  font-semibold rounded-md hover:bg-red-700 transition-colors no-underline
                                  shadow-[0_4px_14px_rgba(211,30,36,0.30)]">
                            Book this service
                        </a>
                    </div>
                </div>

            </article>
            @endforeach
        </div>

        {{-- ── PAGINATION ── --}}
        @if($services->lastPage() > 1)
        <nav aria-label="Pagination" class="flex items-center justify-center gap-2 mt-20">

            {{-- Prev --}}
            @if($services->onFirstPage())
            <span class="w-10 h-10 flex items-center justify-center rounded-full border border-white/10 text-white/25 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </span>
            @else
            <a href="{{ $services->previousPageUrl() }}#services-list-top"
               class="w-10 h-10 flex items-center justify-center rounded-full border border-white/15 text-white/60
                      hover:text-white hover:border-white/40 transition-colors no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            @endif

            {{-- Page numbers --}}
            <div class="flex items-center gap-1 mx-2">
                @php
                    $pages = [];
                    $delta = 1;
                    for ($i = 1; $i <= $services->lastPage(); $i++) {
                        if ($i === 1 || $i === $services->lastPage() ||
                            ($i >= $services->currentPage() - $delta && $i <= $services->currentPage() + $delta)) {
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
                    <a href="{{ $services->url($p) }}#services-list-top"
                       class="min-w-[40px] h-10 px-3 rounded-full text-sm font-medium transition-all no-underline
                              flex items-center justify-center
                              {{ $p === $services->currentPage() ? 'bg-custom-primary text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
                       aria-current="{{ $p === $services->currentPage() ? 'page' : 'false' }}">
                        {{ $p }}
                    </a>
                    @endif
                @endforeach
            </div>

            {{-- Next --}}
            @if($services->hasMorePages())
            <a href="{{ $services->nextPageUrl() }}#services-list-top"
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

        @endif {{-- end services not empty --}}

    </div>
</section>


{{-- ── BOOKING CTA ── --}}
<x-quick-booking />

</div>

@endsection
