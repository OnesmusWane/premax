@php
    $pageTitle       = $page->title . ' | Premax';
    $pageDescription = $page->description ?? $page->title;
    $pageKeyWords    = '';
    $isTerms         = $page->type === \App\Models\LegalPage::TYPE_TERMS;
    $breadcrumbLabel = $isTerms ? 'Terms' : 'Privacy';
    $sections        = $page->sections ?? [];
@endphp

@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] text-white">

    {{-- ── Hero ──────────────────────────────────────────────────────────── --}}
    <section class="relative pt-40 pb-28 px-6 bg-[#0a0a0a] overflow-hidden">
        <div class="absolute inset-0">
            <x-responsive-image path="assets/images/hero/about.webp" alt=""
                 class="w-full h-full object-cover object-center" :priority="true" />
            <div class="absolute inset-0 bg-[#0a0a0a]/80"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(211,30,36,0.07)_0%,transparent_60%)]"></div>
        </div>
        <div class="relative max-w-7xl mx-auto">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-[11px] uppercase tracking-widest text-white/30 mb-8">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a>
                <svg class="w-3 h-3 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-white/50">{{ $breadcrumbLabel }}</span>
            </nav>

            <span class="text-custom-primary text-xs font-bold tracking-[0.25em] uppercase mb-4 block">
                Legal
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight tracking-tight max-w-3xl">
                {{ $page->title }}
            </h1>
            @if($page->description)
            <p class="text-white/50 text-lg leading-relaxed max-w-xl">
                {{ $page->description }}
            </p>
            @endif
        </div>
    </section>

    {{-- ── Content ─────────────────────────────────────────────────────────── --}}
    <section class="py-24 md:py-32 px-6">
        <div class="max-w-3xl mx-auto">

            @if($page->effective_date)
            <p class="text-[11px] uppercase tracking-widest text-white/25 mb-14">
                Effective Date · {{ $page->effective_date->format('d F Y') }}
            </p>
            @endif

            @if(!empty($sections))
            {{-- Structured sections from DB ──────────────────────────────── --}}
            <div class="divide-y divide-white/5 mt-6">
                @foreach($sections as $section)
                <div class="py-10 first:pt-0 last:pb-0 mt-4">
                    <h2 class="font-bold text-white text-xl md:text-2xl mb-4 leading-snug">
                        {{ $section['title'] }}
                    </h2>
                    <p class="text-white/55 text-base leading-loose max-w-2xl">
                        {{ $section['body'] }}
                    </p>
                </div>
                @endforeach
            </div>

            @else
            {{-- Fallback: render legacy HTML content ─────────────────────── --}}
            <div class="prose prose-invert max-w-none
                        prose-headings:font-semibold prose-headings:text-white
                        prose-h2:text-xl prose-h3:text-base
                        prose-p:text-white/60 prose-p:leading-relaxed
                        prose-li:text-white/60
                        prose-a:text-custom-primary prose-a:no-underline hover:prose-a:underline
                        prose-strong:text-white/90">
                {!! $page->content !!}
            </div>
            @endif

            {{-- Contact nudge ─────────────────────────────────────────────── --}}
            <div class="mt-16 pt-10 border-t border-white/8 flex items-center gap-4">
                <p class="text-white/35 text-sm">Have a question about this policy?</p>
                <a href="{{ route('contact.index') }}"
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-custom-primary
                          hover:text-red-400 transition-colors">
                    Contact us
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

        </div>
    </section>

</div>

@endsection
