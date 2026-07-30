{{--
    Partial: components/review-card.blade.php
    Usage:   @include('components.review-card', ['review' => $review])
--}}
<div class="bg-[#1a1a1a] rounded-2xl p-6 flex flex-col gap-4 border border-white/5
            hover:border-white/10 transition-colors duration-300 h-full">

    {{-- Stars + source --}}
    <div class="flex items-center gap-0.5">
        @for($s = 1; $s <= 5; $s++)
        <svg class="w-4 h-4 {{ $s <= $review->rating ? 'text-yellow-400' : 'text-white/10' }}"
             fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
        @endfor
        @if($review->source && $review->source !== 'website')
        <span class="ml-auto text-[10px] text-white/25 uppercase tracking-widest">
            via {{ ucfirst($review->source) }}
        </span>
        @endif
    </div>

    {{-- Quote --}}
    <p class="text-sm text-white/60 leading-relaxed italic flex-1">
        "{{ $review->body }}"
    </p>

    {{-- Service tag --}}
    @if($review->service)
    <div class="text-[10px] font-semibold text-custom-primary bg-custom-primary/10
                border border-custom-primary/20 rounded-full px-3 py-1 w-fit">
        {{ $review->service->name }}
    </div>
    @endif

    {{-- Author --}}
    <div class="flex items-center gap-3 pt-3 border-t border-white/5">
        @if($review->reviewer_avatar_url)
        <img src="{{ $review->reviewer_avatar_url }}" loading="lazy" decoding="async"
             alt="{{ $review->reviewer_name }}"
             class="w-9 h-9 rounded-full object-cover shrink-0">
        @else
        <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm text-white shrink-0"
             style="background-color: {{ $review->avatar_color }}">
            {{ $review->initials }}
        </div>
        @endif

        <div>
            <div class="text-sm font-semibold text-white">{{ $review->reviewer_name }}</div>
            <div class="text-xs text-white/30 flex items-center gap-1 mt-0.5">
                @if($review->is_verified_customer)
                <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Verified Customer
                @else
                Customer
                @endif
            </div>
        </div>
    </div>

</div>
