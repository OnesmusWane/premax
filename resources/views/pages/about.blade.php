@php
    $pageTitle       = 'About Us | Premax Autocare & Diagnostic Services';
    $pageDescription = 'Learn about Premax Autocare — 10+ years of premium auto care and diagnostics in Nairobi. Meet our expert team and discover our story.';
    $pageKeyWords    = 'about premax autocare, auto garage nairobi, car diagnostics nairobi, premax team, car service nairobi';
@endphp

@extends('layouts.default-menu-page')
@section('content')
{{-- ═══════════════════════════════════════════
    PREMAX AUTOCARE — ABOUT PAGE
═══════════════════════════════════════════ --}}

{{-- ── PAGE HERO ── --}}
<section class="bg-custom-secondary py-16 text-center">
    <div class="max-w-2xl mx-auto px-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">About Premax Autocare</h1>
        <p class="mt-3 text-gray-400 text-sm leading-relaxed">
            Setting the standard for premium auto care and diagnostics in Nairobi<br>since 2014.
        </p>
    </div>
</section>

{{-- ── OUR STORY ── --}}
<section class="bg-white py-20">
    <div class="max-w-5xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Image --}}
            <div class="rounded-2xl overflow-hidden shadow-md">
                <img src="{{ asset('assets/images/car.avif') }}"
                     alt="Premium car at Premax Autocare"
                     class="w-full h-full object-cover aspect-[4/3]">
            </div>

            {{-- Content --}}
            <div class="flex flex-col gap-6">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Our Story</h2>

                <div class="flex flex-col gap-4 text-sm text-gray-600 leading-relaxed">
                    <p>
                        Premax Autocare started with a simple mission: to provide a level of car care that we couldn't find anywhere else in Nairobi. What began as a small two-bay wash has grown into a comprehensive auto care facility.
                    </p>
                    <p>
                        We believe that your vehicle is an investment that deserves the best care. That's why we use only premium products, employ trained professionals, and constantly upgrade our equipment to ensure the highest quality results.
                    </p>
                </div>

                {{-- Stats --}}
                <div class="flex items-stretch gap-8 pt-2">
                    <div class="flex flex-col gap-0.5 pl-4 border-l-2 border-custom-primary">
                        <span class="text-2xl font-extrabold text-gray-900">10+</span>
                        <span class="text-xs text-gray-500">Years Experience</span>
                    </div>
                    <div class="flex flex-col gap-0.5 pl-4 border-l-2 border-custom-primary">
                        <span class="text-2xl font-extrabold text-gray-900">15k+</span>
                        <span class="text-xs text-gray-500">Happy Customers</span>
                    </div>
                    <div class="flex flex-col gap-0.5 pl-4 border-l-2 border-custom-primary">
                        <span class="text-2xl font-extrabold text-gray-900">4.9</span>
                        <span class="text-xs text-gray-500">Average Rating</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── WHY CHOOSE US ── --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-5xl mx-auto px-6">

        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Why Choose Us</h2>
            <p class="mt-2 text-gray-500 text-sm">Our core values drive everything we do.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
            $values = [
                [
                    'title' => 'Quality First',
                    'desc'  => 'We never compromise on the quality of our products or our workmanship.',
                    'icon'  => 'badge',
                ],
                [
                    'title' => 'Expert Team',
                    'desc'  => 'Our staff are highly trained professionals passionate about cars.',
                    'icon'  => 'users',
                ],
                [
                    'title' => 'Efficiency',
                    'desc'  => 'We value your time and strive to provide prompt, reliable service.',
                    'icon'  => 'clock',
                ],
                [
                    'title' => 'Trust & Honesty',
                    'desc'  => 'Transparent pricing and honest advice about what your car actually needs.',
                    'icon'  => 'shield',
                ],
            ];
            @endphp

            @foreach($values as $val)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col items-center text-center gap-4">

                <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                    @if($val['icon'] === 'badge')
                    <svg class="w-6 h-6 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    @elseif($val['icon'] === 'users')
                    <svg class="w-6 h-6 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    @elseif($val['icon'] === 'clock')
                    <svg class="w-6 h-6 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                    </svg>
                    @else
                    <svg class="w-6 h-6 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    @endif
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ $val['title'] }}</h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">{{ $val['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ── MEET THE TEAM ── --}}
@include('components.team-section')

{{-- ── CTA BANNER ── --}}
<section class="bg-custom-primary py-14 text-center px-6">
    <div class="max-w-2xl mx-auto flex flex-col items-center gap-4">
        <h2 class="text-2xl md:text-3xl font-extrabold text-white">Ready to experience the difference?</h2>
        <p class="text-red-200 text-sm leading-relaxed">
            Book your appointment today and let our team take care of your vehicle.
        </p>
        <div class="flex items-center gap-3 flex-wrap justify-center mt-2">
            <a href="{{ url('/booking') }}"
               class="inline-flex items-center gap-2 bg-white text-custom-primary font-bold text-sm px-7 py-3 rounded-xl no-underline
                      hover:bg-gray-100 transition-colors duration-200 shadow-lg">
                Book a Service
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ url('/contact') }}"
               class="inline-flex items-center gap-2 border border-white/40 text-white font-bold text-sm px-7 py-3 rounded-xl no-underline
                      hover:bg-white/10 transition-colors duration-200">
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection