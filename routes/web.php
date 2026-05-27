<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\SitemapController;

Route::get('/', function () {
    return view('welcome');
});

// ── Services ─────────────────────────────────────────────────────────────────
Route::get('/services',        [ServicesController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServicesController::class, 'show'])->name('services.show');

// ── Shop ──────────────────────────────────────────────────────────────────────
Route::get('/shop',        [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

// ── Cart (AJAX) ───────────────────────────────────────────────────────────────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',        [CartController::class, 'index']) ->name('index');
    Route::get('/count',   [CartController::class, 'count']) ->name('count');
    Route::post('/add',    [CartController::class, 'add'])   ->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
});

// ── Checkout (auth middleware stores url.intended automatically) ───────────────
Route::middleware('auth')->group(function () {
    Route::get('/checkout',  [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// ── M-Pesa ────────────────────────────────────────────────────────────────────
Route::post('/mpesa/callback',       [MpesaController::class, 'callback'])->name('mpesa.callback');
Route::middleware('auth')->group(function () {
    Route::get('/mpesa/waiting/{order}', fn(\App\Models\Order $order) => view('pages.mpesa-waiting', compact('order')))->name('mpesa.waiting');
    Route::get('/mpesa/status/{order}',  [MpesaController::class, 'status']) ->name('mpesa.status');
    Route::get('/mpesa/success/{order}', [MpesaController::class, 'success'])->name('mpesa.success');
});

// ── Auth ──────────────────────────────────────────────────────────────────────
Route::get('/login',        [AuthController::class, 'showLogin'])  ->name('login');
Route::post('/login',       [AuthController::class, 'login'])      ->name('login.post');
Route::post('/login/otp',   [AuthController::class, 'verifyOtp'])  ->name('login.otp');
Route::post('/login/resend',[AuthController::class, 'resendOtp'])  ->name('login.resend');
Route::get('/signup',       [AuthController::class, 'showSignup']) ->name('signup');
Route::post('/signup',      [AuthController::class, 'signup'])     ->name('signup.post');
Route::post('/logout',      [AuthController::class, 'logout'])     ->name('logout');

// ── Account (requires auth) ───────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/account',   [AccountController::class, 'index']) ->name('account');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
});

// ── Our Work ──────────────────────────────────────────────────────────────────
Route::get('/work',        [WorkController::class, 'index'])->name('work.index');
Route::get('/work/{slug}', [WorkController::class, 'show'])->name('work.show');

// ── Static pages ─────────────────────────────────────────────────────────────
Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact',  [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/',        [BookingController::class, 'index'])   ->name('index');
    Route::post('/',       [BookingController::class, 'store'])   ->name('store');
    Route::get('/success', [BookingController::class, 'success']) ->name('success');
});

Route::get('/{slug}', [LegalController::class, 'show'])
    ->where('slug', 'privacy-policy|terms-of-service')
    ->name('legal.show');

Route::view('/feedback/thanks',  'feedback.thanks')->name('feedback.thanks');
Route::view('/feedback/invalid', 'feedback.invalid')->name('feedback.invalid');
Route::view('/feedback/used',    'feedback.used')->name('feedback.used');
Route::view('/feedback/expired', 'feedback.expired')->name('feedback.expired');

Route::get('/feedback/{token}',  [FeedbackController::class, 'show'])->name('feedback.show');
Route::post('/feedback/{token}', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// ── Sitemap ───────────────────────────────────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
