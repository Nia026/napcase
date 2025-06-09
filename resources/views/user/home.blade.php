<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Homepage User - NapCase</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100 font-sans">

  <x-navbar />

  <main class="container mx-auto px-4 py-8">
    <!-- Banner -->
    <section class="mb-8 rounded-lg overflow-hidden shadow-md">
      <img src="{{ asset('images/benner.png') }}" alt="Banner Promo" class="w-full h-auto object-cover">
    </section>

    <!-- Produk -->
    <section>
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Casing Terbaru & Populer</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="product-grid">
        <!-- Produk akan dimuat via fetch -->
      </div>
    </section>
  </main>

  <x-footer />

  <!-- Notifikasi keranjang -->
  <div id="cart-notification"
    class="fixed bottom-6 right-6 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-4 opacity-0 pointer-events-none transition-opacity duration-500 z-50">
    <i class="fas fa-check-circle text-white text-xl"></i>
    <span id="cart-notification-message">Produk berhasil ditambahkan ke keranjang!</span>
    <button onclick="closeCartNotification()"
      class="ml-2 text-white hover:text-gray-200 text-xl font-bold">&times;</button>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const productGrid = document.getElementById("product-grid");
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      function showCartNotification(message = "Produk berhasil ditambahkan ke keranjang!") {
        const notification = document.getElementById("cart-notification");
        const messageEl = document.getElementById("cart-notification-message");

        messageEl.textContent = message;
        notification.classList.remove("opacity-0", "pointer-events-none");
        notification.classList.add("opacity-100");

        setTimeout(() => {
          notification.classList.add("opacity-0", "pointer-events-none");
          notification.classList.remove("opacity-100");
        }, 3000);
      }

      function closeCartNotification() {
        const notification = document.getElementById("cart-notification");
        notification.classList.add("opacity-0", "pointer-events-none");
        notification.classList.remove("opacity-100");
      }

      function fetchProducts() {
        fetch("/api/products")
          .then(res => res.json())
          .then(products => {
            if (!Array.isArray(products) || products.length === 0) {
              productGrid.innerHTML =
                '<p class="text-gray-600 col-span-full text-center">Tidak ada produk ditemukan.</p>';
              return;
            }

            products.forEach(product => {
              const div = document.createElement("div");
              div.className =
                "product-item bg-white rounded-lg shadow-md overflow-hidden flex flex-col hover:scale-105 transition-transform duration-200";
              div.innerHTML = `
                <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover">
                <div class="p-4 flex-grow flex flex-col justify-between">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">${product.name}</h3>
                    <p class="text-gray-600 text-sm mb-3">
                      ${product.description ? product.description.slice(0, 70) + '...' : 'Tidak ada deskripsi.'}
                    </p>
                  </div>
                  <div class="mt-auto">
                    <div class="flex items-center justify-between mb-3">
                      <span class="text-indigo-600 font-bold text-lg">Rp ${parseFloat(product.price).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="flex flex-col space-y-2">
                      <a href="/product/${product.id}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-full transition duration-300">
                        Lihat Detail
                      </a>
                      <form method="POST" class="add-to-cart-form" data-id="${product.id}">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <button type="submit" class="w-full text-center bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full transition duration-300">
                          <i class="fas fa-cart-plus mr-2"></i> Tambahkan ke Keranjang
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              `;
              productGrid.appendChild(div);
            });

            attachAddToCartEvents();
          })
          .catch(err => {
            productGrid.innerHTML = '<p class="text-red-500 col-span-full text-center">Gagal memuat produk.</p>';
            console.error(err);
          });
      }

      function attachAddToCartEvents() {
        document.querySelectorAll(".add-to-cart-form").forEach(form => {
          form.addEventListener("submit", function(e) {
            e.preventDefault();
            const productId = this.getAttribute("data-id");

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('quantity', 1);

            fetch("/cart/add/" + productId, {
                method: "POST",
                body: formData
              })
              .then(() => {
                // Tidak parsing JSON lagi, langsung tampilkan notifikasi
                showCartNotification("Produk berhasil ditambahkan ke keranjang!");
              })
              .catch(err => {
                showCartNotification("Gagal menambahkan produk ke keranjang!");
                console.error(err);
              });
          });
        });
      }

      fetchProducts();
    });
  </script>
</body>

</html>