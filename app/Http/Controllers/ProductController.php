<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('user.detail', compact('product'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('image')->store('images', 'public');
        $imageName = Storage::url($path);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $imageName
        ]);

        return redirect('admin/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('image')) {
            Log::info("Gambar ditemukan, memproses...");

            // Hapus gambar lama jika ada
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
                Log::info("Gambar lama dihapus", ['path' => $product->image]);
            } else {
                Log::info("Gambar lama tidak ditemukan atau sudah dihapus sebelumnya");
            }

            // Simpan gambar baru
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $validated['image'] = '/storage/' . $path;

            Log::info("Gambar baru disimpan", ['path' => $validated['image']]);
        } else {
            Log::info("Tidak ada file image dalam request");
        }

        $product->update($validated);

        return redirect('admin/products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Hapus gambar dari storage jika ada
        if ($product->image && Storage::exists(str_replace('/storage/', 'public/', $product->image))) {
            Storage::delete(str_replace('/storage/', 'public/', $product->image));
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }
}
