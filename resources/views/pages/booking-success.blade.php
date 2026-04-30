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

                {{-- Service --}}
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                    <span class="text-xs text-gray-500">Service</span>
                    <span class="text-sm font-bold text-gray-900">
                        {{ $booking->service?->name ?? '—' }}
                    </span>
                </div>

                {{-- Vehicle --}}
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gray-50/50">
                    <span class="text-xs text-gray-500">Vehicle</span>
                    <div class="text-right">
                        <div class="text-sm font-bold text-gray-900 font-mono">
                            {{ $booking->vehicle?->registration ?? '—' }}
                        </div>
                        @if($booking->vehicle && $booking->vehicle->make !== 'Unknown')
                        <div class="text-xs text-gray-500">
                            {{ $booking->vehicle->make }} {{ $booking->vehicle->model }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Date & Time --}}
               <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                <span class="text-xs text-gray-500">Date & Time</span>
                <span class="text-sm font-bold text-gray-900">
                    {{ $booking->scheduled_at?->format('D, d M Y') ?? '—' }}
                    at {{ $booking->scheduled_at?->format('h:i A') ?? '—' }}
                </span>
            </div>

                {{-- Contact --}}
                <div class="flex items-start justify-between px-5 py-3.5 bg-gray-50/50">
                    <span class="text-xs text-gray-500">Contact</span>
                    <div class="text-right">
                        <div class="text-sm font-bold text-gray-900">
                            {{ $booking->customer?->name ?? '—' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $booking->customer?->phone ?? '—' }}
                        </div>
                        @if($booking->customer?->email)
                        <div class="text-xs text-gray-400">{{ $booking->customer->email }}</div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- WhatsApp confirmation prompt --}}
            @if($contact?->phone_whatsapp)
            <a href="https://wa.me/{{ ltrim($contact->phone_whatsapp_e164, '+') }}?text=Hi+Premax%2C+I+just+booked+a+{{ urlencode($booking->service?->name ?? 'service') }}+appointment.+My+reference+is+{{ $booking->reference }}."
               target="_blank" rel="noopener noreferrer"
               class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-bold text-sm py-3 rounded-xl transition-all duration-200 text-center mb-3">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Confirm via WhatsApp
            </a>
            @endif

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
