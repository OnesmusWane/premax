<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show the full multi-step booking page.
     * Passes all active services grouped by category.
     */
    public function index(Request $request)
    {
        $services = Cache::remember('booking.services', now()->addMinutes(60), function () {
            return Service::with('serviceCategory')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->groupBy(fn($s) => $s->serviceCategory->name ?? 'Other');
        });

        // Pre-selected service from ?service= query param (from homepage cards)
        $selectedServiceId = $request->query('service');

        return view('pages.booking', compact('services', 'selectedServiceId'));
    }

    /**
     * Store a booking submitted from either:
     *   - The homepage quick-booking form
     *   - The full multi-step booking page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Service
            'service_id'         => ['nullable', 'exists:services,id'],
            'service'            => ['required', 'string', 'max:255'],

            // Vehicle
            'reg'                => ['required', 'string', 'max:20'],
            'make'               => ['nullable', 'string', 'max:100'],

            // Schedule
            'date'               => ['required', 'date', 'after_or_equal:today'],
            'time'               => ['required', 'string', 'max:20'],

            // Customer
            'name'               => ['required', 'string', 'max:150'],
            'phone'              => ['required', 'string', 'max:20'],
            'email'              => ['nullable', 'email', 'max:150'],

            // Optional extras
            'notes'              => ['nullable', 'string', 'max:1000'],
        ]);

        // Resolve the service model (may be null for free-text from quick form)
        $service = isset($validated['service_id'])
            ? Service::find($validated['service_id'])
            : Service::where('name', $validated['service'])->first();

        // Build scheduled_at datetime
        $scheduledAt = Carbon::parse($validated['date'] . ' ' . $validated['time']);

        $booking = Booking::create([
            'reference'                  => Booking::generateReference(),
            'service_id'                 => $service?->id,
            'service_name'               => $service?->name ?? $validated['service'],
            'vehicle_reg'                => strtoupper(trim($validated['reg'])),
            'vehicle_make_model'         => $validated['make'] ?? null,
            'booking_date'               => $validated['date'],
            'booking_time'               => $validated['time'],
            'scheduled_at'               => $scheduledAt,
            'customer_name'              => $validated['name'],
            'customer_phone'             => $validated['phone'],
            'customer_email'             => $validated['email'] ?? null,
            'source'                     => 'website',
            'status'                     => 'pending',
            'customer_notes'             => $validated['notes'] ?? null,
            'estimated_duration_minutes' => $service?->duration_minutes,
            'price_quoted'               => $service?->price_from,
        ]);

        return redirect()
            ->route('booking.success', ['ref' => $booking->reference])
            ->with('booking', $booking);
    }

    /**
     * Booking success / confirmation page.
     */
    public function success(Request $request)
    {
        $ref     = $request->query('ref');
        $booking = Booking::where('reference', $ref)->firstOrFail();

        return view('pages.booking-success', compact('booking'));
    }
}