<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_details' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $user = $request->user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'shipping_details' => $request->shipping_details,
            'payment_method' => $request->payment_method,
        ]);

        $cartItems->each(function ($item) {
            $item->product->decrement('quantity', $item->quantity);
            $item->delete();
        });

        return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
    }
}
