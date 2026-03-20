
<meta charset="utf-8">

<meta
	name="viewport"
	content="width=device-width, initial-scale=1.0"
>

<meta
	name="csrf-token"
	content="{{ csrf_token() }}"
>

<meta
	name="description"
	content="{{ $pageDescription ?? 'Premax auto service' }}"
/>

<meta
	name="keywords"
	content="{{ $pageKeyWords ?? '' }}"
>

<title>{{ $pageTitle ?? 'Premax auto service' }}</title>

{{-- Favicon --}}
<link rel="icon"             href="{{ asset('assets/images/logos/favicon.ico') }}"        type="image/x-icon">
<link rel="icon"             href="{{ asset('assets/images/logos/favicon-32x32.png') }}"  sizes="32x32"  type="image/png">
<link rel="icon"             href="{{ asset('assets/images/logos/favicon-16x16.png') }}"  sizes="16x16"  type="image/png">
<link rel="apple-touch-icon" href="{{ asset('assets/images/logos/apple-touch-icon.png') }}" sizes="180x180">

{{-- Favicon --}}
<link rel="icon"             href="{{ asset('assets/images/logos/favicon.png') }}"    type="image/x-icon">
<link rel="icon"             href="{{ asset('assets/images/logos/favicon-32x32.png') }}" sizes="32x32" type="image/png">
<link rel="icon"             href="{{ asset('assets/images/logos/favicon-16x16.png') }}" sizes="16x16" type="image/png">
<link rel="apple-touch-icon" href="{{ asset('assets/images/logos/apple-touch-icon.png') }}" sizes="180x180">

{{-- app css --}}
@if (config('app.env') == 'local')
	@vite('resources/css/app.css')
@else
	<style>
		{!! Vite::content('resources/css/app.css') !!}
	</style>
@endif
