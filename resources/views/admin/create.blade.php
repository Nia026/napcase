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
      margin: 0;
    }

    .main {
      margin-left: 260px;
      padding: 1rem;
      flex: 1;
      display: flex;
      flex-direction: column;
    }
  </style>
</head>

<body>
  {{-- Sidebar pakai komponen --}}
  <x-admin-sidebar />

  {{-- Konten utama --}}
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

  </div>

</body>

</html>