@extends('layouts.default-menu-page')
@section('content')

<style>
    .feedback-input:focus {
        outline: none;
        border-color: #D31E24;
        box-shadow: 0 0 0 3px rgba(211,30,36,0.12);
    }
    .star-btn { transition: transform 0.1s ease; }
    .star-btn:hover { transform: scale(1.15); }
    .star-btn.active svg { fill: #FBBF24; color: #FBBF24; }
</style>

{{-- ── HERO ── --}}
<section class="bg-custom-secondary py-14 text-center px-6">
    <div class="max-w-xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Share Your Feedback</h1>
        <p class="mt-3 text-gray-400 text-sm leading-relaxed max-w-md mx-auto">
            We value your opinion. Let us know about your experience at Premax Autocare so
            we can continue to improve our services.
        </p>
    </div>
</section>

{{-- ── FORM ── --}}
<div class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-2xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

            <form id="feedback-form" action="{{ url('/feedback/' . $token->token) }}" method="POST"
                  novalidate>
                @csrf

                {{-- ── Row 1: Name + Phone ── --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-gray-700">
                            Your Name <span class="text-custom-primary">*</span>
                        </label>
                        <input id="fb-name" name="name" type="text" placeholder="John Doe"
                               value="{{ old('name', $token->customer_name ?? '') }}"
                               class="feedback-input border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200">
                        <p id="err-name" class="hidden text-xs text-custom-primary mt-0.5">Name is required.</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-gray-700">Phone Number</label>
                        <input id="fb-phone" name="phone" type="tel" placeholder="0700 123 456"
                               value="{{ old('phone', $token->customer_phone ?? '') }}"
                               class="feedback-input border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200">
                    </div>
                </div>

                {{-- ── Row 2: Vehicle + Service ── --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-100">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-gray-700">Vehicle Registration</label>
                        <input id="fb-vehicle" name="vehicle" type="text" placeholder="KAA 123A"
                               value="{{ old('vehicle', $token->vehicle_reg ?? '') }}"
                               class="feedback-input border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-gray-700">Service Received</label>
                        <select id="fb-service" name="service"
                                class="feedback-input border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 bg-white transition-all duration-200 cursor-pointer">
                            <option value="">Select a service...</option>
                            @foreach(['Basic Wash','Full Wash','Engine Wash','Interior Detailing','Full Detailing','Oil Change','Brake Check & Service','AC Service','Full Service','Tire Rotation','Wheel Balancing','Puncture Repair'] as $svc)
                                <option value="{{ $svc }}" {{ old('service', $token->service ?? '') === $svc ? 'selected' : '' }}>{{ $svc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ── Star Rating ── --}}
                <div class="flex flex-col items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-800">
                        How would you rate our service? <span class="text-custom-primary">*</span>
                    </p>
                    <div class="flex items-center gap-3" id="star-group" role="group" aria-label="Rating">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                class="star-btn w-10 h-10 flex items-center justify-center rounded-full focus:outline-none"
                                data-value="{{ $i }}"
                                aria-label="{{ $i }} star{{ $i > 1 ? 's' : '' }}">
                            <svg class="w-9 h-9" fill="none" stroke="#CBD5E1" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="fb-rating" value="{{ old('rating', '') }}">
                    <p id="err-rating" class="hidden text-xs text-custom-primary">Please select a rating.</p>
                </div>

                {{-- ── What went well ── --}}
                <div class="flex flex-col gap-1.5 mb-4">
                    <label class="text-sm font-semibold text-gray-700">What did you like most?</label>
                    <textarea id="fb-liked" name="liked" rows="4"
                              placeholder="Tell us what went well..."
                              class="feedback-input border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 resize-none">{{ old('liked') }}</textarea>
                </div>

                {{-- ── Suggestions ── --}}
                <div class="flex flex-col gap-1.5 mb-6">
                    <label class="text-sm font-semibold text-gray-700">Any suggestions for improvement?</label>
                    <textarea id="fb-suggestions" name="suggestions" rows="4"
                              placeholder="How can we do better next time?"
                              class="feedback-input border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 resize-none">{{ old('suggestions') }}</textarea>
                </div>

                {{-- ── Recommend ── --}}
                <div class="flex flex-col gap-3 mb-8 pb-6 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-700">Would you recommend us to a friend?</p>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="recommend" value="yes"
                                   {{ old('recommend', 'yes') === 'yes' ? 'checked' : '' }}
                                   class="w-4 h-4 accent-custom-primary cursor-pointer">
                            <span class="text-sm text-gray-700">Yes, definitely</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="recommend" value="no"
                                   {{ old('recommend') === 'no' ? 'checked' : '' }}
                                   class="w-4 h-4 accent-custom-primary cursor-pointer">
                            <span class="text-sm text-gray-700">No</span>
                        </label>
                    </div>
                </div>

                {{-- ── Submit ── --}}
                <button type="submit" id="submit-btn"
                        class="w-full bg-custom-primary hover:bg-red-800 text-white font-bold text-sm py-4 rounded-xl
                               transition-all duration-200 shadow-[0_4px_14px_rgba(211,30,36,0.30)] hover:-translate-y-px active:translate-y-0">
                    Submit Feedback
                </button>

            </form>

        </div>
    </div>
</div>

@endsection
@push('scripts-stack')
    @vite('resources/js/feedback.ts')
@endpush