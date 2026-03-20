@php
    $pageTitle       = 'Our Services | Premax Autocare — Nairobi';
    $pageDescription = 'Comprehensive auto care services in Nairobi — tyre fitting, wheel alignment, oil change, engine wash, panel beating, diagnostics and more. Book online today.';
    $pageKeyWords    = 'tyre services nairobi, wheel alignment nairobi, oil change nairobi, engine wash, panel beating nairobi, car diagnostics, auto garage kiambu road';
@endphp

@extends('layouts.default-menu-page')
@section('content')

{{-- ── PAGE HERO ── --}}
<section class="bg-custom-secondary py-16 text-center">
    <div class="max-w-2xl mx-auto px-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Our Services</h1>
        <p class="mt-3 text-gray-400 text-sm leading-relaxed">
            Comprehensive auto care solutions tailored to your vehicle's needs.<br>
            Quality service guaranteed.
        </p>
    </div>
</section>

{{-- ── CATEGORY FILTER TABS ── --}}
<div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm" id="category-nav">
    <div class="max-w-5xl mx-auto px-6 overflow-x-auto">
        <div class="flex items-center gap-1 py-3 min-w-max">
            {{-- "All" tab --}}
            <button type="button"
                    class="category-tab active px-4 py-2 rounded-full text-xs font-semibold border transition-all duration-150
                           bg-custom-primary text-white border-custom-primary"
                    data-target="all">
                All Services
            </button>
            @foreach($categories as $category)
            <button type="button"
                    class="category-tab px-4 py-2 rounded-full text-xs font-semibold border transition-all duration-150
                           bg-white text-gray-600 border-gray-300 hover:border-custom-primary hover:text-custom-primary"
                    data-target="cat-{{ $category->id }}">
                {{ $category->name }}
            </button>
            @endforeach
        </div>
    </div>
</div>

{{-- ── SERVICES CONTENT ── --}}
<div class="bg-gray-50 py-16">
    <div class="max-w-5xl mx-auto px-6 flex flex-col gap-16" id="services-container">

        @forelse($categories as $category)
        <div class="category-section" id="cat-{{ $category->id }}">

            {{-- Category heading --}}
            <div class="flex items-center gap-3 pb-3 border-b-2 border-gray-200 mb-6">
                <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center shrink-0">
                    @include('components.service-icon', ['icon' => $category->icon ?? 'wrench'])
                </div>
                <h2 class="text-xl font-extrabold text-gray-900">{{ $category->name }}</h2>
                <span class="ml-auto text-xs text-gray-400 font-medium">{{ $category->services->count() }} services</span>
            </div>

            @if($category->description)
            <p class="text-sm text-gray-500 -mt-3 mb-6 leading-relaxed">{{ $category->description }}</p>
            @endif

            {{-- Service cards grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($category->services as $service)
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col gap-3">

                    {{-- Top row: icon + price --}}
                    <div class="flex items-start justify-between">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center shrink-0 text-custom-primary">
                            @include('components.service-icon', ['icon' => $service->icon])
                        </div>
                        <div class="text-right">
                            <div class="text-[10px] text-gray-400 uppercase tracking-widest">
                                {{ $service->price_is_estimate ? 'From' : 'Price' }}
                            </div>
                            <div class="text-sm font-extrabold text-gray-900">
                                KES {{ number_format($service->price_from) }}
                                @if($service->price_to)
                                <span class="text-xs font-normal text-gray-400">
                                    – {{ number_format($service->price_to) }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Name + desc --}}
                    <div class="flex flex-col gap-1">
                        <h3 class="text-sm font-bold text-gray-900">{{ $service->name }}</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $service->description }}</p>
                    </div>

                    {{-- Footer: duration + book --}}
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100 mt-auto">
                        <span class="flex items-center gap-1.5 text-xs text-gray-400">
                            @if($service->duration_minutes)
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                            </svg>
                            @if($service->duration_minutes < 60)
                                {{ $service->duration_minutes }} mins
                            @elseif($service->duration_minutes % 60 === 0)
                                {{ $service->duration_minutes / 60 }} {{ Str::plural('hr', $service->duration_minutes / 60) }}
                            @else
                                {{ floor($service->duration_minutes / 60) }}h {{ $service->duration_minutes % 60 }}m
                            @endif
                            @else
                            <span class="text-gray-300">—</span>
                            @endif
                        </span>

                        <a href="{{ route('booking.index', ['service' => $service->id]) }}"
                           class="inline-flex items-center gap-1 text-xs font-bold text-custom-primary hover:gap-2 no-underline transition-all duration-200
                                  bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">
                            Book Now
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-20 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
            </svg>
            <p class="text-sm">No services available at the moment. Please check back soon.</p>
        </div>
        @endforelse

    </div>
</div>

{{-- ── CTA BANNER ── --}}
<section class="bg-custom-primary py-14 text-center px-6">
    <div class="max-w-2xl mx-auto flex flex-col items-center gap-4">
        <h2 class="text-2xl md:text-3xl font-extrabold text-white">Not sure what your car needs?</h2>
        <p class="text-red-200 text-sm leading-relaxed">
            Bring it in for a free basic inspection. Our experts will advise you on the best services for your vehicle.
        </p>
        <a href="{{ url('/contact') }}"
           class="inline-flex items-center bg-white text-custom-primary font-bold text-sm px-8 py-3 rounded-xl no-underline
                  hover:bg-gray-100 transition-colors duration-200 shadow-lg mt-2">
            Contact Us Today
        </a>
    </div>
</section>

@push('scripts-stack')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs     = document.querySelectorAll('.category-tab');
    const sections = document.querySelectorAll('.category-section');
    const nav      = document.getElementById('category-nav');

    function setActive(targetId) {
        // Update tab styles
        tabs.forEach(tab => {
            const isActive = tab.dataset.target === targetId;
            tab.classList.toggle('bg-custom-primary',  isActive);
            tab.classList.toggle('text-white',          isActive);
            tab.classList.toggle('border-custom-primary', isActive);
            tab.classList.toggle('bg-white',            !isActive);
            tab.classList.toggle('text-gray-600',       !isActive);
            tab.classList.toggle('border-gray-300',     !isActive);
        });

        if (targetId === 'all') {
            sections.forEach(s => s.style.display = '');
        } else {
            sections.forEach(s => {
                s.style.display = s.id === targetId ? '' : 'none';
            });
        }
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetId = tab.dataset.target;
            setActive(targetId);

            // Scroll past the sticky nav
            const container = document.getElementById('services-container');
            if (container) {
                const offset = (nav?.offsetHeight ?? 0) + 24;
                const top    = container.getBoundingClientRect().top + window.scrollY - offset;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

    // Support deep-linking: /services#cat-3
    const hash = window.location.hash.replace('#', '');
    if (hash && document.getElementById(hash)) {
        setActive(hash);
        setTimeout(() => {
            const el     = document.getElementById(hash);
            const offset = (nav?.offsetHeight ?? 0) + 24;
            const top    = el.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        }, 100);
    }
});
</script>
@endpush

@endsection