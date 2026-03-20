@extends('layouts.default-menu-page')
@section('content')

{{-- ═══════════════════════════════════════════
    PREMAX AUTOCARE — HOME PAGE
    Sections: Hero → Services → How It Works → Booking → Testimonials
═══════════════════════════════════════════ --}}

<style>
    /* Hero background image with dark overlay */
    #hero {
        background-image: linear-gradient(to right, rgba(0,0,0,0.92) 40%, rgba(0,0,0,0.35) 100%),
                          url('{{ asset("assets/images/carwash.avif") }}');
        background-size: cover;
        background-position: center;
    }

    /* Connector line between How It Works steps */
    .step-connector {
        position: absolute;
        top: 40px;
        left: calc(50% + 44px);
        right: calc(-50% + 44px);
        height: 1px;
        background: linear-gradient(to right, #fca5a5, #fca5a5);
        opacity: 0.4;
    }

    /* Form input focus ring in brand color */
    .booking-input:focus {
        outline: none;
        border-color: #D31E24;
        box-shadow: 0 0 0 3px rgba(211,30,36,0.15);
    }
</style>

{{-- ══════════════════════════════════════
     1. HERO
══════════════════════════════════════ --}}
<section id="hero" class="min-h-[92vh] flex items-center">
     <!-- <div class="absolute inset-0 
        bg-[radial-gradient(#d4d4d8_1px,transparent_1px)] 
        [background-size:22px_22px] 
        opacity-40">
    </div> -->
    <div class="max-w-7xl mx-auto px-6 py-20 w-full">
        <div class="max-w-xl flex flex-col gap-6">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 bg-custom-primary/20 border border-custom-primary/40 text-custom-primary text-xs font-semibold px-3.5 py-1.5 rounded-full w-fit">
                <svg class="w-3.5 h-3.5 fill-custom-primary" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Top Rated Auto Care in Nairobi
            </div>

            {{-- Heading --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight">
                Premax Autocare &<br>
                <span class="text-custom-primary">Diagnostic Services</span>
            </h1>

            {{-- Sub --}}
            <p class="text-gray-300 text-base leading-relaxed max-w-md">
                Experience premium vehicle care with our expert team. From quick washes to full detailing and mechanical services, we treat your car like our own.
            </p>

            {{-- CTAs --}}
            <div class="flex items-center gap-3 flex-wrap mt-2">
                <a href="{{ url('/booking') }}"
                   class="inline-flex items-center gap-2 bg-custom-primary hover:bg-red-800 text-white font-bold text-sm
                          px-7 py-3.5 rounded-lg no-underline transition-all duration-200
                          shadow-[0_4px_16px_rgba(211,30,36,0.4)] hover:shadow-[0_6px_24px_rgba(211,30,36,0.5)] hover:-translate-y-px active:translate-y-0">
                    Book Service
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ url('/services') }}"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-sm
                          px-7 py-3.5 rounded-lg no-underline transition-all duration-200 backdrop-blur-sm">
                    View Services
                </a>
            </div>

            {{-- Stats --}}
            <div class="flex items-center gap-8 pt-4 border-t border-white/15 mt-2">
                <div>
                    <div class="text-2xl font-extrabold text-white">10+</div>
                    <div class="text-xs text-gray-400 mt-0.5">Years Exp.</div>
                </div>
                <div class="w-px h-8 bg-white/15"></div>
                <div>
                    <div class="text-2xl font-extrabold text-white">5k+</div>
                    <div class="text-xs text-gray-400 mt-0.5">Cars Serviced</div>
                </div>
                <div class="w-px h-8 bg-white/15"></div>
                <div>
                    <div class="text-2xl font-extrabold text-white">4.9</div>
                    <div class="text-xs text-gray-400 mt-0.5">Rating</div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════
     2. OUR PREMIUM SERVICES
══════════════════════════════════════ --}}
<x-featured-services />


{{-- ══════════════════════════════════════
     3. HOW IT WORKS
══════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center max-w-xl mx-auto mb-14">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">How It Works</h2>
            <p class="mt-3 text-gray-500 text-sm">A simple, hassle-free process to get your car serviced.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            @php
            $steps = [
                ['num' => 1, 'title' => 'Book Online',    'desc' => 'Choose your service and preferred time slot.',         'icon' => 'calendar'],
                ['num' => 2, 'title' => 'Bring Your Car', 'desc' => 'Drop off your vehicle at our secure facility.',        'icon' => 'car'],
                ['num' => 3, 'title' => 'We Service It',  'desc' => 'Our experts perform the requested services.',          'icon' => 'wrench'],
                ['num' => 4, 'title' => 'Drive Away',     'desc' => 'Pick up your clean, fully serviced vehicle.',          'icon' => 'thumb'],
            ];
            @endphp

            @foreach($steps as $i => $step)
            <div class="flex flex-col items-center text-center gap-4 relative">

                {{-- Connector line (not on last) --}}
                @if($i < 3)
                <div class="hidden lg:block step-connector"></div>
                @endif

                {{-- Icon circle --}}
                <div class="w-20 h-20 rounded-full bg-red-50 flex items-center justify-center shrink-0 relative z-10">
                    @if($step['icon'] === 'calendar')
                    <svg class="w-8 h-8 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    @elseif($step['icon'] === 'car')
                    <svg class="w-8 h-8 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 17H3a2 2 0 01-2-2v-4l2.5-6h13l2.5 6v4a2 2 0 01-2 2h-2m-9 0a2 2 0 104 0m5 0a2 2 0 104 0"/>
                    </svg>
                    @elseif($step['icon'] === 'wrench')
                    <svg class="w-8 h-8 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>
                    </svg>
                    @else
                    <svg class="w-8 h-8 text-custom-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3H14z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/>
                    </svg>
                    @endif
                </div>

                <div>
                    <h3 class="text-base font-bold text-gray-900">{{ $step['num'] }}. {{ $step['title'] }}</h3>
                    <p class="mt-1.5 text-sm text-gray-500 leading-relaxed max-w-[180px] mx-auto">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════
     4. QUICK BOOKING
══════════════════════════════════════ --}}
<!-- <section class="bg-custom-primary py-16 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-2">

            {{-- Left — dark panel --}}
            <div class="bg-custom-secondary p-8 lg:p-10 flex flex-col gap-6 justify-center">
                <h2 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">
                    Ready for a<br>premium service?
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Skip the line by booking your appointment online. We'll have a bay ready for you when you arrive.
                </p>
                <ul class="flex flex-col gap-3">
                    @foreach(['No waiting in line', 'Guaranteed time slot', 'Premium service quality'] as $perk)
                    <li class="flex items-center gap-3 text-sm text-gray-300">
                        <svg class="w-5 h-5 text-custom-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $perk }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Right — form --}}
            <div class="p-8 lg:p-10 flex flex-col gap-5">
                <h3 class="text-xl font-extrabold text-gray-900">Quick Booking</h3>

                <form action="{{ url('/booking') }}" method="POST" class="flex flex-col gap-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Name</label>
                            <input type="text" name="name" placeholder="John Doe" required
                                   class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Phone</label>
                            <input type="tel" name="phone" placeholder="+254 700 000000" required
                                   class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200">
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Service</label>
                        <select name="service" required
                                class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 bg-white transition-all duration-200 cursor-pointer">
                            <option>Basic Wash</option>
                            <option>Full Detailing</option>
                            <option>Engine Wash</option>
                            <option>Oil Change</option>
                            <option>Tire Services</option>
                            <option>Brake Check</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Date</label>
                            <input type="date" name="date" required
                                   class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 transition-all duration-200">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Time</label>
                            <input type="time" name="time" required
                                   class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 transition-all duration-200">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-custom-primary hover:bg-red-800 text-white font-bold text-sm py-3.5 rounded-xl
                                   transition-all duration-200 shadow-[0_4px_14px_rgba(211,30,36,0.35)] hover:-translate-y-px active:translate-y-0 mt-1">
                        Confirm Appointment
                    </button>
                </form>
            </div>

        </div>
    </div>
</section> -->
<x-quick-booking />


{{-- ══════════════════════════════════════
     5. TESTIMONIALS
══════════════════════════════════════ --}}
<x-testimonials />

@endsection