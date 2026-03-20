{{-- ══════════════════════════════════════
     OUR PREMIUM SERVICES
     Component: <x-featured-services />
     Rotates 6 random services daily — cached until midnight.
══════════════════════════════════════ --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Header --}}
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Our Premium Services</h2>
            <p class="mt-3 text-gray-500 text-sm leading-relaxed">
                We offer a comprehensive range of auto care services to keep your vehicle looking and running its best.
            </p>
        </div>

        {{-- Cards grid --}}
        @if($services->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($services as $service)
            <div class="bg-white rounded-2xl p-6 flex flex-col gap-4 border transition-all duration-300 group
                        {{ $service->is_popular
                           ? 'border-custom-primary shadow-[0_8px_30px_rgba(211,30,36,0.15)] scale-[1.02]'
                           : 'border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-1 hover:border-custom-primary' }}">

                {{-- Icon --}}
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-red-50 text-custom-primary
                            group-hover:bg-custom-primary group-hover:text-white transition-colors duration-300">
                    @include('components.service-icon', ['icon' => $service->icon])
                </div>

                {{-- Content --}}
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1">
                        {{ $service->serviceCategory->name ?? '' }}
                    </p>
                    <h3 class="text-base font-bold text-gray-900">{{ $service->name }}</h3>
                    <p class="mt-1.5 text-sm text-gray-500 leading-relaxed">{{ $service->description }}</p>
                </div>

                {{-- Price + Book --}}
                <div class="mt-auto flex items-end justify-between pt-4 border-t border-gray-100">
                    <div>
                        <div class="text-[10px] text-gray-400 uppercase tracking-widest mb-0.5">
                            {{ $service->price_is_estimate ? 'From' : 'Price' }}
                        </div>
                        <div class="text-base font-extrabold text-gray-900">
                            KES {{ number_format($service->price_from) }}
                            @if($service->price_to)
                                <span class="text-sm font-normal text-gray-400">– {{ number_format($service->price_to) }}</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ url('/booking?service=' . $service->id) }}"
                       class="inline-flex items-center gap-1 text-sm font-bold text-custom-primary hover:gap-2 no-underline transition-all duration-200">
                        Book Now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-400 text-sm">No services available at the moment.</p>
        @endif

        <div class="text-center mt-8 flex justify-center">
            <a href="{{ url('/services') }}" class="text-semibold text-custom-primary flex gap-2 items-center">
                View All Services
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="w-5 h-5" aria-hidden="true">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</section>