<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OnlineOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Add product to cart (AJAX).
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'    => 'nullable|integer|min:1',
        ]);

        $product  = Product::findOrFail($request->product_id);
        $qty      = $request->quantity ?? 1;
        $cart     = session()->get('cart', []);
        $id       = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $primaryImg = $product->product_images()->where('is_primary', 1)->first()
                       ?? $product->product_images()->first();

            $cart[$id] = [
                'name'     => $product->name,
                'price'    => $product->sale_price,
                'mrp'      => $product->mrp,
                'quantity' => $qty,
                'image'    => $primaryImg ? $primaryImg->image_url : null,
            ];
        }

        session()->put('cart', $cart);

        $totalItems = collect($cart)->sum('quantity');
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        // Generate mini cart items HTML
        $miniCartHtml = '';
        foreach ($cart as $id => $item) {
            $imgSrc = $item['image'] ? asset('storage/'.$item['image']) : '';
            $imgHtml = $item['image'] ? '<img src="'.$imgSrc.'" class="w-full h-full object-cover">' : '💊';
            $priceStr = number_format($item['price'], 2);
            $miniCartHtml .= '
            <div class="flex items-center gap-3 p-2 hover:bg-slate-50 rounded-xl transition-colors cart-item-row">
                <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                    '.$imgHtml.'
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-slate-800 truncate">'.$item['name'].'</p>
                    <p class="text-xs text-slate-500">'.$item['quantity'].' × ৳'.$priceStr.'</p>
                </div>
                <button type="button" onclick="removeFromCart('.$id.', this)" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>';
        }

        return response()->json([
            'success'    => true,
            'message'    => $product->name . ' added to cart!',
            'totalItems' => $totalItems,
            'subtotal'   => $subtotal,
            'miniCartHtml' => $miniCartHtml
        ]);
    }

    /**
     * Remove item from cart (AJAX).
     */
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $id   = $request->product_id;

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $totalItems = collect($cart)->sum('quantity');
        $subtotal   = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return response()->json([
            'success'    => true,
            'totalItems' => $totalItems,
            'subtotal'   => $subtotal,
        ]);
    }

    /**
     * Update quantity (AJAX).
     */
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id   = $request->product_id;
        $qty  = max(1, (int) $request->quantity);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $qty;
            session()->put('cart', $cart);
        }

        $totalItems = collect($cart)->sum('quantity');
        $subtotal   = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return response()->json([
            'success'    => true,
            'totalItems' => $totalItems,
            'subtotal'   => $subtotal,
        ]);
    }

    /**
     * Show checkout page.
     */
    public function checkout(Request $request)
    {
        // Handle direct "Buy Now" checkout without messing with main cart
        if ($request->has('buy_now_id')) {
            $product = Product::findOrFail($request->buy_now_id);
            $qty = max(1, (int) $request->input('qty', 1));
            
            $primaryImg = $product->product_images()->where('is_primary', 1)->first()
                       ?? $product->product_images()->first();

            $cart = [
                $product->id => [
                    'name'     => $product->name,
                    'price'    => $product->sale_price,
                    'mrp'      => $product->mrp,
                    'quantity' => $qty,
                    'image'    => $primaryImg ? $primaryImg->image_url : null,
                ]
            ];
            
            session()->put('buy_now_cart', $cart); // Store temporarily for place order
        } else {
            $cart = session()->get('cart', []);
            session()->forget('buy_now_cart'); // Clear any previous direct buys
        }

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $delivery = 60;
        $total    = $subtotal + $delivery;

        $user     = Auth::user();
        $customer = $user ? Customer::where('email', $user->email)->first() : null;

        $isBuyNow = $request->has('buy_now_id');

        return view('frontend.checkout.index', compact('cart', 'subtotal', 'delivery', 'total', 'user', 'customer', 'isBuyNow'));
    }

    /**
     * Place order.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $isBuyNow = $request->input('is_buy_now');
        $cart = $isBuyNow ? session()->get('buy_now_cart', []) : session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $delivery = 60;
        $total    = $subtotal + $delivery;

        $user     = Auth::user();
        $customer = $user ? Customer::where('email', $user->email)->first() : null;

        // Create order
        $order = OnlineOrder::create([
            'order_no'              => 'ORD-' . strtoupper(uniqid()),
            'customer_id'           => $customer->id ?? null,
            'status'                => 'pending',
            'payment_status'        => 'unpaid',
            'fulfillment_status'    => 'unfulfilled',
            'subtotal'              => $subtotal,
            'discount'              => 0,
            'delivery_charge'       => $delivery,
            'vat'                   => 0,
            'total'                 => $total,
            'prescription_required' => false,
        ]);

        // Clear respective cart
        if ($isBuyNow) {
            session()->forget('buy_now_cart');
        } else {
            session()->forget('cart');
        }

        return redirect()->route('order.success', $order->id);
    }

    /**
     * Order success page.
     */
    public function orderSuccess($orderId)
    {
        $order = OnlineOrder::findOrFail($orderId);
        return view('frontend.checkout.success', compact('order'));
    }
}
