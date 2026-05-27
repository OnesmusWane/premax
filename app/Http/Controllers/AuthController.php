<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\CartItem;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // ── Show pages ────────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->intended(route('account'));
        }
        return view('auth.login');
    }

    public function showSignup()
    {
        if (Auth::check()) {
            return redirect()->intended(route('account'));
        }
        return view('auth.signup');
    }

    // ── Step 1: validate credentials + send OTP ───────────────────────────────

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid email or password.'], 422);
        }

        // Store pending email in session (not flash — must survive the OTP request)
        $request->session()->put('otp_pending_email', $request->email);

        $this->sendOtp($user);

        return response()->json(['success' => true]);
    }

    // ── Step 2: verify OTP + complete login ───────────────────────────────────

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $email = $request->session()->get('otp_pending_email');

        if (!$email) {
            return response()->json(['message' => 'Session expired. Please sign in again.'], 422);
        }

        $otp = EmailOtp::where('email', $email)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp || !Hash::check($request->code, $otp->code)) {
            return response()->json(['message' => 'Invalid or expired code. Please try again.'], 422);
        }

        $otp->update(['used_at' => now()]);
        $request->session()->forget('otp_pending_email');

        $user = User::where('email', $email)->firstOrFail();
        Auth::login($user, true);
        $request->session()->regenerate();

        // Merge any guest session cart into the user's DB cart
        $this->mergeSessionCartToDb($user, $request);

        $intended = session()->pull('url.intended', route('account'));

        return response()->json(['success' => true, 'redirect' => $intended]);
    }

    // ── Resend OTP ────────────────────────────────────────────────────────────

    public function resendOtp(Request $request)
    {
        $email = $request->session()->get('otp_pending_email');

        if (!$email) {
            return response()->json(['message' => 'Session expired. Please sign in again.'], 422);
        }

        $user = User::where('email', $email)->firstOrFail();
        $this->sendOtp($user);

        return response()->json(['success' => true]);
    }

    // ── Signup ────────────────────────────────────────────────────────────────

    public function signup(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:120',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:30',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $this->mergeSessionCartToDb($user, $request);

        $intended = session()->pull('url.intended', route('account'));

        return response()->json(['success' => true, 'redirect' => $intended]);
    }

    // ── Logout ────────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function sendOtp(User $user): void
    {
        // Invalidate any previous unused OTPs for this email
        EmailOtp::where('email', $user->email)->whereNull('used_at')->delete();

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailOtp::create([
            'email'      => $user->email,
            'code'       => Hash::make($code),
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($code, explode(' ', $user->name)[0]));
    }

    private function mergeSessionCartToDb(User $user, Request $request): void
    {
        $sessionCart = $request->session()->get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $slug => $item) {
            $productId = $item['product_id'] ?? null;
            if (!$productId) {
                continue;
            }

            $existing = CartItem::where(['user_id' => $user->id, 'product_id' => $productId])->first();

            if ($existing) {
                $existing->increment('qty', $item['qty']);
            } else {
                CartItem::create([
                    'user_id'    => $user->id,
                    'product_id' => $productId,
                    'qty'        => $item['qty'],
                ]);
            }
        }

        $request->session()->forget('cart');
    }
}
