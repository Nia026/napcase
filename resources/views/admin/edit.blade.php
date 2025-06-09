<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Produk - Napcase Admin</title>
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
  {{-- Sidebar --}}
  <x-admin-sidebar />

  {{-- Main Content --}}
  <div class="main">
    <nav class="navbar navbar-expand-lg bg-light mb-4">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Edit Produk</span>
      </div>
    </nav>

    <div class="container">
      <div class="card shadow">
        <div class="card-body">
          <form action="{{ url('admin/products/' . $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="name" class="form-label">Nama Produk</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Deskripsi</label>
              <textarea name="description" id="description" class="form-control" rows="3"
                required>{{ $product->description }}</textarea>
            </div>

            <div class="mb-3">
              <label for="price" class="form-label">Harga</label>
              <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <div class="mb-3">
              <label for="category" class="form-label">Kategori</label>
              <input type="text" name="category" id="category" class="form-control" value="{{ $product->category }}"
                required>
            </div>

            <div class="mb-3">
              <label for="image" class="form-label">Gambar Produk (opsional)</label>
              <input type="file" name="image" id="image" class="form-control" accept="image/*">
              <small>Gambar saat ini:
                <a href="{{ asset('storage/' . $product->gambar) }}" target="_blank">Lihat</a>
              </small>
            </div>

            <button type="submit" class="btn btn-primary">Update Produk</button>
            <a href="{{ url('admin/products') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>

  </div>

</body>

</html>