<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Informasi Pemesanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans relative">

  <!-- Navbar -->
  <x-navbar />

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
      Informasi Pemesanan
    </h2>

    <div id="transaksi-container">
      <p class="text-gray-500 text-center">Memuat data transaksi...</p>
    </div>
  </main>

  <!-- Toast Notification -->
  <div id="toast"
    class="hidden fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300 opacity-0">
  </div>

  <!-- Footer -->
  <x-footer />

  <script>
    const userId = "{{ auth()->id() }}";
    const container = document.getElementById('transaksi-container');

    function showToast(message) {
      const toast = document.getElementById("toast");
      toast.textContent = message;
      toast.classList.remove("hidden");
      toast.classList.add("opacity-100");

      setTimeout(() => {
        toast.classList.remove("opacity-100");
        toast.classList.add("opacity-0");
        setTimeout(() => toast.classList.add("hidden"), 300);
      }, 3000);
    }

    async function loadTransaksi() {
      try {
        const response = await fetch(`/api/transaksi/user/${userId}`);
        const data = await response.json();

        if (!data.length) {
          container.innerHTML = `
            <p class="text-gray-500 text-center">Belum ada transaksi.</p>
          `;
          return;
        }

        container.innerHTML = data.map((trx, index) => `
          <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold text-indigo-600 mb-4">
              Transaksi ${index + 1}
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
              <p><span class="font-semibold">Total:</span> Rp ${parseInt(trx.total).toLocaleString('id-ID')}</p>
              <p><span class="font-semibold">Status:</span> ${trx.status}</p>
              <p class="sm:col-span-2"><span class="font-semibold">Alamat:</span> ${trx.alamat}</p>
            </div>

            <div class="mt-4">
              <h4 class="font-semibold text-gray-800 mb-2">Detail Produk:</h4>
              <ul class="list-disc list-inside space-y-1 text-sm text-gray-600">
                ${trx.detail_transaksis.map(item => `
                  <li>${item.product_name} x${item.quantity} - Rp ${parseInt(item.price).toLocaleString('id-ID')}</li>
                `).join('')}
              </ul>
            </div>

            ${trx.status === 'produk dalam perjalanan' ? `
              <form onsubmit="return konfirmasiDiterima(${trx.id})" class="mt-6">
                <button type="submit"
                  class="bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 rounded-lg shadow">
                  Pesanan Diterima
                </button>
              </form>
            ` : ''}
          </div>
        `).join('');
      } catch (error) {
        container.innerHTML = `
          <p class="text-red-500 text-center">Gagal memuat data.</p>
        `;
      }
    }

    async function konfirmasiDiterima(id) {
      const konfirmasi = confirm("Apakah Anda yakin pesanan sudah diterima?");
      if (!konfirmasi) return false;

      try {
        await fetch(`/api/transaksi/selesai/${id}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
          }
        });

        showToast("Pesanan berhasil dikonfirmasi!");
        loadTransaksi();
      } catch (error) {
        showToast("Gagal mengkonfirmasi pesanan.");
      }

      return false; // Prevent form reload
    }

    // Load transaksi saat halaman dimuat
    loadTransaksi();
  </script>

</body>

</html>