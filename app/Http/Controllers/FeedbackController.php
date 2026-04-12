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
            'name'        => 'required|string|max:120',
            'phone'       => 'nullable|string|max:20',
            'vehicle'     => 'nullable|string|max:30',
            'service'     => 'nullable|string|max:60',
            'rating'      => 'required|integer|min:1|max:5',
            'liked'       => 'nullable|string|max:1000',
            'suggestions' => 'nullable|string|max:1000',
            'recommend'   => 'required|in:yes,no',
        ]);

        // Save feedback
        CustomerFeedback::create(array_merge($validated, [
            'feedback_token_id' => $record->id,
        ]));

        // Mark token as used AFTER saving
        $record->update(['used' => true]);

        return redirect()->route('feedback.thanks');
    }
}