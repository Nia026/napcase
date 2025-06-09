<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Detail Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100 font-sans leading-relaxed">
  <!-- Navbar -->
  <x-navbar />

  <!-- Main Content -->
  <main class="max-w-6xl mx-auto px-4 py-10">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="md:flex md:gap-8">
        <!-- Gambar Produk -->
        <div class="md:w-1/2 p-6 flex items-center justify-center">
          <img id="detail-image" src="https://via.placeholder.com/400" alt="Detail Produk"
            class="w-full h-auto max-h-[500px] object-contain rounded-lg border border-gray-200">
        </div>

        <!-- Informasi Produk -->
        <div class="md:w-1/2 p-6 space-y-4">
          <h1 id="detail-name" class="text-3xl font-bold text-gray-800">Nama Produk</h1>
          <p id="detail-description" class="text-gray-600 text-base leading-relaxed">Deskripsi produk akan muncul di
            sini.</p>

          <div class="text-sm text-gray-500">
            Kategori: <span id="detail-category" class="font-semibold text-indigo-600">Kategori</span>
          </div>

          <div class="text-2xl font-extrabold text-indigo-600">
            Rp <span id="detail-price">0</span>
          </div>

          <form id="add-to-cart-form" method="POST" action="">
            @csrf
            <button type="submit"
              class="mt-4 w-full bg-indigo-500 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-full shadow-md transition duration-300">
              <i class="fas fa-cart-plus mr-2"></i> Masukkan ke Keranjang
            </button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <x-footer />

  <!-- Script -->
  <script>
    const detailImage = document.getElementById('detail-image');
    const detailName = document.getElementById('detail-name');
    const detailDescription = document.getElementById('detail-description');
    const detailPrice = document.getElementById('detail-price');
    const detailCategory = document.getElementById('detail-category');

    function getProductDetail() {
      const pathSegments = window.location.pathname.split('/');
      const productId = parseInt(pathSegments[pathSegments.length - 1]);

      if (productId) {
        fetch(`/api/products/${productId}`)
          .then(response => {
            if (!response.ok) throw new Error('Produk tidak ditemukan');
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
            document.querySelector('main').innerHTML = `
              <div class="text-center text-red-600 mt-16">
                <p>${error.message}</p>
                <a href="/home" class="mt-4 inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-300">Kembali</a>
              </div>`;
          });
      } else {
        document.querySelector('main').innerHTML = `
          <div class="text-center text-red-600 mt-16">
            <p>ID produk tidak valid.</p>
            <a href="/home" class="mt-4 inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-300">Kembali</a>
          </div>`;
      }
    }

    getProductDetail();
  </script>
</body>

</html>