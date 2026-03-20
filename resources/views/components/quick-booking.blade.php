{{-- ══════════════════════════════════════
     QUICK BOOKING — Homepage Section
     Services fetched from DB (cached 60 min)
══════════════════════════════════════ --}}

@php
    $quickServices = Cache::remember('quick_booking_services', now()->addMinutes(60), fn() =>
        \App\Models\Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name'])
    );
@endphp

<section class="bg-custom-primary py-16 px-6">
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

                <a href="{{ route('booking.index') }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-custom-primary hover:gap-3 transition-all duration-200 mt-2">
                    Full booking form
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Right — form --}}
            <div class="p-8 lg:p-10 flex flex-col gap-5">
                <h3 class="text-xl font-extrabold text-gray-900">Quick Booking</h3>

                <form action="{{ route('booking.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf

                    @if($errors->any())
                    <div class="text-xs text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-3">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   placeholder="John Doe" required
                                   class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 focus:outline-none focus:border-custom-primary focus:ring-2 focus:ring-red-100">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   placeholder="+254 700 000000" required
                                   class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 focus:outline-none focus:border-custom-primary focus:ring-2 focus:ring-red-100">
                        </div>
                    </div>

                    {{-- Registration --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Vehicle Registration</label>
                        <input type="text" name="reg" value="{{ old('reg') }}"
                               placeholder="e.g. KCA 123A" required
                               class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 focus:outline-none focus:border-custom-primary focus:ring-2 focus:ring-red-100">
                    </div>

                    {{-- Service dropdown — fetched from DB --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Service</label>
                        <select name="service" required
                                class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 bg-white transition-all duration-200 cursor-pointer focus:outline-none focus:border-custom-primary focus:ring-2 focus:ring-red-100">
                            <option value="" disabled selected>Select a service…</option>
                            @foreach($quickServices as $svc)
                            <option value="{{ $svc->name }}"
                                    data-id="{{ $svc->id }}"
                                    {{ old('service') === $svc->name ? 'selected' : '' }}>
                                {{ $svc->name }}
                            </option>
                            @endforeach
                        </select>
                        {{-- Pass the resolved service_id via JS on select change --}}
                        <input type="hidden" name="service_id" id="quick-service-id" value="{{ old('service_id') }}">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Date</label>
                            <input type="date" name="date" value="{{ old('date') }}" required
                                   min="{{ date('Y-m-d') }}"
                                   class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:outline-none focus:border-custom-primary focus:ring-2 focus:ring-red-100">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Time</label>
                            <select name="time" required
                                    class="booking-input w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-900 bg-white transition-all duration-200 cursor-pointer focus:outline-none focus:border-custom-primary focus:ring-2 focus:ring-red-100">
                                <option value="" disabled selected>Select time…</option>
                                @foreach(['08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM'] as $slot)
                                <option value="{{ $slot }}" {{ old('time') === $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                @endforeach
                            </select>
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
</section>

@push('scripts-stack')
<script>
    // Sync hidden service_id when dropdown changes
    document.querySelector('select[name="service"]')?.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('quick-service-id').value = selected.dataset.id ?? '';
    });
</script>
@endpush