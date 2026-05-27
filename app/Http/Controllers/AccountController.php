<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Real orders from the database
        $orders = Order::where('user_id', $user->id)
            ->with('items')
            ->orderByDesc('created_at')
            ->get();

        // Bookings — guarded against missing table/model
        $bookings = collect();
        if (class_exists(\App\Models\Booking::class)) {
            try {
                $bookings = \App\Models\Booking::where('user_id', $user->id)
                    ->with('service')
                    ->orderByDesc('scheduled_at')
                    ->limit(20)
                    ->get();
            } catch (\Exception) {
                $bookings = collect();
            }
        }

        return view('pages.account', compact('user', 'orders', 'bookings'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => 'required|string|max:120',
            'phone'    => 'nullable|string|max:30',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name  = $validated['name'];
        $user->phone = $validated['phone'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('account')
            ->with('profile_success', 'Profile updated successfully.')
            ->withFragment('profile');
    }
}
