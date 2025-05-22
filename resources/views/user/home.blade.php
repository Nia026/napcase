<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage User</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    /* Efek hover sederhana untuk produk */
    .product-item:hover {
      transform: scale(1.02);
      transition: transform 0.2s ease-in-out;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  </style>
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
        <a href="/info.html" class="text-gray-700 hover:text-indigo-600 transition duration-300">
          <i class="fas fa-info-circle mr-1"></i> Informasi Pemesanan
        </a>
        <a href="/cart" class="relative text-gray-700 hover:text-indigo-600 transition duration-300">
          <i class="fas fa-shopping-cart mr-1"></i> Keranjang
        </a>
      </div>
    </nav>
  </header>

  <main class="container mx-auto px-4 py-8">
    <section id="product-list">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Daftar Casing</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      </div>
    </section>
  </main>

  <footer class="text-center py-6 text-sm text-gray-500 bg-white mt-8">
    &copy; {{ date('Y') }} Napcase. All rights reserved.
  </footer>

  <script>
    const productListSection = document.getElementById('product-list').querySelector('.grid');
    const searchInput = document.getElementById('search-input');
    let productsData = []; // Menyimpan semua data produk dari API

    function fetchProducts() {
      fetch('/api/products') // Pastikan URL ini benar
        .then(response => response.json())
        .then(data => {
          productsData = data; // Simpan data ke variabel global
          renderProducts(data);
        })
        .catch(error => {
          console.error('Error fetching products:', error);
          productListSection.innerHTML = '<p class="text-red-500">Gagal memuat produk.</p>';
        });
    }

    function renderProducts(products) {
      productListSection.innerHTML = '';
      if (products.length === 0) {
        productListSection.innerHTML = '<p class="text-gray-600">Tidak ada produk yang ditemukan.</p>';
        return;
      }
      products.forEach(product => {
        const productDiv = document.createElement('div');
        productDiv.classList.add('product-item', 'bg-white', 'rounded-lg', 'shadow-md', 'overflow-hidden');
        productDiv.innerHTML = `
                            <div class="p-4"> <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover">
                                <h3 class="text-lg font-semibold text-gray-800 mt-4 mb-2">${product.name}</h3>
                                <p class="text-gray-600 text-sm mb-3">${product.description ? product.description.substring(0, 50) + '...' : ''}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-indigo-600 font-bold">Rp ${parseFloat(product.price).toLocaleString()}</span>
                                    <a href="/product/${product.id}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-300">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        `;
        productListSection.appendChild(productDiv);
      });
    }

    // Fitur Pencarian
    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const filteredProducts = productsData.filter(product =>
        product.name.toLowerCase().includes(searchTerm)
      );
      renderProducts(filteredProducts);
    });

    fetchProducts();
  </script>
</body>

</html>