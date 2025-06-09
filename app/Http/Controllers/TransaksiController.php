<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('detailTransaksis')->get();
        return response()->json($transaksis);
    }

    public function checkoutForm()
    {
        $cartItems = session('cart', []);
        $metodePembayaran = MetodePembayaran::all();

        return view('user.checkout', compact('cartItems', 'metodePembayaran'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksis')->find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    }

    public function storeCheckout(Request $request)
    {
        Log::info('Masuk ke storeCheckout');

        $request->validate([
            'nama' => 'required|string',
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        Log::info('Validasi berhasil');

        $buktiPath = $request->file('bukti_pembayaran')->store('images', 'public');

        Log::info('Bukti pembayaran disimpan', ['path' => $buktiPath]);

        $cartItems = session('cart', []);
        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        try {
            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'nama' => $request->nama,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'metode_pembayaran_id' => $request->metode_pembayaran_id,
                'bukti_pembayaran' => $buktiPath,
                'total' => $total,
                'status' => 'transaksi terkirim ke admin',
            ]);

            Log::info('Transaksi berhasil dibuat', ['id' => $transaksi->id]);
            Log::info('User ID:', ['id' => auth()->id()]);

            foreach ($cartItems as $productId => $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            session()->forget('cart');
            Log::info('Cart dikosongkan, redirect ke /home');
            return redirect('/home')->with('success', 'Transaksi berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Gagal simpan transaksi', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Hapus relasi detail terlebih dahulu jika perlu
        $transaksi->detailTransaksis()->delete();
        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus']);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nama' => 'string|nullable',
            'telepon' => 'string|nullable',
            'alamat' => 'string|nullable',
            'metode_pembayaran_id' => 'exists:metode_pembayarans,id|nullable',
            'status' => 'string|nullable',
        ]);

        $transaksi->update($validated);

        return response()->json(['message' => 'Transaksi berhasil diupdate', 'data' => $transaksi]);
    }

    public function getByUser($id)
    {
        try {
            $transaksi = Transaksi::with('detailTransaksis')
                ->where('user_id', $id)
                ->get();
            return response()->json($transaksi);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function konfirmasiSelesai($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        // Simpan riwayat terlebih dahulu jika diperlukan
        // Misal: RiwayatTransaksi::create([...])
        $transaksi->delete(); // hapus transaksi setelah selesai
        return response()->json(['message' => 'Transaksi selesai']);
    }
}
