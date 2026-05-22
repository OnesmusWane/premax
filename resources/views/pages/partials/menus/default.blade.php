<header class="fixed inset-x-0 top-0 z-50 border-b border-white/5 bg-black/70 backdrop-blur-xl">
    <nav class="premax-container flex h-[72px] items-center justify-between gap-6">
        <a href="{{ url('/') }}" class="group flex items-center gap-2 no-underline">
            <span class="font-display text-xl font-extrabold uppercase tracking-[0.18em] text-white">Premax</span>
            <span class="h-2 w-2 bg-premax-red transition-transform group-hover:scale-125"></span>
            <!-- <img src="/assets/images/logos/favicon.png" class="h-10 w-auto"/> -->
        </a>

        <ul class="hidden items-center gap-8 lg:flex">
            @foreach([
                ['Services', '/services', 'services*'],
                ['Gallery', '/gallery', 'gallery*'],
                ['About', '/about', 'about*'],
                ['Contact', '/contact', 'contact*'],
            ] as [$label, $href, $pattern])
                <li>
                    <a href="{{ url($href) }}"
                       class="text-sm font-medium no-underline transition-colors {{ request()->is($pattern) ? 'text-white' : 'text-premax-platinum/70 hover:text-white' }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="flex items-center gap-2 md:gap-4">
            <a href="{{ url('/booking') }}" class="premax-button premax-button-primary hidden px-5 py-2.5 md:inline-flex">
                Book Service
            </a>
            <button id="mobile-menu-open" type="button" class="flex h-10 w-10 items-center justify-center rounded-full text-white transition-colors hover:bg-white/5 lg:hidden" aria-label="Open menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>
    </nav>
</header>

<div id="mobile-menu" class="invisible fixed inset-0 z-[60] bg-premax-dark opacity-0 transition-all duration-300 lg:hidden">
    <div class="flex h-[72px] items-center justify-between border-b border-white/5 px-6">
        <a href="{{ url('/') }}" class="flex items-center gap-2 no-underline">
            <span class="font-display text-xl font-extrabold uppercase tracking-[0.18em] text-white">Premax</span>
            <span class="h-2 w-2 bg-premax-red"></span>
        </a>
        <button id="mobile-menu-close" type="button" class="flex h-10 w-10 items-center justify-center rounded-full text-white hover:bg-white/5" aria-label="Close menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <div class="flex min-h-[calc(100vh-72px)] flex-col items-center justify-center gap-7 p-6">
        @foreach([
            ['Services', '/services'],
            ['Gallery', '/gallery'],
            ['About', '/about'],
            ['Contact', '/contact'],
        ] as [$label, $href])
            <a href="{{ url($href) }}" class="font-display text-2xl font-semibold text-white no-underline transition-colors hover:text-premax-red">{{ $label }}</a>
        @endforeach
        <a href="{{ url('/booking') }}" class="premax-button premax-button-primary mt-5 w-full max-w-sm">Book Service</a>
    </div>
</div>

<script>
(() => {
    const menu = document.getElementById('mobile-menu');
    const open = document.getElementById('mobile-menu-open');
    const close = document.getElementById('mobile-menu-close');
    const toggle = (show) => {
        menu.classList.toggle('invisible', !show);
        menu.classList.toggle('opacity-0', !show);
        menu.classList.toggle('opacity-100', show);
        document.body.style.overflow = show ? 'hidden' : '';
    };
    open?.addEventListener('click', () => toggle(true));
    close?.addEventListener('click', () => toggle(false));
    menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => toggle(false)));
})();
</script>
