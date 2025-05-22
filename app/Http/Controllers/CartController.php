<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = session('cart', []); // Ambil data keranjang dari session
        return view('user.cart', compact('cartItems')); // Tampilkan view cart.blade.php
    }

    public function update(Request $request, $productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = max(1, (int) $request->input('quantity'));
        }

        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui!');
    }

    public function remove($productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang!');
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}
