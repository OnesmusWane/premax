@php
    $pageTitle       = 'Contact Premax Automotive Studio Nairobi | Car Detailing & Auto Care';
    $pageDescription = 'Contact Premax Automotive Studio in Nairobi for car detailing, ceramic coating, paint protection and premium auto care services. Visit us on Kiambu Road near Northern Bypass or call today.';
    $pageKeyWords    = 'car detailing Nairobi, ceramic coating Nairobi, auto garage Kiambu Road, Premax Automotive contact, car service Nairobi';
@endphp

@extends('layouts.default-menu-page')
@section('head-tags')
@php
$_schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'AutoRepair',
    'name'     => 'Premax Automotive Studio',
    'url'      => 'https://premaxautoservice.co.ke/contact',
    'telephone' => $contact->phone_primary ?? '',
    'address'  => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $contact->street_address ?? '',
        'addressLocality' => $contact->city ?? '',
        'addressCountry'  => 'KE',
    ],
    'geo' => [
        '@type'     => 'GeoCoordinates',
        'latitude'  => $contact->latitude ?? '',
        'longitude' => $contact->longitude ?? '',
    ],
];
@endphp
<script type="application/ld+json">{!! json_encode($_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endsection
@section('content')

<div class="bg-[#111111]">

    {{-- ── HERO ── --}}
    <section class="relative pt-40 pb-24 px-6 overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('assets/images/hero/contact.webp') }}" alt=""
                class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-[#0a0a0a]/75"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(211,30,36,0.08)_0%,transparent_60%)]"></div>
        </div>
        <div class="relative max-w-7xl mx-auto">
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                Get in Touch
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight tracking-tight max-w-2xl">
                Let's Talk About Your Vehicle.
            </h1>
            <p class="text-white/55 text-lg leading-relaxed max-w-xl">
                Whether you have a question, need a quote, or want to book a service,
                our team is ready to assist you.
            </p>
        </div>
    </section>

    <h1 class="sr-only">
        Contact Premax Automotive Studio Nairobi – Car Detailing & Auto Care Services
    </h1>

    {{-- ── MAIN CONTENT ── --}}
    <section class="py-20 px-6 border-t border-white/5">
        <div class="max-w-7xl mx-auto">

            {{-- Success message --}}
            @if(session('success'))
            <div class="mb-10 flex items-start gap-4 bg-green-950/40 border border-green-900/40 text-green-400 rounded-xl px-6 py-4">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold">Message sent successfully.</p>
                    <p class="text-sm text-green-500/70 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-10 bg-red-950/40 border border-red-900/40 rounded-xl px-6 py-4">
                <p class="text-sm font-semibold text-red-400 mb-2">Please fix the following:</p>
                <ul class="list-disc list-inside text-sm text-red-400/70 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-[380px_1fr] gap-12">

                {{-- ── LEFT: Contact details ── --}}
                <div class="space-y-8">

                    <div>
                        <h2 class="text-xl font-bold text-white mb-8">Studio Contact</h2>

                        <ul class="space-y-6">

                            @if($contact && $contact->short_address)
                            <li class="flex items-start gap-5">
                                <div class="w-10 h-10 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-white/30 uppercase tracking-widest mb-1">Location</div>
                                    <a href="{{ $contact->google_maps_url ?? '#' }}"
                                    target="{{ $contact->google_maps_url ? '_blank' : '_self' }}"
                                    rel="noopener noreferrer"
                                    class="text-sm text-white/60 hover:text-white transition-colors no-underline leading-relaxed block">
                                        {{ $contact->street_address }}
                                        @if($contact->landmark)<br><span class="text-xs text-white/35">{{ $contact->landmark }}</span>@endif
                                        <br>{{ $contact->city }}{{ $contact->county ? ', ' . $contact->county : '' }}
                                    </a>
                                </div>
                            </li>
                            @endif

                            @if($contact && $contact->phone_primary)
                            <li class="flex items-start gap-5">
                                <div class="w-10 h-10 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 18.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-white/30 uppercase tracking-widest mb-1">Phone & WhatsApp</div>
                                    <a href="tel:{{ $contact->phone_primary_e164 }}"
                                    class="text-sm text-white/60 hover:text-white transition-colors no-underline block">
                                        {{ $contact->phone_primary }}
                                    </a>
                                    @if($contact->phone_secondary)
                                    <a href="tel:{{ $contact->phone_secondary_e164 }}"
                                    class="text-sm text-white/60 hover:text-white transition-colors no-underline block">
                                        {{ $contact->phone_secondary }}
                                    </a>
                                    @endif
                                </div>
                            </li>
                            @endif

                            @if($contact && $contact->email_primary)
                            <li class="flex items-start gap-5">
                                <div class="w-10 h-10 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-white/30 uppercase tracking-widest mb-1">Email</div>
                                    <a href="mailto:{{ $contact->email_primary }}"
                                    class="text-sm text-white/60 hover:text-white transition-colors no-underline block">
                                        {{ $contact->email_primary }}
                                    </a>
                                    @if($contact->email_support && $contact->email_support !== $contact->email_primary)
                                    <a href="mailto:{{ $contact->email_support }}"
                                    class="text-sm text-white/60 hover:text-white transition-colors no-underline block">
                                        {{ $contact->email_support }}
                                    </a>
                                    @endif
                                </div>
                            </li>
                            @endif

                            @if($contact && $contact->business_hours)
                            <li class="flex items-start gap-5">
                                <div class="w-10 h-10 rounded-full bg-custom-primary/10 border border-custom-primary/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-white/30 uppercase tracking-widest mb-1">Hours</div>
                                    <div class="text-sm text-white/60 leading-relaxed">
                                        @foreach($contact->formattedHours() as $line)
                                            {{ $line }}<br>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            @endif

                        </ul>
                    </div>

                    {{-- Social links --}}
                    @if($contact && ($contact->facebook_url || $contact->instagram_url || $contact->twitter_url || $contact->tiktok_url))
                    <div class="pt-6 border-t border-white/5">
                        <div class="text-xs text-white/30 uppercase tracking-widest mb-4">Follow Us</div>
                        <div class="flex items-center gap-4">
                            @if($contact->facebook_url)
                            <a href="{{ $contact->facebook_url }}" target="_blank" rel="noopener noreferrer"
                            class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center text-white/40
                                    hover:bg-custom-primary/10 hover:text-custom-primary transition-all duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                            </a>
                            @endif
                            @if($contact->instagram_url)
                            <a href="{{ $contact->instagram_url }}" target="_blank" rel="noopener noreferrer"
                            class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center text-white/40
                                    hover:bg-custom-primary/10 hover:text-custom-primary transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/>
                                    <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/>
                                </svg>
                            </a>
                            @endif
                            @if($contact->twitter_url)
                            <a href="{{ $contact->twitter_url }}" target="_blank" rel="noopener noreferrer"
                            class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center text-white/40
                                    hover:bg-custom-primary/10 hover:text-custom-primary transition-all duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                            </a>
                            @endif
                            @if($contact->tiktok_url)
                            <a href="{{ $contact->tiktok_url }}" target="_blank" rel="noopener noreferrer"
                            class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center text-white/40
                                    hover:bg-custom-primary/10 hover:text-custom-primary transition-all duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- WhatsApp CTA --}}
                    @if($contact && $contact->whatsapp_url)
                    <a href="{{ $contact->whatsapp_url }}"
                    aria-label="Chat with Premax Automotive Studio on WhatsApp Nairobi"
                    target="_blank" rel="noopener noreferrer"
                    class="flex items-center justify-center gap-3 w-full bg-green-600 hover:bg-green-500 text-white font-semibold
                            text-sm py-3.5 rounded-lg no-underline transition-all duration-200 mt-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Chat on WhatsApp
                    </a>
                    @endif

                </div>

                {{-- ── RIGHT: Form + Map ── --}}
                <div class="flex flex-col gap-8">

                    {{-- Message form --}}
                    <div class="bg-[#1a1a1a] border border-white/5 rounded-2xl p-8 md:p-10">
                        <h2 class="text-xl font-bold text-white mb-8">Send a Message</h2>

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-8">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                <div class="relative">
                                    <input type="text" name="name" id="ct_name"
                                        value="{{ old('name') }}" placeholder=" " required
                                        class="block w-full bg-transparent border-0 border-b {{ $errors->has('name') ? 'border-red-500' : 'border-white/20' }} py-3 text-white text-sm
                                                focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent">
                                    <label for="ct_name"
                                        class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                                peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                                        Your Name
                                    </label>
                                    @error('name')<p class="text-xs text-red-400 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="relative">
                                    <input type="tel" name="phone" id="ct_phone"
                                        value="{{ old('phone') }}" placeholder=" "
                                        class="block w-full bg-transparent border-0 border-b {{ $errors->has('phone') ? 'border-red-500' : 'border-white/20' }} py-3 text-white text-sm
                                                focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent">
                                    <label for="ct_phone"
                                        class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                                peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                                        Phone <span class="text-white/25">(optional)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="relative">
                                <input type="email" name="email" id="ct_email"
                                    value="{{ old('email') }}" placeholder=" " required
                                    class="block w-full bg-transparent border-0 border-b {{ $errors->has('email') ? 'border-red-500' : 'border-white/20' }} py-3 text-white text-sm
                                            focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent">
                                <label for="ct_email"
                                    class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                            peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                            peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                                    Email Address
                                </label>
                                @error('email')<p class="text-xs text-red-400 mt-2">{{ $message }}</p>@enderror
                            </div>

                            <div class="relative">
                                <textarea name="message" id="ct_message" rows="4" placeholder=" " required
                                        class="block w-full bg-transparent border-0 border-b {{ $errors->has('message') ? 'border-red-500' : 'border-white/20' }} py-3 text-white text-sm
                                                focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer placeholder-transparent resize-none">{{ old('message') }}</textarea>
                                <label for="ct_message"
                                    class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                            peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                            peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                                    Your Message
                                </label>
                                @error('message')<p class="text-xs text-red-400 mt-2">{{ $message }}</p>@enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-8 py-4 bg-custom-primary text-white font-semibold
                                            rounded-md hover:bg-red-700 hover:scale-[1.02] transition-all duration-200
                                            shadow-[0_4px_14px_rgba(211,30,36,0.30)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Map --}}
                    <div class="rounded-2xl border border-white/5 overflow-hidden h-64">
                        @if($contact && $contact->latitude && $contact->longitude)
                            <iframe
                                src="https://maps.google.com/maps?q={{ $contact->latitude }},{{ $contact->longitude }}&z={{ $contact->map_zoom }}&output=embed"
                                width="100%" height="100%" style="border:0;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                title="Premax Automotive Studio Location">
                            </iframe>
                        @elseif($contact && $contact->google_maps_url)
                            <div class="bg-[#1a1a1a] h-full flex flex-col items-center justify-center gap-3 text-white/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-sm text-white/30">{{ $contact->short_address }}</p>
                                <a href="{{ $contact->google_maps_url }}" target="_blank" rel="noopener noreferrer"
                                class="text-xs font-bold text-custom-primary hover:underline">
                                    View on Google Maps →
                                </a>
                            </div>
                        @else
                            <div class="bg-[#1a1a1a] h-full flex items-center justify-center">
                                <p class="text-sm text-white/20">Map not configured</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@endsection
