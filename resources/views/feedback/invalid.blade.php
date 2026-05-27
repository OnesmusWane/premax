@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-36 pb-24 px-6 flex items-center justify-center">
    <div class="max-w-md mx-auto text-center" id="state-wrap" style="opacity:0;transform:translateY(20px)">

        <div class="w-20 h-20 rounded-full bg-custom-primary/10 border border-custom-primary/20
                    flex items-center justify-center mx-auto mb-8">
            <svg class="w-8 h-8 text-custom-primary/60" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
        </div>

        <span class="text-custom-primary/60 text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
            Invalid Link
        </span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
            Link not recognised.
        </h1>
        <p class="text-white/45 text-lg max-w-sm mx-auto mb-10">
            This review link doesn't exist or may have been entered incorrectly.
            If you received a link from us, please check it and try again.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact.index') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-custom-primary text-white
                      font-semibold rounded-md hover:bg-red-700 transition-colors">
                Contact support
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center px-8 py-3.5 border border-white/15 text-white
                      font-semibold rounded-md hover:bg-white/5 transition-colors">
                Back to home
            </a>
        </div>

    </div>
</div>

@push('scripts-stack')
<script>
(function () {
    var el = document.getElementById('state-wrap');
    setTimeout(function () {
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        el.style.opacity    = '1';
        el.style.transform  = 'translateY(0)';
    }, 60);
})();
</script>
@endpush

@endsection
