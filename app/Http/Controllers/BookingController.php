<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\BookingSource;
use App\Models\BookingStatus;
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
        'service_id'  => ['nullable', 'exists:services,id'],
        'service'     => ['required', 'string', 'max:255'],
        'reg'         => ['required', 'string', 'max:20'],
        'make'        => ['nullable', 'string', 'max:100'],
        'date'        => ['required', 'date', 'after_or_equal:today'],
        'time'        => ['required', 'string', 'max:20'],
        'name'        => ['required', 'string', 'max:150'],
        'phone'       => ['required', 'string', 'max:20'],
        'email'       => ['nullable', 'email', 'max:150'],
        'notes'       => ['nullable', 'string', 'max:1000'],
    ]);

    // ── 1. Resolve or create Customer (by phone number) ───────────────────
    $customer = Customer::updateOrCreate(
        ['phone' => $validated['phone']], 
        [
            'name'         => $validated['name'],
            'email'        => $validated['email'] ?? null,
            'member_since' => now()->toDateString(), 
            'is_active'    => true,
        ]
    );

    // Don't overwrite member_since if customer already exists
    if ($customer->wasRecentlyCreated === false && !$customer->member_since) {
        $customer->update(['member_since' => now()->toDateString()]);
    }

    // ── 2. Resolve or create Vehicle (by registration) ────────────────────
    $reg     = strtoupper(trim($validated['reg']));
    $vehicle = Vehicle::updateOrCreate(
        ['registration' => $reg],                      // match by reg
        [
            'customer_id'     => $customer->id,        // link to customer
            'make'            => $validated['make'] ?? 'Unknown',
            'model'           => 'Unknown',            // not collected on quick form
            'last_service_at' => now(),
        ]
    );

    // If vehicle exists but belongs to different customer — keep original owner
    // but update last_service_at
    if (!$vehicle->wasRecentlyCreated) {
        $vehicle->update(['last_service_at' => now()]);
    }

    // ── 3. Resolve Service ────────────────────────────────────────────────
    $service = isset($validated['service_id'])
        ? Service::find($validated['service_id'])
        : Service::where('name', $validated['service'])->first();

    // ── 4. Resolve BookingSource ──────────────────────────────────────────
    $source = BookingSource::where('slug', 'website')->first();

    // ── 5. Resolve BookingStatus (pending) ───────────────────────────────
    $status = BookingStatus::where('slug', 'pending')->first();

    // ── 6. Create Booking ─────────────────────────────────────────────────
    $booking = Booking::create([
        'reference'         => Booking::generateReference(),
        'service_id'        => $service?->id,
        'vehicle_id'        => $vehicle->id,
        'customer_id'       => $customer->id,
        'booking_source_id' => $source?->id,
        'booking_status_id' => $status?->id,
        'scheduled_at'      => Carbon::parse($validated['date'] . ' ' . $validated['time']),
        'customer_notes'    => $validated['notes'] ?? null,
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
            $booking = Booking::with(['service', 'vehicle', 'customer'])
                ->where('reference', $ref)
                ->firstOrFail();

            return view('pages.booking-success', compact('booking'));
        }
}