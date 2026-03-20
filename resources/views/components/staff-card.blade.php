{{--
    Partial: components/staff-card.blade.php
    Usage:   @include('components.staff-card', ['member' => $member])
--}}
<div class="flex flex-col items-center text-center gap-4 bg-gray-50 rounded-2xl p-7 border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 h-full">

    {{-- Avatar --}}
    @if($member->avatar_url)
    <img src="{{ $member->avatar_url }}"
         alt="{{ $member->name }}"
         class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-sm shrink-0">
    @else
    <div class="w-16 h-16 rounded-full border-2 flex items-center justify-center font-extrabold text-xl shrink-0"
         style="background-color: {{ $member->avatar_color }}1a; border-color: {{ $member->avatar_color }}33; color: {{ $member->avatar_color }}">
        {{ $member->derived_initials }}
    </div>
    @endif

    {{-- Name + Role --}}
    <div>
        <div class="text-sm font-bold text-gray-900">{{ $member->name }}</div>
        <div class="text-xs text-gray-500 mt-0.5">{{ $member->role }}</div>
    </div>

    {{-- Bio --}}
    @if($member->bio)
    <p class="text-xs text-gray-400 leading-relaxed line-clamp-3">{{ $member->bio }}</p>
    @endif

</div>