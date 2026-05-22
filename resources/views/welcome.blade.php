@php
    use App\Models\Service;
    use App\Models\Review;
    use Illuminate\Support\Facades\Cache;

    $pageTitle = 'Premax Auto Service | Luxury Automotive Studio Nairobi';
    $pageDescription = 'Premium diagnostics, detailing, maintenance, bodywork and concierge vehicle care for luxury marques in Nairobi.';

    $featuredServices = rescue(fn () =>
        Cache::remember('home.featured-services.premium', now()->addMinutes(30), fn () =>
            Service::with('serviceCategory')->where('is_active', true)->orderByDesc('is_popular')->orderBy('sort_order')->take(6)->get()
        ),
        collect()
    );

    $testimonial = rescue(fn () =>
        Cache::remember('home.featured-review.premium', now()->addMinutes(30), fn () =>
            Review::where('status', 'approved')->where('show_on_website', true)->orderByDesc('is_featured')->latest('reviewed_at')->first()
        ),
        null
    );

    $brands = ['BMW', 'MERCEDES-BENZ', 'PORSCHE', 'LAND ROVER', 'AUDI', 'RANGE ROVER', 'JAGUAR', 'LEXUS', 'VOLVO'];
@endphp

@extends('layouts.default-menu-page')

@section('content')
<section class="relative flex min-h-screen items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1614200187524-dc4b892acf16?q=80&w=2574&auto=format&fit=crop" alt="Luxury car detail" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-premax-dark via-transparent to-transparent"></div>
    </div>
    <div class="relative z-10 mx-auto mt-20 max-w-5xl px-6 text-center">
        <span class="mb-6 block text-xs font-bold uppercase tracking-[0.3em] text-premax-muted">Nairobi · Est. 2015</span>
        <h1 class="mb-8 font-display text-5xl font-extrabold leading-[1.1] text-white md:text-7xl lg:text-8xl">
            Engineering Excellence.<br>
            <span class="text-white/90">Unrivaled Care.</span>
        </h1>
        <p class="mx-auto mb-12 max-w-2xl text-lg font-light leading-relaxed text-premax-platinum/80 md:text-xl">
            The premier automotive studio for luxury marques. Precision diagnostics, elite detailing, and meticulous maintenance for those who demand perfection.
        </p>
        <div class="flex flex-col items-center justify-center gap-5 sm:flex-row">
            <a href="{{ url('/booking') }}" class="premax-button premax-button-primary w-full sm:w-auto">Book Executive Service</a>
            <a href="#studio" class="premax-button premax-button-ghost w-full sm:w-auto">Explore The Studio</a>
        </div>
    </div>
    <a href="#philosophy" class="absolute bottom-10 left-1/2 z-10 flex -translate-x-1/2 flex-col items-center gap-2 text-xs uppercase tracking-widest text-white/50 no-underline">
        Scroll
        <svg class="h-5 w-5 animate-bounce" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
    </a>
</section>

<section id="philosophy" class="bg-premax-dark px-6 py-24 md:py-32">
    <div class="mx-auto max-w-4xl text-center">
        <h2 class="mb-16 font-display text-2xl font-medium leading-relaxed text-white md:text-4xl">
            "We treat every vehicle not as a machine, but as a masterpiece of engineering. Our studio is built on the uncompromising pursuit of perfection."
        </h2>
        <div class="grid grid-cols-1 gap-12 border-t border-white/5 pt-16 md:grid-cols-3">
            @foreach([['10+','Years of Craft'], ['4','Core Marques'], ['100%','OEM Standards']] as [$value, $label])
                <div class="flex flex-col items-center gap-2">
                    <span class="font-display text-4xl font-extrabold text-white md:text-5xl">{{ $value }}</span>
                    <span class="text-sm uppercase tracking-widest text-premax-muted">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="services" class="bg-premax-dark px-6 py-24 md:py-32">
    <div class="mx-auto max-w-7xl">
        <div class="mb-16 max-w-2xl md:mb-24">
            <span class="premax-eyebrow mb-4 block">Our Expertise</span>
            <h2 class="mb-6 font-display text-4xl font-extrabold text-white md:text-5xl">Comprehensive Care.</h2>
            <p class="text-lg leading-relaxed text-premax-platinum/70">From routine maintenance to complex diagnostics, our studio is equipped to handle every aspect of luxury vehicle care with surgical precision.</p>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            @forelse($featuredServices as $service)
                <article class="premax-card group flex min-h-[280px] flex-col justify-between p-8 transition-colors hover:border-white/15 {{ $loop->first || $loop->iteration === 5 ? 'md:col-span-2' : '' }}">
                    <div>
                        <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-premax-dark text-premax-red transition-transform group-hover:-translate-y-1">
                            @include('components.service-icon', ['icon' => $service->icon ?? 'wrench'])
                        </div>
                        <h3 class="mb-3 font-display text-xl font-semibold text-white">{{ $service->name }}</h3>
                        <p class="text-sm leading-relaxed text-premax-platinum/60">{{ $service->description }}</p>
                    </div>
                    <div class="mt-8 flex items-center justify-between gap-4">
                        <span class="text-xs uppercase tracking-widest text-white/35">{{ $service->serviceCategory?->name }}</span>
                        <a href="{{ route('booking.index', ['service' => $service->id]) }}" class="text-sm font-medium text-white/55 no-underline transition-colors group-hover:text-white">Book now &rarr;</a>
                    </div>
                </article>
            @empty
                <div class="premax-card p-8 text-premax-platinum/60 md:col-span-3">Services will appear here once published.</div>
            @endforelse
        </div>
        <div class="mt-16 text-center">
            <a href="{{ url('/services') }}" class="premax-button premax-button-ghost">View all services &rarr;</a>
        </div>
    </div>
</section>

<section id="studio" class="bg-[#0A0A0A] px-6 py-24 md:py-32">
    <div class="mx-auto max-w-7xl">
        <div class="mb-32 grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
            <div class="relative aspect-[4/3] overflow-hidden rounded-2xl">
                <img src="https://images.unsplash.com/photo-1635784063858-3610996c9c61?q=80&w=2670&auto=format&fit=crop" alt="Spotless modern workshop bay" class="h-full w-full object-cover">
                <div class="absolute inset-0 rounded-2xl border border-white/10"></div>
            </div>
            <div class="lg:pl-12">
                <span class="premax-eyebrow mb-4 block">The Facility</span>
                <h2 class="mb-6 font-display text-3xl font-extrabold text-white md:text-4xl">A Clinical Environment for Automotive Excellence.</h2>
                <p class="mb-8 text-lg leading-relaxed text-premax-platinum/70">Our studio is designed to rival the assembly lines of the marques we service, with clean work bays, diagnostic discipline, secure storage, and careful handover.</p>
                <ul class="space-y-4">
                    @foreach(['OEM-grade diagnostic suites', 'Dust-free detailing bays', 'Secure, monitored storage'] as $item)
                        <li class="flex items-center text-premax-platinum/80"><span class="mr-4 h-1.5 w-1.5 rounded-full bg-premax-red"></span>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
            <div class="order-2 lg:order-1 lg:pr-12">
                <span class="premax-eyebrow mb-4 block">The Experience</span>
                <h2 class="mb-6 font-display text-3xl font-extrabold text-white md:text-4xl">Seamless from Start to Finish.</h2>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4 lg:grid-cols-2">
                    @foreach([['01','Inquiry'], ['02','Collection'], ['03','Service'], ['04','Delivery']] as [$num, $title])
                        <div>
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full border border-premax-red bg-premax-dark font-display text-sm font-bold text-premax-red shadow-[0_0_15px_rgba(211,47,47,0.2)]">{{ $num }}</div>
                            <h3 class="mb-2 font-display text-lg font-semibold text-white">{{ $title }}</h3>
                            <p class="text-sm leading-relaxed text-premax-platinum/60">A precise, documented step in the ownership-care journey.</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="relative order-1 aspect-[4/3] overflow-hidden rounded-2xl lg:order-2">
                <img src="https://images.unsplash.com/photo-1504222490345-c075b6008014?q=80&w=2670&auto=format&fit=crop" alt="Technician working on luxury car" class="h-full w-full object-cover">
                <div class="absolute inset-0 rounded-2xl border border-white/10"></div>
            </div>
        </div>
    </div>
</section>

<section class="overflow-hidden border-y border-white/5 bg-premax-dark py-24">
    <div class="mx-auto mb-12 max-w-7xl px-6 text-center">
        <span class="text-xs font-bold uppercase tracking-[0.3em] text-premax-muted">The Registry</span>
    </div>
    <div class="relative flex w-full overflow-hidden">
        <div class="absolute bottom-0 left-0 top-0 z-10 w-32 bg-gradient-to-r from-premax-dark to-transparent"></div>
        <div class="absolute bottom-0 right-0 top-0 z-10 w-32 bg-gradient-to-l from-premax-dark to-transparent"></div>
        <div class="flex w-max animate-[marquee_42s_linear_infinite] hover:[animation-play-state:paused]">
            @foreach(array_merge($brands, $brands, $brands) as $brand)
                <div class="flex items-center justify-center px-12 md:px-20">
                    <span class="whitespace-nowrap font-display text-2xl font-extrabold tracking-wider text-white/30 transition-colors hover:text-white/80 md:text-4xl">{{ $brand }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#0A0A0A] px-6 py-24 md:py-32">
    <div class="relative mx-auto max-w-4xl text-center">
        <div class="absolute -top-12 left-1/2 -translate-x-1/2 select-none font-display text-8xl text-premax-red/20">"</div>
        <blockquote class="relative z-10 mb-12 font-display text-2xl font-medium leading-relaxed text-white md:text-4xl">
            "{{ $testimonial?->body ?? 'The level of detail and transparency at Premax is unmatched in Nairobi. It is not just a garage; it truly is a studio.' }}"
        </blockquote>
        <div class="flex flex-col items-center">
            <span class="font-medium tracking-wide text-white">{{ $testimonial?->reviewer_name ?? 'David K.' }}</span>
            <span class="mt-1 text-sm text-premax-muted">{{ $testimonial?->service?->name ?? 'Porsche 911 Carrera S Owner' }}</span>
        </div>
    </div>
</section>

<section class="border-t border-white/5 bg-premax-dark px-6 py-24 md:py-32">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-16 lg:grid-cols-2 lg:gap-24">
        <div>
            <span class="premax-eyebrow mb-4 block">Reservations</span>
            <h2 class="mb-8 font-display text-3xl font-extrabold text-white md:text-5xl">Book Executive Service.</h2>
            <p class="mb-10 text-lg text-premax-platinum/70">Secure your appointment at the studio. A service advisor will confirm details and arrange concierge collection where required.</p>
            <a href="{{ url('/booking') }}" class="premax-button premax-button-primary">Start Booking</a>
        </div>
        <div class="relative hidden min-h-[480px] overflow-hidden rounded-2xl lg:block">
            <img src="https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?q=80&w=2669&auto=format&fit=crop" alt="Luxury car interior detail" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-premax-dark/80 to-transparent"></div>
        </div>
    </div>
</section>

<style>
@keyframes marquee {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
}
</style>
@endsection
