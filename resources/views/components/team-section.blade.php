{{-- ── MEET THE TEAM ──
     Fetched from staff_members table.
     ≤ 3 members → standard 3-col grid.
     > 3 members → drag-scrollable horizontal carousel with dot indicators.
--}}

@php
    $team = \Illuminate\Support\Facades\Cache::remember('staff.website', now()->addHours(2), function () {
        return \App\Models\StaffMember::visible()->get();
    });
@endphp

@if($team->isNotEmpty())
<section class="py-24 px-6 border-t border-white/5 bg-[#111111]">
    <div class="max-w-7xl mx-auto">

        <div class="mb-16">
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                The Team
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">Master Craftsmen.</h2>
            <p class="text-white/40 text-sm">Decades of factory training, distilled into one studio.</p>
        </div>

        @if($team->count() <= 3)
        {{-- ── GRID ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($team as $member)
                @include('components.staff-card', ['member' => $member])
            @endforeach
        </div>

        @else
        {{-- ── SCROLLABLE CAROUSEL ── --}}
        <div class="relative">

            {{-- Fade edge hints --}}
            <div class="pointer-events-none absolute left-0 top-0 bottom-6 w-16 bg-gradient-to-r from-[#111111] to-transparent z-10 hidden md:block"></div>
            <div class="pointer-events-none absolute right-0 top-0 bottom-6 w-16 bg-gradient-to-l from-[#111111] to-transparent z-10 hidden md:block"></div>

            {{-- Scroll track --}}
            <div id="team-track"
                 class="flex gap-5 overflow-x-auto pb-4 scroll-smooth snap-x snap-mandatory
                        [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden
                        cursor-grab active:cursor-grabbing select-none">

                @foreach($team as $member)
                <div class="snap-start shrink-0 w-[75vw] sm:w-[260px] md:w-[280px]">
                    @include('components.staff-card', ['member' => $member])
                </div>
                @endforeach

            </div>

            {{-- Dot indicators --}}
            <div class="flex justify-center gap-2 mt-6" id="team-dots">
                @foreach($team as $i => $member)
                <button type="button"
                        class="team-dot h-1.5 rounded-full transition-all duration-300
                               {{ $i === 0 ? 'bg-custom-primary w-6' : 'bg-white/20 w-1.5' }}"
                        data-index="{{ $i }}"
                        aria-label="Go to {{ $member->name }}">
                </button>
                @endforeach
            </div>

        </div>
        @endif

    </div>
</section>

@if($team->count() > 3)
@push('scripts-stack')
<script>
(function () {
    const track = document.getElementById('team-track');
    const dots  = document.querySelectorAll('.team-dot');
    if (!track) return;

    let isDown = false, startX = 0, scrollLeft = 0;

    track.addEventListener('mousedown', e => {
        isDown = true;
        startX = e.pageX - track.offsetLeft;
        scrollLeft = track.scrollLeft;
    });
    ['mouseleave', 'mouseup'].forEach(ev => track.addEventListener(ev, () => isDown = false));
    track.addEventListener('mousemove', e => {
        if (!isDown) return;
        e.preventDefault();
        track.scrollLeft = scrollLeft - (e.pageX - track.offsetLeft - startX) * 1.5;
    });

    function setActiveDot(index) {
        dots.forEach((dot, i) => {
            const active = i === index;
            dot.classList.toggle('bg-custom-primary', active);
            dot.classList.toggle('w-6',               active);
            dot.classList.toggle('bg-white/20',       !active);
            dot.classList.toggle('w-1.5',             !active);
        });
    }

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            const cards = track.querySelectorAll(':scope > div');
            const card  = cards[i];
            if (card) track.scrollTo({ left: card.offsetLeft - track.offsetLeft, behavior: 'smooth' });
        });
    });

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const cards = Array.from(track.querySelectorAll(':scope > div'));
            const index = cards.indexOf(entry.target);
            if (index !== -1) setActiveDot(index);
        });
    }, { root: track, threshold: 0.6 });

    track.querySelectorAll(':scope > div').forEach(card => observer.observe(card));
})();
</script>
@endpush
@endif

@endif
