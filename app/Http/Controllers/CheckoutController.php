<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Support\KopoKopoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = CartController::resolveCart();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('info', 'Your cart is empty.');
        }

        $subtotal = (float) collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $shipping = ($subtotal > 10000 || $subtotal == 0) ? 0 : 0;
        $total    = $subtotal + $shipping;

        return view('pages.checkout', compact('cart', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $cart = CartController::resolveCart();

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $validated = $request->validate([
            'contact_email'  => 'required|email|max:191',
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'address'        => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'phone'          => 'required|string|max:30',
            'mpesa_phone'    => 'required|string|max:30',
        ]);

        $subtotal = (float) collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $shipping = ($subtotal > 10000 || $subtotal == 0) ? 0 : 800;
        $total    = $subtotal + $shipping;

        $order = Order::create([
            'user_id'             => Auth::id(),
            'order_number'        => Order::generateNumber(),
            'status'              => 'pending',
            'contact_email'       => $validated['contact_email'],
            'delivery_first_name' => $validated['first_name'],
            'delivery_last_name'  => $validated['last_name'],
            'delivery_address'    => $validated['address'],
            'delivery_city'       => $validated['city'],
            'delivery_phone'      => $validated['phone'],
            'payment_method'      => 'mpesa',
            'payment_status'      => 'pending',
            'subtotal'            => $subtotal,
            'shipping'            => $shipping,
            'total'               => $total,
        ]);

        foreach ($cart as $slug => $item) {
            $product = Product::where('slug', $slug)->first();
            $order->items()->create([
                'product_id'   => $product?->id,
                'product_name' => $item['name'],
                'product_slug' => $slug,
                'unit_price'   => $item['price'],
                'qty'          => $item['qty'],
                'subtotal'     => $item['price'] * $item['qty'],
            ]);
        }

        $kopo = new KopoKopoService();

        if (!$kopo->isConfigured()) {
            $order->update(['payment_status' => 'failed']);
            return response()->json(['success' => false, 'message' => 'M-Pesa is not configured. Please contact support.'], 422);
        }

        $phone = $this->formatPhone($validated['mpesa_phone']);

        try {
            $response   = $kopo->initiateIncomingPayment([
                'payment_channel' => 'M-PESA STK Push',
                'till_number'     => $kopo->tillNumber(),
                'subscriber'      => [
                    'first_name'   => $validated['first_name'],
                    'last_name'    => $validated['last_name'],
                    'phone_number' => $phone,
                ],
                'amount'   => [
                    'currency' => 'KES',
                    'value'    => (int) ceil($total),
                ],
                'metadata' => [
                    'reference' => $order->order_number,
                    'notes'     => 'Premax Boutique Order',
                ],
                '_links' => [
                    'callback_url' => url('/mpesa/callback'),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('KopoKopo STK push failed', ['message' => $e->getMessage()]);
            $order->update(['payment_status' => 'failed']);
            return response()->json(['success' => false, 'message' => 'Failed to send payment prompt. Please try again.'], 422);
        }

        $location   = $response['location'];
        $checkoutId = basename(parse_url($location, PHP_URL_PATH));

        $order->update(['mpesa_checkout_request_id' => $checkoutId]);

        return response()->json([
            'success'        => true,
            'order_id'       => $order->id,
            'order_number'   => $order->order_number,
            'payment_method' => 'mpesa',
            'mpesa_phone'    => $validated['mpesa_phone'],
            'status_url'     => route('mpesa.status',  $order->id),
            'success_url'    => route('mpesa.success', $order->id),
        ]);
    }

    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\s+/', '', $phone);
        $phone = ltrim($phone, '+');

        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }

        return '+' . $phone;
    }
}
