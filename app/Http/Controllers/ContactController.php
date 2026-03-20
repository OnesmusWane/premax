<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\ContactInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContactController extends Controller
{
    /**
     * Show the contact page with info fetched from DB.
     */
    public function index()
    {
        $contact = Cache::remember('contact.primary', now()->addMinutes(60), function () {
            return ContactInformation::where('is_primary', true)
                ->where('is_active', true)
                ->first();
        });

        return view('pages.contact', compact('contact'));
    }

    /**
     * Store a contact form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'email'   => ['required', 'email', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Your message has been sent! We\'ll get back to you shortly.');
    }
}