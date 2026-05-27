@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-36 pb-24 px-6 flex items-center justify-center">
    <div class="max-w-xl mx-auto text-center" id="ty-wrap" style="opacity:0;transform:translateY(20px)">

        <div class="w-20 h-20 rounded-full bg-custom-primary/10 border-2 border-custom-primary
                    flex items-center justify-center mx-auto mb-8">
            <svg class="w-8 h-8 text-custom-primary" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
            Thank You
        </span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
            Your review has been received.
        </h1>
        <p class="text-white/55 text-lg max-w-md mx-auto mb-10">
            Feedback from clients like you is how we sharpen our craft.
            We are grateful for your time.
        </p>

        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 px-8 py-3.5 bg-custom-primary text-white font-semibold
                  rounded-md hover:bg-red-700 transition-colors shadow-[0_4px_14px_rgba(211,30,36,0.28)]">
            Return home
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>

    </div>
</div>

@push('scripts-stack')
<script>
(function () {
    var wrap = document.getElementById('ty-wrap');
    setTimeout(function () {
        wrap.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        wrap.style.opacity    = '1';
        wrap.style.transform  = 'translateY(0)';
    }, 60);
})();
</script>
@endpush

@endsection
