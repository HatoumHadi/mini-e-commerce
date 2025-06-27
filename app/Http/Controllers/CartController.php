<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Product $product, Request $request)
    {
        $quantity = (int) $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        $existingQuantity = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        $newTotalQuantity = $existingQuantity + $quantity;

        if ($newTotalQuantity > $product->stock) {
            return redirect()->route('cart.index')->with('error', "Only {$product->stock} item(s) of {$product->name} available in stock.");
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $newTotalQuantity;
        } else {
            $cart[$product->id] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $product->price
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }


    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }


    public function update(Product $product, Request $request)
    {
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }
}
