<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manajemen Transaksi - Napcase Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .main {
      margin-left: 260px;
      padding: 1.5rem;
    }

    .bukti-img {
      max-width: 90px;
      max-height: 90px;
    }

    .badge-detail {
      display: inline-block;
      margin: 2px;
    }

    select.form-select {
      min-width: 180px;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <x-admin-sidebar />

  <!-- Main Content -->
  <div class="main">
    <nav class="navbar navbar-expand-lg bg-light mb-4">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Manajemen Transaksi</span>
      </div>
    </nav>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Detail Barang</th>
                <th>Total Harga</th>
                <th>Bukti Pembayaran</th>
                <th>Status</th>
                <th>Terakhir Diperbarui</th>
              </tr>
            </thead>
            <tbody id="transaksiBody">
              <tr>
                <td colspan="8">Memuat data...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <script>
    const API_URL = "http://127.0.0.1:8000/api/transaksi";
    const statusList = [
      "transaksi terkirim ke admin",
      "admin konfirmasi transaksi",
      "admin menyiapkan produk",
      "produk diserahkan ke kurir",
      "produk dalam perjalanan"
    ];

    function loadTransaksi() {
      fetch(API_URL)
        .then(res => res.json())
        .then(data => {
          const tbody = document.getElementById("transaksiBody");
          tbody.innerHTML = "";

          if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = "<tr><td colspan='8'>Tidak ada data transaksi.</td></tr>";
            return;
          }

          data.forEach(item => {
            let detailBarangHTML = "";
            item.detail_transaksis.forEach(detail => {
              detailBarangHTML +=
                `<span class="badge bg-secondary badge-detail">${detail.product_name} (${detail.quantity})</span><br>`;
            });

            const buktiURL = "/storage/" + item.bukti_pembayaran;
            const optionsHTML = statusList.map(status => {
              return `<option value="${status}" ${status === item.status ? 'selected' : ''}>${status}</option>`;
            }).join('');

            tbody.innerHTML += `
              <tr>
                <td>${item.nama}</td>
                <td>${item.alamat}</td>
                <td>${item.telepon}</td>
                <td>${detailBarangHTML}</td>
                <td>Rp${parseInt(item.total).toLocaleString()}</td>
                <td>
                  <a href="${buktiURL}" target="_blank">
                    <img src="${buktiURL}" class="bukti-img img-thumbnail" />
                  </a>
                </td>
                <td>
                  <select class="form-select form-select-sm" onchange="updateStatus(${item.id}, this.value)">
                    ${optionsHTML}
                  </select>
                </td>
                <td><small>${new Date(item.updated_at).toLocaleString()}</small></td>
              </tr>
            `;
          });
        })
        .catch(error => {
          console.error(error);
          document.getElementById("transaksiBody").innerHTML = "<tr><td colspan='8'>Gagal memuat data.</td></tr>";
        });
    }

    function updateStatus(id, newStatus) {
      fetch(`${API_URL}/${id}`, {
          method: "PUT",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            status: newStatus
          })
        })
        .then(res => {
          if (res.ok) {
            alert("Status berhasil diperbarui");
            loadTransaksi();
          } else {
            res.json().then(data => alert(data.message || "Gagal memperbarui status"));
          }
        })
        .catch(() => alert("Terjadi kesalahan saat memperbarui status"));
    }

    loadTransaksi();
  </script>
</body>

</html>