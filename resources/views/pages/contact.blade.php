@php
    $pageTitle       = 'Contact Us | Premax Autocare Nairobi';
    $pageDescription = 'Get in touch with Premax Autocare. Located on Kiambu Road / Northern Bypass Junction next to Glee Hotel. Call +254 742 091 794 or send us a message.';
    $pageKeyWords    = 'contact premax autocare, auto garage kiambu road, car service nairobi contact, premax phone number';
@endphp


@extends('layouts.default-menu-page')
@section('content')

{{-- ═══════════════════════════════════════════
    PREMAX AUTOCARE — CONTACT PAGE
    Contact details fetched from contact_information table
═══════════════════════════════════════════ --}}

<style>
    .contact-input:focus {
        outline: none;
        border-color: #D31E24;
        box-shadow: 0 0 0 3px rgba(211,30,36,0.12);
    }
</style>

{{-- ── PAGE HERO ── --}}
<section class="bg-custom-secondary py-16 text-center">
    <div class="max-w-2xl mx-auto px-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Contact Us</h1>
        <p class="mt-3 text-gray-400 text-sm">Get in touch with our team for any inquiries or support.</p>
    </div>
</section>

{{-- ── MAIN CONTENT ── --}}
<section class="bg-gray-50 py-16">
    <div class="max-w-5xl mx-auto px-6">

        {{-- ── SUCCESS ALERT ── --}}
        @if(session('success'))
        <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4"
             x-data="{ show: true }" x-show="show" x-transition>
            <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <p class="text-sm font-semibold">Message sent successfully!</p>
                <p class="text-sm text-green-700 mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-700 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        @endif

        {{-- ── VALIDATION ERRORS ── --}}
        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-5 py-4">
            <p class="text-sm font-semibold text-red-800 mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6 items-start">

            {{-- ── LEFT: Get In Touch card ── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-7 flex flex-col gap-6">
                <h2 class="text-lg font-extrabold text-gray-900">Get In Touch</h2>

                <ul class="flex flex-col gap-5 list-none m-0 p-0">

                    {{-- Location --}}
                    @if($contact && $contact->short_address)
                    <li class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900">Location</div>
                            <a href="{{ $contact->google_maps_url ?? '#' }}"
                               target="{{ $contact->google_maps_url ? '_blank' : '_self' }}"
                               rel="noopener noreferrer"
                               class="text-sm text-gray-500 mt-0.5 leading-relaxed no-underline hover:text-custom-primary transition-colors duration-200 block">
                                {{ $contact->street_address }}
                                @if($contact->landmark)<br><span class="text-xs">{{ $contact->landmark }}</span>@endif
                                <br>{{ $contact->city }}{{ $contact->county ? ', ' . $contact->county : '' }}, {{ $contact->country }}
                            </a>
                        </div>
                    </li>
                    @endif

                    {{-- Phone --}}
                    @if($contact && $contact->phone_primary)
                    <li class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 18.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900">Phone & WhatsApp</div>
                            <a href="tel:{{ $contact->phone_primary_e164 }}"
                               class="text-sm text-gray-500 mt-0.5 hover:text-custom-primary no-underline transition-colors duration-200 block">
                                {{ $contact->phone_primary }}
                            </a>
                            @if($contact->phone_secondary)
                            <a href="tel:{{ $contact->phone_secondary_e164 }}"
                               class="text-sm text-gray-500 hover:text-custom-primary no-underline transition-colors duration-200 block">
                                {{ $contact->phone_secondary }}
                            </a>
                            @endif
                        </div>
                    </li>
                    @endif

                    {{-- Email --}}
                    @if($contact && $contact->email_primary)
                    <li class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900">Email</div>
                            <a href="mailto:{{ $contact->email_primary }}"
                               class="text-sm text-gray-500 mt-0.5 hover:text-custom-primary no-underline transition-colors duration-200 block">
                                {{ $contact->email_primary }}
                            </a>
                            @if($contact->email_support && $contact->email_support !== $contact->email_primary)
                            <a href="mailto:{{ $contact->email_support }}"
                               class="text-sm text-gray-500 hover:text-custom-primary no-underline transition-colors duration-200 block">
                                {{ $contact->email_support }}
                            </a>
                            @endif
                        </div>
                    </li>
                    @endif

                    {{-- Operating Hours --}}
                    @if($contact && $contact->business_hours)
                    <li class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900">Operating Hours</div>
                            <div class="text-sm text-gray-500 mt-0.5 leading-relaxed">
                                @foreach($contact->formattedHours() as $line)
                                    {{ $line }}<br>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    @endif

                    {{-- Social Media --}}
                    @if($contact && ($contact->facebook_url || $contact->instagram_url || $contact->twitter_url || $contact->tiktok_url))
                    <li class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900 mb-2">Follow Us</div>
                            <div class="flex items-center gap-3 flex-wrap">
                                @if($contact->facebook_url)
                                <a href="{{ $contact->facebook_url }}" target="_blank" rel="noopener noreferrer"
                                   class="text-gray-400 hover:text-custom-primary transition-colors" aria-label="Facebook">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                                </a>
                                @endif
                                @if($contact->instagram_url)
                                <a href="{{ $contact->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                   class="text-gray-400 hover:text-custom-primary transition-colors" aria-label="Instagram">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/>
                                        <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/>
                                    </svg>
                                </a>
                                @endif
                                @if($contact->twitter_url)
                                <a href="{{ $contact->twitter_url }}" target="_blank" rel="noopener noreferrer"
                                   class="text-gray-400 hover:text-custom-primary transition-colors" aria-label="Twitter">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                                </a>
                                @endif
                                @if($contact->tiktok_url)
                                <a href="{{ $contact->tiktok_url }}" target="_blank" rel="noopener noreferrer"
                                   class="text-gray-400 hover:text-custom-primary transition-colors" aria-label="TikTok">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z"/></svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endif

                </ul>

                {{-- WhatsApp CTA --}}
                @if($contact && $contact->whatsapp_url)
                <a href="{{ $contact->whatsapp_url }}"
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-bold text-sm
                          py-3 rounded-xl no-underline transition-colors duration-200 mt-1">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Chat on WhatsApp
                </a>
                @endif
            </div>

            {{-- ── RIGHT: Form + Map ── --}}
            <div class="flex flex-col gap-6">

                {{-- Message form --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-7">
                    <h2 class="text-lg font-extrabold text-gray-900 mb-6">Send us a Message</h2>

                    <form action="{{ route('contact.store') }}" method="POST" class="flex flex-col gap-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-semibold text-gray-600">Your Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       placeholder="John Doe" required
                                       class="contact-input w-full border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200">
                                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-semibold text-gray-600">Phone Number <span class="text-gray-400 font-normal">(Optional)</span></label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                       placeholder="+254 700 000000"
                                       class="contact-input w-full border {{ $errors->has('phone') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200">
                                @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   placeholder="john@example.com" required
                                   class="contact-input w-full border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200">
                            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-600">Message</label>
                            <textarea name="message" rows="5" placeholder="How can we help you?" required
                                      class="contact-input w-full border {{ $errors->has('message') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 resize-none">{{ old('message') }}</textarea>
                            @error('message')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <button type="submit"
                                    class="inline-flex items-center gap-2 bg-custom-primary hover:bg-red-800 text-white font-bold text-sm
                                           px-7 py-3 rounded-xl transition-all duration-200
                                           shadow-[0_4px_14px_rgba(211,30,36,0.30)] hover:-translate-y-px active:translate-y-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Message
                            </button>
                        </div>

                    </form>
                </div>

                {{-- Google Maps embed -- driven by DB coordinates --}}
                <div class="rounded-2xl border border-gray-200 overflow-hidden h-64">
                    @if($contact && $contact->latitude && $contact->longitude)
                        {{-- Dynamic embed using stored coordinates --}}
                        <iframe
                            src="https://maps.google.com/maps?q={{ $contact->latitude }},{{ $contact->longitude }}&z={{ $contact->map_zoom }}&output=embed"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Premax Autocare Location">
                        </iframe>
                    @elseif($contact && $contact->google_maps_url)
                        {{-- Fallback: link to Google Maps if no coordinates --}}
                        <div class="bg-gray-100 h-full flex flex-col items-center justify-center gap-3 text-gray-400">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-500">{{ $contact->short_address }}</p>
                            <a href="{{ $contact->google_maps_url }}" target="_blank" rel="noopener noreferrer"
                               class="text-xs font-bold text-custom-primary hover:underline">
                                View on Google Maps →
                            </a>
                        </div>
                    @else
                        <div class="bg-gray-100 h-full flex flex-col items-center justify-center gap-2 text-gray-400">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-400">Map not configured yet</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

@endsection