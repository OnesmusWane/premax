@php
    $pageTitle = 'Services | Premax Auto Service Nairobi';
    $pageDescription = 'Luxury vehicle diagnostics, detailing, maintenance, bodywork, tyres, alignment and concierge care in Nairobi.';
    $heroImage = 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=2670&auto=format&fit=crop';
@endphp

@extends('layouts.default-menu-page')

@section('content')
<section class="relative flex h-[58vh] min-h-[460px] items-end overflow-hidden">
    <img src="{{ $heroImage }}" alt="Luxury vehicle services" class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-premax-dark via-premax-dark/45 to-transparent"></div>
    <div class="premax-container relative z-10 pb-16 md:pb-24">
        <div class="mb-6 flex items-center gap-2 text-xs uppercase tracking-widest text-premax-platinum/60">
            <a href="{{ url('/') }}" class="text-premax-platinum/60 no-underline hover:text-white">Home</a>
            <span>/</span>
            <span class="text-white">Services</span>
        </div>
        <span class="premax-eyebrow mb-4 block">Our Expertise</span>
        <h1 class="max-w-4xl font-display text-4xl font-extrabold leading-[1.05] text-white md:text-6xl lg:text-7xl">Services Crafted for the Marques You Drive.</h1>
        <p class="mt-6 max-w-2xl text-lg font-light leading-relaxed text-premax-platinum/80 md:text-xl">A complete spectrum of luxury European vehicle care, executed with manufacturer-level precision and executive-level communication.</p>
    </div>
</section>

<section id="category-nav" class="sticky top-[72px] z-30 border-b border-white/5 bg-premax-dark/90 backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-6 py-6">
        <div class="no-scrollbar flex items-center gap-3 overflow-x-auto">
            <button type="button" data-filter="all" class="category-tab rounded-full border border-premax-red bg-premax-red px-5 py-2.5 text-xs font-semibold uppercase tracking-widest text-white">All Services</button>
            @foreach($categories as $category)
                <button type="button" data-filter="cat-{{ $category->id }}" class="category-tab whitespace-nowrap rounded-full border border-white/15 px-5 py-2.5 text-xs font-semibold uppercase tracking-widest text-white/60 transition-colors hover:border-white/40 hover:text-white">
                    {{ $category->name }}
                    <span class="ml-2 text-[10px] text-white/30">{{ $category->services->count() }}</span>
                </button>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-premax-dark px-6 py-20 md:py-28">
    <div class="mx-auto max-w-7xl space-y-24 md:space-y-32" id="services-container">
        @forelse($categories as $category)
            @foreach($category->services as $service)
                @php
                    $image = match(true) {
                        str_contains(strtolower($service->name), 'detail') => 'https://images.unsplash.com/photo-1607860108855-64acf2078ed9?q=80&w=2670&auto=format&fit=crop',
                        str_contains(strtolower($service->name), 'diagnostic') => 'https://images.unsplash.com/photo-1486006920555-c77dcf18193c?q=80&w=2670&auto=format&fit=crop',
                        str_contains(strtolower($service->name), 'tyre') || str_contains(strtolower($service->name), 'wheel') => 'https://images.unsplash.com/photo-1601362840469-51e4d8d58785?q=80&w=2670&auto=format&fit=crop',
                        default => 'https://images.unsplash.com/photo-1632823471565-1ecdf5c6da77?q=80&w=2670&auto=format&fit=crop',
                    };
                    $isReversed = $loop->parent->iteration % 2 === 0;
                    $hours = $service->duration_minutes ? ($service->duration_minutes < 60 ? $service->duration_minutes . ' mins' : floor($service->duration_minutes / 60) . 'h' . ($service->duration_minutes % 60 ? ' ' . $service->duration_minutes % 60 . 'm' : '')) : 'By assessment';
                @endphp
                <article class="category-section grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-20" data-category="cat-{{ $category->id }}">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-2xl {{ $isReversed ? 'lg:order-2' : '' }}">
                        <img src="{{ $image }}" alt="{{ $service->name }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 rounded-2xl border border-white/10"></div>
                        <div class="absolute left-6 top-6 flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-black/70 text-premax-red backdrop-blur-sm">
                            @include('components.service-icon', ['icon' => $service->icon ?? 'wrench'])
                        </div>
                        <div class="absolute right-6 top-6 rounded-full border border-white/10 bg-black/70 px-3 py-1 backdrop-blur-sm">
                            <span class="text-[10px] uppercase tracking-widest text-white/80">{{ $category->name }}</span>
                        </div>
                    </div>
                    <div class="{{ $isReversed ? 'lg:order-1' : '' }}">
                        <span class="premax-eyebrow mb-4 block">Service</span>
                        <h2 class="mb-6 font-display text-3xl font-extrabold leading-tight text-white md:text-4xl">{{ $service->name }}</h2>
                        <p class="mb-8 text-lg leading-relaxed text-premax-platinum/70">{{ $service->description }}</p>
                        <div class="mb-8 flex flex-wrap gap-6 text-sm text-white/70">
                            <span>{{ $hours }}</span>
                            <span>From KES {{ number_format($service->price_from) }}</span>
                            @if($service->price_to)<span>Up to KES {{ number_format($service->price_to) }}</span>@endif
                        </div>
                        <a href="{{ route('booking.index', ['service' => $service->id]) }}" class="premax-button premax-button-primary">Book this service</a>
                    </div>
                </article>
            @endforeach
        @empty
            <div class="premax-card p-12 text-center text-premax-platinum/60">No services are currently published.</div>
        @endforelse
    </div>
</section>

<section class="border-t border-white/5 bg-[#0A0A0A] px-6 py-24 text-center">
    <span class="premax-eyebrow mb-4 block">Reservations</span>
    <h2 class="mx-auto mb-6 max-w-2xl font-display text-3xl font-extrabold text-white md:text-5xl">Not sure what your car needs?</h2>
    <p class="mx-auto mb-8 max-w-2xl text-premax-platinum/70">Start with an advisor-led inspection and we will recommend only the work your vehicle actually needs.</p>
    <a href="{{ url('/contact') }}" class="premax-button premax-button-ghost">Speak to an Advisor</a>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.category-tab');
    const sections = document.querySelectorAll('.category-section');
    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.filter;
            tabs.forEach((button) => {
                const active = button === tab;
                button.classList.toggle('bg-premax-red', active);
                button.classList.toggle('border-premax-red', active);
                button.classList.toggle('text-white', active);
                button.classList.toggle('text-white/60', !active);
            });
            sections.forEach((section) => {
                section.style.display = target === 'all' || section.dataset.category === target ? '' : 'none';
            });
        });
    });
});
</script>
@endsection
