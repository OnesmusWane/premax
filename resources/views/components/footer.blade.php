<footer class="border-t border-white/5 bg-[#050505] px-6 pb-12 pt-24">
    <div class="mx-auto max-w-7xl">
        <div class="mb-20 grid grid-cols-2 gap-12 md:grid-cols-3 lg:grid-cols-5">
            <div class="col-span-2 lg:col-span-1">
                <a href="{{ url('/') }}" class="mb-6 flex items-center gap-2 no-underline">
                    <span class="font-display text-2xl font-extrabold uppercase tracking-[0.18em] text-white">Premax</span>
                    <span class="h-2 w-2 bg-premax-red"></span>
                </a>
                <p class="mb-6 text-sm leading-relaxed text-premax-platinum/60">
                    Engineering excellence and unrivaled care for luxury marques in Nairobi.
                </p>
                <div class="flex gap-3">
                    @foreach([
                        ['Instagram', $contact?->instagram_url],
                        ['X', $contact?->twitter_url],
                        ['Facebook', $contact?->facebook_url],
                    ] as [$label, $url])
                        @if($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/5 text-xs font-bold text-white/70 transition-colors hover:bg-premax-red hover:text-white" aria-label="{{ $label }}">
                                {{ substr($label, 0, 1) }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="mb-6 font-display font-semibold text-white">Services</h4>
                <ul class="space-y-4">
                    @forelse($categories->take(5) as $category)
                        <li><a href="{{ url('/services#cat-' . $category->id) }}" class="text-sm text-premax-platinum/60 no-underline transition-colors hover:text-white">{{ $category->name }}</a></li>
                    @empty
                        <li class="text-sm text-premax-platinum/40">Services coming soon.</li>
                    @endforelse
                    <li><a href="{{ url('/services') }}" class="text-sm text-white no-underline transition-colors hover:text-premax-red">View all &rarr;</a></li>
                </ul>
            </div>

            <div>
                <h4 class="mb-6 font-display font-semibold text-white">Studio</h4>
                <ul class="space-y-4">
                    @foreach([['About Premax','/about'], ['Our Work','/gallery'], ['Book Service','/booking'], ['Contact','/contact']] as [$label, $href])
                        <li><a href="{{ url($href) }}" class="text-sm text-premax-platinum/60 no-underline transition-colors hover:text-white">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="mb-6 font-display font-semibold text-white">Client Care</h4>
                <ul class="space-y-4">
                    <li><a href="{{ url('/booking') }}" class="text-sm text-premax-platinum/60 no-underline transition-colors hover:text-white">Reservations</a></li>
                    <li><a href="{{ url('/feedback/thanks') }}" class="text-sm text-premax-platinum/60 no-underline transition-colors hover:text-white">Reviews</a></li>
                    @foreach($legalPages as $legal)
                        <li><a href="{{ url('/' . $legal->slug) }}" class="text-sm text-premax-platinum/60 no-underline transition-colors hover:text-white">{{ $legal->title }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="mb-6 font-display font-semibold text-white">Contact</h4>
                <ul class="space-y-4 text-sm text-premax-platinum/60">
                    @if($contact?->short_address)
                        <li>{{ $contact->street_address }}@if($contact->landmark)<br>{{ $contact->landmark }}@endif<br>{{ $contact->city }}, {{ $contact->country }}</li>
                    @endif
                    @if($contact?->phone_primary)
                        <li><a href="tel:{{ $contact->phone_primary_e164 }}" class="text-premax-platinum/60 no-underline hover:text-white">{{ $contact->phone_primary }}</a></li>
                    @endif
                    @if($contact?->email_primary)
                        <li><a href="mailto:{{ $contact->email_primary }}" class="text-premax-platinum/60 no-underline hover:text-white">{{ $contact->email_primary }}</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 md:flex-row">
            <p class="text-xs text-white/40">&copy; {{ date('Y') }} Premax Auto Service. All rights reserved.</p>
            <a href="{{ url('/admin') }}" class="text-xs text-white/40 no-underline transition-colors hover:text-white">Admin Login</a>
        </div>
    </div>
</footer>
