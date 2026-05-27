@php
    $pageTitle       = 'About Premax Automotive Studio Nairobi | Car Detailing & Auto Care Experts';
    $pageDescription = 'Premax Automotive Studio — Nairobi\'s premier destination for car detailing, ceramic coating, paint protection, diagnostics and premium auto care. Over 10 years of factory-level precision.';
    $pageKeyWords    = 'car detailing Nairobi, ceramic coating Nairobi, auto care Nairobi, paint protection Nairobi, auto diagnostics Kenya, premium car care Nairobi';
@endphp

@extends('layouts.default-menu-page')

@section('head-tags')
@php
$_aboutContact = \Illuminate\Support\Facades\Cache::remember('contact.primary', now()->addMinutes(60), fn () =>
    \App\Models\ContactInformation::where('is_primary', true)->where('is_active', true)->first()
);
$_schema = [
    '@context'    => 'https://schema.org',
    '@type'       => 'AutoRepair',
    'name'        => 'Premax Automotive Studio',
    'description' => 'Premium automotive studio in Nairobi specializing in car detailing, ceramic coating, paint protection and diagnostics.',
    'url'         => url('/about'),
    'telephone'   => $_aboutContact->phone_primary ?? '',
    'address'     => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $_aboutContact->street_address ?? '',
        'addressLocality' => $_aboutContact->city ?? 'Nairobi',
        'addressCountry'  => 'KE',
    ],
    'areaServed'  => 'Nairobi',
    'priceRange'  => '$$',
];
@endphp
<script type="application/ld+json">{!! json_encode($_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endsection

@section('content')

<div class="bg-[#111111]">

{{-- ── HERO ── --}}
<section class="relative pt-40 pb-28 px-6 bg-[#0a0a0a] overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('assets/images/hero/about.webp') }}" alt=""
            class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-[#0a0a0a]/75"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(211,30,36,0.08)_0%,transparent_60%)]"></div>
    </div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(211,30,36,0.06)_0%,transparent_60%)]"></div>
    <div class="relative max-w-7xl mx-auto">
        <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
            Our Story
        </span>
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight tracking-tight max-w-3xl">
            Built on an Uncompromising Pursuit of Perfection.
        </h1>
        <p class="text-white/55 text-lg leading-relaxed max-w-xl">
            Since 2015, Premax has been the standard for luxury vehicle care in Nairobi —
            a studio built by craftsmen, for those who demand excellence.
        </p>
    </div>
</section>
<h1 class="sr-only">
    About Premax Automotive Studio Nairobi – Car Detailing, Diagnostics & Auto Care Experts
</h1>

<div class="max-w-3xl mx-auto text-white/60 mt-8 leading-relaxed">
    <p>
        Premax Automotive Studio is a premium automotive care center based in Nairobi, Kenya,
        specializing in car detailing, ceramic coating, paint protection, diagnostics, and full-service auto care.
    </p>

    <p class="mt-4">
        Since 2015, we have served thousands of vehicle owners across Nairobi and Kenya,
        delivering factory-level precision and luxury-grade automotive restoration services.
    </p>
</div>


{{-- ── OUR STORY ── --}}
<section class="py-24 px-6 border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden">
                <img src="{{ asset('assets/images/about-support.webp') }}"
                     alt="Premax Automotive Studio"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 border border-white/8 rounded-2xl pointer-events-none"></div>
            </div>

            <div>
                <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                    The Beginning
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-8 leading-tight">
                    A Studio Born from Passion.
                </h2>
                <div class="space-y-5 text-white/55 leading-relaxed">
                    <p>
                        Premax Automotive Studio was founded with a singular vision: to create an
                        environment where luxury vehicles receive the same level of attention and
                        precision as they did at the factory.
                    </p>
                    <p>
                        What began as a specialist detail and wash operation has evolved into a
                        comprehensive automotive studio — offering everything from OEM-grade diagnostics
                        to full paint correction and mechanical rebuilds.
                    </p>
                    <p>
                        Every decision we make, every product we select, every technician we hire is
                        guided by one question: is this good enough for the marques we service?
                    </p>
                    <p>
                        Today, Premax is recognized for premium car detailing in Nairobi, ceramic coating,
                        paint protection, and advanced automotive diagnostics across Kenya.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-8 mt-12 pt-8 border-t border-white/5">
                    @foreach([['10+', 'Years of Craft'], ['15k+', 'Clients Served'], ['4.9★', 'Average Rating']] as [$val, $lbl])
                    <div>
                        <div class="text-3xl font-bold text-white mb-1">{{ $val }}</div>
                        <div class="text-xs text-white/30 uppercase tracking-widest">{{ $lbl }}</div>
                    </div>
                    @endforeach
                </div>
                <p class="text-white/40 text-sm mt-6">
                    Trusted by luxury and daily vehicle owners across Nairobi for premium automotive care and detailing services.
                </p>
            </div>

        </div>
    </div>
</section>


{{-- ── PHILOSOPHY ── --}}
<section class="py-24 px-6 bg-[#0a0a0a] border-t border-white/5">
    <div class="max-w-7xl mx-auto">

        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                Philosophy
            </span>
            <blockquote class="text-2xl md:text-3xl font-medium text-white leading-relaxed">
                "We don't treat vehicles as machines. We treat them as masterpieces of engineering
                that deserve an equally engineered standard of care."
            </blockquote>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $pillars = [
                ['Quality First',   'We never compromise on products, process, or workmanship. Every job is held to the same uncompromising standard.', 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                ['Expert Team',     'Factory-trained technicians with an intimate understanding of the marques they service. Craft, not just skill.', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['Efficiency',      'Your time is as valuable as your vehicle. We operate with precision scheduling and transparent communication throughout.', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['Total Honesty',   'Transparent pricing, honest assessments, and no unnecessary upsells. You receive exactly what your vehicle needs — nothing more.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ];
            @endphp

            @foreach($pillars as [$title, $desc, $path])
            <div class="bg-[#1a1a1a] border border-white/5 rounded-2xl p-8">
                <div class="w-10 h-10 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center mb-6">
                    <svg class="w-5 h-5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-white mb-3">{{ $title }}</h3>
                <p class="text-white/40 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ── THE FACILITY ── --}}
<section class="py-24 px-6 border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div class="order-2 lg:order-1">
                <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                    The Facility
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-8 leading-tight">
                    Engineered for Excellence.
                </h2>
                <p class="text-white/55 leading-relaxed mb-8">
                    Our studio was designed to mirror the precision environments in which these
                    vehicles were manufactured. Climate-controlled bays, shadow-free LED lighting,
                    dust-free zones, and OEM diagnostic suites — every detail considered.
                </p>
                <ul class="space-y-4">
                    @foreach(['OEM-Grade Diagnostic Suites', 'Dust-Free Detailing Bays', 'Climate-Controlled Paint Zone', 'Secure, Monitored Compound', 'Epoxy Floor System'] as $item)
                    <li class="flex items-center gap-4 text-white/60 text-sm">
                        <div class="w-1.5 h-1.5 bg-custom-primary rounded-full shrink-0"></div>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden order-1 lg:order-2">
                <img src="{{ asset('assets/images/about-engineering.webp') }}"
                     alt="Premax Studio Facility"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 border border-white/8 rounded-2xl pointer-events-none"></div>
            </div>

        </div>
    </div>
</section>


{{-- ── MEET THE TEAM ── --}}
@include('components.team-section')


{{-- ── MARQUES ── --}}
@php
    $brands = ['BMW', 'MERCEDES-BENZ', 'PORSCHE', 'LAND ROVER', 'AUDI', 'RANGE ROVER', 'JAGUAR', 'LEXUS', 'VOLVO'];
    $marqueeItems = array_merge($brands, $brands, $brands);
@endphp

<section class="py-20 border-t border-white/5 bg-[#0a0a0a] overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 mb-10 text-center">
        <span class="text-white/20 text-xs font-bold tracking-[0.35em] uppercase">Vehicles We Service</span>
    </div>
    <div class="relative w-full flex overflow-hidden">
        <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-[#0a0a0a] to-transparent z-10 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-[#0a0a0a] to-transparent z-10 pointer-events-none"></div>
        <div class="flex w-max animate-marquee">
            @foreach($marqueeItems as $brand)
            <div class="flex items-center px-10 md:px-14">
                <span class="font-bold text-xl md:text-2xl text-white/15 hover:text-white/50 transition-colors duration-300 cursor-default whitespace-nowrap tracking-wider">
                    {{ $brand }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ── CTA ── --}}
<section class="py-24 px-6 border-t border-white/5">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to Experience the Difference?
        </h2>
        <p class="text-white/50 text-lg mb-6 leading-relaxed">
            Book your vehicle in for a consultation and let our team demonstrate why
            Premax is Nairobi's premier automotive studio.
        </p>
        <p class="text-white/30 text-sm mb-10 leading-relaxed">
            Explore our <a href="{{ url('/services') }}" class="text-custom-primary hover:underline">car detailing services</a>,
            <a href="{{ url('/services') }}" class="text-custom-primary hover:underline">ceramic coating in Nairobi</a>,
            and <a href="{{ url('/services') }}" class="text-custom-primary hover:underline">paint protection services</a>.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/booking') }}"
               class="w-full sm:w-auto px-8 py-4 bg-custom-primary text-white font-semibold rounded-md
                      hover:bg-red-700 hover:scale-[1.02] transition-all duration-200
                      shadow-[0_4px_20px_rgba(211,30,36,0.4)] no-underline text-center">
                Book Executive Service
            </a>
            <a href="{{ url('/contact') }}"
               class="w-full sm:w-auto px-8 py-4 bg-transparent border border-white/15 text-white
                      font-medium rounded-md hover:bg-white/5 transition-all duration-200 no-underline text-center">
                Contact Us
            </a>
        </div>
    </div>
</section>

</div>

@endsection
