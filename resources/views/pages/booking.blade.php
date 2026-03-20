@php
    $pageTitle       = 'Book a Service | Premax Autocare Nairobi';
    $pageDescription = 'Book your car service appointment online at Premax Autocare. Choose your service, pick a time slot, and skip the queue. Located on Kiambu Road, Nairobi.';
    $pageKeyWords    = 'book car service nairobi, car wash booking, auto appointment nairobi, premax booking';
@endphp

@extends('layouts.default-menu-page')
@section('content')

{{-- ═══════════════════════════════════════════
    PREMAX AUTOCARE — BOOKING PAGE
    Services fetched from DB, grouped by category
═══════════════════════════════════════════ --}}

<style>
    .booking-input:focus {
        outline: none;
        border-color: #D31E24;
        box-shadow: 0 0 0 3px rgba(211,30,36,0.12);
    }
    .time-slot.selected {
        background: #D31E24;
        color: #fff;
        border-color: #D31E24;
    }
    .service-card.selected {
        border-color: #D31E24;
        background: #fff5f5;
    }
    .step-line {
        transition: background-color 0.4s ease;
    }
</style>

<div class="bg-gray-100 min-h-screen py-12 px-4">
    <div class="max-w-2xl mx-auto">

        {{-- Title --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Book an Appointment</h1>
            <p class="mt-2 text-sm text-gray-500">Schedule your service in just a few simple steps.</p>
        </div>

        {{-- ── STEPPER ── --}}
        <div class="flex items-center justify-center mb-8 px-4" id="stepper">
            @php $steps = ['Service','Vehicle','Time','Details','Confirm']; @endphp
            @foreach($steps as $i => $label)
                <div class="flex flex-col items-center relative" data-step="{{ $i + 1 }}">
                    <div class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300
                                {{ $i === 0 ? 'bg-custom-primary border-custom-primary text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                        <span class="step-num">{{ $i + 1 }}</span>
                        <svg class="step-check hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.801 10A10 10 0 1 1 17 3.335"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 11 3 3L22 4"/>
                        </svg>
                    </div>
                    <span class="step-label absolute -bottom-5 text-[10px] text-gray-400 whitespace-nowrap">{{ $label }}</span>
                </div>
                @if($i < count($steps) - 1)
                <div class="step-line flex-1 h-0.5 bg-gray-300 mx-1" data-line="{{ $i + 1 }}"></div>
                @endif
            @endforeach
        </div>

        {{-- ── STEP PANELS ── --}}
        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- ── STEP 1: Select Service ── --}}
            <div id="step-1" class="step-panel p-7">
                <h2 class="flex items-center gap-2 text-lg font-extrabold text-gray-900 mb-5">
                    <svg class="w-5 h-5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>
                    </svg>
                    Select Service
                </h2>

                {{-- Category tabs (if multiple categories) --}}
                @if($services->count() > 1)
                <div class="flex flex-wrap gap-2 mb-4" id="category-tabs">
                    @foreach($services->keys() as $catIndex => $catName)
                    <button type="button"
                            class="category-tab px-3 py-1.5 rounded-full text-xs font-semibold border transition-all duration-150
                                   {{ $catIndex === 0 ? 'bg-custom-primary text-white border-custom-primary' : 'bg-white text-gray-600 border-gray-300 hover:border-custom-primary' }}"
                            data-category="{{ Str::slug($catName) }}">
                        {{ $catName }}
                    </button>
                    @endforeach
                </div>
                @endif

                {{-- Service cards grouped by category --}}
                @foreach($services as $categoryName => $categoryServices)
                <div class="category-group grid grid-cols-2 gap-3" data-group="{{ Str::slug($categoryName) }}"
                     style="{{ !$loop->first ? 'display:none' : '' }}">
                    @foreach($categoryServices as $svc)
                    <button type="button"
                            class="service-card text-left px-4 py-3 rounded-xl border-2 border-gray-200 text-sm font-semibold text-gray-800
                                   hover:border-custom-primary hover:bg-red-50 transition-all duration-150"
                            data-service="{{ $svc->name }}"
                            data-service-id="{{ $svc->id }}"
                            data-duration="{{ $svc->duration_minutes }}"
                            data-price="KES {{ number_format($svc->price_from) }}"
                            {{ isset($selectedServiceId) && $selectedServiceId == $svc->id ? 'data-preselect=true' : '' }}>
                        {{ $svc->name }}
                        @if($svc->price_from)
                        <span class="block text-xs font-normal text-gray-400 mt-0.5">
                            From KES {{ number_format($svc->price_from) }}
                        </span>
                        @endif
                    </button>
                    @endforeach
                </div>
                @endforeach

                <p id="err-service" class="hidden text-xs text-red-500 mt-3">Please select a service to continue.</p>

                <div class="flex justify-end mt-6">
                    <button type="button" onclick="nextStep(1)"
                            class="inline-flex items-center gap-2 bg-custom-primary hover:bg-red-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition-all duration-200 shadow-[0_4px_12px_rgba(211,30,36,0.3)]">
                        Next Step
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 2: Vehicle Details ── --}}
            <div id="step-2" class="step-panel hidden p-7">
                <h2 class="flex items-center gap-2 text-lg font-extrabold text-gray-900 mb-5">
                    <svg class="w-5 h-5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 17H3a2 2 0 01-2-2v-4l2.5-6h13l2.5 6v4a2 2 0 01-2 2h-2m-9 0a2 2 0 104 0m5 0a2 2 0 104 0"/>
                    </svg>
                    Vehicle Details
                </h2>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Registration Number</label>
                        <input id="reg-number" type="text" placeholder="e.g. KCA 123A"
                               class="booking-input border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400">
                        <p id="err-reg" class="hidden text-xs text-red-500">Registration number is required.</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">
                            Make & Model <span class="text-gray-400 font-normal">(Optional)</span>
                        </label>
                        <input id="make-model" type="text" placeholder="e.g. Toyota Corolla"
                               class="booking-input border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400">
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="button" onclick="prevStep(2)" class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">Back</button>
                    <button type="button" onclick="nextStep(2)"
                            class="inline-flex items-center gap-2 bg-custom-primary hover:bg-red-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition-all duration-200 shadow-[0_4px_12px_rgba(211,30,36,0.3)]">
                        Next Step <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 3: Date & Time ── --}}
            <div id="step-3" class="step-panel hidden p-7">
                <h2 class="flex items-center gap-2 text-lg font-extrabold text-gray-900 mb-5">
                    <svg class="w-5 h-5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    Date & Time
                </h2>
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Select Date</label>
                        <input id="booking-date" type="date" min="{{ date('Y-m-d') }}"
                               class="booking-input border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900">
                        <p id="err-date" class="hidden text-xs text-red-500">Please select a date.</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-600">Select Time Slot</label>
                        <div class="flex flex-wrap gap-2" id="time-grid">
                            @foreach(['08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM'] as $slot)
                            <button type="button"
                                    class="time-slot px-4 py-2 rounded-lg border-2 border-gray-200 text-xs font-semibold text-gray-700
                                           hover:border-custom-primary hover:bg-red-50 transition-all duration-150"
                                    data-time="{{ $slot }}">{{ $slot }}</button>
                            @endforeach
                        </div>
                        <p id="err-time" class="hidden text-xs text-red-500">Please select a time slot.</p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="button" onclick="prevStep(3)" class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">Back</button>
                    <button type="button" onclick="nextStep(3)"
                            class="inline-flex items-center gap-2 bg-custom-primary hover:bg-red-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition-all duration-200 shadow-[0_4px_12px_rgba(211,30,36,0.3)]">
                        Next Step <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 4: Contact Details ── --}}
            <div id="step-4" class="step-panel hidden p-7">
                <h2 class="flex items-center gap-2 text-lg font-extrabold text-gray-900 mb-5">
                    <svg class="w-5 h-5 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Contact Details
                </h2>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Full Name</label>
                        <input id="full-name" type="text" placeholder="John Doe"
                               class="booking-input border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400">
                        <p id="err-name" class="hidden text-xs text-red-500">Full name is required.</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Phone Number</label>
                        <input id="phone" type="tel" placeholder="+254 700 000000"
                               class="booking-input border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400">
                        <p id="err-phone" class="hidden text-xs text-red-500">A valid phone number is required.</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Email <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <input id="email" type="email" placeholder="john@example.com"
                               class="booking-input border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-gray-600">Additional Notes <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <textarea id="notes" rows="2" placeholder="Any special requests or details about your vehicle…"
                                  class="booking-input border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 resize-none"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="button" onclick="prevStep(4)" class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">Back</button>
                    <button type="button" onclick="nextStep(4)"
                            class="inline-flex items-center gap-2 bg-custom-primary hover:bg-red-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition-all duration-200 shadow-[0_4px_12px_rgba(211,30,36,0.3)]">
                        Next Step <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 5: Confirm ── --}}
            <div id="step-5" class="step-panel hidden p-7">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mb-3">
                        <svg class="w-7 h-7 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-extrabold text-gray-900">Confirm Your Booking</h2>
                    <p class="text-sm text-gray-500 mt-1">Please review your details before confirming.</p>
                </div>

                <div class="border border-gray-100 rounded-xl overflow-hidden mb-6">
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Service</span>
                        <div class="text-right">
                            <div id="confirm-service" class="text-sm font-bold text-gray-900">—</div>
                            <div id="confirm-price" class="text-xs text-gray-400">—</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gray-50/50">
                        <span class="text-sm text-gray-500">Vehicle</span>
                        <span id="confirm-vehicle" class="text-sm font-bold text-gray-900">—</span>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Date & Time</span>
                        <span id="confirm-datetime" class="text-sm font-bold text-gray-900">—</span>
                    </div>
                    <div class="flex items-start justify-between px-5 py-3.5 bg-gray-50/50">
                        <span class="text-sm text-gray-500">Contact</span>
                        <div class="text-right">
                            <div id="confirm-name" class="text-sm font-bold text-gray-900">—</div>
                            <div id="confirm-phone" class="text-sm text-gray-600">—</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="button" onclick="prevStep(5)"
                            class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">Back</button>

                    <form id="booking-form" action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" id="h-service-id">
                        <input type="hidden" name="service"    id="h-service">
                        <input type="hidden" name="reg"        id="h-reg">
                        <input type="hidden" name="make"       id="h-make">
                        <input type="hidden" name="date"       id="h-date">
                        <input type="hidden" name="time"       id="h-time">
                        <input type="hidden" name="name"       id="h-name">
                        <input type="hidden" name="phone"      id="h-phone">
                        <input type="hidden" name="email"      id="h-email">
                        <input type="hidden" name="notes"      id="h-notes">
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition-all duration-200 shadow-[0_4px_12px_rgba(22,163,74,0.3)]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirm Booking
                        </button>
                    </form>
                </div>
            </div>

        </div>{{-- end panels --}}
    </div>{{-- end max-w --}}
</div>{{-- end wrapper --}}

@endsection
@push('scripts-stack')
    @vite('resources/js/booking.ts')

    {{-- Pass PHP data to TS --}}
    <script>
        window.PREMAX = {
            // Pre-selected service from ?service= param
            selectedServiceId: @json($selectedServiceId ?? null),
        };
    </script>
@endpush