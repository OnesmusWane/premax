{{-- ── TOP BAR ── --}}
{{-- Component: <x-topbar /> --}}
{{-- Data fetched automatically from contact_information table (cached 60 min) --}}

@if ($contact)
<div id="topbar" class="bg-custom-secondary text-gray-400 text-xs sticky top-0 z-50 overflow-hidden hidden md:block">
    <div class="max-w-7xl mx-auto px-6 py-2 flex items-center justify-between flex-wrap gap-1">

        {{-- ── Left: Phone · Address · Hours ── --}}
        <div class="flex items-center gap-6 flex-wrap">

            {{-- Primary Phone --}}
            @if ($contact->phone_primary)
            <a href="tel:{{ $contact->phone_primary_e164 }}"
               class="flex items-center gap-1.5 whitespace-nowrap hover:text-custom-primary transition-colors">
                <svg class="w-3 h-3 text-custom-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 18.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ $contact->phone_primary }}
            </a>
            @endif

            {{-- Secondary Phone (optional — shown if present) --}}
            @if ($contact->phone_secondary)
            <a href="tel:{{ $contact->phone_secondary_e164 }}"
               class="flex items-center gap-1.5 whitespace-nowrap hover:text-custom-primary transition-colors">
                <svg class="w-3 h-3 text-custom-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 18.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ $contact->phone_secondary }}
            </a>
            @endif

            {{-- Address --}}
            @if ($contact->short_address)
            <a href="{{ $contact->google_maps_url ?? '#' }}"
               target="{{ $contact->google_maps_url ? '_blank' : '_self' }}"
               rel="noopener noreferrer"
               class="flex items-center gap-1.5 whitespace-nowrap hover:text-custom-primary transition-colors">
                <svg class="w-3 h-3 text-custom-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $contact->short_address }}
            </a>
            @endif

            {{-- Today's Hours --}}
            @if ($contact->today_hours)
            <span class="flex items-center gap-1.5 whitespace-nowrap">
                <svg class="w-3 h-3 text-custom-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                </svg>
                {{ $contact->today_hours }}
            </span>
            @endif

        </div>

        {{-- ── Right: Social Icons ── --}}
        <div class="flex items-center gap-3">
            @if ($contact->facebook_url)
            <a href="{{ $contact->facebook_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="Facebook" class="text-gray-500 hover:text-custom-primary transition-colors flex">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                </svg>
            </a>
            @endif

            @if ($contact->twitter_url)
            <a href="{{ $contact->twitter_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="Twitter / X" class="text-gray-500 hover:text-custom-primary transition-colors flex">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
                </svg>
            </a>
            @endif

            @if ($contact->instagram_url)
            <a href="{{ $contact->instagram_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="Instagram" class="text-gray-500 hover:text-custom-primary transition-colors flex">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                    <circle cx="12" cy="12" r="4"/>
                    <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/>
                </svg>
            </a>
            @endif

            @if ($contact->tiktok_url)
            <a href="{{ $contact->tiktok_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="TikTok" class="text-gray-500 hover:text-custom-primary transition-colors flex">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z"/>
                </svg>
            </a>
            @endif

            @if ($contact->youtube_url)
            <a href="{{ $contact->youtube_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="YouTube" class="text-gray-500 hover:text-custom-primary transition-colors flex">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.96A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/>
                </svg>
            </a>
            @endif

            @if ($contact->linkedin_url)
            <a href="{{ $contact->linkedin_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="LinkedIn" class="text-gray-500 hover:text-custom-primary transition-colors flex">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
                    <circle cx="4" cy="4" r="2"/>
                </svg>
            </a>
            @endif

            {{-- WhatsApp (derived from phone_whatsapp or phone_primary) --}}
            @if ($contact->whatsapp_url)
            <a href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="WhatsApp" class="text-gray-500 hover:text-custom-primary transition-colors flex">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.116.554 4.103 1.523 5.824L.057 23.882a.5.5 0 00.61.61l6.057-1.467A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.88 9.88 0 01-5.032-1.378l-.36-.214-3.733.904.92-3.633-.235-.374A9.861 9.861 0 012.118 12C2.118 6.533 6.533 2.118 12 2.118c5.466 0 9.882 4.415 9.882 9.882 0 5.466-4.416 9.882-9.882 9.882z"/>
                </svg>
            </a>
            @endif

        </div>

    </div>
</div>
@endif