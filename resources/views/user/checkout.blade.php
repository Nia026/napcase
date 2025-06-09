<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout - Napcase</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body class="bg-gray-100 font-sans">

  {{-- Navbar Component --}}
  <x-navbar />

  <main class="container mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h2>

    @if(empty($cartItems))
    <p class="text-gray-500">Keranjang Anda kosong.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      {{-- LEFT: List Produk --}}
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Barang yang Dibeli</h3>
        <ul>
          @php $total = 0; @endphp
          @foreach($cartItems as $item)
          @php
          $subtotal = $item['price'] * $item['quantity'];
          $total += $subtotal;
          @endphp
          <li class="flex items-center border-b py-4">
            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-md mr-4">
            <div class="flex-grow">
              <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
              <p class="text-sm text-gray-600">Rp {{ number_format($item['price'], 0, ',', '.') }} x
                {{ $item['quantity'] }}
              </p>
            </div>
            <div class="font-semibold text-gray-700">
              Rp {{ number_format($subtotal, 0, ',', '.') }}
            </div>
          </li>
          @endforeach
        </ul>
        <div class="mt-4 flex justify-between text-lg font-semibold text-gray-800 border-t pt-4">
          <span>Total</span>
          <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
      </div>

      {{-- RIGHT: Form Checkout --}}
      <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-lg shadow-md p-6">
        @csrf
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Informasi Pemesanan</h3>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Nama</label>
          <input type="text" name="nama" required class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm
           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
          <input type="text" name="telepon" required class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm
           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Alamat</label>
          <textarea name="alamat" rows="3" required class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm
           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Metode Pembayaran</label>
          <div class="space-y-2">
            @foreach ($metodePembayaran as $metode)
            <label
              class="flex items-start space-x-2 border border-gray-300 rounded-md p-3 cursor-pointer hover:border-indigo-500">
              <input type="radio" name="metode_pembayaran_id" value="{{ $metode->id }}" required class="mt-1">
              <div>
                <p class="font-medium text-gray-800">{{ $metode->name }}</p>
                <p class="text-sm text-gray-600">Nomor Rekening: <span class="font-semibold">{{ $metode->value }}</span>
                </p>
              </div>
            </label>
            @endforeach
          </div>
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700">Upload Bukti Pembayaran</label>
          <input type="file" name="bukti_pembayaran" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <button type="submit"
          class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">
          <i class="fas fa-paper-plane mr-2"></i> Kirim Pesanan
        </button>
      </form>
    </div>
    @endif
  </main>

  {{-- Footer Component --}}
  <x-footer />

</body>

</html>