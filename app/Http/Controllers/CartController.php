<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ── Public pages ──────────────────────────────────────────────────────────

    public function index()
    {
        $cart = static::resolveCart();
        return view('pages.cart', compact('cart'));
    }

    // ── AJAX endpoints ────────────────────────────────────────────────────────

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'qty'        => 'sometimes|integer|min:1',
        ]);

        $product = Product::active()->findOrFail($request->product_id);

        if ($product->is_sold_out) {
            return response()->json(['success' => false, 'message' => 'Sold out'], 422);
        }

        $qty = max(1, (int) $request->input('qty', 1));

        if (Auth::check()) {
            $item = CartItem::firstOrNew([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
            ]);
            $item->qty = ($item->exists ? $item->qty : 0) + $qty;
            $item->save();
        } else {
            $cart     = (array) session('cart', []);
            $key      = $product->slug;
            $itemData = [
                'product_id'     => $product->id,
                'slug'           => $product->slug,
                'name'           => $product->name,
                'price'          => (float) $product->effective_price,
                'original_price' => (float) $product->price,
                'has_sale'       => (bool) $product->sale_price,
                'image'          => $product->image,
                'category_label' => $product->category_label ?? '',
                'qty'            => isset($cart[$key]) ? $cart[$key]['qty'] + $qty : $qty,
            ];
            $cart[$key] = $itemData;
            session(['cart' => $cart]);
        }

        return response()->json([
            'success' => true,
            'count'   => $this->getCartCount(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'slug' => 'required|string',
            'qty'  => 'required|integer|min:0',
        ]);

        $slug = $request->slug;
        $qty  = (int) $request->qty;

        if (Auth::check()) {
            $product = Product::where('slug', $slug)->first();
            if ($product) {
                if ($qty <= 0) {
                    CartItem::where(['user_id' => Auth::id(), 'product_id' => $product->id])->delete();
                } else {
                    CartItem::where(['user_id' => Auth::id(), 'product_id' => $product->id])
                        ->update(['qty' => $qty]);
                }
            }
        } else {
            $cart = (array) session('cart', []);
            if ($qty <= 0) {
                unset($cart[$slug]);
            } elseif (isset($cart[$slug])) {
                $cart[$slug]['qty'] = $qty;
            }
            session(['cart' => $cart]);
        }

        $cart     = $this->getCartArray();
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $shipping = $this->calcShipping($subtotal);

        return response()->json([
            'success'        => true,
            'count'          => $this->getCartCount(),
            'item_total'     => isset($cart[$slug]) ? number_format($cart[$slug]['price'] * $cart[$slug]['qty']) : '0',
            'subtotal'       => number_format($subtotal),
            'shipping_label' => $shipping === 0 ? 'Free' : 'KES ' . number_format($shipping),
            'total'          => number_format($subtotal + $shipping),
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate(['slug' => 'required|string']);

        $slug = $request->slug;

        if (Auth::check()) {
            $product = Product::where('slug', $slug)->first();
            if ($product) {
                CartItem::where(['user_id' => Auth::id(), 'product_id' => $product->id])->delete();
            }
        } else {
            $cart = (array) session('cart', []);
            unset($cart[$slug]);
            session(['cart' => $cart]);
        }

        $cart     = $this->getCartArray();
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $shipping = $this->calcShipping($subtotal);

        return response()->json([
            'success'        => true,
            'count'          => $this->getCartCount(),
            'empty'          => empty($cart),
            'subtotal'       => number_format($subtotal),
            'shipping_label' => $shipping === 0 ? 'Free' : 'KES ' . number_format($shipping),
            'total'          => number_format($subtotal + $shipping),
        ]);
    }

    public function count()
    {
        return response()->json(['count' => $this->getCartCount()]);
    }

    // ── Static helpers (used by CheckoutController) ───────────────────────────

    public static function resolveCart(): array
    {
        if (Auth::check()) {
            return static::dbCartToArray((int) Auth::id());
        }
        return (array) session('cart', []);
    }

    public static function clearCart(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function getCartArray(): array
    {
        return static::resolveCart();
    }

    private function getCartCount(): int
    {
        if (Auth::check()) {
            return (int) CartItem::where('user_id', Auth::id())->sum('qty');
        }
        return (int) array_sum(array_column(session('cart', []), 'qty'));
    }

    private function calcShipping(float $subtotal): int
    {
        return ($subtotal > 10000 || $subtotal == 0) ? 0 : 800;
    }

    private static function dbCartToArray(int $userId): array
    {
        $items = CartItem::where('user_id', $userId)
            ->with('product')
            ->get();

        $cart = [];
        foreach ($items as $item) {
            $p = $item->product;
            if (!$p || !$p->is_active) {
                continue;
            }
            $cart[$p->slug] = [
                'product_id'     => $p->id,
                'slug'           => $p->slug,
                'name'           => $p->name,
                'price'          => (float) $p->effective_price,
                'original_price' => (float) $p->price,
                'has_sale'       => (bool) $p->sale_price,
                'image'          => $p->image,
                'category_label' => $p->category_label ?? '',
                'qty'            => $item->qty,
            ];
        }
        return $cart;
    }
}
