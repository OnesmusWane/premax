@php
    $pageTitle       = 'Book Executive Service | Premax Automotive Studio';
    $pageDescription = 'Book your car service appointment online at Premax Automotive Studio. Choose your service, pick a time, and our team will confirm your reservation.';
    $pageKeyWords    = 'book car service nairobi, car appointment nairobi, premax booking, luxury car service booking';
@endphp

@extends('layouts.default-menu-page')
@section('content')

<style>
    .step-circle  { transition: background-color 0.3s, border-color 0.3s, color 0.3s; }
    .step-line    { transition: background-color 0.4s ease; }
    .time-slot.selected { background-color: #D31E24; border-color: #D31E24; color: #fff; }
    .service-card.selected { border-color: #D31E24; background-color: rgba(211,30,36,0.08); }
</style>

<div class="bg-[#111111] min-h-screen">

{{-- ── HERO HEADER ── --}}
<section class="relative pt-40 pb-16 px-6 bg-[#0a0a0a] overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(211,30,36,0.05)_0%,transparent_60%)]"></div>
    <div class="relative max-w-3xl mx-auto text-center">
        <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
            Reservations
        </span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight tracking-tight">
            Book Executive Service.
        </h1>
        <p class="text-white/50 text-lg leading-relaxed">
            Complete the steps below to secure your appointment. A service advisor
            will contact you to confirm all details.
        </p>
    </div>
</section>

{{-- ── STEPPER + PANELS ── --}}
<section class="py-16 px-6">
    <div class="max-w-2xl mx-auto">

        {{-- Stepper --}}
        <div class="flex items-center mb-12 px-2" id="stepper">
            @php $steps = ['Service', 'Vehicle', 'Time', 'Details', 'Confirm']; @endphp
            @foreach($steps as $i => $label)
                <div class="flex flex-col items-center relative shrink-0" data-step="{{ $i + 1 }}">
                    <div class="step-circle w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 z-10
                                {{ $i === 0 ? 'bg-custom-primary border-custom-primary text-white' : 'bg-[#1a1a1a] border-white/15 text-white/30' }}">
                        <span class="step-num">{{ $i + 1 }}</span>
                        <svg class="step-check hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="step-label absolute -bottom-6 text-[10px] text-white/25 whitespace-nowrap uppercase tracking-wider">{{ $label }}</span>
                </div>
                @if($i < count($steps) - 1)
                <div class="step-line flex-1 h-px bg-white/10 mx-1" data-line="{{ $i + 1 }}"></div>
                @endif
            @endforeach
        </div>

        {{-- Panels --}}
        <div class="mt-10 bg-[#1a1a1a] border border-white/5 rounded-2xl overflow-hidden">

            {{-- ── STEP 1: Select Service ── --}}
            <div id="step-1" class="step-panel p-8 md:p-10">
                <h2 class="flex items-center gap-3 text-lg font-bold text-white mb-6">
                    <div class="w-8 h-8 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>
                        </svg>
                    </div>
                    Select Service
                </h2>

                @if($services->count() > 1)
                <div class="flex flex-wrap gap-2 mb-5" id="category-tabs">
                    @foreach($services->keys() as $catIndex => $catName)
                    <button type="button"
                            class="category-tab px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border transition-all duration-200
                                   {{ $catIndex === 0 ? 'bg-custom-primary text-white border-custom-primary' : 'bg-transparent text-white/40 border-white/10 hover:text-white hover:border-white/30' }}"
                            data-category="{{ Str::slug($catName) }}">
                        {{ $catName }}
                    </button>
                    @endforeach
                </div>
                @endif

                @foreach($services as $categoryName => $categoryServices)
                <div class="category-group grid grid-cols-1 sm:grid-cols-2 gap-3" data-group="{{ Str::slug($categoryName) }}"
                     style="{{ !$loop->first ? 'display:none' : '' }}">
                    @foreach($categoryServices as $svc)
                    <button type="button"
                            class="service-card text-left px-5 py-4 rounded-xl border border-white/10 text-sm font-semibold text-white/70
                                   hover:border-custom-primary/50 hover:text-white hover:bg-custom-primary/5 transition-all duration-150"
                            data-service="{{ $svc->name }}"
                            data-service-id="{{ $svc->id }}"
                            data-duration="{{ $svc->duration_minutes }}"
                            data-price="KES {{ number_format($svc->price_from) }}"
                            {{ isset($selectedServiceId) && $selectedServiceId == $svc->id ? 'data-preselect=true' : '' }}>
                        <span class="block text-white font-semibold">{{ $svc->name }}</span>
                        @if($svc->price_from)
                        <span class="block text-xs text-white/35 mt-1 font-normal">
                            From KES {{ number_format($svc->price_from) }}
                        </span>
                        @endif
                    </button>
                    @endforeach
                </div>
                @endforeach

                <p id="err-service" class="hidden text-xs text-red-400 mt-4">Please select a service to continue.</p>

                <div class="flex justify-end mt-8 pt-6 border-t border-white/5">
                    <button type="button" onclick="nextStep(1)"
                            class="inline-flex items-center gap-2 px-7 py-3.5 bg-custom-primary text-white font-semibold text-sm
                                   rounded-md hover:bg-red-700 transition-all duration-200 shadow-[0_4px_12px_rgba(211,30,36,0.30)]">
                        Next Step
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 2: Vehicle Details ── --}}
            <div id="step-2" class="step-panel hidden p-8 md:p-10">
                <h2 class="flex items-center gap-3 text-lg font-bold text-white mb-6">
                    <div class="w-8 h-8 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 17H3a2 2 0 01-2-2v-4l2.5-6h13l2.5 6v4a2 2 0 01-2 2h-2m-9 0a2 2 0 104 0m5 0a2 2 0 104 0"/>
                        </svg>
                    </div>
                    Vehicle Details
                </h2>
                <div class="space-y-8">
                    <div class="relative">
                        <input id="reg-number" type="text" placeholder=" "
                               class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                      focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent">
                        <label for="reg-number" class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                      peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                      peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                            Registration Number (e.g. KCA 123A)
                        </label>
                        <p id="err-reg" class="hidden text-xs text-red-400 mt-2">Registration number is required.</p>
                    </div>
                    <div class="relative">
                        <input id="make-model" type="text" placeholder=" "
                               class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                      focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent">
                        <label for="make-model" class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                      peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                      peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                            Make & Model <span class="text-white/20">(optional)</span>
                        </label>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-white/5">
                    <button type="button" onclick="prevStep(2)"
                            class="text-sm font-medium text-white/40 hover:text-white transition-colors">← Back</button>
                    <button type="button" onclick="nextStep(2)"
                            class="inline-flex items-center gap-2 px-7 py-3.5 bg-custom-primary text-white font-semibold text-sm
                                   rounded-md hover:bg-red-700 transition-all duration-200 shadow-[0_4px_12px_rgba(211,30,36,0.30)]">
                        Next Step <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 3: Date & Time ── --}}
            <div id="step-3" class="step-panel hidden p-8 md:p-10">
                <h2 class="flex items-center gap-3 text-lg font-bold text-white mb-6">
                    <div class="w-8 h-8 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                    </div>
                    Date & Time
                </h2>
                <div class="space-y-8">
                    <div class="relative">
                        <input id="booking-date" type="date" min="{{ date('Y-m-d') }}"
                               class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                      focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors
                                      [color-scheme:dark]">
                        <label for="booking-date" class="absolute left-0 -top-3.5 text-xs text-white/40">Preferred Date</label>
                        <p id="err-date" class="hidden text-xs text-red-400 mt-2">Please select a date.</p>
                    </div>
                    <div>
                        <div class="text-xs text-white/40 mb-3 uppercase tracking-widest">Preferred Time</div>
                        <div class="flex flex-wrap gap-2" id="time-grid">
                            @foreach(['08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM'] as $slot)
                            <button type="button"
                                    class="time-slot px-4 py-2 rounded-lg border border-white/10 text-xs font-medium text-white/50
                                           hover:border-custom-primary/50 hover:text-white transition-all duration-150"
                                    data-time="{{ $slot }}">{{ $slot }}</button>
                            @endforeach
                        </div>
                        <p id="err-time" class="hidden text-xs text-red-400 mt-2">Please select a time slot.</p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-white/5">
                    <button type="button" onclick="prevStep(3)"
                            class="text-sm font-medium text-white/40 hover:text-white transition-colors">← Back</button>
                    <button type="button" onclick="nextStep(3)"
                            class="inline-flex items-center gap-2 px-7 py-3.5 bg-custom-primary text-white font-semibold text-sm
                                   rounded-md hover:bg-red-700 transition-all duration-200 shadow-[0_4px_12px_rgba(211,30,36,0.30)]">
                        Next Step <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 4: Contact Details ── --}}
            <div id="step-4" class="step-panel hidden p-8 md:p-10">
                <h2 class="flex items-center gap-3 text-lg font-bold text-white mb-6">
                    <div class="w-8 h-8 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    Contact Details
                </h2>
                <div class="space-y-8">
                    <div class="relative">
                        <input id="full-name" type="text" placeholder=" "
                               class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                      focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent">
                        <label for="full-name" class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                      peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                      peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                            Full Name
                        </label>
                        <p id="err-name" class="hidden text-xs text-red-400 mt-2">Full name is required.</p>
                    </div>
                    <div class="relative">
                        <input id="phone" type="tel" placeholder=" "
                               class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                      focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent">
                        <label for="phone" class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                      peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                      peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                            Phone Number
                        </label>
                        <p id="err-phone" class="hidden text-xs text-red-400 mt-2">A valid phone number is required.</p>
                    </div>
                    <div class="relative">
                        <input id="email" type="email" placeholder=" "
                               class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                      focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent">
                        <label for="email" class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                      peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                      peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                            Email <span class="text-white/20">(optional)</span>
                        </label>
                    </div>
                    <div class="relative">
                        <textarea id="notes" rows="3" placeholder=" "
                                  class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                         focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent resize-none"></textarea>
                        <label for="notes" class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                      peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                      peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                            Additional Notes <span class="text-white/20">(optional)</span>
                        </label>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-white/5">
                    <button type="button" onclick="prevStep(4)"
                            class="text-sm font-medium text-white/40 hover:text-white transition-colors">← Back</button>
                    <button type="button" onclick="nextStep(4)"
                            class="inline-flex items-center gap-2 px-7 py-3.5 bg-custom-primary text-white font-semibold text-sm
                                   rounded-md hover:bg-red-700 transition-all duration-200 shadow-[0_4px_12px_rgba(211,30,36,0.30)]">
                        Review Booking <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── STEP 5: Confirm ── --}}
            <div id="step-5" class="step-panel hidden p-8 md:p-10">
                <div class="flex flex-col items-center text-center mb-8">
                    <div class="w-14 h-14 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-white">Confirm Your Booking</h2>
                    <p class="text-sm text-white/40 mt-1">Review the details below before confirming.</p>
                </div>

                <div class="border border-white/5 rounded-xl overflow-hidden mb-8">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-white/5">
                        <span class="text-sm text-white/40">Service</span>
                        <div class="text-right">
                            <div id="confirm-service" class="text-sm font-semibold text-white">—</div>
                            <div id="confirm-price" class="text-xs text-white/30">—</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between px-5 py-4 border-b border-white/5 bg-white/2">
                        <span class="text-sm text-white/40">Vehicle</span>
                        <span id="confirm-vehicle" class="text-sm font-semibold text-white">—</span>
                    </div>
                    <div class="flex items-center justify-between px-5 py-4 border-b border-white/5">
                        <span class="text-sm text-white/40">Date & Time</span>
                        <span id="confirm-datetime" class="text-sm font-semibold text-white">—</span>
                    </div>
                    <div class="flex items-start justify-between px-5 py-4 bg-white/2">
                        <span class="text-sm text-white/40">Contact</span>
                        <div class="text-right">
                            <div id="confirm-name" class="text-sm font-semibold text-white">—</div>
                            <div id="confirm-phone" class="text-sm text-white/40">—</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <button type="button" onclick="prevStep(5)"
                            class="text-sm font-medium text-white/40 hover:text-white transition-colors">← Back</button>

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
                                class="inline-flex items-center gap-2 px-7 py-3.5 bg-green-600 hover:bg-green-500 text-white
                                       font-semibold text-sm rounded-md transition-all duration-200
                                       shadow-[0_4px_12px_rgba(22,163,74,0.30)]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Confirm Booking
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

</div>

@endsection
@push('scripts-stack')
<div id="premax-data"
     data-selected-service="{{ $selectedServiceId ?? '' }}"
     data-user='@json($userData)'
     style="display:none"></div>
    @vite('resources/js/booking.ts')
@endpush
