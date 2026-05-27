@php
    $pageTitle       = 'My Account | Premax Automotive Studio';
    $pageDescription = 'Manage your Premax studio account.';
    $pageKeyWords    = '';

    $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');

    $statusStyles = [
        'CONFIRMED'  => 'bg-green-500/15 text-green-400 border-green-500/30',
        'PENDING'    => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/30',
        'COMPLETED'  => 'bg-white/10 text-white/50 border-white/15',
        'CANCELLED'  => 'bg-red-500/15 text-red-400 border-red-500/30',
    ];

    $orderStatusStyles = [
        'pending'    => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/30',
        'processing' => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
        'shipped'    => 'bg-purple-500/15 text-purple-400 border-purple-500/30',
        'delivered'  => 'bg-green-500/15 text-green-400 border-green-500/30',
        'cancelled'  => 'bg-red-500/15 text-red-400 border-red-500/30',
    ];
    $errors ??= new Illuminate\Support\ViewErrorBag();
@endphp

@extends('layouts.default-menu-page')
@section('content')

<div class="bg-[#111111] min-h-screen pt-32 pb-24">
    <div class="max-w-5xl mx-auto px-6">

        {{-- Order success banner --}}
        @if(session('order_success'))
        <div class="mb-8 flex items-center gap-4 bg-green-500/10 border border-green-500/30 rounded-xl px-6 py-4">
            <svg class="w-5 h-5 text-green-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-white font-semibold text-sm">Order placed successfully!</p>
                <p class="text-white/50 text-xs mt-0.5">Order {{ session('order_success') }} is confirmed. We'll be in touch shortly.</p>
            </div>
        </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between mb-10 flex-wrap gap-4">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-full bg-custom-primary flex items-center justify-center shrink-0">
                    <span class="text-white font-bold text-lg tracking-wider">{{ $initials }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-white/40 text-sm mt-0.5">{{ $user->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 px-4 py-2.5 border border-white/15 rounded-lg text-white/50
                               hover:border-white/30 hover:text-white transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign out
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-8">

            {{-- Sidebar tabs --}}
            <nav class="flex lg:flex-col gap-2">
                @foreach([
                    ['bookings', 'Bookings', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['orders',   'Orders',   'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                    ['profile',  'Profile',  'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ] as [$id, $label, $icon])
                <button type="button" data-tab="{{ $id }}"
                        class="tab-btn flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors text-left
                               text-white/50 hover:bg-white/5 hover:text-white">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                    </svg>
                    {{ $label }}
                </button>
                @endforeach
            </nav>

            {{-- Tab content --}}
            <div>

                {{-- ── BOOKINGS TAB ── --}}
                <div id="tab-bookings" class="tab-panel">
                    <h2 class="text-lg font-semibold text-white mb-6">Your Bookings</h2>

                    @if($bookings->isEmpty())
                    <div class="text-center py-16 bg-[#1a1a1a] border border-white/10 rounded-2xl">
                        <svg class="w-10 h-10 text-white/20 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-white/40 text-sm mb-4">No bookings yet</p>
                        <a href="{{ route('booking.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-custom-primary text-white text-sm font-semibold rounded-md
                                  hover:bg-red-700 transition-colors no-underline">
                            Book a service
                        </a>
                    </div>
                    @else
                    <div class="space-y-3">
                        @foreach($bookings as $booking)
                        @php
                            $bStatus = strtoupper($booking->status ?? 'PENDING');
                            $bStyle  = $statusStyles[$bStatus] ?? 'bg-white/10 text-white/50 border-white/15';
                        @endphp
                        <div class="bg-[#1a1a1a] border border-white/10 rounded-xl px-6 py-5 flex items-center justify-between gap-4 flex-wrap">
                            <div>
                                <p class="text-white font-medium text-sm">
                                    {{ $booking->service->name ?? $booking->service_name ?? 'Service' }}
                                </p>
                                <p class="text-white/40 text-xs mt-1">
                                    {{ isset($booking->scheduled_at) ? \Carbon\Carbon::parse($booking->scheduled_at)->format('D, d M Y · H:i') : '—' }}
                                </p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $bStyle }}">
                                {{ ucfirst(strtolower($bStatus)) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- ── ORDERS TAB ── --}}
                <div id="tab-orders" class="tab-panel hidden">
                    <h2 class="text-lg font-semibold text-white mb-6">Your Orders</h2>

                    @if($orders->isEmpty())
                    <div class="text-center py-16 bg-[#1a1a1a] border border-white/10 rounded-2xl">
                        <svg class="w-10 h-10 text-white/20 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <p class="text-white/40 text-sm mb-4">No orders yet</p>
                        <a href="{{ route('shop.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-custom-primary text-white text-sm font-semibold rounded-md
                                  hover:bg-red-700 transition-colors no-underline">
                            Browse the boutique
                        </a>
                    </div>
                    @else
                    <div class="space-y-4">
                        @foreach($orders as $order)
                        @php $oStyle = $orderStatusStyles[$order->status] ?? 'bg-white/10 text-white/50 border-white/15'; @endphp
                        <div class="bg-[#1a1a1a] border border-white/10 rounded-xl overflow-hidden">
                            <div class="flex items-center justify-between gap-4 px-6 py-4 flex-wrap border-b border-white/5">
                                <div>
                                    <p class="text-white font-semibold text-sm font-mono">{{ $order->order_number }}</p>
                                    <p class="text-white/40 text-xs mt-0.5">
                                        {{ $order->created_at->format('d M Y') }} · {{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-white font-bold text-sm tabular-nums">KES {{ number_format($order->total) }}</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $oStyle }}">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                            </div>
                            <ul class="divide-y divide-white/5">
                                @foreach($order->items as $item)
                                <li class="flex items-center justify-between gap-3 px-6 py-3">
                                    <p class="text-white/70 text-sm truncate">
                                        <span class="text-white/30 mr-2">×{{ $item->qty }}</span>{{ $item->product_name }}
                                    </p>
                                    <span class="text-white/50 text-sm tabular-nums shrink-0">KES {{ number_format($item->subtotal) }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- ── PROFILE TAB ── --}}
                <div id="tab-profile" class="tab-panel hidden">
                    <h2 class="text-lg font-semibold text-white mb-6">Profile & Settings</h2>

                    <form method="POST" action="{{ route('account.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-8 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="sm:col-span-2">
                                    <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                           class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm
                                                  focus:outline-none focus:border-custom-primary transition-colors">
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Email</label>
                                    <input type="email" value="{{ $user->email }}" disabled
                                           class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white/40 text-sm cursor-not-allowed">
                                    <p class="text-white/20 text-xs mt-1">Email cannot be changed.</p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Phone</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                           placeholder="+254..."
                                           class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm
                                                  focus:outline-none focus:border-custom-primary transition-colors">
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-8 space-y-5">
                            <h3 class="text-sm font-semibold text-white">Change Password</h3>
                            <p class="text-white/40 text-xs">Leave blank to keep your current password.</p>
                            <div>
                                <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">New Password</label>
                                <input type="password" name="password" autocomplete="new-password"
                                       class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm
                                              focus:outline-none focus:border-custom-primary transition-colors">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Confirm Password</label>
                                <input type="password" name="password_confirmation" autocomplete="new-password"
                                       class="w-full bg-[#111] border border-white/10 rounded-md px-4 py-3.5 text-white text-sm
                                              focus:outline-none focus:border-custom-primary transition-colors">
                            </div>
                        </div>

                        @if(session('profile_success'))
                        <p class="text-green-400 text-sm">{{ session('profile_success') }}</p>
                        @endif
                        @if($errors->any())
                        <ul class="text-custom-primary text-sm space-y-1">
                            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                        </ul>
                        @endif

                        <button type="submit"
                                class="px-6 py-3 bg-custom-primary text-white text-sm font-semibold rounded-md hover:bg-red-700 transition-colors">
                            Save Changes
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="account-init-tab" data-tab="{{ session('order_success') ? 'orders' : '' }}" style="display:none"></div>

@push('scripts-stack')
<script>
(function () {
    const tabs   = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');

    function activate(id) {
        tabs.forEach(function (t) {
            var active = t.dataset.tab === id;
            t.classList.toggle('bg-white/10', active);
            t.classList.toggle('text-white',   active);
            t.classList.toggle('text-white/50', !active);
        });
        panels.forEach(function (p) { p.classList.toggle('hidden', p.id !== 'tab-' + id); });
        history.replaceState(null, '', '#' + id);
    }

    tabs.forEach(function (t) { t.addEventListener('click', function () { activate(t.dataset.tab); }); });

    var initTab  = document.getElementById('account-init-tab').dataset.tab;
    var hash     = location.hash.replace('#', '');
    var valid    = ['bookings', 'orders', 'profile'];
    activate(initTab || (valid.indexOf(hash) !== -1 ? hash : 'bookings'));
})();
</script>
@endpush

@endsection
