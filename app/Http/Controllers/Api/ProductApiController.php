<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProductApiController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('image')->store('public/images', 'public');

        $imageName = str_replace('public/', 'storage/', $path);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $imageName
        ]);

        return response()->json($product, 201);
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $product->image = asset($product->image);
        return response()->json($product);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->name ?? $product->name;
        $product->description = $request->description ?? $product->description;
        $product->price = $request->price ?? $product->price;
        $product->category = $request->category ?? $product->category;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists(str_replace('/storage/', 'public/', $product->image))) {
                Storage::delete(str_replace('/storage/', 'public/', $product->image));
            }

            $path = $request->file('image')->store('public/images');
            $product->image = Storage::url($path);
        }

        $product->save();

        return response()->json($product);
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::exists(str_replace('/storage/', 'public/', $product->image))) {
            Storage::delete(str_replace('/storage/', 'public/', $product->image));
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
