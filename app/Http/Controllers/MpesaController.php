<?php

namespace App\Http\Controllers;

use App\Mail\AdminAlertMail;
use App\Models\CartItem;
use App\Models\ContactInformation;
use App\Models\Order;
use App\Models\Product;
use App\Support\KopoKopoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MpesaController extends Controller
{
    /**
     * KopoKopo webhook — fires after the customer completes or cancels.
     * CSRF is excluded in bootstrap/app.php for this path.
     */
    public function callback(Request $request): \Illuminate\Http\Response
    {
        Log::info('KopoKopo callback received', $request->all());

        $status     = strtolower($request->input('data.attributes.status', 'pending'));
        $resource   = $request->input('data.attributes.event.resource', []);
        $location   = $request->input('data.links.self') ?? $request->input('data.attributes._links.self');
        $checkoutId = $location ? basename(parse_url($location, PHP_URL_PATH)) : null;

        if (!$checkoutId) {
            return response('', 200);
        }

        $order = Order::where('mpesa_checkout_request_id', $checkoutId)->first();
        if (!$order) {
            return response('', 200);
        }

        if ($status === 'success' && $order->payment_status !== 'paid') {
            $this->handlePaymentSuccess($order, $resource['reference'] ?? null);
        } elseif ($status === 'failed') {
            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        }

        return response('', 200);
    }

    /**
     * Front-end polls this every 5 s.
     * Also polls KopoKopo directly so detection works even without a reachable callback URL.
     */
    public function status(Order $order): \Illuminate\Http\JsonResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status === 'pending' && $order->mpesa_checkout_request_id) {
            try {
                $kopo         = new KopoKopoService();
                $location     = $kopo->locationFromId($order->mpesa_checkout_request_id);
                $payload      = $kopo->paymentStatus($location);
                $remoteStatus = strtolower($payload['data']['attributes']['status'] ?? 'pending');
                $resource     = $payload['data']['attributes']['event']['resource'] ?? [];

                if ($remoteStatus === 'success') {
                    $this->handlePaymentSuccess($order, $resource['reference'] ?? null);
                } elseif ($remoteStatus === 'failed') {
                    $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
                }
            } catch (\Throwable $e) {
                Log::warning('KopoKopo status poll failed', ['message' => $e->getMessage()]);
            }
        }

        $order->refresh();

        return response()->json([
            'payment_status'       => $order->payment_status,
            'mpesa_transaction_id' => $order->mpesa_transaction_id,
            'order_number'         => $order->order_number,
        ]);
    }

    /**
     * Order success page.
     */
    public function success(Order $order): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->loadMissing('items.product');

        return response()->view('pages.order-success', compact('order'));
    }

    /**
     * Runs inside a transaction: marks order paid, clears cart, deducts stock.
     * Sends admin email after the transaction commits.
     */
    private function handlePaymentSuccess(Order $order, ?string $receipt): void
    {
        DB::transaction(function () use ($order, $receipt) {
            $order->update([
                'payment_status'       => 'paid',
                'mpesa_transaction_id' => $receipt,
                'status'               => 'processing',
            ]);

            CartItem::where('user_id', $order->user_id)->delete();

            $order->loadMissing('items');
            foreach ($order->items as $item) {
                if (!$item->product_id) continue;

                $product = Product::lockForUpdate()->find($item->product_id);
                if (!$product) continue;

                $newQty = max(0, $product->stock_qty - $item->qty);
                $product->update([
                    'stock_qty'   => $newQty,
                    'is_sold_out' => $newQty <= 0,
                ]);

                DB::table('product_movements')->insert([
                    'product_id'    => $product->id,
                    'user_id'       => null,
                    'type'          => 'order',
                    'source_ref'    => $order->order_number,
                    'quantity'      => -$item->qty,
                    'balance_after' => $newQty,
                    'notes'         => 'M-Pesa order ' . $order->order_number,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }

            // Record in the shared invoices table so it appears in the admin Payments section
            $invoiceNumber = 'INV-' . str_pad((DB::table('invoices')->max('id') ?? 0) + 1, 3, '0', STR_PAD_LEFT);

            $invoiceId = DB::table('invoices')->insertGetId([
                'invoice_number'          => $invoiceNumber,
                'anonymous_customer_name' => $order->delivery_first_name . ' ' . $order->delivery_last_name,
                'sale_type'               => 'product_order',
                'subtotal'                => (int) round($order->subtotal),
                'vat_percent'             => 0,
                'vat_amount'              => 0,
                'discount'                => 0,
                'total'                   => (int) round($order->total),
                'payment_method'          => 'mpesa',
                'payment_provider'        => 'kopokopo',
                'mpesa_reference'         => $receipt,
                'gateway_reference'       => $order->order_number,
                'status'                  => 'paid',
                'notes'                   => 'Web shop order: ' . $order->order_number,
                'paid_at'                 => now(),
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);

            foreach ($order->items as $item) {
                DB::table('invoice_items')->insert([
                    'invoice_id'  => $invoiceId,
                    'line_type'   => 'custom',
                    'description' => $item->product_name,
                    'quantity'    => $item->qty,
                    'unit_price'  => (int) round($item->unit_price),
                    'total'       => (int) round($item->subtotal),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        });

        // Send admin email only after payment is confirmed
        try {
            $adminEmail = ContactInformation::primaryEmail();
            if (!$adminEmail) return;

            $order->loadMissing('items');
            $itemLines = $order->items->map(
                fn($i) => $i->product_name . ' × ' . $i->qty . ' — KES ' . number_format($i->subtotal)
            )->implode("\n");

            Mail::to($adminEmail)->send(new AdminAlertMail(
                alertSubject: 'Payment confirmed — ' . $order->order_number,
                type: 'Shop Purchase (Paid)',
                rows: [
                    ['label' => 'Order No.',  'value' => $order->order_number],
                    ['label' => 'Customer',   'value' => $order->delivery_first_name . ' ' . $order->delivery_last_name],
                    ['label' => 'Phone',      'value' => $order->delivery_phone],
                    ['label' => 'Email',      'value' => $order->contact_email],
                    ['label' => 'City',       'value' => $order->delivery_city],
                    ['label' => 'Total',      'value' => 'KES ' . number_format($order->total)],
                    ['label' => 'M-Pesa Ref', 'value' => $order->mpesa_transaction_id ?? 'N/A'],
                    ['label' => 'Paid at',    'value' => now()->format('d M Y, H:i')],
                ],
                note: $itemLines,
            ));
        } catch (\Throwable $e) {
            Log::error('Failed to send order confirmation email', ['order' => $order->order_number, 'error' => $e->getMessage()]);
        }
    }
}
