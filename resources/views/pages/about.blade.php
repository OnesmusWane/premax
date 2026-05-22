@php
    $pageTitle = 'About Premax | Luxury Automotive Studio Nairobi';
    $pageDescription = 'Premax is a Nairobi automotive studio built by engineers and trusted by luxury car enthusiasts.';
@endphp

@extends('layouts.default-menu-page')

@section('content')
<section class="relative flex h-[58vh] min-h-[460px] items-end overflow-hidden">
    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=2670&auto=format&fit=crop" alt="Premax automotive studio" class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-premax-dark via-premax-dark/45 to-transparent"></div>
    <div class="premax-container relative z-10 pb-16 md:pb-24">
        <span class="premax-eyebrow mb-4 block">About The Studio</span>
        <h1 class="max-w-4xl font-display text-4xl font-extrabold leading-[1.05] text-white md:text-6xl lg:text-7xl">Built by Engineers. Trusted by Enthusiasts.</h1>
        <p class="mt-6 max-w-2xl text-lg font-light leading-relaxed text-premax-platinum/80 md:text-xl">Premax was founded on a simple conviction: luxury vehicles in Nairobi deserve the same caliber of care available in Munich, Stuttgart, or Solihull.</p>
    </div>
</section>

<section class="bg-premax-dark px-6 py-24 md:py-32">
    <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-16 lg:grid-cols-2">
        <div class="relative aspect-[4/5] overflow-hidden rounded-2xl">
            <img src="https://images.unsplash.com/photo-1487754180451-c456f719a1fc?q=80&w=2670&auto=format&fit=crop" alt="Premax workshop interior" class="h-full w-full object-cover">
            <div class="absolute inset-0 rounded-2xl border border-white/10"></div>
        </div>
        <div>
            <span class="premax-eyebrow mb-4 block">Our Story</span>
            <h2 class="mb-8 font-display text-3xl font-extrabold leading-tight text-white md:text-5xl">A studio, not a garage.</h2>
            <div class="space-y-6 text-lg leading-relaxed text-premax-platinum/75">
                <p>Premax began with a refusal to accept the status quo of independent automotive service in Nairobi.</p>
                <p>Today, the facility combines diagnostic discipline, careful detailing, documented service records, and a concierge mindset for clients who notice the details.</p>
                <p>Our clients arrive by referral, reputation, and the quiet recommendation of people who expect work to be done properly the first time.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#0A0A0A] px-6 py-24 md:py-32">
    <div class="mx-auto max-w-7xl">
        <div class="mb-16 text-center">
            <span class="premax-eyebrow mb-4 block">Our Principles</span>
            <h2 class="font-display text-3xl font-extrabold text-white md:text-5xl">What We Stand For.</h2>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['Uncompromising Integrity', 'Transparent estimates, evidence-based recommendations, and no work without your consent.'],
                ['Engineering First', 'We diagnose causes, not symptoms, with a deep understanding of each marque.'],
                ['Factory-Level Talent', 'Technicians with experience, discipline, and respect for manufacturer standards.'],
                ['Client as Partner', 'Long-term stewardship of your vehicle with direct advisor communication.'],
            ] as [$title, $description])
                <article class="premax-card p-8 transition-colors hover:border-white/15">
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-premax-dark text-premax-red">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.6-4A12 12 0 0 1 12 3 12 12 0 0 1 3.4 6 12 12 0 0 0 12 21a12 12 0 0 0 8.6-15Z"/></svg>
                    </div>
                    <h3 class="mb-3 font-display text-lg font-semibold text-white">{{ $title }}</h3>
                    <p class="text-sm leading-relaxed text-premax-platinum/60">{{ $description }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-premax-dark px-6 py-24 md:py-32">
    <div class="mx-auto max-w-7xl">
        <div class="mb-16 max-w-2xl">
            <span class="premax-eyebrow mb-4 block">The People</span>
            <h2 class="mb-6 font-display text-3xl font-extrabold text-white md:text-5xl">Master Craftsmen.</h2>
            <p class="text-lg leading-relaxed text-premax-platinum/70">Decades of factory training, distilled into one studio.</p>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            @foreach([
                ['James Mwangi', 'Founder & Master Technician', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=2670&auto=format&fit=crop'],
                ['Aisha Karanja', 'Head of Detailing Studio', 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=2576&auto=format&fit=crop'],
                ['David Otieno', 'Diagnostics Lead', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=2574&auto=format&fit=crop'],
            ] as [$name, $role, $image])
                <article class="group">
                    <div class="mb-6 aspect-[3/4] overflow-hidden rounded-2xl border border-white/5">
                        <img src="{{ $image }}" alt="{{ $name }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <h3 class="mb-1 font-display text-xl font-semibold text-white">{{ $name }}</h3>
                    <p class="mb-3 text-xs uppercase tracking-widest text-premax-red">{{ $role }}</p>
                    <p class="text-sm leading-relaxed text-premax-platinum/60">Factory-trained, detail-driven, and trusted with complex European marques.</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
