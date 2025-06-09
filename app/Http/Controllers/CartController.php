<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\MetodePembayaran;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = session('cart', []);
        return view('user.cart', compact('cartItems'));
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
        try {
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

            // Periksa apakah request ingin JSON (dari fetch)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Produk berhasil ditambahkan ke keranjang!',
                    'cart' => $cart
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat menambahkan ke keranjang.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan.');
        }
    }

    public function showCheckout()
    {
        $cartItems = session()->get('cart', []);
        $metodePembayaran = MetodePembayaran::all();

        return view('user.checkout', compact('cartItems', 'metodePembayaran'));
    }
}
