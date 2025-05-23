<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductApiController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        Log::info('Nama:', ['name' => $request->input('name')]);
        Log::info('Data yang Diterima:', $request->all());

        try {
            // Validasi input
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'category' => 'required',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            ]);

            // Simpan gambar ke public storage
            if (!$request->hasFile('image')) {
                Log::error('Gambar tidak ditemukan di request.');
                return response()->json(['error' => 'Gambar tidak ditemukan'], 400);
            }

            $path = $request->file('image')->store('images', 'public'); // simpan ke storage/app/public/images
            $imageName = Storage::url($path); // hasilnya: /storage/images/namafile.jpg

            Log::info('Gambar berhasil disimpan di: ' . $imageName);

            // Simpan data ke database
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category' => $request->category,
                'image' => $imageName
            ]);

            Log::info('Produk berhasil ditambahkan', ['product' => $product]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            // Tangkap kesalahan dan tulis ke log
            Log::error('Gagal menambah produk: ' . $e->getMessage());

            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan produk',
                'error' => $e->getMessage()
            ], 500);
        }
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

    public function update(Request $request, $id)
    {
        Log::info("Memulai update produk", ['id' => $id]);

        try {
            $product = Product::findOrFail($id);

            Log::info("Data request", $request->all());

            // Validasi input
            $validated = $request->validate([
                'name' => 'nullable|string',
                'description' => 'nullable|string',
                'category' => 'nullable|string',
                'price' => 'nullable|numeric',
                'image' => 'nullable|image|max:5120',
            ]);

            // Cek dan proses gambar baru jika ada
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

            // Update produk dengan data terbaru
            $product->update($validated);

            Log::info("Produk berhasil diupdate", ['product' => $product]);

            return response()->json([
                'message' => 'Produk berhasil diupdate',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan saat update produk", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Gagal update produk',
                'error' => $e->getMessage()
            ], 500);
        }
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
