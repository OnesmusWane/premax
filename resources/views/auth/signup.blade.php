@php
    $pageTitle       = 'Create Account | Premax Automotive Studio';
    $pageDescription = 'Create your Premax studio account.';
    $pageKeyWords    = '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    @include('pages.partials.global-head-tags')
    @if(config('app.env') == 'local')
    @vite('resources/js/app.js')
    @else
    <script type="module">{!! Vite::content('resources/js/app.js') !!}</script>
    @endif
</head>
<body class="bg-[#111111]">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    {{-- ── LEFT IMAGE ── --}}
    <div class="hidden lg:block relative">
        <img src="{{ asset('assets/images/hero/signup.jpg') }}"
             alt=""
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-[#111111] via-black/30 to-transparent"></div>

        <div class="absolute bottom-12 left-12 right-12">
            <a href="{{ url('/') }}" class="flex items-center gap-2 mb-12 no-underline group">
                <span class="font-bold text-xl tracking-widest uppercase text-white">Premax</span>
                <div class="w-2 h-2 bg-custom-primary group-hover:scale-125 transition-transform"></div>
            </a>
            <h2 class="text-3xl font-bold text-white leading-tight">Join the studio.</h2>
            <p class="text-white/55 mt-4 leading-relaxed">
                Track every service, manage your vehicle profile, and access concierge collection —
                all from one quiet account.
            </p>
        </div>
    </div>

    {{-- ── RIGHT FORM ── --}}
    <div class="flex items-center justify-center px-6 py-16 min-h-screen overflow-y-auto">
        <div class="w-full max-w-md">

            <a href="{{ url('/') }}" class="lg:hidden flex items-center gap-2 mb-12 no-underline group">
                <span class="font-bold text-xl tracking-widest uppercase text-white">Premax</span>
                <div class="w-2 h-2 bg-custom-primary group-hover:scale-125 transition-transform"></div>
            </a>

            <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">Request Access</span>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Create your account.</h1>
            <p class="text-white/50 mb-10">Membership is complimentary for our clients.</p>

            <form id="signup-form" class="space-y-5" novalidate>
                @csrf

                {{-- Full name --}}
                <div>
                    <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Full Name</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" name="name" id="s-name" required
                               class="w-full bg-[#1a1a1a] border border-white/15 rounded-md pl-11 pr-4 py-3.5 text-white text-sm
                                      focus:outline-none focus:border-custom-primary transition-colors placeholder-white/20"
                               placeholder="Your full name">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Email</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" name="email" id="s-email" required
                               class="w-full bg-[#1a1a1a] border border-white/15 rounded-md pl-11 pr-4 py-3.5 text-white text-sm
                                      focus:outline-none focus:border-custom-primary transition-colors placeholder-white/20"
                               placeholder="you@example.com">
                    </div>
                </div>

                {{-- Phone --}}
                <div>
                    <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Phone (Optional)</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <input type="tel" name="phone" id="s-phone"
                               class="w-full bg-[#1a1a1a] border border-white/15 rounded-md pl-11 pr-4 py-3.5 text-white text-sm
                                      focus:outline-none focus:border-custom-primary transition-colors placeholder-white/20"
                               placeholder="+254...">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Password</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" name="password" id="s-password" required
                               class="w-full bg-[#1a1a1a] border border-white/15 rounded-md pl-11 pr-12 py-3.5 text-white text-sm
                                      focus:outline-none focus:border-custom-primary transition-colors">
                        <button type="button" id="s-toggle-pw"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-white/30 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Strength bar --}}
                    <div id="strength-wrap" class="mt-3 hidden">
                        <div class="flex gap-1 mb-1.5">
                            <div class="strength-seg h-1 flex-1 rounded bg-white/10 transition-colors"></div>
                            <div class="strength-seg h-1 flex-1 rounded bg-white/10 transition-colors"></div>
                            <div class="strength-seg h-1 flex-1 rounded bg-white/10 transition-colors"></div>
                            <div class="strength-seg h-1 flex-1 rounded bg-white/10 transition-colors"></div>
                        </div>
                        <p class="text-xs text-white/30">Strength: <span id="strength-label" class="text-white">Weak</span></p>
                    </div>
                </div>

                {{-- Checkboxes --}}
                <div class="space-y-3 pt-2">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="s-agreed" class="w-4 h-4 mt-1 accent-red-600 shrink-0">
                        <span class="text-sm text-white/70">
                            I accept the
                            <a href="{{ route('legal.show', 'terms-of-service') }}" class="text-white underline hover:text-custom-primary no-underline" target="_blank">Terms of Service</a>
                            and
                            <a href="{{ route('legal.show', 'privacy-policy') }}" class="text-white underline hover:text-custom-primary no-underline" target="_blank">Privacy Policy</a>
                        </span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="s-marketing" class="w-4 h-4 mt-1 accent-red-600 shrink-0">
                        <span class="text-sm text-white/40">Send me occasional studio news and care reminders</span>
                    </label>
                </div>

                <p id="signup-error" class="text-custom-primary text-sm hidden"></p>

                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-custom-primary text-white font-semibold rounded-md hover:bg-red-700 transition-colors mt-2">
                    Create account
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </form>

            <p class="text-sm text-white/40 text-center mt-8">
                Already a member?
                <a href="{{ route('login') }}" class="text-white font-semibold hover:text-custom-primary transition-colors no-underline ml-1">Sign in</a>
            </p>

        </div>
    </div>

</div>

<script>
(function () {
    const CSRF      = document.querySelector('meta[name=csrf-token]')?.content ?? '';
    const pwInput   = document.getElementById('s-password');
    const togglePw  = document.getElementById('s-toggle-pw');
    const strengthW = document.getElementById('strength-wrap');
    const strengthL = document.getElementById('strength-label');
    const segs      = document.querySelectorAll('.strength-seg');
    const signupErr = document.getElementById('signup-error');

    // Toggle password visibility
    togglePw?.addEventListener('click', () => {
        pwInput.type = pwInput.type === 'password' ? 'text' : 'password';
    });

    // Password strength
    function calcStrength(p) {
        let s = 0;
        if (p.length >= 8)          s++;
        if (/[A-Z]/.test(p))        s++;
        if (/\d/.test(p))           s++;
        if (/[^A-Za-z0-9]/.test(p)) s++;
        return s;
    }

    pwInput?.addEventListener('input', () => {
        const p = pwInput.value;
        if (!p) { strengthW.classList.add('hidden'); return; }
        strengthW.classList.remove('hidden');
        const s = calcStrength(p);
        const labels = ['Weak', 'Fair', 'Good', 'Strong'];
        strengthL.textContent = labels[Math.max(0, s - 1)] || 'Weak';
        segs.forEach((seg, i) => {
            seg.classList.toggle('bg-custom-primary', i < s);
            seg.classList.toggle('bg-white/10',       i >= s);
        });
    });

    // Submit
    document.getElementById('signup-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        signupErr.classList.add('hidden');

        const name     = document.getElementById('s-name').value.trim();
        const email    = document.getElementById('s-email').value.trim();
        const phone    = document.getElementById('s-phone').value.trim();
        const password = document.getElementById('s-password').value;
        const agreed   = document.getElementById('s-agreed').checked;

        if (!name || !email || !password) {
            signupErr.textContent = 'Please complete all required fields.';
            signupErr.classList.remove('hidden');
            return;
        }
        if (password.length < 8) {
            signupErr.textContent = 'Password must be at least 8 characters.';
            signupErr.classList.remove('hidden');
            return;
        }
        if (!agreed) {
            signupErr.textContent = 'You must accept the Terms of Service and Privacy Policy.';
            signupErr.classList.remove('hidden');
            return;
        }

        const btn = e.target.querySelector('button[type=submit]');
        btn.disabled    = true;
        btn.textContent = 'Creating…';

        try {
            const res  = await fetch('{{ route('signup.post') }}', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body:    JSON.stringify({ name, email, phone, password }),
            });
            const data = await res.json();
            if (data.success) {
                window.location.href = '{{ route('account') }}';
                return;
            }
            const msgs = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message ?? 'Something went wrong.');
            signupErr.textContent = msgs;
            signupErr.classList.remove('hidden');
        } catch {
            signupErr.textContent = 'Something went wrong. Please try again.';
            signupErr.classList.remove('hidden');
        }

        btn.disabled    = false;
        btn.innerHTML   = 'Create account <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>';
    });
})();
</script>
</body>
</html>
