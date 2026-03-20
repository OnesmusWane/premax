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
<section class="bg-white py-20">
    <div class="max-w-5xl mx-auto px-6">

        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Meet Our Team</h2>
            <p class="mt-2 text-gray-500 text-sm">The skilled hands behind every clean, every fix, every satisfied customer.</p>
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
            <div class="pointer-events-none absolute left-0 top-0 bottom-6 w-10 bg-gradient-to-r from-white to-transparent z-10 hidden md:block"></div>
            <div class="pointer-events-none absolute right-0 top-0 bottom-6 w-10 bg-gradient-to-l from-white to-transparent z-10 hidden md:block"></div>

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
            <div class="flex justify-center gap-2 mt-4" id="team-dots">
                @foreach($team as $i => $member)
                <button type="button"
                        class="team-dot w-2 h-2 rounded-full transition-all duration-300
                               {{ $i === 0 ? 'bg-custom-primary w-5' : 'bg-gray-300' }}"
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

    // ── Drag to scroll ──────────────────────────────────
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

    // ── Dot sync ────────────────────────────────────────
    function setActiveDot(index) {
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-custom-primary', i === index);
            dot.classList.toggle('w-5',               i === index);
            dot.classList.toggle('bg-gray-300',       i !== index);
            dot.classList.toggle('w-2',               i !== index);
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