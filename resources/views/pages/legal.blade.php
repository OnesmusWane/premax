@extends('layouts.default-menu-page')
@section('content')

<section class="bg-custom-secondary py-14 text-center">
    <div class="max-w-2xl mx-auto px-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">{{ $page->title }}</h1>
        @if($page->version || $page->effective_date)
        <p class="mt-3 text-gray-400 text-sm">
            @if($page->version) Version {{ $page->version }} · @endif
            @if($page->effective_date) Effective {{ $page->effective_date->format('d F Y') }} @endif
        </p>
        @endif
    </div>
</section>

<section class="bg-gray-50 py-16">
    <div class="max-w-3xl mx-auto px-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 md:p-12
                    prose prose-sm max-w-none
                    prose-headings:font-extrabold prose-headings:text-gray-900
                    prose-h2:text-2xl prose-h3:text-base prose-h3:mt-8
                    prose-p:text-gray-600 prose-p:leading-relaxed
                    prose-li:text-gray-600 prose-li:leading-relaxed
                    prose-a:text-custom-primary prose-a:no-underline hover:prose-a:underline
                    prose-strong:text-gray-800">
            {!! $page->content !!}
        </div>

        <div class="mt-8 text-center">
            <a href="{{ url('/contact') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-custom-primary hover:underline">
                Have questions? Contact us →
            </a>
        </div>
    </div>
</section>

@endsection