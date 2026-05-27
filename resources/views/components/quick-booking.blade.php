{{-- ═══════════════════════════════════════════
     BOOK EXECUTIVE SERVICE — Dark form
     Component: <x-quick-booking />
     Posts to: route('booking.store')
═══════════════════════════════════════════ --}}

@php
    $quickServices = Cache::remember('quick_booking_services', now()->addMinutes(60), fn() =>
        \App\Models\Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name'])
    );
    $servicesJson = $quickServices->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->toJson();
@endphp

<section id="booking" class="py-24 md:py-36 bg-[#111111] border-t border-white/5">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">

            {{-- ── Form side ── --}}
            <div>
                <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                    Reservations
                </span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    Book Executive Service.
                </h2>
                <p class="text-white/55 text-lg leading-relaxed mb-12">
                    Secure your appointment at the studio. A service advisor will contact you shortly
                    to confirm details and arrange concierge collection if required.
                </p>

                <form action="{{ route('booking.store') }}" method="POST" class="space-y-8" id="quick-booking-form">
                    @csrf

                    @if($errors->any())
                    <div class="text-xs text-red-400 bg-red-950/40 border border-red-900/40 rounded-lg px-4 py-3">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Name + Phone --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="relative">
                            <input type="text" name="name" id="bk_name"
                                   value="{{ old('name') }}" placeholder=" " required
                                   class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                          focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer
                                          placeholder-transparent autofill:bg-transparent">
                            <label for="bk_name"
                                   class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                          peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                          peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                                Full Name
                            </label>
                        </div>

                        <div class="relative">
                            <input type="tel" name="phone" id="bk_phone"
                                   value="{{ old('phone') }}" placeholder=" " required
                                   class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                          focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer
                                          placeholder-transparent">
                            <label for="bk_phone"
                                   class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                          peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                          peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                                Phone Number
                            </label>
                        </div>

                    </div>

                    {{-- Registration --}}
                    <div class="relative">
                        <input type="text" name="reg" id="bk_reg"
                               value="{{ old('reg') }}" placeholder=" " required
                               class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                      focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer
                                      placeholder-transparent">
                        <label for="bk_reg"
                               class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                      peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                      peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                            Vehicle Registration (e.g. KCA 123A)
                        </label>
                    </div>

                    {{-- Service + Date --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        {{-- Searchable Service Dropdown --}}
                        <div class="relative" id="svc-wrapper">
                            <input type="hidden" name="service"    id="bk_svc_val" value="{{ old('service') }}">
                            <input type="hidden" name="service_id" id="bk_svc_id"  value="{{ old('service_id') }}">
                            <input type="text" id="bk_svc_search"
                                   placeholder=" "
                                   autocomplete="off"
                                   value="{{ old('service') }}"
                                   class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                          focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer
                                          placeholder-transparent">
                            <label for="bk_svc_search"
                                   class="absolute left-0 -top-3.5 text-xs text-white/40 transition-all duration-200
                                          peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:text-white/35
                                          peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-custom-primary">
                                Service
                            </label>
                            {{-- Chevron icon --}}
                            <svg id="svc-chevron" class="pointer-events-none absolute right-0 top-3.5 w-4 h-4 text-white/30 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                            <div id="svc-dropdown"
                                 class="hidden absolute z-50 top-[calc(100%+4px)] left-0 right-0 bg-[#1c1c1c] border border-white/10 rounded-xl
                                        max-h-52 overflow-y-auto shadow-2xl">
                            </div>
                        </div>

                        {{-- Custom Date Picker --}}
                        <div class="relative" id="date-wrapper">
                            <input type="hidden" name="date" id="bk_date" value="{{ old('date') }}">
                            <input type="text" id="bk_date_display"
                                   placeholder=" "
                                   readonly
                                   value="{{ old('date') ? \Carbon\Carbon::parse(old('date'))->format('d M Y') : '' }}"
                                   class="block w-full bg-transparent border-0 border-b border-white/20 py-3 text-white text-sm
                                          focus:ring-0 focus:border-custom-primary focus:outline-none transition-colors peer
                                          placeholder-transparent cursor-pointer select-none">
                            <label for="bk_date_display"
                                   class="absolute left-0 -top-3.5 text-xs text-white/40">
                                Preferred Date
                            </label>
                            {{-- Calendar icon --}}
                            <svg class="pointer-events-none absolute right-0 top-3.5 w-4 h-4 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{-- Calendar popup --}}
                            <div id="date-cal"
                                 class="hidden absolute z-50 top-[calc(100%+4px)] left-0 bg-[#1c1c1c] border border-white/10 rounded-xl
                                        shadow-2xl p-4 w-72 select-none">
                                <div class="flex items-center justify-between mb-4">
                                    <button type="button" id="cal-prev"
                                            class="p-1.5 rounded-lg text-white/40 hover:text-white hover:bg-white/8 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <span id="cal-title" class="text-sm font-semibold text-white tracking-wide"></span>
                                    <button type="button" id="cal-next"
                                            class="p-1.5 rounded-lg text-white/40 hover:text-white hover:bg-white/8 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-7 mb-2">
                                    <div class="text-center text-[10px] font-semibold text-white/25 pb-1">Su</div>
                                    <div class="text-center text-[10px] font-semibold text-white/25 pb-1">Mo</div>
                                    <div class="text-center text-[10px] font-semibold text-white/25 pb-1">Tu</div>
                                    <div class="text-center text-[10px] font-semibold text-white/25 pb-1">We</div>
                                    <div class="text-center text-[10px] font-semibold text-white/25 pb-1">Th</div>
                                    <div class="text-center text-[10px] font-semibold text-white/25 pb-1">Fr</div>
                                    <div class="text-center text-[10px] font-semibold text-white/25 pb-1">Sa</div>
                                </div>
                                <div id="cal-grid" class="grid grid-cols-7 gap-y-0.5"></div>
                            </div>
                        </div>

                    </div>

                    {{-- Time Slots --}}
                    <div>
                        <p class="text-xs text-white/40 mb-3">Preferred Time</p>
                        <input type="hidden" name="time" id="bk_time" value="{{ old('time') }}">
                        <div class="grid grid-cols-5 gap-2" id="time-slots">
                            @foreach(['08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM'] as $slot)
                            <button type="button"
                                    data-slot="{{ $slot }}"
                                    class="time-slot px-2 py-2 rounded-lg border text-xs font-medium transition-all duration-150 cursor-pointer
                                           {{ old('time') === $slot
                                               ? 'border-custom-primary bg-custom-primary/15 text-custom-primary'
                                               : 'border-white/10 text-white/50 hover:border-white/30 hover:text-white/80' }}">
                                {{ $slot }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="px-10 py-4 bg-custom-primary text-white font-semibold rounded-md
                                       hover:bg-red-700 hover:scale-[1.02] transition-all duration-200
                                       shadow-[0_4px_14px_rgba(211,30,36,0.35)]">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>

            {{-- ── Image side ── --}}
            <div class="hidden lg:block relative h-full min-h-[520px] rounded-2xl overflow-hidden">
                <img src="{{ asset('assets/images/booking.webp') }}"
                     alt="Luxury vehicle awaiting executive service"
                     class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#111111]/70 to-transparent"></div>
            </div>

        </div>
    </div>
</section>

@push('scripts-stack')
<script>
(function () {
    // ── Services data ─────────────────────────────────────────────────────
    const SERVICES = {!! $servicesJson !!};

    // ── Searchable Service Dropdown ───────────────────────────────────────
    const svcSearch  = document.getElementById('bk_svc_search');
    const svcVal     = document.getElementById('bk_svc_val');
    const svcId      = document.getElementById('bk_svc_id');
    const svcDrop    = document.getElementById('svc-dropdown');
    const svcWrap    = document.getElementById('svc-wrapper');
    const svcChevron = document.getElementById('svc-chevron');

    function buildItems(query) {
        const q = (query || '').toLowerCase().trim();
        const list = q ? SERVICES.filter(s => s.name.toLowerCase().includes(q)) : SERVICES;
        if (!list.length) {
            return '<div class="px-4 py-3 text-sm text-white/30">No services found</div>';
        }
        return list.map(s => {
            const hi = q
                ? s.name.replace(new RegExp(`(${q})`, 'gi'), '<mark class="bg-transparent text-custom-primary font-semibold">$1</mark>')
                : s.name;
            return `<div class="svc-opt px-4 py-2.5 text-sm text-white/75 hover:bg-white/5 hover:text-white cursor-pointer transition-colors"
                         data-id="${s.id}" data-name="${s.name}">${hi}</div>`;
        }).join('');
    }

    function openSvc() {
        svcDrop.innerHTML = buildItems(svcSearch.value);
        svcDrop.classList.remove('hidden');
        svcChevron.style.transform = 'rotate(180deg)';
    }

    function closeSvc() {
        svcDrop.classList.add('hidden');
        svcChevron.style.transform = '';
        // Restore display to last confirmed selection if the user typed something partial
        if (svcSearch.value !== svcVal.value) {
            svcSearch.value = svcVal.value;
        }
    }

    svcSearch.addEventListener('focus', openSvc);

    svcSearch.addEventListener('input', function () {
        // Typing clears the confirmed selection until user picks one
        svcVal.value = '';
        svcId.value  = '';
        svcDrop.innerHTML = buildItems(this.value);
        svcDrop.classList.remove('hidden');
    });

    svcDrop.addEventListener('mousedown', function (e) {
        // Use mousedown so the input blur fires after we've read the click
        const opt = e.target.closest('.svc-opt');
        if (!opt) return;
        e.preventDefault();
        svcSearch.value = opt.dataset.name;
        svcVal.value    = opt.dataset.name;
        svcId.value     = opt.dataset.id;
        closeSvc();
    });

    document.addEventListener('click', function (e) {
        if (!svcWrap.contains(e.target)) closeSvc();
    });

    // Validate on submit — ensure a service was actually selected from the list
    document.getElementById('quick-booking-form').addEventListener('submit', function (e) {
        if (!svcVal.value) {
            e.preventDefault();
            svcSearch.focus();
            svcSearch.style.borderColor = '#ef4444';
            setTimeout(() => svcSearch.style.borderColor = '', 2000);
        }
    });

    // ── Custom Calendar ───────────────────────────────────────────────────
    const dateHidden  = document.getElementById('bk_date');
    const dateDisplay = document.getElementById('bk_date_display');
    const dateCal     = document.getElementById('date-cal');
    const dateWrap    = document.getElementById('date-wrapper');
    const calGrid     = document.getElementById('cal-grid');
    const calTitle    = document.getElementById('cal-title');
    const calPrev     = document.getElementById('cal-prev');
    const calNext     = document.getElementById('cal-next');

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    let calYear  = today.getFullYear();
    let calMonth = today.getMonth();

    const MONTHS = ['January','February','March','April','May','June','July',
                    'August','September','October','November','December'];

    function pad(n) { return String(n).padStart(2, '0'); }

    function isoToDisplay(iso) {
        const [y, m, d] = iso.split('-');
        return `${parseInt(d)} ${MONTHS[parseInt(m) - 1]} ${y}`;
    }

    function renderCal() {
        calTitle.textContent = `${MONTHS[calMonth]} ${calYear}`;

        const firstOfMonth = new Date(calYear, calMonth, 1);
        const firstOfToday = new Date(today.getFullYear(), today.getMonth(), 1);
        calPrev.disabled = firstOfMonth <= firstOfToday;
        calPrev.style.opacity = calPrev.disabled ? '0.2' : '';

        const startDay    = firstOfMonth.getDay();
        const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
        const selected    = dateHidden.value;

        let cells = '';

        // Leading empty cells
        for (let i = 0; i < startDay; i++) {
            cells += '<div></div>';
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const thisDate = new Date(calYear, calMonth, d);
            const iso      = `${calYear}-${pad(calMonth + 1)}-${pad(d)}`;
            const isPast   = thisDate < today;
            const isSel    = iso === selected;
            const isToday  = thisDate.getTime() === today.getTime();

            if (isPast) {
                cells += `<div class="h-8 w-8 mx-auto flex items-center justify-center text-[11px] text-white/15 rounded-full cursor-not-allowed">${d}</div>`;
            } else {
                let cls = 'cal-day h-8 w-8 mx-auto flex items-center justify-center text-[11px] rounded-full cursor-pointer transition-all ';
                if (isSel) {
                    cls += 'bg-custom-primary text-white font-semibold shadow-[0_0_10px_rgba(211,30,36,0.5)]';
                } else if (isToday) {
                    cls += 'text-custom-primary font-semibold ring-1 ring-custom-primary/40 hover:bg-custom-primary hover:text-white';
                } else {
                    cls += 'text-white/70 hover:bg-white/10 hover:text-white';
                }
                cells += `<div class="${cls}" data-date="${iso}">${d}</div>`;
            }
        }

        calGrid.innerHTML = cells;
    }

    function openCal() {
        renderCal();
        dateCal.classList.remove('hidden');
    }

    function closeCal() {
        dateCal.classList.add('hidden');
    }

    dateDisplay.addEventListener('click', function () {
        dateCal.classList.contains('hidden') ? openCal() : closeCal();
    });

    calGrid.addEventListener('click', function (e) {
        const day = e.target.closest('.cal-day');
        if (!day) return;
        const iso          = day.dataset.date;
        dateHidden.value   = iso;
        dateDisplay.value  = isoToDisplay(iso);
        closeCal();
    });

    calPrev.addEventListener('click', function () {
        if (this.disabled) return;
        if (--calMonth < 0) { calMonth = 11; calYear--; }
        renderCal();
    });

    calNext.addEventListener('click', function () {
        if (++calMonth > 11) { calMonth = 0; calYear++; }
        renderCal();
    });

    document.addEventListener('click', function (e) {
        if (!dateWrap.contains(e.target)) closeCal();
    });

    // Restore from old() on page load
    if (dateHidden.value) {
        const [y, m] = dateHidden.value.split('-');
        calYear  = parseInt(y);
        calMonth = parseInt(m) - 1;
    }

    // ── Time Slots ────────────────────────────────────────────────────────
    const timeInput = document.getElementById('bk_time');
    document.getElementById('time-slots').addEventListener('click', function (e) {
        const btn = e.target.closest('.time-slot');
        if (!btn) return;
        timeInput.value = btn.dataset.slot;
        this.querySelectorAll('.time-slot').forEach(b => {
            b.className = b.className
                .replace('border-custom-primary bg-custom-primary/15 text-custom-primary', '')
                .replace('border-white/10 text-white/50 hover:border-white/30 hover:text-white/80', '')
                .trim();
            b.classList.add('border-white/10', 'text-white/50', 'hover:border-white/30', 'hover:text-white/80');
        });
        btn.classList.remove('border-white/10', 'text-white/50', 'hover:border-white/30', 'hover:text-white/80');
        btn.classList.add('border-custom-primary', 'bg-custom-primary/15', 'text-custom-primary');
    });
})();
</script>
@endpush
