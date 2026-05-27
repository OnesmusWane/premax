
<meta charset="utf-8">

{{-- Typography --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wdth,wght@0,75..100,400..700;1,75..100,400..700&display=swap" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- ── Primary meta ──────────────────────────────────────────────────────── --}}
<title>{{ $pageTitle ?? 'Premax Automotive Studio' }}</title>
<meta name="description" content="{{ $pageDescription ?? 'Nairobi\'s premier automotive studio — detailing, diagnostics, tyres, performance and more.' }}">
@if(!empty($pageKeyWords))
<meta name="keywords" content="{{ $pageKeyWords }}">
@endif

{{-- ── Crawl directives ────────────────────────────────────────────────────── --}}
@if(!empty($pageNoIndex))
<meta name="robots" content="noindex, nofollow">
@else
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
@endif

{{-- ── Canonical ────────────────────────────────────────────────────────────── --}}
<link rel="canonical" href="{{ $pageCanonical ?? url()->current() }}">

{{-- ── Open Graph ───────────────────────────────────────────────────────────── --}}
@php
    $_ogImage = $pageImage   ?? asset('assets/images/hero/about.jpg');
    $_ogTitle = $pageTitle   ?? 'Premax Automotive Studio';
    $_ogDesc  = $pageDescription ?? 'Nairobi\'s premier automotive studio — detailing, diagnostics, tyres, performance and more.';
    $_ogType  = $pageOgType  ?? 'website';
    $_ogUrl   = $pageCanonical ?? url()->current();
@endphp
<meta property="og:type"        content="{{ $_ogType }}">
<meta property="og:url"         content="{{ $_ogUrl }}">
<meta property="og:title"       content="{{ $_ogTitle }}">
<meta property="og:description" content="{{ $_ogDesc }}">
<meta property="og:image"       content="{{ $_ogImage }}">
<meta property="og:image:alt"   content="Premax Automotive Studio">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale"      content="en_KE">
<meta property="og:site_name"   content="Premax Automotive Studio">

{{-- ── Twitter Card ─────────────────────────────────────────────────────────── --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $_ogTitle }}">
<meta name="twitter:description" content="{{ $_ogDesc }}">
<meta name="twitter:image"       content="{{ $_ogImage }}">

{{-- ── Favicon ───────────────────────────────────────────────────────────────── --}}
<link rel="icon"             href="{{ asset('assets/images/logos/favicon.ico') }}"           type="image/x-icon">
<link rel="icon"             href="{{ asset('assets/images/logos/favicon-32x32.png') }}"     sizes="32x32" type="image/png">
<link rel="icon"             href="{{ asset('assets/images/logos/favicon-16x16.png') }}"     sizes="16x16" type="image/png">
<link rel="apple-touch-icon" href="{{ asset('assets/images/logos/apple-touch-icon.png') }}"  sizes="180x180">

{{-- ── Styles ────────────────────────────────────────────────────────────────── --}}
@if (config('app.env') == 'local')
    @vite('resources/css/app.css')
@else
    <style>
        {!! Vite::content('resources/css/app.css') !!}
    </style>
@endif
