<header class="bg-white shadow-md sticky top-0 z-10">
  <nav class="container mx-auto px-4 py-3 flex items-center justify-between">
    <div class="logo">
      <a href="/home" class="text-xl font-semibold text-gray-800">Nap<span class="text-indigo-600">Case</span></a>
    </div>

    <div class="flex items-center space-x-4">
      @php
      $showSearch = Request::is('home');
      @endphp

      @if($showSearch)
      <div class="relative">
        <input type="text" id="search-input"
          class="bg-gray-100 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Cari casing...">
        <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
          <i class="fas fa-search"></i>
        </button>
      </div>
      @endif

      <a href="/informasi" class="text-gray-700 hover:text-indigo-600 transition duration-300">
        <i class="fas fa-info-circle mr-1"></i> Informasi Pemesanan
      </a>

      <a href="/cart" class="relative text-gray-700 hover:text-indigo-600 transition duration-300">
        <i class="fas fa-shopping-cart mr-1"></i> Keranjang
      </a>

      <button onclick="konfirmasiLogout()"
        class="text-red-600 hover:text-red-800 transition duration-300 font-semibold">
        <i class="fas fa-sign-out-alt mr-1"></i> Logout
      </button>
    </div>
  </nav>

  <script>
    function konfirmasiLogout() {
      if (confirm('Apakah Anda yakin ingin logout?')) {
        window.location.href = '/'; // ke halaman landing
      }
    }
  </script>
</header>