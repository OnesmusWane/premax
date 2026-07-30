@php
    $pageTitle       = 'Premax Automotive Studio Nairobi | Car Detailing, Ceramic Coating & Auto Care';
    $pageDescription = 'Nairobi\'s premier automotive studio. Specialists in car detailing, ceramic coating, paint protection, OEM diagnostics and luxury vehicle care on Kiambu Road. Book today.';
    $pageKeyWords    = 'car detailing Nairobi, ceramic coating Nairobi, paint protection Nairobi, auto diagnostics Nairobi, luxury car service Nairobi, Premax Automotive Studio';
@endphp

@extends('layouts.default-menu-page')

@section('head-tags')
@php
$_homeContact = \Illuminate\Support\Facades\Cache::remember('contact.primary', now()->addMinutes(60), fn () =>
    \App\Models\ContactInformation::where('is_primary', true)->where('is_active', true)->first()
);
$_schema = [
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'       => 'AutoRepair',
            '@id'         => url('/') . '#business',
            'name'        => 'Premax Automotive Studio',
            'description' => 'Nairobi\'s premier automotive studio for car detailing, ceramic coating, paint protection and OEM diagnostics.',
            'url'         => url('/'),
            'telephone'   => $_homeContact->phone_primary ?? '',
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $_homeContact->street_address ?? '',
                'addressLocality' => $_homeContact->city ?? 'Nairobi',
                'addressCountry'  => 'KE',
            ],
            'geo'         => [
                '@type'     => 'GeoCoordinates',
                'latitude'  => $_homeContact->latitude ?? '',
                'longitude' => $_homeContact->longitude ?? '',
            ],
            'areaServed'  => 'Nairobi',
            'priceRange'  => '$$',
            'sameAs'      => array_values(array_filter([
                $_homeContact->facebook_url  ?? null,
                $_homeContact->instagram_url ?? null,
                $_homeContact->twitter_url   ?? null,
                $_homeContact->tiktok_url    ?? null,
            ])),
        ],
        [
            '@type'           => 'WebSite',
            '@id'             => url('/') . '#website',
            'url'             => url('/'),
            'name'            => 'Premax Automotive Studio',
            'description'     => 'Premium automotive care in Nairobi — car detailing, ceramic coating, paint protection and diagnostics.',
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => url('/services') . '?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ],
    ],
];
@endphp
<link rel="canonical" href="{{ url('/') }}">
<meta property="og:type"         content="website">
<meta property="og:url"          content="{{ url('/') }}">
<meta property="og:title"        content="{{ $pageTitle }}">
<meta property="og:description"  content="{{ $pageDescription }}">
<meta property="og:image"        content="{{ asset('assets/images/hero/home.webp') }}">
<meta property="og:locale"       content="en_KE">
<meta property="og:site_name"    content="Premax Automotive Studio">
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image"       content="{{ asset('assets/images/hero/home.webp') }}">
<script type="application/ld+json">{!! json_encode($_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endsection

@section('content')

<div class="bg-[#111111]">

{{-- ═══════════════════════════════════════════
     1. HERO
═══════════════════════════════════════════ --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0 z-0">
        <x-responsive-image path="assets/images/hero/home.webp"
             alt="Premax Automotive Studio Nairobi — premium car detailing and ceramic coating facility"
             class="w-full h-full object-cover object-center scale-105" :priority="true" />
        <div class="absolute inset-0 bg-black/65"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#111111] via-[#111111]/20 to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center mt-20">
        <span class="block text-white/40 text-xs font-bold tracking-[0.35em] uppercase mb-6">
            Nairobi &middot; Est. 2015
        </span>

        <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-8 leading-[1.08] tracking-tight">
            Engineering Excellence.<br>
            <span class="text-white/85">Unrivaled Care.</span>
        </h1>

        <p class="text-lg md:text-xl text-white/60 max-w-2xl mx-auto mb-12 font-light leading-relaxed">
            The premier automotive studio for luxury marques. Precision diagnostics, elite detailing,
            and meticulous maintenance for those who demand perfection.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/booking') }}"
               class="w-full sm:w-auto px-8 py-4 bg-custom-primary text-white font-semibold rounded-md
                      hover:bg-red-700 hover:scale-[1.02] transition-all duration-200
                      shadow-[0_4px_20px_rgba(211,30,36,0.4)] no-underline text-center">
                Book Executive Service
            </a>
            <a href="#studio"
               class="w-full sm:w-auto px-8 py-4 bg-transparent border border-white/20 text-white
                      font-medium rounded-md hover:bg-white/5 transition-all duration-200 no-underline text-center">
                Explore The Studio
            </a>
        </div>
    </div>

    {{-- Scroll hint --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
        <span class="text-[10px] text-white/30 uppercase tracking-[0.3em]">Scroll</span>
        <svg class="w-4 h-4 text-white/30 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

</section>

{{-- Hidden SEO layer — visible to crawlers, not to users --}}
<h1 class="sr-only">
    Premax Automotive Studio Nairobi — Car Detailing, Ceramic Coating, Paint Protection & Auto Care Experts
</h1>
<div class="sr-only">
    <p>
        Premax Automotive Studio is Nairobi's leading premium automotive care center,
        located on Kiambu Road near the Northern Bypass Junction. We specialize in
        professional car detailing, ceramic coating, paint protection film, OEM diagnostics,
        and full-service luxury vehicle maintenance across Nairobi and Kenya.
    </p>
    <p>
        Whether you need a full paint correction, a ceramic coating package, a paint protection film
        installation, or advanced automotive diagnostics, our factory-trained technicians deliver
        factory-level precision on every vehicle. Trusted by BMW, Mercedes-Benz, Porsche,
        Land Rover, Audi, and Range Rover owners across Nairobi since 2015.
    </p>
    <nav aria-label="Quick links">
        <a href="{{ url('/services') }}">Car detailing services Nairobi</a>
        <a href="{{ url('/services') }}">Ceramic coating Nairobi</a>
        <a href="{{ url('/services') }}">Paint protection Nairobi</a>
        <a href="{{ url('/booking') }}">Book a car service Nairobi</a>
        <a href="{{ url('/about') }}">About Premax Automotive Studio</a>
        <a href="{{ url('/contact') }}">Contact our Nairobi studio</a>
    </nav>
</div>


{{-- ═══════════════════════════════════════════
     2. PHILOSOPHY
═══════════════════════════════════════════ --}}
<section class="py-24 md:py-36 px-6 bg-[#111111]">
    <div class="max-w-4xl mx-auto text-center">

        <p class="text-2xl md:text-4xl font-medium text-white leading-relaxed mb-20">
            "We treat every vehicle not as a machine, but as a masterpiece of
            engineering. Our studio is built on the uncompromising pursuit of perfection."
        </p>

        <div class="grid grid-cols-3 gap-8 border-t border-white/5 pt-16">
            @foreach([['10+', 'Years of Craft'], ['5k+', 'Cars Serviced'], ['100%', 'OEM Standards']] as [$val, $lbl])
            <div class="flex flex-col items-center gap-2">
                <span class="text-4xl md:text-5xl font-bold text-white">{{ $val }}</span>
                <span class="text-xs text-white/35 uppercase tracking-widest">{{ $lbl }}</span>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════
     3. SERVICES  (component handles DB + cache)
═══════════════════════════════════════════ --}}
<x-featured-services />


{{-- ═══════════════════════════════════════════
     4. STUDIO
═══════════════════════════════════════════ --}}
<section id="studio" class="py-24 md:py-36 px-6 bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto">

        {{-- Row 1 — Facility --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-28">

            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden">
                <x-responsive-image path="assets/images/hero/home-clinic.webp"
                     alt="Premax Automotive Studio — dust-free car detailing bays and OEM diagnostic suites, Nairobi"
                     class="w-full h-full object-cover" />
                <div class="absolute inset-0 border border-white/8 rounded-2xl pointer-events-none"></div>
            </div>

            <div class="lg:pl-8">
                <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                    The Facility
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 leading-tight">
                    A Clinical Environment for Automotive Excellence.
                </h2>
                <p class="text-white/55 text-lg leading-relaxed mb-8">
                    Our studio is designed to rival the assembly lines of the marques we service.
                    Featuring epoxy floors, climate-controlled bays, and shadow-less LED lighting,
                    we ensure every vehicle is treated in a pristine, contaminant-free environment.
                </p>
                <ul class="space-y-4">
                    @foreach(['OEM-Grade Diagnostic Suites', 'Dust-Free Detailing Bays', 'Secure, Monitored Storage'] as $item)
                    <li class="flex items-center gap-4 text-white/70 text-sm">
                        <div class="w-1.5 h-1.5 bg-custom-primary rounded-full shrink-0"></div>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>

        {{-- Row 2 — Technicians --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div class="lg:pr-8 order-2 lg:order-1">
                <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                    The Technicians
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 leading-tight">
                    Master Craftsmen at Work.
                </h2>
                <p class="text-white/55 text-lg leading-relaxed mb-8">
                    Our team consists of factory-trained master technicians who possess an intimate
                    understanding of European engineering. They don't just replace parts;
                    they diagnose, rebuild, and refine.
                </p>
                <a href="{{ url('/about') }}"
                   class="inline-flex items-center gap-2 text-white font-medium hover:text-custom-primary transition-colors no-underline text-sm">
                    Meet the Team <span class="transition-transform group-hover:translate-x-1">→</span>
                </a>
            </div>

            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden order-1 lg:order-2">
                <x-responsive-image path="assets/images/hero/home-craft.webp"
                     alt="Factory-trained Premax technician performing luxury vehicle diagnostics and care in Nairobi"
                     class="w-full h-full object-cover" />
                <div class="absolute inset-0 border border-white/8 rounded-2xl pointer-events-none"></div>
            </div>

        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════
     5. MARQUES MARQUEE
═══════════════════════════════════════════ --}}
@php
    $brands = ['BMW', 'MERCEDES-BENZ', 'PORSCHE', 'LAND ROVER', 'AUDI', 'RANGE ROVER', 'JAGUAR', 'LEXUS', 'VOLVO'];
    $marqueeItems = array_merge($brands, $brands, $brands);
@endphp

<section class="py-20 border-y border-white/5 bg-[#111111] overflow-hidden">

    <div class="max-w-7xl mx-auto px-6 mb-10 text-center">
        <span class="text-white/25 text-xs font-bold tracking-[0.35em] uppercase">The Registry</span>
    </div>

    <div class="relative w-full flex overflow-hidden">
        <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-[#111111] to-transparent z-10 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-[#111111] to-transparent z-10 pointer-events-none"></div>

        <div class="flex w-max animate-marquee">
            @foreach($marqueeItems as $brand)
            <div class="flex items-center justify-center px-10 md:px-16">
                <span class="font-bold text-2xl md:text-3xl text-white/20 hover:text-white/65
                             transition-colors duration-300 cursor-default whitespace-nowrap tracking-wider">
                    {{ $brand }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

</section>


{{-- ═══════════════════════════════════════════
     6. PROCESS
═══════════════════════════════════════════ --}}
<section class="py-24 md:py-36 px-6 bg-[#111111]">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-20">
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                The Experience
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-white">
                Seamless from Start to Finish.
            </h2>
        </div>

        @php
        $steps = [
            ['01', 'Inquiry',    "Schedule a consultation to discuss your vehicle's needs with our service advisors."],
            ['02', 'Collection', 'Drop off at our studio or utilize our white-glove concierge collection service.'],
            ['03', 'Service',    'Meticulous execution of diagnostics, maintenance, or detailing by master technicians.'],
            ['04', 'Delivery',   'Final inspection, complimentary wash, and handover of your pristine vehicle.'],
        ];
        @endphp

        <div class="relative">
            {{-- Connecting line —  desktop --}}
            <div class="hidden md:block absolute top-6 left-0 w-full h-px bg-white/8"></div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10">
                @foreach($steps as [$num, $title, $desc])
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="w-12 h-12 rounded-full bg-[#111111] border border-custom-primary flex items-center justify-center mb-6
                                text-custom-primary font-bold text-sm shadow-[0_0_20px_rgba(211,30,36,0.18)]">
                        {{ $num }}
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-3">{{ $title }}</h3>
                    <p class="text-white/45 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════
     7. TESTIMONIALS  (component handles DB + cache)
═══════════════════════════════════════════ --}}
<x-testimonials />


{{-- ═══════════════════════════════════════════
     8. BOOKING  (component handles DB + cache)
═══════════════════════════════════════════ --}}
<x-quick-booking />

</div>{{-- /bg-[#111111] wrapper --}}

@endsection
