@php
    $pageTitle = 'Contact Premax | Reservations & Concierge Nairobi';
    $pageDescription = 'Contact Premax for reservations, concierge collection, and luxury vehicle service consultation in Nairobi.';
@endphp

@extends('layouts.default-menu-page')

@section('content')
<section class="relative flex h-[58vh] min-h-[460px] items-end overflow-hidden">
    <img src="https://images.unsplash.com/photo-1486006920555-c77dcf18193c?q=80&w=2670&auto=format&fit=crop" alt="Premax diagnostics" class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-premax-dark via-premax-dark/45 to-transparent"></div>
    <div class="premax-container relative z-10 pb-16 md:pb-24">
        <span class="premax-eyebrow mb-4 block">Get In Touch</span>
        <h1 class="max-w-4xl font-display text-4xl font-extrabold leading-[1.05] text-white md:text-6xl lg:text-7xl">A Quiet Word, A Confident Hand.</h1>
        <p class="mt-6 max-w-2xl text-lg font-light leading-relaxed text-premax-platinum/80 md:text-xl">For reservations, concierge collection, or a private consultation about your marque, our advisors are at your service.</p>
    </div>
</section>

<section class="bg-premax-dark px-6 py-24 md:py-32">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-16 lg:grid-cols-2 lg:gap-24">
        <div>
            <span class="premax-eyebrow mb-4 block">Studio Details</span>
            <h2 class="mb-10 font-display text-3xl font-extrabold text-white md:text-4xl">Visit, Call, or Write.</h2>

            <ul class="mb-12 space-y-8">
                @if($contact?->short_address)
                    <li class="flex items-start gap-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-white/10 bg-premax-surface text-premax-red">⌖</span>
                        <div>
                            <h3 class="mb-2 text-xs uppercase tracking-widest text-premax-muted">The Studio</h3>
                            <p class="leading-relaxed text-white">{{ $contact->street_address }}@if($contact->landmark)<br>{{ $contact->landmark }}@endif<br>{{ $contact->city }}, {{ $contact->country }}</p>
                        </div>
                    </li>
                @endif
                @if($contact?->phone_primary)
                    <li class="flex items-start gap-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-white/10 bg-premax-surface text-premax-red">☎</span>
                        <div>
                            <h3 class="mb-2 text-xs uppercase tracking-widest text-premax-muted">Reservations</h3>
                            <a href="tel:{{ $contact->phone_primary_e164 }}" class="leading-relaxed text-white no-underline hover:text-premax-red">{{ $contact->phone_primary }}</a>
                            @if($contact->phone_secondary)<p class="text-white">{{ $contact->phone_secondary }}</p>@endif
                        </div>
                    </li>
                @endif
                @if($contact?->email_primary)
                    <li class="flex items-start gap-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-white/10 bg-premax-surface text-premax-red">@</span>
                        <div>
                            <h3 class="mb-2 text-xs uppercase tracking-widest text-premax-muted">Correspondence</h3>
                            <a href="mailto:{{ $contact->email_primary }}" class="leading-relaxed text-white no-underline hover:text-premax-red">{{ $contact->email_primary }}</a>
                        </div>
                    </li>
                @endif
                @if($contact?->business_hours)
                    <li class="flex items-start gap-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-white/10 bg-premax-surface text-premax-red">◷</span>
                        <div>
                            <h3 class="mb-2 text-xs uppercase tracking-widest text-premax-muted">Studio Hours</h3>
                            @foreach($contact->formattedHours() as $line)
                                <p class="leading-relaxed text-white">{{ $line }}</p>
                            @endforeach
                        </div>
                    </li>
                @endif
            </ul>

            <div class="aspect-[16/9] overflow-hidden rounded-2xl border border-white/10">
                <iframe title="Premax studio location" src="https://www.openstreetmap.org/export/embed.html?bbox=36.8201%2C-1.3133%2C36.8801%2C-1.2733&layer=mapnik" class="h-full w-full grayscale contrast-125 brightness-75" loading="lazy"></iframe>
            </div>
        </div>

        <div class="premax-card p-8 md:p-12">
            <span class="premax-eyebrow mb-4 block">Send a Message</span>
            <h2 class="mb-8 font-display text-3xl font-extrabold text-white">How may we assist?</h2>

            @if(session('success'))
                <div class="mb-8 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-8 rounded-lg border border-premax-red/30 bg-premax-red/10 px-4 py-3 text-sm text-red-200">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <input name="name" value="{{ old('name') }}" required placeholder="Full Name" class="premax-input">
                    <input name="email" value="{{ old('email') }}" required type="email" placeholder="Email" class="premax-input">
                </div>
                <input name="phone" value="{{ old('phone') }}" placeholder="Phone (optional)" class="premax-input">
                <textarea name="message" required rows="5" placeholder="Message" class="premax-input resize-none">{{ old('message') }}</textarea>
                <button type="submit" class="premax-button premax-button-primary w-full">Send Message</button>
            </form>
        </div>
    </div>
</section>
@endsection
