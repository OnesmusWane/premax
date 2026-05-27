<?php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use App\Models\FeedbackToken;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    // ── Show feedback form ───────────────────────

    public function show(string $token): View|RedirectResponse
    {
        $record = FeedbackToken::where('token', $token)->first();

        if (! $record) {
            return view('feedback.invalid');
        }

        if ($record->used) {
            return view('feedback.used');
        }

        if ($record->expires_at && $record->expires_at->isPast()) {
            return view('feedback.expired');
        }

        return view('pages.feedback', ['token' => $record]);
    }

    // ── Store feedback ───────────────────────────

    public function store(Request $request, string $token): RedirectResponse
    {
        $record = FeedbackToken::where('token', $token)->first();

        // Token not found
        if (! $record) {
            return view('feedback.invalid');
        }

        // Already used — redirect back to show() which will render the used view
        if ($record->used) {
            return redirect()->route('feedback.show', $token);
        }

        // Expired — same pattern
        if ($record->expires_at && $record->expires_at->isPast()) {
            return redirect()->route('feedback.show', $token);
        }

        // Validate — on failure Laravel redirects back() with errors automatically
        $validated = $request->validate([
            'rating'       => 'required|integer|min:1|max:5',
            'title'        => 'nullable|string|max:200',
            'body'         => 'nullable|string|max:2000',
            'recommend'    => 'required|in:yes,no',
            'display_name' => 'nullable|string|max:120',
        ]);

        // Save feedback, mapping display_name → name (anonymous fallback)
        CustomerFeedback::create([
            'feedback_token_id' => $record->id,
            'name'              => $validated['display_name'] ?: 'Anonymous',
            'phone'             => $record->customer_phone,
            'vehicle'           => $record->vehicle_reg,
            'service'           => $record->service,
            'title'             => $validated['title'] ?? null,
            'rating'            => $validated['rating'],
            'liked'             => $validated['body'] ?? null,
            'recommend'         => $validated['recommend'],
        ]);

        // Mark token as used AFTER saving
        $record->update(['used' => true]);

        return redirect()->route('feedback.thanks');
    }
}