<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Keranjang Belanja</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body class="bg-gray-100 font-sans">

  {{-- Navbar Component --}}
  <x-navbar />

  <main class="container mx-auto px-4 py-10">
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
        <li class="flex items-center py-6 px-6 border-b flex-wrap md:flex-nowrap">
          <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-24 h-24 object-cover rounded-md mr-6">

          <div class="flex-grow mb-4 md:mb-0">
            <h3 class="text-lg font-semibold text-gray-800">{{ $item['name'] }}</h3>
            <p class="text-gray-600 text-sm mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
          </div>

          <div class="flex items-center space-x-4">
            <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center space-x-2">
              @csrf
              @method('PUT')

              <button type="button" onclick="changeQuantity('{{ $productId }}', -1)"
                class="w-8 h-8 flex items-center justify-center bg-gray-300 hover:bg-gray-400 text-black rounded-md">-</button>

              <input type="number" id="qty-{{ $productId }}" name="quantity" value="{{ $item['quantity'] }}" min="1"
                class="w-12 text-center border border-gray-300 rounded-md bg-gray-100 px-2 py-1" readonly>

              <button type="button" onclick="changeQuantity('{{ $productId }}', 1)"
                class="w-8 h-8 flex items-center justify-center bg-gray-300 hover:bg-gray-400 text-black rounded-md">+</button>
            </form>

            <form action="{{ route('cart.remove', $productId) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700 text-xl">
                <i class="fas fa-trash-alt"></i>
              </button>
            </form>
          </div>
        </li>
        @endforeach
      </ul>

      <div class="p-6 border-t">
        <div class="flex justify-between font-semibold text-gray-700 mb-4">
          <span>Subtotal</span>
          @php
          $subtotal = 0;
          foreach ($cartItems as $item) {
          $subtotal += $item['price'] * $item['quantity'];
          }
          @endphp
          <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <a href="{{ route('checkout.form') }}"
          class="block w-full bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full text-center">
          <i class="fas fa-check mr-2"></i> Checkout
        </a>
      </div>
    </div>
    @endif
  </main>

  {{-- Footer Component --}}
  <x-footer />

  <script>
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

      const form = qtyInput.closest('form');
      const formData = new FormData(form);
      formData.set('quantity', quantity);

      fetch(form.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-HTTP-Method-Override': 'PUT'
        },
        body: formData
      }).then(response => {
        if (response.ok) return response.text();
      }).then(() => {
        location.reload();
      }).catch(error => console.error(error));
    }
  </script>
</body>

</html>