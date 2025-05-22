<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-..." />
</head>

<body class="bg-gray-100 font-sans">
  <header class="bg-white shadow-md sticky top-0 z-10">
    <nav class="container mx-auto px-4 py-3 flex items-center justify-between">
      <div class="logo">
        <a href="/home" class="text-xl font-semibold text-gray-800">Nap<span class="text-indigo-600">Case</span></a>
      </div>
      <div class="flex items-center space-x-4">
        <div class="relative">
          <input type="text" id="search-input"
            class="bg-gray-100 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="Cari casing...">
          <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <a href="/home" class="text-gray-700 hover:text-indigo-600 transition duration-300"> Home
        </a>
        <a href="#" class="relative text-gray-700 hover:text-indigo-600 transition duration-300">
          <i class="fas fa-info-circle mr-1"></i> Informasi Pemesanan
        </a>
      </div>
    </nav>
  </header>

  <main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Keranjang Belanja Anda</h2>

    @if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 rounded-md mb-4">{{ session('success') }}</div>
    @endif

    @if(empty($cartItems))
    <p class="text-gray-500">Keranjang Anda kosong.</p>
    @else
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <ul>
        @foreach($cartItems as $productId => $item)
        <li class="flex items-center py-4 px-6 border-b">
          <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-md mr-4">
          <div class="flex-grow">
            <h3 class="text-lg font-semibold text-gray-800">{{ $item['name'] }}</h3>
            <p class="text-gray-600 text-sm">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
          </div>
          <div class="flex items-center space-x-2">
            <form action="{{ route('cart.update', $productId) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="flex items-center space-x-2">
                <button type="button" onclick="changeQuantity('{{ $productId }}', -1)"
                  class="bg-gray-300 hover:bg-gray-400 text-black px-2 py-1 rounded">-</button>
                <input type="number" id="qty-{{ $productId }}" name="quantity" value="{{ $item['quantity'] }}" min="1"
                  class="w-12 text-center border border-gray-300 rounded-md" readonly>
                <button type="button" onclick="changeQuantity('{{ $productId }}', 1)"
                  class="bg-gray-300 hover:bg-gray-400 text-black px-2 py-1 rounded">+</button>
              </div>
            </form>
            <form action="{{ route('cart.remove', $productId) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                <i class="fas fa-trash-alt"></i>
              </button>
            </form>
          </div>
        </li>
        @endforeach
      </ul>

      <div class="p-6 border-t">
        <div class="flex justify-between font-semibold text-gray-700">
          <span>Subtotal</span>
          @php
          $subtotal = 0;
          foreach ($cartItems as $item) {
          $subtotal += $item['price'] * $item['quantity'];
          }
          @endphp
          <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <button
          class="w-full bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline transition duration-300 mt-4">
          <i class="fas fa-check mr-2"></i> Checkout
        </button>
      </div>
    </div>
    @endif
  </main>

  <footer class="text-center py-6 text-sm text-gray-500 bg-white mt-8">
    &copy; {{ date('Y') }} Napcase. All rights reserved.
  </footer>


  <script>
    // Anda mungkin perlu menyesuaikan cara data keranjang disimpan dan diambil
    const cartItemCountSpan = document.getElementById('cart-item-count');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function updateCartItemCount() {
      if (cartItemCountSpan) {
        cartItemCountSpan.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
      }
    }

    updateCartItemCount();

    function changeQuantity(productId, change) {
      const qtyInput = document.getElementById(`qty-${productId}`);
      let quantity = parseInt(qtyInput.value) + change;
      if (quantity < 1) return;

      qtyInput.value = quantity;

      // Submit form secara otomatis
      const form = qtyInput.closest('form');
      const formData = new FormData(form);
      formData.set('quantity', quantity); // pastikan quantity dikirim

      fetch(form.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-HTTP-Method-Override': 'PUT' // untuk method spoofing
        },
        body: formData
      }).then(response => {
        if (response.ok) {
          return response.text();
        }
      }).then(() => {
        // Reload untuk update subtotal
        location.reload();
      }).catch(error => console.error(error));
    }
  </script>
</body>

</html>