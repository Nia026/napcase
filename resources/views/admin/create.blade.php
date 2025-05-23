<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Tambah Produk - Napcase Admin</title>
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
        <span class="navbar-brand mb-0 h1">Tambah Produk</span>
      </div>
    </nav>

    <div class="container">
      <div class="card shadow">
        <div class="card-body">
          <form action="{{ url('admin/products') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Nama Produk</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Deskripsi</label>
              <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
              <label for="price" class="form-label">Harga</label>
              <input type="number" name="price" id="price" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Kategori</label>
              <input type="text" name="category" id="category" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="image" class="form-label">Gambar Produk</label>
              <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Produk</button>
            <a href="{{ url('admin/products') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>

    <footer class="mt-4">
      <small>&copy; 2025 Napcase Admin</small>
    </footer>
  </div>

</body>

</html>