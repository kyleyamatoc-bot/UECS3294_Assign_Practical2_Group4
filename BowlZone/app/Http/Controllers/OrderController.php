<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        return view('store.checkout', compact('cart', 'items'));
    }

    public function process(CheckoutRequest $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $method = $request->payment_method;
        $reference = null;

        if ($method === 'Card') {
            $reference = 'CARD-' . substr($request->card_number, -4);
        } elseif ($method === 'FPX') {
            $reference = 'FPX-' . strtoupper(substr($request->bank, 0, 3)) . rand(1000, 9999);
        } elseif ($method === 'E-Wallet') {
            $reference = 'WALLET-' . substr($request->wallet_phone, -4);
        }

        $order = DB::transaction(function () use ($request, $cart, $items, $method, $reference) {
            $total = (float) $items->sum('total_price');

            $order = Order::create([
                'user_id' => auth()->id(),
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'payment_method' => $method,
                'payment_reference' => $reference,
                'payment_status' => 'paid',
                'total_amount' => $total,
                'paid_at' => Carbon::now(),
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'variant' => $item->variant,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);
            }

            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('checkout.receipt', $order)->with('status', 'Checkout successful.');
    }

    public function receipt(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items');

        return view('store.receipt', compact('order'));
    }
}
