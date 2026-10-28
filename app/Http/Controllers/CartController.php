<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = Session::get('coupon', null);
        $discount = 0;

        if ($coupon) {
            $activeCoupon = Promotion::where('code', $coupon['code'])->where('status', 'Active')->first();
            if (!$activeCoupon || ($activeCoupon->expires_at && $activeCoupon->expires_at->isPast())) {
                Session::forget('coupon');
                $coupon = null;
            } else {
                $discount = ($subtotal * $coupon['percent']) / 100;
            }
        }

        // Fetch currently active and non-expired promotions
        $activePromotions = Promotion::where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->orderBy('id', 'desc')
            ->get();

        $hasActivePromotions = $activePromotions->isNotEmpty();

        $shipping = $subtotal >= 50 || empty($cart) ? 0 : 5.00;
        $total = max(0, $subtotal - $discount + $shipping);

        $cartProductIds = array_filter(array_column($cart, 'id'));
        $suggestedProducts = Product::where('in_stock', true)
            ->where('stock', '>', 0)
            ->whereNotIn('id', $cartProductIds)
            ->inRandomOrder()
            ->take(4)
            ->get();

        if ($suggestedProducts->isEmpty()) {
            $suggestedProducts = Product::where('in_stock', true)
                ->where('stock', '>', 0)
                ->take(4)
                ->get();
        }

        return view('frontend.cart', compact('cart', 'subtotal', 'discount', 'shipping', 'total', 'coupon', 'suggestedProducts', 'activePromotions', 'hasActivePromotions'));
    }

    public function clear()
    {
        Session::forget('cart');
        Session::forget('coupon');
        return redirect()->route('cart.index')->with('success', 'Your cart has been cleared.');
    }


    public function buyNow(Request $request, $id)
    {
        $request->merge(['action' => 'buy_now']);
        return $this->add($request, $id);
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->isOutOfStock()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Sorry, '{$product->name}' is currently out of stock (Stockout)!",
                ], 422);
            }
            return redirect()->back()->with('error', "Sorry, '{$product->name}' is currently out of stock (Stockout)!");
        }

        $isBuyNow = ($request->input('action') === 'buy_now' || $request->has('buy_now'));
        $cart = Session::get('cart', []);

        $size = $request->input('size', 'L');
        $color = $request->input('color', $product->color ?? 'Standard');
        $qty = max(1, (int) $request->input('quantity', 1));

        // Unique cart key by id + size + color
        $cartKey = $id . '_' . $size . '_' . strtolower(str_replace(' ', '', $color));

        $existingQty = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
        if (($existingQty + $qty) > $product->stock) {
            if ($isBuyNow && $existingQty > 0) {
                // If user clicks Buy Now and already has items in cart, proceed straight to checkout
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'redirect' => route('checkout.index'),
                    ]);
                }
                return redirect()->route('checkout.index')->with('info', "'{$product->name}' is already in your bag. Proceeding to checkout!");
            }
            $available = max(0, $product->stock - $existingQty);
            $msg = "Only {$product->stock} total units of '{$product->name}' in stock. You already have {$existingQty} in your cart.";
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $qty;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'size' => $size,
                'color' => $color,
                'quantity' => $qty,
            ];
        }

        Session::put('cart', $cart);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($isBuyNow) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('checkout.index'),
                    'cartCount' => $cartCount,
                ]);
            }
            return redirect()->route('checkout.index')->with('success', "Ready for checkout with {$product->name}!");
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Added {$product->name} (Size: {$size}) to your cart!",
                'cartCount' => $cartCount,
                'item' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price, 2),
                    'image' => asset($product->image),
                    'size' => $size,
                    'quantity' => $qty,
                ],
            ]);
        }

        return redirect()->back()->with('success', "Added {$product->name} (Size: {$size}) to your cart!");
    }

    public function update(Request $request, $key)
    {
        $cart = Session::get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$key])) {
            if ($quantity > 0) {
                $productId = $cart[$key]['id'] ?? null;
                if ($productId) {
                    $product = Product::find($productId);
                    if ($product) {
                        if ($product->isOutOfStock()) {
                            unset($cart[$key]);
                            Session::put('cart', $cart);
                            return redirect()->route('cart.index')->with('error', "'{$product->name}' is now out of stock (Stockout) and was removed from your cart.");
                        }
                        if ($quantity > $product->stock) {
                            return redirect()->route('cart.index')->with('error', "Cannot set quantity to {$quantity}. Only {$product->stock} units available for '{$product->name}'.");
                        }
                    }
                }
                $cart[$key]['quantity'] = $quantity;
            } else {
                unset($cart[$key]);
            }
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function remove($key)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $code = strtoupper(trim($request->input('coupon_code', '')));

        if (empty($code)) {
            return redirect()->back()->with('error', 'Please enter a coupon code.');
        }

        $activeCount = Promotion::where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })->count();

        if ($activeCount === 0) {
            Session::forget('coupon');
            return redirect()->back()->with('error', 'No active promotional campaigns are currently available.');
        }

        $promo = Promotion::where('code', $code)->first();

        if (!$promo) {
            return redirect()->back()->with('error', "Coupon code '{$code}' does not exist or has expired.");
        }

        if ($promo->status !== 'Active') {
            Session::forget('coupon');
            return redirect()->back()->with('error', "Coupon code '{$code}' is currently {$promo->status}.");
        }

        if ($promo->expires_at && $promo->expires_at->isPast()) {
            Session::forget('coupon');
            return redirect()->back()->with('error', "Coupon code '{$code}' expired on " . $promo->expires_at->format('M d, Y') . ".");
        }

        // Check minimum spend if configured
        $cart = Session::get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        if ($promo->min_spend > 0 && $subtotal < $promo->min_spend) {
            return redirect()->back()->with('error', "Coupon '{$code}' requires a minimum order of $" . number_format($promo->min_spend, 2) . ".");
        }

        Session::put('coupon', [
            'id' => $promo->id,
            'code' => $promo->code,
            'percent' => $promo->discount_percent,
        ]);

        return redirect()->back()->with('success', "Coupon '{$promo->code}' applied! You saved {$promo->discount_percent}% off your cart.");
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        return redirect()->back()->with('info', 'Coupon removed.');
    }
}