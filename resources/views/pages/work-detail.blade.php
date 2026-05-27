@php
    $pageTitle       = $case->title . ' | Premax Automotive Studio';
    $pageDescription = $case->brief ?? 'A Premax Automotive Studio case study in ' . $case->category_label . '.';
    $pageKeyWords    = strtolower($case->category_label) . ' nairobi, premax case study, ' . strtolower($case->service_type ?? '');
    $pageImage       = $case->after_image_url ?? null;
@endphp

@extends('layouts.default-menu-page')

@section('head-tags')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "CreativeWork",
  "name": "{{ addslashes($case->title) }}",
  "description": "{{ addslashes($case->brief ?? '') }}",
  "url": "{{ route('work.show', $case->slug) }}",
  @if($case->after_image_url)"image": "{{ $case->after_image_url }}",@endif
  "creator": {
    "@type": "AutoRepair",
    "name": "Premax Automotive Studio",
    "url": "{{ url('/') }}"
  }
}
</script>
@endsection

@section('content')

<div class="bg-[#111111]">

{{-- ── BREADCRUMB + HERO ── --}}
<section class="relative pt-36 pb-24 px-6 bg-[#0a0a0a] overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(211,30,36,0.05)_0%,transparent_60%)]"></div>

    <div class="relative max-w-7xl mx-auto">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] uppercase text-white/25 mb-10">
            <a href="{{ url('/') }}" class="hover:text-white/50 transition-colors no-underline">Home</a>
            <span>›</span>
            <a href="{{ url('/work') }}" class="hover:text-white/50 transition-colors no-underline">Our Work</a>
            <span>›</span>
            <span class="text-white/50">{{ $case->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">

            {{-- Left: headline --}}
            <div class="lg:col-span-2">
                <span class="inline-flex items-center px-3 py-1 border border-custom-primary/30 text-custom-primary
                             text-[10px] font-bold uppercase tracking-widest rounded-full mb-6">
                    {{ $case->category_label }}
                </span>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight tracking-tight">
                    {{ $case->title }}
                </h1>

                {{-- Meta row --}}
                <div class="flex flex-wrap items-center gap-6 py-6 border-y border-white/5">
                    @if($case->service_type)
                    <div>
                        <div class="text-[10px] text-white/25 uppercase tracking-widest mb-1">Service</div>
                        <div class="text-sm text-white font-medium">{{ $case->service_type }}</div>
                    </div>
                    @endif
                    @if($case->duration_days)
                    <div>
                        <div class="text-[10px] text-white/25 uppercase tracking-widest mb-1">Duration</div>
                        <div class="text-sm text-white font-medium">{{ $case->duration_days }} {{ Str::plural('day', $case->duration_days) }}</div>
                    </div>
                    @endif
                    @if($case->completed_at)
                    <div>
                        <div class="text-[10px] text-white/25 uppercase tracking-widest mb-1">Completed</div>
                        <div class="text-sm text-white font-medium">{{ $case->completed_at->format('F Y') }}</div>
                    </div>
                    @endif
                    @if($case->client_type)
                    <div>
                        <div class="text-[10px] text-white/25 uppercase tracking-widest mb-1">Client</div>
                        <div class="text-sm text-white font-medium">{{ $case->client_type }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right: project metrics sidebar --}}
            @if($case->metrics->isNotEmpty())
            <div class="lg:col-span-1">
                <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-8">
                    <div class="text-[10px] text-white/30 uppercase tracking-widest mb-6">Project Metrics</div>
                    <div class="space-y-5">
                        @foreach($case->metrics as $metric)
                        <div class="flex justify-between items-center py-3 border-b border-white/5 last:border-0">
                            <span class="text-xs text-white/40">{{ $metric->label }}</span>
                            <span class="text-sm font-bold text-white">{{ $metric->value }}</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ url('/booking') }}"
                       class="block w-full text-center mt-8 px-6 py-3.5 bg-custom-primary text-white font-semibold
                              text-sm rounded-md hover:bg-red-700 transition-all duration-200 no-underline
                              shadow-[0_4px_14px_rgba(211,30,36,0.30)]">
                        Commission Similar Work
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</section>


{{-- ── BEFORE / AFTER ── --}}
@if($case->before_image && $case->after_image)
<section class="py-20 px-6 border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-8 block">The Transformation</span>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden">
                <img src="{{ $case->before_image_url }}" alt="Before" class="w-full h-full object-cover">
                <div class="absolute bottom-4 left-4 px-3 py-1.5 bg-black/60 backdrop-blur-sm rounded-full
                            text-[10px] font-bold text-white/70 uppercase tracking-widest">Before</div>
            </div>
            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden">
                <img src="{{ $case->after_image_url }}" alt="After" class="w-full h-full object-cover">
                <div class="absolute bottom-4 left-4 px-3 py-1.5 bg-custom-primary/80 backdrop-blur-sm rounded-full
                            text-[10px] font-bold text-white uppercase tracking-widest">After</div>
            </div>
        </div>
    </div>
</section>
@endif


{{-- ── THE BRIEF ── --}}
@if($case->brief)
<section class="py-20 px-6 bg-[#0a0a0a] border-t border-white/5">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-12">
        <div>
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase block mb-2">01</span>
            <h2 class="text-xl font-bold text-white">The Brief</h2>
        </div>
        <div class="lg:col-span-3">
            <p class="text-white/60 text-lg leading-relaxed">{{ $case->brief }}</p>
        </div>
    </div>
</section>
@endif


{{-- ── THE CHALLENGE ── --}}
@if($case->challenge)
<section class="py-20 px-6 border-t border-white/5">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-12">
        <div>
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase block mb-2">02</span>
            <h2 class="text-xl font-bold text-white">The Challenge</h2>
        </div>
        <div class="lg:col-span-3">
            <p class="text-white/60 text-lg leading-relaxed">{{ $case->challenge }}</p>
        </div>
    </div>
</section>
@endif


{{-- ── OUR APPROACH (Steps) ── --}}
@if($case->steps->isNotEmpty())
<section class="py-20 px-6 bg-[#0a0a0a] border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-12">
            <div>
                <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase block mb-2">03</span>
                <h2 class="text-xl font-bold text-white">Our Approach</h2>
            </div>
        </div>
        <div class="flex flex-col max-w-3xl ml-auto lg:ml-0 lg:pl-[calc(25%+3rem)]">
            @foreach($case->steps as $step)
            <div class="flex gap-8 py-8 border-b border-white/5 last:border-0">
                <div class="w-10 h-10 rounded-full border border-custom-primary flex items-center justify-center shrink-0
                            text-custom-primary font-bold text-sm shadow-[0_0_16px_rgba(211,30,36,0.15)]">
                    {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white mb-2">{{ $step->title }}</h3>
                    @if($step->detail)
                    <p class="text-white/45 text-sm leading-relaxed">{{ $step->detail }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ── THE OUTCOME ── --}}
@if($case->outcome)
<section class="py-20 px-6 border-t border-white/5">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-12">
        <div>
            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase block mb-2">04</span>
            <h2 class="text-xl font-bold text-white">The Outcome</h2>
        </div>
        <div class="lg:col-span-3">
            <p class="text-white/60 text-lg leading-relaxed">{{ $case->outcome }}</p>
        </div>
    </div>
</section>
@endif


{{-- ── PROJECT GALLERY ── --}}
@if($case->gallery->isNotEmpty())
<section class="py-20 px-6 bg-[#0a0a0a] border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-8 block">Project Gallery</span>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($case->gallery as $item)
            <div class="aspect-[4/3] rounded-xl overflow-hidden">
                <img src="{{ $item->image_url }}"
                     alt="{{ $item->caption ?? $case->title }}"
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ── MORE CASE STUDIES ── --}}
@if($related->isNotEmpty())
<section class="py-20 px-6 border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">More Case Studies</span>
        <h2 class="text-2xl font-bold text-white mb-12">Further Reading.</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $rel)
            <a href="{{ route('work.show', $rel->slug) }}"
               class="group bg-[#1a1a1a] border border-white/5 rounded-2xl overflow-hidden
                      hover:border-white/12 transition-colors duration-300 no-underline block">
                <div class="aspect-[4/3] overflow-hidden bg-[#222]">
                    @if($rel->after_image_url)
                    <img src="{{ $rel->after_image_url }}" alt="{{ $rel->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <img src="{{ asset('assets/images/car.avif') }}" alt="{{ $rel->title }}"
                         class="w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-500">
                    @endif
                </div>
                <div class="p-6">
                    <div class="text-[10px] text-custom-primary uppercase tracking-widest font-bold mb-2">{{ $rel->category_label }}</div>
                    <h3 class="text-sm font-semibold text-white group-hover:text-white/80 transition-colors">{{ $rel->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ── CTA ── --}}
<section class="py-24 px-6 bg-[#0a0a0a] border-t border-white/5">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Ready to start your project?</h2>
        <p class="text-white/45 mb-10">Let our team deliver the same results for your vehicle.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/booking') }}"
               class="px-8 py-4 bg-custom-primary text-white font-semibold rounded-md hover:bg-red-700
                      transition-all duration-200 no-underline shadow-[0_4px_20px_rgba(211,30,36,0.4)]">
                Book a Consultation
            </a>
            <a href="{{ url('/work') }}"
               class="px-8 py-4 bg-transparent border border-white/15 text-white font-medium rounded-md
                      hover:bg-white/5 transition-all duration-200 no-underline">
                ← All Case Studies
            </a>
        </div>
    </div>
</section>

</div>

@endsection
