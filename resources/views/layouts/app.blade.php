<!DOCTYPE html>
<html lang="en">
<head>
	@include('pages.partials.global-head-tags')

	@yield('head-tags')

	@stack('head-tags-stack')
	@if (config('app.env') == 'local')
		@vite('resources/js/app.js')
	@else
		<script type="module">
			{!! Vite::content('resources/js/app.js') !!}
		</script>
	@endif
</head>

<body>
	<div id="base-container">
		@yield('menu')
		@yield('content')

		@section('footer')
			@include('pages.partials.footer')
		@show
	</div>

	<x-whatsapp-float />


	{{-- javascript --}}
	@yield('scripts')

	@stack('scripts-stack')
</body>

</html>
<style>
/* Applies to all scrollbars */
* {
  scrollbar-width: thin;
  scrollbar-color: #161616 #FFFF;
}

/* WebKit browsers (Chrome, Safari, Edge) */
*::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

*::-webkit-scrollbar-track {
  background: #8B8F94;
}

*::-webkit-scrollbar-thumb {
  background-color: #161616;
  border-radius: 10px;
  border: 2px solid #8B8F94;
}
</style>
