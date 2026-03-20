{{-- Premax Autocare Navigation --}}

{{-- Only non-Tailwind styles: pseudo-element underline + hamburger bar transforms --}}
<style>
    .nav-link { position: relative; }
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 2px;
        left: 0.75rem;
        right: 0.75rem;
        height: 2px;
        background: theme('colors.custom-primary');
        border-radius: 2px;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .nav-link:hover::after,
    .nav-link.active::after { transform: scaleX(1); }

    /* Hamburger bar animations */
    #hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    #hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    #hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* Topbar slide-up */
    #topbar { transition: margin-top 0.35s cubic-bezier(0.4, 0, 0.2, 1); }

    /* Mobile drawer slide-in */
    #mobile-drawer { transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
</style>

<header>

    {{-- ── TOP BAR ── --}}
 <x-topbar />

    {{-- ── MAIN NAVBAR ── --}}
    <nav id="navbar" class="bg-white border-b border-gray-200 sticky top-0 z-40 transition-shadow duration-300">
        <div class="max-w-7xl mx-auto px-6 h-[68px] flex items-center justify-between gap-4">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0 no-underline">
                <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Premax Autocare" class="h-10 w-auto">
                <span class="text-[1.35rem] font-extrabold tracking-tight text-custom-secondary whitespace-nowrap hidden sm:block">
                    Premax <span class="text-custom-primary">Autocare</span>
                </span>
            </a>

            {{-- Desktop Menu --}}
            <ul class="hidden lg:flex items-center gap-1 list-none m-0 p-0">
                <li>
                    <a href="{{ url('/') }}"
                       class="nav-link inline-block px-3 py-2 text-sm font-medium rounded-md no-underline transition-colors duration-200
                              {{ request()->is('/') ? 'text-custom-primary active' : 'text-gray-700 hover:text-custom-primary' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ url('/services') }}"
                       class="nav-link inline-block px-3 py-2 text-sm font-medium rounded-md no-underline transition-colors duration-200
                              {{ request()->is('services*') ? 'text-custom-primary active' : 'text-gray-700 hover:text-custom-primary' }}">
                        Services
                    </a>
                </li>
                <li>
                    <a href="{{ url('/about') }}"
                       class="nav-link inline-block px-3 py-2 text-sm font-medium rounded-md no-underline transition-colors duration-200
                              {{ request()->is('about*') ? 'text-custom-primary active' : 'text-gray-700 hover:text-custom-primary' }}">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="{{ url('/contact') }}"
                       class="nav-link inline-block px-3 py-2 text-sm font-medium rounded-md no-underline transition-colors duration-200
                              {{ request()->is('contact*') ? 'text-custom-primary active' : 'text-gray-700 hover:text-custom-primary' }}">
                        Contact
                    </a>
                </li>
            </ul>

            {{-- Book CTA (desktop) --}}
            <a href="{{ url('/booking') }}"
               class="hidden lg:inline-flex items-center gap-1.5 bg-custom-primary hover:bg-red-800 text-white text-sm font-bold
                      px-5 py-2.5 rounded-lg shrink-0 no-underline whitespace-nowrap
                      shadow-[0_2px_8px_rgba(211,30,36,0.30)] hover:shadow-[0_4px_16px_rgba(211,30,36,0.35)]
                      hover:-translate-y-px active:translate-y-0 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                Book Service
            </a>

            {{-- Hamburger (mobile) --}}
            <button id="hamburger"
                    class="lg:hidden flex flex-col justify-center items-center w-10 h-10 gap-[5px] p-1.5 rounded-lg
                           bg-transparent border-none cursor-pointer hover:bg-gray-100 transition-colors"
                    aria-label="Toggle menu" aria-expanded="false">
                <span class="block w-[22px] h-0.5 bg-custom-secondary rounded-sm transition-all duration-300"></span>
                <span class="block w-[22px] h-0.5 bg-custom-secondary rounded-sm transition-all duration-300"></span>
                <span class="block w-[22px] h-0.5 bg-custom-secondary rounded-sm transition-all duration-300"></span>
            </button>

        </div>
    </nav>

</header>

{{-- ── MOBILE DRAWER ── --}}
<div id="mobile-menu"
     class="fixed inset-0 z-[9999] flex invisible opacity-0 transition-[opacity,visibility] duration-300"
     role="dialog" aria-modal="true" aria-label="Navigation menu">

    <div id="mobile-overlay" class="absolute inset-0 bg-black/45 backdrop-blur-sm"></div>

    <div id="mobile-drawer"
         class="relative w-[min(340px,88vw)] h-full bg-white flex flex-col overflow-y-auto
                -translate-x-full shadow-[4px_0_30px_rgba(0,0,0,0.15)]">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Premax Autocare" class="h-9 w-auto">
            </a>
            <button id="mobile-close"
                    class="w-9 h-9 flex items-center justify-center border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100 cursor-pointer transition-colors"
                    aria-label="Close menu">
                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Links — Contact intentionally excluded on mobile --}}
        <ul class="flex-1 flex flex-col gap-1 px-3 py-4 list-none m-0">
            <li>
                <a href="{{ url('/') }}"
                   class="flex items-center px-4 py-3 text-base font-medium rounded-xl no-underline transition-colors duration-200
                          {{ request()->is('/') ? 'bg-red-50 text-custom-primary font-semibold' : 'text-gray-900 hover:bg-red-50 hover:text-custom-primary' }}">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ url('/services') }}"
                   class="flex items-center px-4 py-3 text-base font-medium rounded-xl no-underline transition-colors duration-200
                          {{ request()->is('services*') ? 'bg-red-50 text-custom-primary font-semibold' : 'text-gray-900 hover:bg-red-50 hover:text-custom-primary' }}">
                    Services
                </a>
            </li>
            <li>
                <a href="{{ url('/about') }}"
                   class="flex items-center px-4 py-3 text-base font-medium rounded-xl no-underline transition-colors duration-200
                          {{ request()->is('about*') ? 'bg-red-50 text-custom-primary font-semibold' : 'text-gray-900 hover:bg-red-50 hover:text-custom-primary' }}">
                    About Us
                </a>
            </li>
        </ul>

        {{-- Book CTA --}}
        <div class="px-5 py-5 border-t border-gray-100">
            <a href="{{ url('/booking') }}"
               class="flex items-center justify-center w-full py-3.5 bg-custom-primary hover:bg-red-800 text-white font-bold text-[0.95rem]
                      rounded-xl no-underline tracking-wide shadow-[0_4px_14px_rgba(211,30,36,0.30)] transition-colors duration-200">
                Book Service Now
            </a>
        </div>

    </div>
</div>

{{-- ── JS ── --}}
<script>
(function () {
    const topbar      = document.getElementById('topbar');
    const navbar      = document.getElementById('navbar');
    const hamburger   = document.getElementById('hamburger');
    const mobileMenu  = document.getElementById('mobile-menu');
    const mobileClose = document.getElementById('mobile-close');
    const overlay     = document.getElementById('mobile-overlay');
    const drawer      = document.getElementById('mobile-drawer');

    // Topbar hide on scroll
    const topbarH = topbar.offsetHeight;
    let hidden = false;

    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (y > topbarH && !hidden) {
            topbar.style.marginTop = `-${topbarH}px`;
            hidden = true;
        } else if (y <= 5 && hidden) {
            topbar.style.marginTop = '0';
            hidden = false;
        }
        navbar.classList.toggle('shadow-md', y > 10);
    }, { passive: true });

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