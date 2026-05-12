<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_column($cart, 'subtotal'));

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (isset($cart[$product->id])) {
            $quantity += $cart[$product->id]['quantity'];
        }

        if ($quantity > $product->stock) {
            return back()->with('error', 'Not enough stock available!');
        }

        $cart[$product->id] = [
            'name'     => $product->name,
            'price'    => $product->price,
            'quantity' => $quantity,
            'image'    => $product->image,
            'subtotal' => $product->price * $quantity,
        ];

        session()->put('cart', $cart);

        return back()->with('success', 'Item added to cart!');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            $cart[$productId]['subtotal'] =
                $cart[$productId]['price'] * $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Cart cleared!');
    }
}