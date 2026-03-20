{{-- ══════════════════════════════════════
     TESTIMONIALS
     Component: <x-testimonials />
     Fetched from reviews table (approved + show_on_website).
     ≤3 reviews: standard 3-col grid.
     >3 reviews: horizontally scrollable carousel with drag support.
══════════════════════════════════════ --}}

@if($reviews->isNotEmpty())
<section class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Header --}}
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">What Our Customers Say</h2>
            <p class="mt-3 text-gray-500 text-sm">Don't just take our word for it. Here's what our clients have to say.</p>

            {{-- Review count badge --}}
            @if($reviews->count() > 0)
            <div class="mt-4 inline-flex items-center gap-1.5 bg-yellow-50 border border-yellow-200 rounded-full px-4 py-1.5">
                <div class="flex items-center gap-0.5">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-xs font-semibold text-yellow-700">
                    {{ number_format($reviews->avg('rating'), 1) }} · {{ $reviews->count() }} {{ Str::plural('review', $reviews->count()) }}
                </span>
            </div>
            @endif
        </div>

        @if($reviews->count() <= 3)
        {{-- ── GRID (3 or fewer) ── --}}
        <div class="grid grid-cols-1 md:grid-cols-{{ $reviews->count() }} gap-6">
            @foreach($reviews as $review)
                @include('components.review-card', ['review' => $review])
            @endforeach
        </div>

        @else
        {{-- ── SCROLLABLE CAROUSEL (more than 3) ── --}}
        <div class="relative">

            {{-- Fade edges --}}
            <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-12 bg-gradient-to-r from-gray-50 to-transparent z-10 hidden md:block"></div>
            <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-gray-50 to-transparent z-10 hidden md:block"></div>

            {{-- Scroll track --}}
            <div id="testimonials-track"
                 class="flex gap-5 overflow-x-auto pb-4 scroll-smooth snap-x snap-mandatory
                        [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden
                        cursor-grab active:cursor-grabbing select-none">

                @foreach($reviews as $review)
                <div class="snap-start shrink-0 w-[85vw] sm:w-[340px] md:w-[320px] lg:w-[360px]">
                    @include('components.review-card', ['review' => $review])
                </div>
                @endforeach

            </div>

            {{-- Dot indicators --}}
            <div class="flex justify-center gap-2 mt-6" id="testimonials-dots">
                @foreach($reviews->chunk(1) as $i => $chunk)
                <button type="button"
                        class="testimonial-dot w-2 h-2 rounded-full transition-all duration-300
                               {{ $i === 0 ? 'bg-custom-primary w-5' : 'bg-gray-300' }}"
                        data-index="{{ $i }}"
                        aria-label="Go to review {{ $i + 1 }}">
                </button>
                @endforeach
            </div>

        </div>
        @endif

    </div>
</section>

{{-- Drag-scroll + dot sync JS --}}
@if($reviews->count() > 3)
@push('scripts-stack')
<script>
(function () {
    const track = document.getElementById('testimonials-track');
    const dots  = document.querySelectorAll('.testimonial-dot');
    if (!track) return;

    // ── Drag to scroll ──────────────────────────────────
    let isDown = false, startX = 0, scrollLeft = 0;

    track.addEventListener('mousedown', e => {
        isDown     = true;
        startX     = e.pageX - track.offsetLeft;
        scrollLeft = track.scrollLeft;
    });
    track.addEventListener('mouseleave', () => isDown = false);
    track.addEventListener('mouseup',    () => isDown = false);
    track.addEventListener('mousemove',  e => {
        if (!isDown) return;
        e.preventDefault();
        const x    = e.pageX - track.offsetLeft;
        const walk = (x - startX) * 1.5;
        track.scrollLeft = scrollLeft - walk;
    });

    // Touch scroll already works natively — no extra code needed.

    // ── Dot sync ────────────────────────────────────────
    function updateDots(activeIndex) {
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-custom-primary', i === activeIndex);
            dot.classList.toggle('w-5',               i === activeIndex);
            dot.classList.toggle('bg-gray-300',       i !== activeIndex);
            dot.classList.toggle('w-2',               i !== activeIndex);
        });
    }

    // Click dot → scroll to card
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            const cards    = track.querySelectorAll(':scope > div');
            const card     = cards[i];
            if (!card) return;
            track.scrollTo({ left: card.offsetLeft - track.offsetLeft, behavior: 'smooth' });
        });
    });

    // Scroll → update active dot
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const cards = Array.from(track.querySelectorAll(':scope > div'));
            const index = cards.indexOf(entry.target);
            if (index !== -1) updateDots(index);
        });
    }, { root: track, threshold: 0.6 });

    track.querySelectorAll(':scope > div').forEach(card => observer.observe(card));
})();
</script>
@endpush
@endif

@endif {{-- reviews not empty --}}