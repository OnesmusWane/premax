@extends('layouts.default-menu-page')
@section('content')

<div class="bg-gray-100 min-h-screen py-16 px-4 flex items-center justify-center">
    <div class="max-w-md w-full">

        {{-- Success card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">

            <div class="w-16 h-16 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Booking Confirmed!</h1>
            <p class="text-sm text-gray-500 mb-6">
                We'll be in touch to confirm your appointment. See you soon!
            </p>

            {{-- Reference badge --}}
            <div class="inline-flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 mb-6">
                <span class="text-xs text-gray-500 uppercase tracking-widest">Reference</span>
                <span class="font-extrabold text-custom-primary text-sm tracking-widest">{{ $booking->reference }}</span>
            </div>

            {{-- Summary --}}
            <div class="border border-gray-100 rounded-xl overflow-hidden text-left mb-6">
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                    <span class="text-xs text-gray-500">Service</span>
                    <span class="text-sm font-bold text-gray-900">{{ $booking->service_name }}</span>
                </div>
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gray-50/50">
                    <span class="text-xs text-gray-500">Vehicle</span>
                    <span class="text-sm font-bold text-gray-900">
                        {{ $booking->vehicle_reg }}
                        @if($booking->vehicle_make_model)
                            <span class="font-normal text-gray-500">· {{ $booking->vehicle_make_model }}</span>
                        @endif
                    </span>
                </div>
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                    <span class="text-xs text-gray-500">Date & Time</span>
                    <span class="text-sm font-bold text-gray-900">
                        {{ $booking->booking_date->format('D, d M Y') }} at {{ $booking->booking_time }}
                    </span>
                </div>
                <div class="flex items-start justify-between px-5 py-3.5 bg-gray-50/50">
                    <span class="text-xs text-gray-500">Contact</span>
                    <div class="text-right">
                        <div class="text-sm font-bold text-gray-900">{{ $booking->customer_name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->customer_phone }}</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <a href="{{ route('booking.index') }}"
                   class="w-full bg-custom-primary hover:bg-red-800 text-white font-bold text-sm py-3 rounded-xl transition-all duration-200 text-center">
                    Book Another Service
                </a>
                <a href="{{ url('/') }}"
                   class="w-full border border-gray-200 text-gray-600 hover:border-gray-400 font-semibold text-sm py-3 rounded-xl transition-all duration-200 text-center">
                    Back to Home
                </a>
            </div>

        </div>

    </div>
</div>

@endsection