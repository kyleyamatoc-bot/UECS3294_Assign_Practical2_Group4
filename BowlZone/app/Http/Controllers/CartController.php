<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->currentCart();
        $items = $cart->items()->with('product')->get();

        return view('store.cart', compact('cart', 'items'));
    }

    public function store(AddToCartRequest $request)
    {
        $cart = $this->currentCart();
        $product = Product::findOrFail($request->product_id);

        $variant = $request->variant;
        if ($product->variant_type && empty($variant)) {
            return back()->withErrors(['variant' => 'Please select a product ' . $product->variant_type . '.']);
        }

        if ($product->variant_options && $variant && !in_array($variant, $product->variant_options, true)) {
            return back()->withErrors(['variant' => 'Invalid variant selected.']);
        }

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('variant', $variant)
            ->first();

        if ($item) {
            $item->quantity += (int) $request->quantity;
            $item->total_price = $item->quantity * $item->unit_price;
            $item->save();
        } else {
            $qty = (int) $request->quantity;
            $cart->items()->create([
                'product_id' => $product->id,
                'variant' => $variant,
                'quantity' => $qty,
                'unit_price' => $product->price,
                'total_price' => $qty * $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('status', 'Item added to cart.');
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $this->authorizeItem($cartItem);

        $qty = (int) $request->quantity;
        $cartItem->update([
            'quantity' => $qty,
            'total_price' => $qty * $cartItem->unit_price,
        ]);

        return back()->with('status', 'Cart item updated.');
    }

    public function destroy(CartItem $cartItem)
    {
        $this->authorizeItem($cartItem);
        $cartItem->delete();

        return back()->with('status', 'Item removed from cart.');
    }

    private function currentCart()
    {
        return Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);
    }

    private function authorizeItem(CartItem $cartItem)
    {
        if ((int) $cartItem->cart->user_id !== (int) auth()->id()) {
            abort(403);
        }
    }
}
