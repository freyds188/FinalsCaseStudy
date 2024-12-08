<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)->with('product')->get();
        return response()->json($cart);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $cart = Cart::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json(['message' => 'Cart updated successfully', 'cart' => $cart]);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $this->authorize('cart-owner', $cart);

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cart updated successfully']);
    }

    public function remove($id)
    {
        $cart = Cart::findOrFail($id);
        $this->authorize('cart-owner', $cart);

        $cart->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }
}
