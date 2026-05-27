@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-36 pb-24 px-6 flex items-center justify-center">
    <div class="max-w-md mx-auto text-center" id="state-wrap" style="opacity:0;transform:translateY(20px)">

        <div class="w-20 h-20 rounded-full bg-white/5 border border-white/10
                    flex items-center justify-center mx-auto mb-8">
            <svg class="w-8 h-8 text-white/35" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3.5 2"/>
            </svg>
        </div>

        <span class="text-white/30 text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
            Link Expired
        </span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
            This link has expired.
        </h1>
        <p class="text-white/45 text-lg max-w-sm mx-auto mb-10">
            Review links are valid for 7 days after your service date.
            If you'd still like to share your experience, reach out to us directly.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact.index') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-custom-primary text-white
                      font-semibold rounded-md hover:bg-red-700 transition-colors
                      shadow-[0_4px_14px_rgba(211,30,36,0.28)]">
                Contact us
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
