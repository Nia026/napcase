<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;

class MetodePembayaranApiController extends Controller
{
    public function index()
    {
        return response()->json(MetodePembayaran::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $method = MetodePembayaran::create($validated);

        return response()->json([
            'message' => 'Metode pembayaran berhasil ditambahkan',
            'data' => $method
        ], 201);
    }

    public function show($id)
    {
        $method = MetodePembayaran::findOrFail($id);
        return response()->json($method);
    }

    public function update(Request $request, $id)
    {
        $method = MetodePembayaran::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'value' => 'sometimes|required|string|max:255',
        ]);

        $method->update($validated);

        return response()->json([
            'message' => 'Metode pembayaran berhasil diperbarui',
            'data' => $method
        ]);
    }

    public function destroy($id)
    {
        $method = MetodePembayaran::findOrFail($id);
        $method->delete();

        return response()->json([
            'message' => 'Metode pembayaran berhasil dihapus'
        ]);
    }
}
