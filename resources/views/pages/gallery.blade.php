@extends('layouts.default-menu-page')

@section('content')
@php
    $featuredItems = $allItems->take(min(5, $allItems->count()));
@endphp

<style>
    .gallery-page {
        background:
            radial-gradient(circle at top, rgba(211, 30, 36, 0.08), transparent 32%),
            linear-gradient(180deg, #ffffff 0%, #f7f7f8 100%);
    }

    .gallery-hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transform: scale(1.06);
        transition: opacity 0.8s ease, transform 1s ease;
        pointer-events: none;
    }

    .gallery-hero-slide.active {
        opacity: 1;
        transform: scale(1);
        pointer-events: auto;
    }

    .gallery-hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-thumb.active {
        border-color: #D31E24;
        box-shadow: 0 12px 28px rgba(211, 30, 36, 0.28);
        transform: translateY(-2px) scale(1.04);
        opacity: 1;
    }

    .gallery-filter.active {
        background: #D31E24;
        color: #fff;
        border-color: #D31E24;
        box-shadow: 0 12px 28px rgba(211, 30, 36, 0.18);
    }

    .gallery-card {
        transition: transform 0.35s ease, box-shadow 0.35s ease, opacity 0.35s ease;
    }

    .gallery-card.hidden-item {
        display: none;
    }

    .gallery-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 44px rgba(15, 23, 42, 0.16);
    }

    .gallery-card-image {
        transition: transform 0.55s ease;
    }

    .gallery-card:hover .gallery-card-image {
        transform: scale(1.1);
    }

    .gallery-card-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
        background: linear-gradient(180deg, rgba(8, 8, 8, 0.10) 0%, rgba(8, 8, 8, 0.92) 100%);
    }

    .gallery-card:hover .gallery-card-overlay,
    .gallery-card:focus-within .gallery-card-overlay {
        opacity: 1;
    }

    .gallery-line-clamp {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

    .gallery-lightbox {
        position: fixed;
        inset: 0;
        z-index: 100;
        background: rgba(0, 0, 0, 0.96);
        backdrop-filter: blur(10px);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.24s ease, visibility 0.24s ease;
    }

    .gallery-lightbox.open {
        opacity: 1;
        visibility: visible;
    }

    .gallery-lightbox-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 18px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.45);
        transition: opacity 0.22s ease, transform 0.22s ease;
    }

    .gallery-lightbox-image.is-loading {
        opacity: 0;
        transform: translateX(24px);
    }

    .gallery-lightbox-thumb.active {
        border-color: #D31E24;
        opacity: 1;
        transform: scale(1.05);
    }

    .gallery-hero-nav,
    .gallery-lightbox-nav {
        backdrop-filter: blur(8px);
    }

    @media (max-width: 767px) {
        .gallery-hero-thumbs {
            overflow-x: auto;
            padding-bottom: 0.25rem;
            scrollbar-width: none;
        }

        .gallery-hero-thumbs::-webkit-scrollbar {
            display: none;
        }
    }
</style>

<div class="gallery-page">
    @if($allItems->isEmpty())
        <section class="min-h-[60vh] flex items-center justify-center px-6 py-20">
            <div class="text-center max-w-lg">
                <div class="w-18 h-18 mx-auto mb-5 rounded-full bg-red-50 text-custom-primary flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Gallery</h1>
                <p class="mt-4 text-gray-500 leading-relaxed">No gallery images have been published yet. Check back soon for our latest work.</p>
            </div>
        </section>
    @else
        <section class="relative overflow-hidden bg-[#090909]">
            <div class="relative h-[70vh] min-h-[500px] max-h-[820px]">
                @foreach($featuredItems as $item)
                    <div class="gallery-hero-slide {{ $loop->first ? 'active' : '' }}"
                         data-hero-slide
                         data-hero-index="{{ $loop->index }}">
                        <img src="{{ $item->image_url }}"
                             alt="{{ $item->alt_text ?? $item->title ?? 'Premax Autocare gallery' }}"
                             loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/38 to-black/18"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/45 to-transparent"></div>
                    </div>
                @endforeach

                <div class="absolute inset-0 z-10 flex items-end">
                    <div class="max-w-7xl mx-auto w-full px-6 pb-10 md:pb-12">
                        <div class="max-w-2xl">
                            <div class="inline-flex items-center gap-2 rounded-full border border-red-400/30 bg-red-500/15 px-4 py-1.5 text-sm font-semibold uppercase tracking-[0.14em] text-red-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2-2h6l2 2h4v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/>
                                    <circle cx="12" cy="13" r="3"/>
                                </svg>
                                Our Work
                            </div>
                            <h1 class="mt-5 text-5xl md:text-7xl font-extrabold tracking-tight text-white">Gallery</h1>
                            <p class="mt-4 max-w-xl text-lg md:text-xl leading-relaxed text-gray-200">
                                See the quality of our craftsmanship. Every vehicle that leaves Premax is a testament to our commitment to excellence.
                            </p>
                        </div>

                        @if($featuredItems->count() > 1)
                            <div class="gallery-hero-thumbs mt-8 flex gap-3">
                                @foreach($featuredItems as $item)
                                    <button type="button"
                                            class="gallery-thumb {{ $loop->first ? 'active' : '' }} relative h-16 w-24 shrink-0 overflow-hidden rounded-xl border-2 border-white/25 bg-white/5 opacity-70 transition-all duration-300"
                                            data-hero-thumb
                                            data-hero-target="{{ $loop->index }}"
                                            aria-label="Show featured image {{ $loop->iteration }}">
                                        <img src="{{ $item->image_url }}"
                                             alt="{{ $item->alt_text ?? $item->title ?? 'Featured gallery image' }}"
                                             class="h-full w-full object-cover">
                                        <div class="absolute inset-0 bg-black/20"></div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                @if($featuredItems->count() > 1)
                    <button type="button"
                            class="gallery-hero-nav absolute left-4 top-1/2 z-20 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-black/35 text-white transition-colors hover:bg-custom-primary"
                            data-hero-prev
                            aria-label="Previous featured image">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button"
                            class="gallery-hero-nav absolute right-4 top-1/2 z-20 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-black/35 text-white transition-colors hover:bg-custom-primary"
                            data-hero-next
                            aria-label="Next featured image">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @endif
            </div>
        </section>

        <section class="py-16 md:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.18em] text-custom-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/>
                        </svg>
                        Browse By Category
                    </div>
                    <h2 class="mt-3 text-4xl md:text-5xl font-extrabold tracking-tight text-gray-950">Explore Our Work</h2>
                </div>

                <div class="mt-10 flex flex-wrap justify-center gap-3" id="gallery-filters">
                    @foreach($categories as $cat)
                        @php
                            $count = $cat === 'All' ? $allItems->count() : ($grouped[$cat]?->count() ?? 0);
                        @endphp
                        <button type="button"
                                class="gallery-filter {{ $loop->first ? 'active' : '' }} rounded-full border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition-all duration-300 hover:border-gray-300 hover:bg-gray-50"
                                data-filter="{{ $cat }}">
                            {{ $cat }}
                            <span class="ml-1.5 text-xs {{ $loop->first ? 'text-white/75' : 'text-gray-400' }}">({{ $count }})</span>
                        </button>
                    @endforeach
                </div>

                <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3" id="gallery-grid">
                    @foreach($allItems as $item)
                        <article class="gallery-card group relative aspect-[4/3] overflow-hidden rounded-[1.6rem] bg-gray-200 shadow-[0_18px_40px_rgba(15,23,42,0.08)]"
                                 data-gallery-item
                                 data-src="{{ $item->image_url }}"
                                 data-title="{{ $item->title ?? $item->service?->name ?? 'Premax Autocare' }}"
                                 data-desc="{{ $item->description ?? '' }}"
                                 data-category="{{ $item->service?->name ?? 'Uncategorised' }}"
                                 role="button"
                                 tabindex="0"
                                 aria-label="View {{ $item->title ?? 'gallery image' }}">
                            <img src="{{ $item->image_url }}"
                                 alt="{{ $item->alt_text ?? $item->title ?? 'Premax Autocare gallery' }}"
                                 loading="lazy"
                                 decoding="async"
                                 class="gallery-card-image h-full w-full object-cover"
                                 onerror="this.closest('[data-gallery-item]')?.remove()">

                            <div class="absolute left-4 top-4 z-10 rounded-full bg-black/70 px-3 py-1 text-xs font-bold text-white backdrop-blur-sm transition-opacity duration-300 group-hover:opacity-0">
                                {{ $item->service?->name ?? 'Uncategorised' }}
                            </div>

                            <div class="gallery-card-overlay absolute inset-0 flex flex-col justify-end p-6 text-left">
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-custom-primary">
                                    {{ $item->service?->name ?? 'Uncategorised' }}
                                </p>
                                <h3 class="mt-2 text-2xl font-extrabold leading-tight text-white">
                                    {{ $item->title ?? $item->service?->name ?? 'Premax Autocare' }}
                                </h3>
                                <p class="gallery-line-clamp mt-2 text-sm leading-relaxed text-gray-200">
                                    {{ $item->description ?? 'Real work completed by the Premax Autocare team.' }}
                                </p>
                                <div class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-white/80">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="11" cy="11" r="7"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 8v6M8 11h6"/>
                                    </svg>
                                    Click to enlarge
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div id="gallery-empty" class="hidden py-20 text-center text-gray-400">
                    <svg class="mx-auto mb-4 h-16 w-16 opacity-30" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2-2h6l2 2h4v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/>
                        <circle cx="12" cy="13" r="3"/>
                    </svg>
                    <p class="text-lg font-medium">No images in this category yet.</p>
                </div>

                <div class="mt-10 text-center text-sm text-gray-500">
                    Showing <span id="gallery-visible-count">{{ $allItems->count() }}</span> of {{ $allItems->count() }} images
                </div>
            </div>
        </section>

        <section class="bg-custom-primary py-14 text-center px-6">
            <div class="max-w-xl mx-auto flex flex-col items-center gap-4">
                <h2 class="text-2xl md:text-3xl font-extrabold text-white">Want results like these?</h2>
                <p class="text-red-200 text-sm">Book your vehicle in today and let our team work their magic.</p>
                <a href="{{ url('/booking') }}"
                   class="inline-flex items-center gap-2 bg-white text-custom-primary font-bold text-sm px-8 py-3 rounded-xl no-underline hover:bg-gray-100 transition-colors duration-200 shadow-lg mt-1">
                    Book a Service
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </section>

        <div id="gallery-lightbox"
             class="gallery-lightbox flex flex-col"
             role="dialog"
             aria-modal="true"
             aria-label="Gallery image viewer">
            <div class="flex items-center justify-between px-4 py-4 text-white sm:px-8">
                <div>
                    <h3 id="lb-title" class="text-lg font-extrabold"></h3>
                    <p id="lb-meta" class="text-sm text-gray-400"></p>
                </div>
                <button type="button"
                        id="lb-close"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 transition-colors hover:bg-white/20"
                        aria-label="Close lightbox">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="relative flex min-h-0 flex-1 items-center justify-center px-4 py-4 sm:px-16">
                <button type="button"
                        id="lb-prev"
                        class="gallery-lightbox-nav absolute left-2 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-custom-primary sm:left-6"
                        aria-label="Previous image">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <img id="lb-img" src="" alt="" class="gallery-lightbox-image">

                <button type="button"
                        id="lb-next"
                        class="gallery-lightbox-nav absolute right-2 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-custom-primary sm:right-6"
                        aria-label="Next image">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <div class="px-4 pb-6 sm:px-8">
                <p id="lb-desc" class="mx-auto mb-4 max-w-3xl text-center text-sm leading-relaxed text-gray-300"></p>
                <div id="lb-thumbs" class="flex justify-center gap-2 overflow-x-auto pb-2"></div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts-stack')
    @vite('resources/js/gallery.ts')
@endpush
