<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manajemen Produk - Napcase Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      position: fixed;
      top: 0;
      bottom: 0;
      padding: 1rem;
    }

    .sidebar a {
      color: white;
      display: block;
      padding: 0.5rem 0;
      text-decoration: none;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .main {
      margin-left: 260px;
      padding: 1rem;
      flex: 1;
    }

    footer {
      background-color: #f8f9fa;
      text-align: center;
      padding: 10px;
      margin-left: 260px;
    }
  </style>
</head>

<body>

  <div class="sidebar">
    <h4>Napcase Admin</h4>
    <hr>
    <a href="{{ url('admin/products') }}">Manajemen Produk</a>
    <a href="{{ url('admin/metode-pembayaran') }}">Manajemen Metode Pembayaran</a>
    <a href="{{ url('admin/transaksi') }}">Transaksi</a>
  </div>

  <div class="main">
    <nav class="navbar navbar-expand-lg bg-light mb-4">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Manajemen Produk</span>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Produk</h3>
        <a href="{{ url('admin/create') }}" class="btn btn-success">+ Tambah Produk</a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center" id="produkTable">
          <thead class="table-dark">
            <tr>
              <th>Gambar</th>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th>Harga</th>
              <th>Kategori</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="produkBody">
            <tr>
              <td colspan="6">Memuat data...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <footer class="mt-4">
      <small>&copy; 2025 Napcase Admin</small>
    </footer>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      fetch("{{ url('/api/products') }}")
        .then(res => res.json())
        .then(data => {
          const tbody = document.getElementById("produkBody");
          tbody.innerHTML = "";
          if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6">Tidak ada data produk.</td></tr>';
            return;
          }
          data.forEach(item => {
            const row = document.createElement("tr");
            row.innerHTML = `
              <td><img src="${item.image}" class="img-thumbnail" width="80"/></td>
              <td>${item.name}</td>
              <td>${item.description}</td>
              <td>Rp${parseInt(item.price).toLocaleString('id-ID')}</td>
              <td>${item.category}</td>
              <td>
                <a href="/admin/edit/${item.id}" class="btn btn-warning btn-sm mb-1">Edit</a>
                <button onclick="hapusProduk(${item.id})" class="btn btn-danger btn-sm">Hapus</button>
              </td>
            `;
            tbody.appendChild(row);
          });
        })
        .catch(err => {
          console.error("Gagal memuat data produk:", err);
          document.getElementById("produkBody").innerHTML = '<tr><td colspan="6">Gagal memuat data.</td></tr>';
        });
    });

    function hapusProduk(id) {
      if (confirm("Yakin ingin menghapus produk ini?")) {
        fetch(`/api/products/${id}`, {
            method: "DELETE"
          })
          .then(res => {
            if (res.ok) {
              alert("Produk berhasil dihapus");
              location.reload();
            } else {
              res.json().then(data => {
                alert(data.message || "Gagal menghapus produk");
              });
            }
          })
          .catch(() => {
            alert("Terjadi kesalahan saat menghapus produk");
          });
      }
    }
  </script>

</body>

</html>