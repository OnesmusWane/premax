@php
    $pageTitle = 'Book Executive Service | Premax Auto Service Nairobi';
    $pageDescription = 'Reserve studio time for luxury vehicle diagnostics, detailing, maintenance and concierge service at Premax Nairobi.';
    $flatServices = $services->flatten(1);
@endphp

@extends('layouts.default-menu-page')

@section('content')
<section class="relative flex h-[55vh] min-h-[440px] items-end overflow-hidden">
    <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=2670&auto=format&fit=crop" alt="Book Premax service" class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-premax-dark via-premax-dark/45 to-transparent"></div>
    <div class="premax-container relative z-10 pb-16 md:pb-24">
        <span class="premax-eyebrow mb-4 block">Reservations</span>
        <h1 class="max-w-4xl font-display text-4xl font-extrabold leading-[1.05] text-white md:text-6xl lg:text-7xl">Book Executive Service.</h1>
        <p class="mt-6 max-w-2xl text-lg font-light leading-relaxed text-premax-platinum/80 md:text-xl">Reserve studio time for your vehicle. A service advisor will confirm the details by phone or WhatsApp.</p>
    </div>
</section>

<section class="bg-premax-dark px-6 py-16 md:py-24">
    <div class="mx-auto max-w-5xl">
        @if($errors->any())
            <div class="mb-8 rounded-lg border border-premax-red/30 bg-premax-red/10 px-4 py-3 text-sm text-red-200">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" class="premax-card p-6 md:p-10">
            @csrf
            <div class="mb-12">
                <span class="premax-eyebrow mb-4 block">Step 01 · Service</span>
                <h2 class="mb-2 font-display text-2xl font-extrabold text-white md:text-3xl">Select the work.</h2>
                <p class="text-premax-platinum/60">Choose a service and tell us about the vehicle.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-xs uppercase tracking-widest text-premax-muted">Service</label>
                    <select name="service_id" id="service-select" required class="w-full rounded-md border border-white/15 bg-premax-dark px-4 py-3 text-white focus:border-premax-red focus:ring-0">
                        <option value="">Select service</option>
                        @foreach($flatServices as $service)
                            <option value="{{ $service->id }}" data-name="{{ $service->name }}" @selected((string) $selectedServiceId === (string) $service->id)>
                                {{ $service->name }} · From KES {{ number_format($service->price_from) }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="service" id="service-name" value="{{ optional($flatServices->firstWhere('id', $selectedServiceId))->name }}">
                </div>
                <div>
                    <label class="mb-2 block text-xs uppercase tracking-widest text-premax-muted">Registration</label>
                    <input name="reg" value="{{ old('reg') }}" required placeholder="KDA 123A" class="w-full rounded-md border border-white/15 bg-premax-dark px-4 py-3 text-white placeholder:text-white/30 focus:border-premax-red focus:ring-0">
                </div>
                <div>
                    <label class="mb-2 block text-xs uppercase tracking-widest text-premax-muted">Marque / Make</label>
                    <input name="make" value="{{ old('make') }}" placeholder="BMW, Porsche, Mercedes-Benz..." class="w-full rounded-md border border-white/15 bg-premax-dark px-4 py-3 text-white placeholder:text-white/30 focus:border-premax-red focus:ring-0">
                </div>
                <div>
                    <label class="mb-2 block text-xs uppercase tracking-widest text-premax-muted">Preferred Date</label>
                    <input name="date" type="date" min="{{ date('Y-m-d') }}" value="{{ old('date') }}" required class="w-full rounded-md border border-white/15 bg-premax-dark px-4 py-3 text-white focus:border-premax-red focus:ring-0">
                </div>
            </div>

            <div class="mt-12 border-t border-white/10 pt-12">
                <span class="premax-eyebrow mb-4 block">Step 02 · Schedule</span>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach(['08:00','09:00','10:00','11:00','12:00','14:00','15:00','16:00'] as $slot)
                        <label class="cursor-pointer">
                            <input type="radio" name="time" value="{{ $slot }}" class="peer sr-only" required @checked(old('time') === $slot)>
                            <span class="block rounded-lg border border-white/15 px-4 py-3 text-center text-sm font-semibold text-white/80 transition-all peer-checked:border-premax-red peer-checked:bg-premax-red peer-checked:text-white hover:border-white/40">{{ $slot }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-12 border-t border-white/10 pt-12">
                <span class="premax-eyebrow mb-4 block">Step 03 · Details</span>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <input name="name" value="{{ old('name') }}" required placeholder="Full name" class="premax-input">
                    <input name="phone" value="{{ old('phone') }}" required placeholder="Phone number" class="premax-input">
                    <input name="email" type="email" value="{{ old('email') }}" placeholder="Email (optional)" class="premax-input md:col-span-2">
                    <textarea name="notes" rows="4" placeholder="Notes, symptoms, or concierge collection request" class="premax-input resize-none md:col-span-2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-10 flex flex-col items-start justify-between gap-5 border-t border-white/10 pt-8 md:flex-row md:items-center">
                <p class="max-w-xl text-sm leading-relaxed text-premax-platinum/55">This submits a reservation request. Your appointment is confirmed once a Premax advisor contacts you.</p>
                <button type="submit" class="premax-button premax-button-primary w-full md:w-auto">Confirm Booking</button>
            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('service-select');
    const name = document.getElementById('service-name');
    const sync = () => {
        const option = select.options[select.selectedIndex];
        name.value = option?.dataset?.name || option?.textContent?.split('·')[0]?.trim() || '';
    };
    select.addEventListener('change', sync);
    sync();
});
</script>
@endsection
