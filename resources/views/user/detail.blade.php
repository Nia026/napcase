<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Detail Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100 font-sans">
  <header class="bg-white shadow-md sticky top-0 z-10">
    <nav class="container mx-auto px-4 py-3 flex items-center justify-between">
      <div class="logo">
        <a href="/home" class="text-xl font-semibold text-gray-800">Nap<span class="text-indigo-600">Case</span></a>
      </div>
      <div class="flex items-center space-x-4">
        <a href="/home" class="text-gray-700 hover:text-indigo-600 transition duration-300">
          <i class="fas fa-arrow-left mr-1"></i> Kembali ke Produk
        </a>
        <a href="/cart" class="relative text-gray-700 hover:text-indigo-600 transition duration-300">
          <i class="fas fa-shopping-cart mr-1"></i> Keranjang
          <span id="cart-item-count"
            class="absolute top-[-8px] right-[-8px] bg-red-500 text-white text-xs rounded-full px-2 py-0.5">0</span>
        </a>
      </div>
    </nav>
  </header>

  <main class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="md:flex">
        <div class="md:w-1/2 p-6">
          <img id="detail-image" src="https://via.placeholder.com/400" alt="Detail Produk"
            class="w-full h-auto object-cover rounded-md">
        </div>
        <div class="md:w-1/2 p-6">
          <h1 id="detail-name" class="text-2xl font-semibold text-gray-800 mb-3">Nama Produk</h1>
          <p id="detail-description" class="text-gray-700 text-sm mb-4">Deskripsi produk yang panjang dan detail akan
            muncul di sini.</p>
          <p class="text-gray-600 mb-2">Kategori: <span id="detail-category"
              class="font-semibold text-indigo-600">Kategori Produk</span></p>
          <p class="text-xl font-bold text-indigo-600 mb-4">Harga: Rp <span id="detail-price">100.000</span></p>
          <form id="add-to-cart-form" method="POST" action="">
            @csrf
            <button type="submit"
              class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline transition duration-300">
              <i class="fas fa-cart-plus mr-2"></i> Masukkan ke Keranjang
            </button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <footer class="text-center py-6 text-sm text-gray-500 bg-white mt-8">
    &copy; {{ date('Y') }} Napcase. All rights reserved.
  </footer>

  <script>
    const detailImage = document.getElementById('detail-image');
    const detailName = document.getElementById('detail-name');
    const detailDescription = document.getElementById('detail-description');
    const detailPrice = document.getElementById('detail-price');
    const detailCategory = document.getElementById('detail-category');
    const cartItemCountSpan = document.getElementById('cart-item-count');

    // Ambil keranjang dari sessionStorage (lebih aman jika backend handle cart)
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function updateCartItemCount() {
      const count = cart.reduce((sum, item) => sum + item.quantity, 0);
      if (count === 0) {
        cartItemCountSpan.style.display = 'none';
      } else {
        cartItemCountSpan.textContent = count;
        cartItemCountSpan.style.display = 'inline-block';
      }
    }

    function getProductDetail() {
      const pathSegments = window.location.pathname.split('/');
      const productId = parseInt(pathSegments[pathSegments.length - 1]);

      if (productId) {
        fetch(`/api/products/${productId}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Produk tidak ditemukan');
            }
            return response.json();
          })
          .then(product => {
            detailImage.src = product.image;
            detailImage.alt = product.name;
            detailName.textContent = product.name;
            detailDescription.textContent = product.description;
            detailPrice.textContent = parseFloat(product.price).toLocaleString();
            detailCategory.textContent = product.category;
            document.getElementById('add-to-cart-form').action = `/cart/add/${product.id}`;
          })
          .catch(error => {
            console.error('Error fetching product detail:', error);
            document.querySelector('main').innerHTML = `
            <div class="text-center text-red-600 mt-8">
              <p>${error.message}</p>
              <a href="/home" class="mt-4 inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-300">Kembali</a>
            </div>`;
          });
      } else {
        document.querySelector('main').innerHTML = `
        <div class="text-center text-red-600 mt-8">
          <p>ID produk tidak valid.</p>
          <a href="/home" class="mt-4 inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-300">Kembali</a>
        </div>`;
      }
    }

    updateCartItemCount();
    getProductDetail();
  </script>


</body>

</html>