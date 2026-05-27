{{-- ═══════════════════════════════════════════
     TESTIMONIALS — Dark section
     Component: <x-testimonials />
     Data: approved reviews, featured first (cached 2h)
     ≤3 reviews → grid  |  >3 → drag-scroll carousel
═══════════════════════════════════════════ --}}

@if($reviews->isNotEmpty())
<section class="py-24 md:py-36 px-6 bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="text-center max-w-xl mx-auto mb-16">
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                Client Stories
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-white tracking-tight">
                What Our Clients Say.
            </h2>

            @if($reviews->count() > 0)
            <div class="mt-6 inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5">
                <div class="flex items-center gap-0.5">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-xs font-semibold text-white/50">
                    {{ number_format($reviews->avg('rating'), 1) }} &middot; {{ $reviews->count() }} {{ Str::plural('review', $reviews->count()) }}
                </span>
            </div>
            @endif
        </div>

        @if($reviews->count() <= 3)
        {{-- Grid (3 or fewer) --}}
        <div class="grid grid-cols-1 md:grid-cols-{{ $reviews->count() }} gap-6">
            @foreach($reviews as $review)
                @include('components.review-card', ['review' => $review])
            @endforeach
        </div>

        @else
        {{-- Drag-scroll carousel --}}
        <div class="relative">
            <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-[#0a0a0a] to-transparent z-10 hidden md:block"></div>
            <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#0a0a0a] to-transparent z-10 hidden md:block"></div>

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
            <div class="flex justify-center gap-2 mt-8" id="testimonials-dots">
                @foreach($reviews->chunk(1) as $i => $chunk)
                <button type="button"
                        class="testimonial-dot rounded-full transition-all duration-300
                               {{ $i === 0 ? 'bg-custom-primary w-5 h-2' : 'bg-white/20 w-2 h-2' }}"
                        data-index="{{ $i }}"
                        aria-label="Go to review {{ $i + 1 }}">
                </button>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@if($reviews->count() > 3)
@push('scripts-stack')
<script>
(function () {
    const track = document.getElementById('testimonials-track');
    const dots  = document.querySelectorAll('.testimonial-dot');
    if (!track) return;

    let isDown = false, startX = 0, scrollLeft = 0;
    track.addEventListener('mousedown', e => { isDown = true; startX = e.pageX - track.offsetLeft; scrollLeft = track.scrollLeft; });
    track.addEventListener('mouseleave', () => isDown = false);
    track.addEventListener('mouseup',    () => isDown = false);
    track.addEventListener('mousemove',  e => {
        if (!isDown) return;
        e.preventDefault();
        track.scrollLeft = scrollLeft - (e.pageX - track.offsetLeft - startX) * 1.5;
    });

    function updateDots(idx) {
        dots.forEach((d, i) => {
            d.classList.toggle('bg-custom-primary', i === idx);
            d.classList.toggle('w-5',               i === idx);
            d.classList.toggle('bg-white/20',       i !== idx);
            d.classList.toggle('w-2',               i !== idx);
        });
    }

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            const card = track.querySelectorAll(':scope > div')[i];
            if (card) track.scrollTo({ left: card.offsetLeft - track.offsetLeft, behavior: 'smooth' });
        });
    });

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const idx = Array.from(track.querySelectorAll(':scope > div')).indexOf(entry.target);
            if (idx !== -1) updateDots(idx);
        });
    }, { root: track, threshold: 0.6 });

    track.querySelectorAll(':scope > div').forEach(card => observer.observe(card));
})();
</script>
@endpush
@endif

@endif {{-- reviews not empty --}}
