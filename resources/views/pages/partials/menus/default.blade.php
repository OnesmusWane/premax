{{-- Premax Navigation — Premium Dark --}}

<style>
    #hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    #hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    #hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }
    #mobile-drawer { transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
    #navbar { transition: background-color 0.3s ease, padding 0.3s ease, border-color 0.3s ease, backdrop-filter 0.3s ease; }
</style>

<header class="relative z-40">
    <nav id="navbar"
         class="{{ request()->is('/') ? 'bg-transparent py-6' : 'bg-black/90 backdrop-blur-lg border-b border-white/5 py-4' }} fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline shrink-0">
                <div class="bg-white rounded-xl p-1.5 shrink-0">
                    <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Premax Autocare"
                         class="h-8 w-auto">
                </div>
                <span class="text-lg font-extrabold tracking-tight text-white">
                    Premax <span class="text-custom-primary">Autocare</span>
                </span>
            </a>

            {{-- Desktop Nav --}}
            <ul class="hidden lg:flex items-center gap-8 list-none m-0 p-0">
                @foreach([
                    ['Services', '/services', 'services*'],
                    ['Our Work', '/work',     'work*'],
                    ['Shop',     '/shop',     'shop*'],
                    ['About',    '/about',    'about*'],
                    ['Contact',  '/contact',  'contact*'],
                ] as [$label, $href, $pattern])
                <li>
                    <a href="{{ url($href) }}"
                       class="text-sm font-medium no-underline transition-colors duration-200
                              {{ request()->is($pattern) ? 'text-white' : 'text-white/60 hover:text-white' }}">
                        {{ $label }}
                    </a>
                </li>
                @endforeach
            </ul>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">

                {{-- Cart --}}
                @php
                    $cartCount = auth()->check()
                        ? (int) \App\Models\CartItem::where('user_id', auth()->id())->sum('qty')
                        : (int) array_sum(array_column(session('cart', []), 'qty'));
                @endphp
                <a href="{{ route('cart.index') }}"
                   class="relative w-10 h-10 flex items-center justify-center text-white/60 hover:text-white transition-colors no-underline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span data-cart-count
                          class="absolute -top-0.5 -right-0.5 w-4.5 h-4.5 rounded-full bg-custom-primary text-white text-[9px] font-bold
                                 flex items-center justify-center leading-none {{ $cartCount === 0 ? 'hidden' : '' }}">
                        {{ $cartCount ?: '' }}
                    </span>
                </a>

                {{-- User / Account --}}
                @auth
                <a href="{{ route('account') }}"
                   class="w-10 h-10 flex items-center justify-center text-white/60 hover:text-white transition-colors no-underline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="w-10 h-10 flex items-center justify-center text-white/60 hover:text-white transition-colors no-underline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
                @endauth

                <a href="{{ url('/booking') }}"
                   class="hidden md:inline-flex items-center justify-center px-5 py-2.5
                          bg-custom-primary text-white text-sm font-bold rounded-md
                          hover:bg-red-700 hover:scale-[1.02] transition-all duration-200
                          shadow-[0_2px_8px_rgba(211,30,36,0.30)] no-underline whitespace-nowrap">
                    Book Service
                </a>

                <button id="hamburger"
                        class="lg:hidden flex flex-col justify-center items-center w-10 h-10 gap-[5px] p-1.5 rounded-lg
                               bg-transparent border-none cursor-pointer hover:bg-white/5 transition-colors"
                        aria-label="Toggle menu" aria-expanded="false">
                    <span class="block w-[22px] h-0.5 bg-white rounded-sm transition-all duration-300"></span>
                    <span class="block w-[22px] h-0.5 bg-white rounded-sm transition-all duration-300"></span>
                    <span class="block w-[22px] h-0.5 bg-white rounded-sm transition-all duration-300"></span>
                </button>
            </div>

        </div>
    </nav>
</header>

{{-- Mobile Drawer --}}
<div id="mobile-menu"
     class="fixed inset-0 z-[9999] flex invisible opacity-0 transition-[opacity,visibility] duration-300"
     role="dialog" aria-modal="true" aria-label="Navigation menu">

    <div id="mobile-overlay" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    <div id="mobile-drawer"
         class="relative w-[min(340px,88vw)] h-full bg-[#111111] flex flex-col overflow-y-auto
                -translate-x-full shadow-[4px_0_40px_rgba(0,0,0,0.6)] border-r border-white/5">

        {{-- Drawer header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                <div class="bg-white rounded-xl p-1.5 shrink-0">
                    <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Premax Autocare"
                         class="h-7 w-auto">
                </div>
                <span class="text-base font-extrabold tracking-tight text-white">
                    Premax <span class="text-custom-primary">Autocare</span>
                </span>
            </a>
            <button id="mobile-close"
                    class="w-9 h-9 flex items-center justify-center border border-white/10 rounded-lg
                           bg-white/5 hover:bg-white/10 cursor-pointer transition-colors text-white"
                    aria-label="Close menu">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Nav links --}}
        <ul class="flex-1 flex flex-col gap-1 px-3 py-6 list-none m-0">
            @foreach([
                ['Home',     '/',         '/'],
                ['Services', '/services', 'services*'],
                ['Our Work', '/work',     'work*'],
                ['Shop',     '/shop',     'shop*'],
                ['Gallery',  '/gallery',  'gallery*'],
                ['About',    '/about',    'about*'],
                ['Contact',  '/contact',  'contact*'],
            ] as [$label, $href, $pattern])
            <li>
                <a href="{{ url($href) }}"
                   class="flex items-center px-4 py-3.5 text-base font-medium rounded-xl no-underline transition-colors duration-200
                          {{ request()->is($pattern) ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    {{ $label }}
                </a>
            </li>
            @endforeach
        </ul>

        {{-- Book CTA --}}
        <div class="px-5 py-5 border-t border-white/10">
            <a href="{{ url('/booking') }}"
               class="flex items-center justify-center w-full py-4 bg-custom-primary hover:bg-red-700 text-white
                      font-bold text-[0.95rem] rounded-xl no-underline tracking-wide
                      shadow-[0_4px_14px_rgba(211,30,36,0.30)] transition-colors duration-200">
                Book Service Now
            </a>
        </div>

    </div>
</div>

<script>
(function () {
    const navbar      = document.getElementById('navbar');
    const hamburger   = document.getElementById('hamburger');
    const mobileMenu  = document.getElementById('mobile-menu');
    const mobileClose = document.getElementById('mobile-close');
    const overlay     = document.getElementById('mobile-overlay');
    const drawer      = document.getElementById('mobile-drawer');
    const isHome      = {{ request()->is('/') ? 'true' : 'false' }};

    // Transparent-on-scroll only for home page
    if (isHome) {
        function updateNav() {
            const scrolled = window.scrollY > 60;
            if (scrolled) {
                navbar.classList.remove('bg-transparent', 'py-6');
                navbar.classList.add('bg-black/90', 'backdrop-blur-lg', 'border-b', 'border-white/5', 'py-4');
            } else {
                navbar.classList.remove('bg-black/90', 'backdrop-blur-lg', 'border-b', 'border-white/5', 'py-4');
                navbar.classList.add('bg-transparent', 'py-6');
            }
        }
        window.addEventListener('scroll', updateNav, { passive: true });
    }

    // Mobile drawer
    function openMenu() {
        mobileMenu.classList.remove('invisible', 'opacity-0');
        mobileMenu.classList.add('opacity-100');
        drawer.classList.remove('-translate-x-full');
        drawer.classList.add('translate-x-0');
        hamburger.classList.add('open');
        hamburger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        mobileMenu.classList.add('opacity-0');
        drawer.classList.remove('translate-x-0');
        drawer.classList.add('-translate-x-full');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        setTimeout(() => mobileMenu.classList.add('invisible'), 300);
    }

    hamburger.addEventListener('click', () =>
        mobileMenu.classList.contains('opacity-100') ? closeMenu() : openMenu()
    );
    mobileClose.addEventListener('click', closeMenu);
    overlay.addEventListener('click', closeMenu);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });
})();
</script>
