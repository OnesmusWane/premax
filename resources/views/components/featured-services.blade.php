{{-- ═══════════════════════════════════════════
     OUR SERVICES — Asymmetric masonry grid
     Component: <x-featured-services />
     Data: 6 random active services, rotated daily (cached)
     Layout: indices 0 & 4 span 2 cols (large), rest are 1 col
═══════════════════════════════════════════ --}}
<section id="services" class="py-24 md:py-32 px-6 bg-[#111111]">
    <div class="max-w-7xl mx-auto">

        <div class="mb-16 md:mb-24 max-w-2xl">
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                Our Expertise
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                Comprehensive Care.
            </h2>
            <p class="text-white/55 text-lg leading-relaxed">
                From routine maintenance to complex rebuilds, our studio is equipped to handle
                every aspect of luxury vehicle care with surgical precision.
            </p>
        </div>

        @if($services->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[minmax(280px,auto)]">
            @foreach($services as $service)
            @php
                $isLarge = $loop->index === 0 || $loop->index === 4;
            @endphp
            <div class="group relative bg-[#1a1a1a] border border-white/5 rounded-2xl p-8 flex flex-col justify-between
                        hover:border-white/15 transition-colors duration-300
                        {{ $isLarge ? 'md:col-span-2' : 'col-span-1' }}">

                <div>
                    {{-- Icon --}}
                    <div class="w-12 h-12 rounded-full bg-[#111111] border border-white/10 flex items-center justify-center mb-6
                                text-custom-primary group-hover:-translate-y-1 transition-transform duration-300">
                        @include('components.service-icon', ['icon' => $service->icon])
                    </div>

                    {{-- Category label --}}
                    <p class="text-[10px] text-white/25 uppercase tracking-widest mb-2">
                        {{ $service->serviceCategory->name ?? '' }}
                    </p>

                    <h3 class="text-xl font-semibold text-white mb-3">{{ $service->name }}</h3>
                    <p class="text-white/50 leading-relaxed text-sm">{{ $service->description }}</p>
                </div>

                <div class="mt-8">
                    @if($service->slug)
                    <a href="{{ route('services.show', $service->slug) }}"
                       class="inline-flex items-center text-sm font-medium text-white/50
                              group-hover:text-white transition-colors duration-200 no-underline">
                        Learn more
                        <span class="ml-2 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    @else
                    <a href="{{ url('/booking?service=' . $service->id) }}"
                       class="inline-flex items-center text-sm font-medium text-white/50
                              group-hover:text-white transition-colors duration-200 no-underline">
                        Book Now
                        <span class="ml-2 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    @endif
                </div>

            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-white/25 text-sm py-16">No services available at the moment.</p>
        @endif

        <div class="mt-16 text-center">
            <a href="{{ url('/services') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-transparent border border-white/15
                      text-white font-medium rounded-md hover:bg-white/5 transition-colors no-underline">
                View all services →
            </a>
        </div>

    </div>
</section>
