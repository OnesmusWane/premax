@php
    $pageTitle       = 'Share Your Review | Premax';
    $pageDescription = 'Tell us about your experience at Premax.';
    $pageKeyWords    = '';
    $ratingLabels    = ['Poor', 'Fair', 'Good', 'Excellent', 'Exceptional'];
@endphp

@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-32 pb-24 px-6">
    <div class="max-w-3xl mx-auto">

        {{-- ── Header ──────────────────────────────────────────────────────── --}}
        <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">
            Client Review
        </span>
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-3 leading-tight">
            How was your visit?
        </h1>
        <p class="text-white/55 text-lg mb-10">
            Your candid feedback helps us refine the studio experience.
        </p>

        {{-- ── Visit context card ──────────────────────────────────────────── --}}
        <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-6 mb-10
                    flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="text-[10px] uppercase tracking-widest text-white/30 mb-1">Visit Reference</div>
                <div class="font-bold text-white text-xl tabular-nums font-mono">
                    {{ strtoupper($token->token) }}
                </div>
            </div>
            <div class="md:text-right">
                <div class="text-white font-medium">{{ $token->service ?? 'Premax Service' }}</div>
                <div class="text-white/40 text-sm mt-0.5">
                    @if($token->vehicle_reg)
                        {{ strtoupper($token->vehicle_reg) }} ·
                    @endif
                    {{ $token->created_at->format('d M Y') }}
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="text-xs text-red-400 bg-red-950/40 border border-red-900/40 rounded-xl px-4 py-3 mb-8">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('feedback.store', $token->token) }}" method="POST"
              id="review-form" class="space-y-6">
            @csrf

            {{-- ── Star rating ─────────────────────────────────────────────── --}}
            <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-8 text-center">
                <h2 class="font-semibold text-white text-xl mb-2">Overall rating</h2>
                <p class="text-white/45 text-sm mb-7">Tap a star to rate your experience.</p>

                <div class="flex items-center justify-center gap-2 mb-3" id="star-group">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button"
                            class="star-btn p-1 transition-transform hover:scale-110 focus:outline-none"
                            data-value="{{ $i }}"
                            aria-label="{{ $i }} star{{ $i > 1 ? 's' : '' }}">
                        <svg class="w-10 h-10 transition-colors star-icon" fill="none"
                             stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </button>
                    @endfor
                </div>

                <div id="rating-label" class="text-sm text-white/50 uppercase tracking-widest h-5 transition-all"></div>
                <input type="hidden" name="rating" id="fb-rating" value="{{ old('rating', '') }}">
                @error('rating')
                <p class="text-custom-primary text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Review text ─────────────────────────────────────────────── --}}
            <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-8 space-y-6">

                <div>
                    <label class="text-[10px] uppercase tracking-widest text-white/35 mb-2 block">Title</label>
                    <input type="text" name="title"
                           value="{{ old('title') }}"
                           placeholder="A few words on your experience"
                           class="w-full bg-[#111] border border-white/10 rounded-lg px-4 py-3.5 text-white text-sm
                                  placeholder-white/20 focus:outline-none focus:border-custom-primary transition-colors">
                </div>

                <div>
                    <label class="text-[10px] uppercase tracking-widest text-white/35 mb-2 block">Your review</label>
                    <textarea name="body" rows="5"
                              placeholder="Tell us about the service, the team, and the details that mattered."
                              class="w-full bg-[#111] border border-white/10 rounded-lg px-4 py-3.5 text-white text-sm
                                     placeholder-white/20 focus:outline-none focus:border-custom-primary transition-colors resize-none">{{ old('body') }}</textarea>
                </div>

                {{-- Photos (optional) --}}
                <div>
                    <label class="text-[10px] uppercase tracking-widest text-white/35 mb-3 block">
                        Photos <span class="text-white/20">(optional)</span>
                    </label>
                    <div class="flex flex-wrap gap-3" id="photo-previews">
                        <label id="photo-add-btn"
                               class="w-20 h-20 rounded-xl border border-dashed border-white/15 hover:border-white/35
                                      hover:bg-white/4 flex flex-col items-center justify-center cursor-pointer
                                      text-white/30 hover:text-white/60 transition-colors">
                            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                            </svg>
                            <span class="text-[9px] uppercase tracking-wider">Add</span>
                            <input type="file" id="photo-input" accept="image/*" multiple class="hidden">
                        </label>
                    </div>
                </div>

            </div>

            {{-- ── Recommend ────────────────────────────────────────────────── --}}
            <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-8">
                <h3 class="font-semibold text-white text-lg mb-5">
                    Would you recommend Premax to another luxury car owner?
                </h3>
                <input type="hidden" name="recommend" id="fb-recommend" value="{{ old('recommend', '') }}">
                <div class="flex gap-3">
                    <button type="button" id="rec-yes"
                            class="rec-btn flex-1 py-3 rounded-lg text-sm uppercase tracking-widest font-semibold border
                                   transition-all border-white/12 text-white/55 hover:border-white/30 hover:text-white/80"
                            data-val="yes">
                        Yes, absolutely
                    </button>
                    <button type="button" id="rec-no"
                            class="rec-btn flex-1 py-3 rounded-lg text-sm uppercase tracking-widest font-semibold border
                                   transition-all border-white/12 text-white/55 hover:border-white/30 hover:text-white/80"
                            data-val="no">
                        Not at this time
                    </button>
                </div>
                @error('recommend')
                <p class="text-custom-primary text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Display name ─────────────────────────────────────────────── --}}
            <div class="bg-[#1a1a1a] border border-white/8 rounded-2xl p-8">
                <label class="text-[10px] uppercase tracking-widest text-white/35 mb-2 block">
                    Display name <span class="text-white/20">(optional)</span>
                </label>
                <input type="text" name="display_name"
                       value="{{ old('display_name') }}"
                       placeholder="How would you like to be credited?"
                       class="w-full bg-[#111] border border-white/10 rounded-lg px-4 py-3.5 text-white text-sm
                              placeholder-white/20 focus:outline-none focus:border-custom-primary transition-colors">
                <p class="text-[11px] text-white/25 mt-3">
                    Leave blank to remain anonymous. Reviews are moderated before publication.
                </p>
            </div>

            {{-- ── Submit ───────────────────────────────────────────────────── --}}
            <button type="submit" id="submit-btn" disabled
                    class="w-full py-4 bg-custom-primary text-white font-semibold rounded-md
                           hover:bg-red-700 transition-colors shadow-[0_4px_14px_rgba(211,30,36,0.28)]
                           disabled:opacity-40 disabled:cursor-not-allowed">
                Submit Review
            </button>

        </form>
    </div>
</div>

@push('scripts-stack')
<script>
(function () {
    const LABELS      = ['Poor', 'Fair', 'Good', 'Excellent', 'Exceptional'];
    const ACTIVE_STAR = '#EF4444';   // red-500
    const IDLE_STROKE = 'rgba(255,255,255,0.15)';

    var rating      = parseInt('{{ old('rating', 0) }}') || 0;
    var hoverRating = 0;

    const ratingInput  = document.getElementById('fb-rating');
    const ratingLabel  = document.getElementById('rating-label');
    const submitBtn    = document.getElementById('submit-btn');
    const stars        = document.querySelectorAll('.star-btn');
    const recInput     = document.getElementById('fb-recommend');
    const recBtns      = document.querySelectorAll('.rec-btn');

    // ── Stars ────────────────────────────────────────────────────────────
    function paintStars(upTo) {
        stars.forEach(function (btn) {
            var n   = parseInt(btn.dataset.value);
            var svg = btn.querySelector('svg');
            if (n <= upTo) {
                svg.style.fill   = ACTIVE_STAR;
                svg.style.stroke = ACTIVE_STAR;
            } else {
                svg.style.fill   = 'none';
                svg.style.stroke = IDLE_STROKE;
            }
        });
    }

    function updateLabel(n) {
        ratingLabel.textContent = n > 0 ? LABELS[n - 1] : '';
    }

    stars.forEach(function (btn) {
        btn.addEventListener('mouseenter', function () {
            hoverRating = parseInt(this.dataset.value);
            paintStars(hoverRating);
            updateLabel(hoverRating);
        });
        btn.addEventListener('mouseleave', function () {
            hoverRating = 0;
            paintStars(rating);
            updateLabel(rating);
        });
        btn.addEventListener('click', function () {
            rating           = parseInt(this.dataset.value);
            ratingInput.value = rating;
            paintStars(rating);
            updateLabel(rating);
            submitBtn.disabled = (rating === 0);
        });
    });

    // Restore old() value on validation failure
    if (rating > 0) {
        paintStars(rating);
        updateLabel(rating);
        submitBtn.disabled = false;
    }

    // ── Recommend buttons ────────────────────────────────────────────────
    var ACTIVE_REC   = 'border-custom-primary bg-custom-primary/10 text-custom-primary';
    var INACTIVE_REC = 'border-white/12 text-white/55 hover:border-white/30 hover:text-white/80';

    function setRecommend(val) {
        recInput.value = val;
        recBtns.forEach(function (btn) {
            var isActive = btn.dataset.val === val;
            btn.className = btn.className
                .replace(ACTIVE_REC, '')
                .replace(INACTIVE_REC, '')
                .trim();
            btn.classList.add(...(isActive ? ACTIVE_REC : INACTIVE_REC).split(' '));
        });
    }

    recBtns.forEach(function (btn) {
        btn.addEventListener('click', function () { setRecommend(this.dataset.val); });
    });

    // Restore old recommend value
    var oldRec = '{{ old('recommend', '') }}';
    if (oldRec) setRecommend(oldRec);

    // ── Photo previews ───────────────────────────────────────────────────
    var photoInput    = document.getElementById('photo-input');
    var photoContainer = document.getElementById('photo-previews');
    var addBtn        = document.getElementById('photo-add-btn');

    photoInput.addEventListener('change', function () {
        Array.from(this.files).forEach(function (file) {
            if (!file.type.startsWith('image/')) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                var wrap = document.createElement('div');
                wrap.className = 'relative w-20 h-20 rounded-xl overflow-hidden border border-white/10 shrink-0';
                wrap.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">'
                    + '<button type="button" class="absolute top-1 right-1 w-5 h-5 rounded-full bg-black/70 flex items-center justify-center text-white text-xs leading-none">×</button>';
                wrap.querySelector('button').addEventListener('click', function () { wrap.remove(); });
                photoContainer.insertBefore(wrap, addBtn);
            };
            reader.readAsDataURL(file);
        });
        this.value = ''; // reset so same file can be re-added after removal
    });
})();
</script>
@endpush

@endsection
