@php
    $pageTitle       = 'Sign In | Premax Automotive Studio';
    $pageDescription = 'Sign in to your Premax studio account.';
    $pageKeyWords    = '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    @include('pages.partials.global-head-tags')
    @vite('resources/js/app.js')
</head>
<body class="bg-[#111111]">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    {{-- ── LEFT IMAGE ── --}}
    <div class="hidden lg:block relative">
        <x-responsive-image path="assets/images/hero/signin.webp"
             alt=""
             class="absolute inset-0 w-full h-full object-cover" :priority="true" />
        <div class="absolute inset-0 bg-gradient-to-t from-[#111111] via-black/30 to-transparent"></div>

        <div class="absolute bottom-12 left-12 right-12">
            <a href="{{ url('/') }}" class="flex items-center gap-2 mb-12 no-underline group">
                <span class="font-bold text-xl tracking-widest uppercase text-white">Premax</span>
                <div class="w-2 h-2 bg-custom-primary group-hover:scale-125 transition-transform"></div>
            </a>
            <blockquote class="text-2xl font-bold text-white leading-relaxed">
                "The studio remembers every detail of every visit. So I don't have to."
            </blockquote>
            <p class="text-white/50 text-sm mt-4">— Member since 2019</p>
        </div>
    </div>

    {{-- ── RIGHT FORM ── --}}
    <div class="flex items-center justify-center px-6 py-16 min-h-screen">
        <div class="w-full max-w-md">

            <a href="{{ url('/') }}" class="lg:hidden flex items-center gap-2 mb-12 no-underline group">
                <span class="font-bold text-xl tracking-widest uppercase text-white">Premax</span>
                <div class="w-2 h-2 bg-custom-primary group-hover:scale-125 transition-transform"></div>
            </a>

            {{-- Step 1: Credentials --}}
            <div id="step-credentials">
                <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">Sign In</span>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Welcome back.</h1>
                <p class="text-white/50 mb-10">Access your studio account.</p>

                <form id="login-form" class="space-y-6" novalidate>
                    @csrf
                    <div>
                        <label class="text-[10px] uppercase tracking-widest text-white/30 mb-2 block">Email</label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <input type="email" name="email" id="email" required autocomplete="email"
                                   class="w-full bg-[#1a1a1a] border border-white/15 rounded-md pl-11 pr-4 py-3.5 text-white text-sm
                                          focus:outline-none focus:border-custom-primary transition-colors placeholder-white/20"
                                   placeholder="you@example.com">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-[10px] uppercase tracking-widest text-white/30">Password</label>
                        </div>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input type="password" name="password" id="password" required autocomplete="current-password"
                                   class="w-full bg-[#1a1a1a] border border-white/15 rounded-md pl-11 pr-12 py-3.5 text-white text-sm
                                          focus:outline-none focus:border-custom-primary transition-colors"
                                   placeholder="••••••••">
                            <button type="button" id="toggle-pw"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-white/30 hover:text-white transition-colors">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <p id="login-error" class="text-custom-primary text-sm hidden"></p>

                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-custom-primary text-white font-semibold rounded-md hover:bg-red-700 transition-colors">
                        Continue
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </button>
                </form>

                <p class="text-sm text-white/40 text-center mt-8">
                    No account yet?
                    <a href="{{ route('signup') }}" class="text-white font-semibold hover:text-custom-primary transition-colors no-underline ml-1">Request access</a>
                </p>
            </div>

            {{-- Step 2: 2FA --}}
            <div id="step-2fa" class="hidden">
                <div class="w-14 h-14 rounded-full bg-custom-primary/10 border border-custom-primary/40 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-custom-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="text-custom-primary text-xs font-bold tracking-[0.3em] uppercase mb-4 block">Two-Factor Authentication</span>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Verify it's you.</h1>
                <p class="text-white/50 mb-2">Enter the six-digit code we sent to</p>
                <p id="otp-email-display" class="text-white font-semibold mb-8 text-sm"></p>

                <form id="tfa-form" class="space-y-6" novalidate>
                    <div class="flex gap-2 md:gap-3 justify-between">
                        @for($i = 0; $i < 6; $i++)
                        <input type="text" inputmode="numeric" maxlength="1"
                               class="otp-input w-12 h-14 md:w-14 md:h-16 text-center text-2xl font-bold
                                      bg-[#1a1a1a] border border-white/15 rounded-md text-white
                                      focus:outline-none focus:border-custom-primary transition-colors">
                        @endfor
                    </div>
                    <p id="tfa-error" class="text-custom-primary text-sm hidden"></p>
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-custom-primary text-white font-semibold rounded-md hover:bg-red-700 transition-colors">
                        Verify and sign in
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </button>
                    <div class="flex items-center justify-between text-sm">
                        <button type="button" id="back-to-creds" class="text-white/40 hover:text-white transition-colors">
                            ← Use different email
                        </button>
                        <button type="button" id="resend-otp" class="text-white/40 hover:text-white transition-colors">
                            Resend code
                        </button>
                    </div>
                    <p id="resend-msg" class="text-green-400 text-xs hidden text-center">A new code has been sent.</p>
                </form>
            </div>

        </div>
    </div>

</div>

<script>
(function () {
    const CSRF      = document.querySelector('meta[name=csrf-token]')?.content ?? '';
    const stepCreds = document.getElementById('step-credentials');
    const step2fa   = document.getElementById('step-2fa');
    const loginForm = document.getElementById('login-form');
    const tfaForm   = document.getElementById('tfa-form');
    const loginErr  = document.getElementById('login-error');
    const tfaErr    = document.getElementById('tfa-error');
    const pwInput   = document.getElementById('password');
    const togglePw  = document.getElementById('toggle-pw');
    const eyeIcon   = document.getElementById('eye-icon');

    // Toggle password visibility
    togglePw?.addEventListener('click', () => {
        const show = pwInput.type === 'password';
        pwInput.type = show ? 'text' : 'password';
        eyeIcon.innerHTML = show
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    });

    // Step 1 → submit credentials
    loginForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        loginErr.classList.add('hidden');
        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        if (!email || !password) {
            loginErr.textContent = 'Please complete both fields.';
            loginErr.classList.remove('hidden');
            return;
        }

        const btn = loginForm.querySelector('button[type=submit]');
        btn.disabled    = true;
        btn.textContent = 'Checking…';

        try {
            const res  = await fetch('{{ route('login.post') }}', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body:    JSON.stringify({ email, password }),
            });
            const data = await res.json();
            if (data.success) {
                document.getElementById('otp-email-display').textContent = email;
                stepCreds.classList.add('hidden');
                step2fa.classList.remove('hidden');
                setTimeout(() => document.querySelector('.otp-input')?.focus(), 50);
                return;
            }
            loginErr.textContent = data.message ?? 'Invalid credentials.';
            loginErr.classList.remove('hidden');
        } catch {
            loginErr.textContent = 'Something went wrong. Please try again.';
            loginErr.classList.remove('hidden');
        }

        btn.disabled    = false;
        btn.innerHTML   = 'Continue <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>';
    });

    // OTP input navigation
    document.querySelectorAll('.otp-input').forEach((inp, i, all) => {
        inp.addEventListener('input', () => {
            inp.value = inp.value.replace(/\D/g, '').slice(-1);
            if (inp.value && i < all.length - 1) all[i + 1].focus();
        });
        inp.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !inp.value && i > 0) all[i - 1].focus();
        });
        inp.addEventListener('paste', (e) => {
            e.preventDefault();
            const digits = (e.clipboardData?.getData('text') ?? '').replace(/\D/g, '').slice(0, 6);
            digits.split('').forEach((d, j) => { if (all[j]) all[j].value = d; });
            all[Math.min(digits.length, all.length - 1)]?.focus();
        });
    });

    // Step 2 → verify OTP server-side
    tfaForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        tfaErr.classList.add('hidden');
        const code = Array.from(document.querySelectorAll('.otp-input')).map(i => i.value).join('');
        if (code.length < 6) {
            tfaErr.textContent = 'Enter all six digits.';
            tfaErr.classList.remove('hidden');
            return;
        }

        const btn = tfaForm.querySelector('button[type=submit]');
        btn.disabled    = true;
        btn.textContent = 'Verifying…';

        try {
            const res  = await fetch('{{ route('login.otp') }}', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body:    JSON.stringify({ code }),
            });
            const data = await res.json();
            if (data.success) {
                window.location.href = data.redirect;
                return;
            }
            tfaErr.textContent = data.message ?? 'Invalid code.';
            tfaErr.classList.remove('hidden');
        } catch {
            tfaErr.textContent = 'Something went wrong. Please try again.';
            tfaErr.classList.remove('hidden');
        }

        btn.disabled  = false;
        btn.innerHTML = 'Verify and sign in <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>';
    });

    // Resend OTP
    document.getElementById('resend-otp')?.addEventListener('click', async () => {
        const msg = document.getElementById('resend-msg');
        msg.classList.add('hidden');
        try {
            const res = await fetch('{{ route('login.resend') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({}),
            });
            const data = await res.json();
            if (data.success) {
                msg.classList.remove('hidden');
                document.querySelectorAll('.otp-input').forEach(i => { i.value = ''; });
                document.querySelector('.otp-input')?.focus();
            }
        } catch {}
    });

    document.getElementById('back-to-creds')?.addEventListener('click', () => {
        step2fa.classList.add('hidden');
        stepCreds.classList.remove('hidden');
    });
})();
</script>
</body>
</html>
