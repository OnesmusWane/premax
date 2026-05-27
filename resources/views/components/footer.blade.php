{{-- ── FOOTER ──
     Component: <x-footer />
     Data sources:
       - Contact info  → contact_information table
       - Services col  → service_categories table (top 5)
       - Social links  → contact_information table
       - Legal links   → legal_pages table
--}}

<footer class="bg-custom-secondary text-gray-400">

    {{-- ── MAIN FOOTER CONTENT ── --}}
    <div class="max-w-7xl mx-auto px-6 py-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

        {{-- Col 1 — Brand + Socials --}}
        <div class="flex flex-col gap-5">
            <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline w-fit">
                <div class="bg-white rounded-xl p-1.5 shrink-0">
                    <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Premax Autocare" class="h-10 w-auto">
                </div>
                <span class="text-xl font-extrabold tracking-tight text-white">
                    Premax <span class="text-custom-primary">Autocare</span>
                </span>
            </a>

            <p class="text-sm text-gray-400 leading-relaxed max-w-[240px]">
                Premium auto care and diagnostic services in Nairobi. We treat every vehicle with the utmost care and professionalism.
            </p>

            {{-- Social icons — from DB --}}
            <div class="flex items-center gap-3 mt-1">

                @if($contact?->facebook_url)
                <a href="{{ $contact->facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-custom-primary flex items-center justify-center transition-colors duration-200">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                    </svg>
                </a>
                @endif

                @if($contact?->twitter_url)
                <a href="{{ $contact->twitter_url }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter / X"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-custom-primary flex items-center justify-center transition-colors duration-200">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
                    </svg>
                </a>
                @endif

                @if($contact?->instagram_url)
                <a href="{{ $contact->instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-custom-primary flex items-center justify-center transition-colors duration-200">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/>
                    </svg>
                </a>
                @endif

                @if($contact?->tiktok_url)
                <a href="{{ $contact->tiktok_url }}" target="_blank" rel="noopener noreferrer" aria-label="TikTok"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-custom-primary flex items-center justify-center transition-colors duration-200">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z"/>
                    </svg>
                </a>
                @endif

                @if($contact?->youtube_url)
                <a href="{{ $contact->youtube_url }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-custom-primary flex items-center justify-center transition-colors duration-200">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.96A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/>
                    </svg>
                </a>
                @endif

                {{-- Always show WhatsApp if phone exists --}}
                @if($contact?->whatsapp_url)
                <a href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                   class="w-9 h-9 rounded-full bg-white/10 hover:bg-green-500 flex items-center justify-center transition-colors duration-200">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
                @endif

                {{-- Fallback: show placeholder circles if no contact record yet --}}
                @if(!$contact)
                @foreach(['Facebook', 'Twitter', 'Instagram'] as $s)
                <span class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center" aria-hidden="true"></span>
                @endforeach
                @endif

            </div>
        </div>

        {{-- Col 2 — Quick Links (static) --}}
        <div class="flex flex-col gap-4">
            <h3 class="text-white font-bold text-base tracking-wide">Quick Links</h3>
            <ul class="flex flex-col gap-2.5 list-none m-0 p-0">
                @foreach([
                    ['Home',             '/'],
                    ['About Us',         '/about'],
                    ['Our Services',     '/services'],
                    ['Book Appointment', '/booking'],
                    ['Contact Us',       '/contact'],
                ] as [$label, $href])
                <li>
                    <a href="{{ url($href) }}"
                       class="text-sm text-gray-400 hover:text-custom-primary no-underline transition-colors duration-200
                              flex items-center gap-2 group">
                        <span class="w-1 h-1 rounded-full bg-custom-primary opacity-0 group-hover:opacity-100 transition-opacity duration-200 shrink-0"></span>
                        {{ $label }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Col 3 — Service Categories (from DB) --}}
        <div class="flex flex-col gap-4">
            <h3 class="text-white font-bold text-base tracking-wide">Our Services</h3>
            <ul class="flex flex-col gap-2.5 list-none m-0 p-0">
                @forelse($categories as $category)
                <li>
                    <a href="{{ url('/services#cat-' . $category->id) }}"
                       class="text-sm text-gray-400 hover:text-custom-primary no-underline transition-colors duration-200
                              flex items-center gap-2 group">
                        <span class="w-1 h-1 rounded-full bg-custom-primary opacity-0 group-hover:opacity-100 transition-opacity duration-200 shrink-0"></span>
                        {{ $category->name }}
                    </a>
                </li>
                @empty
                <li class="text-sm text-gray-600">No services listed yet.</li>
                @endforelse
                <li>
                    <a href="{{ url('/services') }}"
                       class="text-xs font-semibold text-custom-primary hover:underline flex items-center gap-1 mt-1">
                        View all services →
                    </a>
                </li>
            </ul>
        </div>

        {{-- Col 4 — Contact Info (from DB) --}}
        <div class="flex flex-col gap-4">
            <h3 class="text-white font-bold text-base tracking-wide">Contact Info</h3>
            <ul class="flex flex-col gap-4 list-none m-0 p-0">

                {{-- Address --}}
                @if($contact?->short_address)
                <li class="flex items-start gap-3">
                    <span class="w-8 h-8 rounded-lg bg-custom-primary/15 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </span>
                    <a href="{{ $contact->google_maps_url ?? '#' }}"
                       target="{{ $contact->google_maps_url ? '_blank' : '_self' }}"
                       rel="noopener noreferrer"
                       class="text-sm leading-relaxed text-gray-400 hover:text-custom-primary no-underline transition-colors duration-200">
                        {{ $contact->street_address }}
                        @if($contact->landmark)<br>{{ $contact->landmark }}@endif
                        <br>{{ $contact->city }}, {{ $contact->country }}
                    </a>
                </li>
                @endif

                {{-- Phone --}}
                @if($contact?->phone_primary)
                <li class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-custom-primary/15 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 18.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </span>
                    <div class="flex flex-col">
                        <a href="tel:{{ $contact->phone_primary_e164 }}"
                           class="text-sm text-gray-400 hover:text-custom-primary no-underline transition-colors duration-200">
                            {{ $contact->phone_primary }}
                        </a>
                        @if($contact->phone_secondary)
                        <a href="tel:{{ $contact->phone_secondary_e164 }}"
                           class="text-sm text-gray-400 hover:text-custom-primary no-underline transition-colors duration-200">
                            {{ $contact->phone_secondary }}
                        </a>
                        @endif
                    </div>
                </li>
                @endif

                {{-- Today's hours --}}
                @if($contact?->today_hours)
                <li class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-custom-primary/15 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                        </svg>
                    </span>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-600 uppercase tracking-widest">Today</span>
                        <span class="text-sm">{{ $contact->today_hours }}</span>
                    </div>
                </li>
                @endif

                {{-- Email --}}
                @if($contact?->email_primary)
                <li class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-custom-primary/15 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <a href="mailto:{{ $contact->email_primary }}"
                       class="text-sm text-gray-400 hover:text-custom-primary no-underline transition-colors duration-200">
                        {{ $contact->email_primary }}
                    </a>
                </li>
                @endif

            </ul>
        </div>

    </div>

    {{-- ── DIVIDER ── --}}
    <div class="border-t border-white/10"></div>

    {{-- ── BOTTOM BAR ── --}}
    <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-600">
        <span>&copy; {{ date('Y') }} Premax Autocare. All rights reserved.</span>

        <div class="flex items-center gap-5">

            {{-- Legal pages from DB --}}
            @foreach($legalPages as $legal)
            <a href="{{ url('/' . $legal->slug) }}"
               class="text-gray-600 hover:text-custom-primary no-underline transition-colors duration-200">
                {{ $legal->title }}
            </a>
            @endforeach

            <a href="https://admin.premaxautoservice.co.ke" target="_blank"
               class="text-gray-600 hover:text-custom-primary no-underline transition-colors duration-200">
                Admin Login
            </a>
        </div>
    </div>

</footer>