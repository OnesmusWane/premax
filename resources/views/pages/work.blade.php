@php
    $pageTitle       = 'Our Work | Premax Automotive Studio';
    $pageDescription = 'Explore Premax Automotive Studio case studies — detailing, performance builds, bodywork and diagnostics on luxury vehicles in Nairobi.';
    $pageKeyWords    = 'car detailing nairobi, luxury car restoration nairobi, premax work, case studies';

    $categoryLabels = [
        'all'         => 'All',
        'detailing'   => 'Detailing',
        'performance' => 'Performance',
        'bodywork'    => 'Bodywork',
        'diagnostics' => 'Diagnostics',
    ];
@endphp

@extends('layouts.default-menu-page')

@section('head-tags')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Premax Automotive Studio — Our Work",
  "url": "{{ route('work.index') }}",
  "itemListElement": [
    @foreach($cases as $i => $c)
    {
      "@type": "ListItem",
      "position": {{ $i + 1 }},
      "name": "{{ addslashes($c->title) }}",
      "url": "{{ route('work.show', $c->slug) }}"
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endsection
@section('content')

<div class="bg-[#111111]">

{{-- ── HERO ── --}}
<section class="relative pt-40 pb-24 px-6 overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('assets/images/hero/work.webp') }}" alt="Premax Automotive Studio work"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/65"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#111111] via-[#111111]/30 to-transparent"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(211,30,36,0.07)_0%,transparent_60%)]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto">

        <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
            Portfolio
        </span>
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight tracking-tight max-w-3xl">
            The Work Speaks<br>for Itself.
        </h1>
        <p class="text-white/55 text-lg leading-relaxed max-w-xl mb-16">
            A curated selection of case studies from the studio — each representing
            the depth of our craft and commitment to perfection.
        </p>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-white/5 pt-12">
            @foreach([['1,200+', 'Vehicles Serviced'], ['480', 'Detailing Projects'], ['95%', 'Repeat Clients'], ['10', 'Years in Business']] as [$val, $lbl])
            <div>
                <div class="text-3xl md:text-4xl font-bold text-white mb-1">{{ $val }}</div>
                <div class="text-xs text-white/30 uppercase tracking-widest">{{ $lbl }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ── BEFORE / AFTER ── --}}
@php
    $baCases = $cases->filter(fn($c) => $c->before_image && $c->after_image)->take(2)->values();
@endphp
@if($baCases->isNotEmpty())
<section class="py-24 px-6 border-t border-white/5">
    <div class="max-w-7xl mx-auto">

        <div class="max-w-2xl mb-16">
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                Before · After
            </span>
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-5 leading-tight">
                The Difference, Made Visible.
            </h2>
            <p class="text-white/50 text-lg">Drag the slider to reveal the transformation.</p>
        </div>

        <div class="space-y-24">
            @foreach($baCases as $baCase)
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-12 items-center">

                {{-- Drag slider --}}
                <div>
                    <div class="relative rounded-2xl overflow-hidden aspect-[4/3] select-none bg-[#0a0a0a]"
                         data-ba-container>

                        {{-- Before layer --}}
                        <div class="absolute inset-0">
                            <img src="{{ $baCase->before_image_url }}" alt="Before"
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-4 left-4 px-3 py-1.5 bg-black/60 backdrop-blur-sm rounded-full
                                        text-[10px] font-bold text-white/70 uppercase tracking-widest">Before</div>
                        </div>

                        {{-- After layer (clipped) --}}
                        <div class="absolute inset-0 overflow-hidden" data-ba-after
                             style="clip-path: inset(0 50% 0 0)">
                            <img src="{{ $baCase->after_image_url }}" alt="After"
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-4 right-4 px-3 py-1.5 bg-custom-primary/85 backdrop-blur-sm rounded-full
                                        text-[10px] font-bold text-white uppercase tracking-widest">After</div>
                        </div>

                        {{-- Divider line --}}
                        <div class="absolute top-0 bottom-0 w-0.5 bg-white/70 shadow-[0_0_8px_rgba(255,255,255,0.5)]"
                             data-ba-line style="left:50%"></div>

                        {{-- Handle --}}
                        <div class="absolute top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white shadow-xl
                                    flex items-center justify-center cursor-ew-resize z-10"
                             data-ba-handle style="left:calc(50% - 18px)">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-white/25 text-xs mt-3 text-center italic">Drag horizontally to compare</p>
                </div>

                {{-- Info panel --}}
                <div>
                    <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
                        Case {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-4 leading-tight">
                        {{ $baCase->title }}
                    </h3>
                    @if($baCase->brief)
                    <p class="text-white/55 leading-relaxed mb-8">{{ Str::limit($baCase->brief, 200) }}</p>
                    @endif

                    @if($baCase->metrics->isNotEmpty())
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/10">
                        @foreach($baCase->metrics->take(3) as $metric)
                        <div>
                            <div class="text-2xl font-bold text-white">{{ $metric->value }}</div>
                            <div class="text-[10px] uppercase tracking-widest text-white/30 mt-1">{{ $metric->label }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>
@endif


{{-- ── CASE STUDIES ── --}}
<section class="py-20 px-6 bg-[#0a0a0a] border-t border-white/5">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
            <div>
                <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">Archive</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Case Studies.</h2>
            </div>

            {{-- Filter pills --}}
            <div class="flex items-center gap-2 flex-wrap">
                @foreach($categoryLabels as $key => $label)
                <button type="button"
                        class="work-filter shrink-0 px-4 py-2 rounded-full text-xs font-bold tracking-wider uppercase
                               transition-all duration-200 {{ $key === 'all' ? 'bg-custom-primary text-white border border-custom-primary' : 'bg-transparent text-white/40 border border-white/10 hover:text-white hover:border-white/30' }}"
                        data-filter="{{ $key }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>
        </div>

        @if($cases->isEmpty())
        <div class="text-center py-24 border border-white/5 rounded-2xl">
            <p class="text-white/20 text-sm mb-2">Case studies coming soon.</p>
            <p class="text-white/15 text-xs">We're documenting our latest projects.</p>
        </div>
        @else
        <div id="cases-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cases as $case)
            <a href="{{ route('work.show', $case->slug) }}"
               class="case-card group block bg-[#1a1a1a] border border-white/5 rounded-2xl overflow-hidden
                      hover:border-white/12 transition-colors duration-300 no-underline"
               data-category="{{ $case->category }}">

                {{-- Image --}}
                <div class="aspect-[4/3] relative overflow-hidden bg-[#222]">
                    @if($case->after_image_url)
                    <img src="{{ $case->after_image_url }}" alt="{{ $case->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @elseif($case->before_image_url)
                    <img src="{{ $case->before_image_url }}" alt="{{ $case->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <img src="{{ asset('assets/images/car.avif') }}" alt="{{ $case->title }}"
                             class="w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-500">
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a]/60 to-transparent"></div>

                    @if($case->is_featured)
                    <div class="absolute top-3 left-3 px-2.5 py-1 bg-custom-primary/90 rounded text-[10px] font-bold text-white uppercase tracking-widest">
                        Featured
                    </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-6">
                    <div class="text-[10px] text-custom-primary uppercase tracking-widest font-bold mb-2">
                        {{ $case->category_label }}
                    </div>
                    <h3 class="text-base font-semibold text-white mb-2 group-hover:text-white/90 transition-colors leading-snug">
                        {{ $case->title }}
                    </h3>
                    @if($case->brief)
                    <p class="text-xs text-white/40 leading-relaxed mb-4">
                        {{ Str::limit($case->brief, 90) }}
                    </p>
                    @endif

                    <div class="flex items-center gap-4 text-[10px] text-white/25 uppercase tracking-widest">
                        @if($case->service_type)
                        <span>{{ $case->service_type }}</span>
                        @endif
                        @if($case->completed_at)
                        <span>{{ $case->completed_at->format('M Y') }}</span>
                        @endif
                    </div>
                </div>

            </a>
            @endforeach
        </div>

        <div id="no-cases" class="hidden text-center py-24">
            <p class="text-white/25 text-sm">No case studies in this category yet.</p>
        </div>
        @endif

    </div>
</section>


{{-- ── CTA ── --}}
<section class="py-24 px-6 border-t border-white/5">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Commission Similar Work.
        </h2>
        <p class="text-white/50 text-lg mb-10 leading-relaxed">
            Ready to transform your vehicle? Our team is prepared to deliver
            the same level of excellence shown in our portfolio.
        </p>
        <a href="{{ url('/booking') }}"
           class="inline-flex items-center gap-2 px-10 py-4 bg-custom-primary text-white font-semibold
                  rounded-md hover:bg-red-700 transition-all duration-200 no-underline
                  shadow-[0_4px_20px_rgba(211,30,36,0.4)] hover:scale-[1.02]">
            Book a Consultation
        </a>
    </div>
</section>

</div>

@push('scripts-stack')
<script>
(function () {
    // Before/After drag sliders — works for any number of [data-ba-container] on the page
    document.querySelectorAll('[data-ba-container]').forEach(container => {
        const after  = container.querySelector('[data-ba-after]');
        const line   = container.querySelector('[data-ba-line]');
        const handle = container.querySelector('[data-ba-handle]');
        if (!after || !line || !handle) return;

        let dragging = false;

        function setPos(x) {
            const rect = container.getBoundingClientRect();
            const pct  = Math.max(5, Math.min(95, ((x - rect.left) / rect.width) * 100));
            after.style.clipPath = `inset(0 ${100 - pct}% 0 0)`;
            line.style.left      = pct + '%';
            handle.style.left    = `calc(${pct}% - 18px)`;
        }

        handle.addEventListener('mousedown',  () => dragging = true);
        handle.addEventListener('touchstart', () => dragging = true, { passive: true });
        window.addEventListener('mouseup',    () => dragging = false);
        window.addEventListener('touchend',   () => dragging = false);
        window.addEventListener('mousemove',  e => { if (dragging) setPos(e.clientX); });
        window.addEventListener('touchmove',  e => { if (dragging) setPos(e.touches[0].clientX); }, { passive: true });
    });

    // Case study filter
    const filters = document.querySelectorAll('.work-filter');
    const cases   = document.querySelectorAll('.case-card');
    const noCases = document.getElementById('no-cases');

    filters.forEach(btn => {
        btn.addEventListener('click', () => {
            const f = btn.dataset.filter;
            filters.forEach(b => {
                const on = b === btn;
                b.classList.toggle('bg-custom-primary',    on);
                b.classList.toggle('text-white',           on);
                b.classList.toggle('border-custom-primary', on);
                b.classList.toggle('bg-transparent',       !on);
                b.classList.toggle('text-white/40',        !on);
                b.classList.toggle('border-white/10',      !on);
            });
            let vis = 0;
            cases.forEach(c => {
                const show = f === 'all' || c.dataset.category === f;
                c.style.display = show ? '' : 'none';
                if (show) vis++;
            });
            if (noCases) noCases.classList.toggle('hidden', vis > 0);
        });
    });
})();
</script>
@endpush

@endsection
