{{--
    Partial: components/staff-card.blade.php
    Usage:   @include('components.staff-card', ['member' => $member])
--}}
<div class="flex flex-col bg-[#1a1a1a] border border-white/5 rounded-2xl overflow-hidden
            hover:border-white/12 transition-colors duration-300">

    {{-- Portrait / Initials fallback --}}
    <div class="relative overflow-hidden bg-[#222]" style="aspect-ratio:3/4">
        @if($member->avatar_url)
        <img src="{{ $member->avatar_url }}"
             alt="{{ $member->name }}"
             class="w-full h-full object-cover object-top">
        @else
        <div class="w-full h-full flex items-center justify-center"
             style="background-color: {{ $member->avatar_color ?? '#1f1f1f' }}22">
            <span class="text-7xl font-extrabold tracking-tight select-none"
                  style="color: {{ $member->avatar_color ?? '#D31E24' }}">
                {{ $member->derived_initials }}
            </span>
        </div>
        @endif
    </div>

    {{-- Name · Role · Bio --}}
    <div class="p-6">
        <div class="text-base font-bold text-white mb-1">{{ $member->name }}</div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-custom-primary mb-3">
            {{ $member->role }}
        </div>
        @if($member->bio)
        <p class="text-xs text-white/40 leading-relaxed">{{ $member->bio }}</p>
        @endif
    </div>

</div>
