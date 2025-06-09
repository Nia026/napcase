<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manajemen Metode Pembayaran - Napcase Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
        <span class="navbar-brand mb-0 h1">Manajemen Metode Pembayaran</span>
      </div>
    </nav>

    <div class="container">
      <div class="card shadow mb-4">
        <div class="card-body">
          <form id="metodeForm">
            <input type="hidden" id="metodeId" />
            <div class="row g-2">
              <div class="col-md-4">
                <input type="text" id="name" class="form-control" placeholder="Nama Bank" required />
              </div>
              <div class="col-md-4">
                <input type="text" id="value" class="form-control" placeholder="Nomor Rekening" required />
              </div>
              <div class="col-md-4">
                <button type="submit" class="btn btn-primary me-2" id="submitBtn">Tambah</button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card shadow">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center mb-0">
              <thead class="table-dark">
                <tr>
                  <th>No</th>
                  <th>Nama Bank</th>
                  <th>Nomor Rekening</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="metodeBody">
                <tr>
                  <td colspan="4">Memuat data...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script>
    const API_URL = "http://127.0.0.1:8000/api/MetodePembayaran";

    function loadMetode() {
      fetch(API_URL)
        .then((res) => res.json())
        .then((data) => {
          const tbody = document.getElementById("metodeBody");
          tbody.innerHTML = "";
          if (data.length === 0) {
            tbody.innerHTML = "<tr><td colspan='4'>Tidak ada data.</td></tr>";
            return;
          }

          data.forEach((item) => {
            tbody.innerHTML += `
              <tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.value}</td>
                <td>
                  <button class="btn btn-warning btn-sm" onclick="editMetode(${item.id}, '${item.name}', '${item.value}')">Edit</button>
                  <button class="btn btn-danger btn-sm" onclick="hapusMetode(${item.id})">Hapus</button>
                </td>
              </tr>
            `;
          });
        })
        .catch(() => {
          document.getElementById("metodeBody").innerHTML = "<tr><td colspan='4'>Gagal memuat data.</td></tr>";
        });
    }

    document.getElementById("metodeForm").addEventListener("submit", function(e) {
      e.preventDefault();

      const id = document.getElementById("metodeId").value;
      const name = document.getElementById("name").value;
      const value = document.getElementById("value").value;

      const method = id ? "PUT" : "POST";
      const url = id ? `${API_URL}/${id}` : API_URL;

      fetch(url, {
          method: method,
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            name,
            value
          }),
        })
        .then((res) => {
          if (res.ok) {
            alert(id ? "Metode berhasil diperbarui" : "Metode berhasil ditambahkan");
            resetForm();
            loadMetode();
          } else {
            res.json().then((data) => alert(data.message || "Gagal menyimpan data"));
          }
        })
        .catch(() => alert("Terjadi kesalahan saat menyimpan data"));
    });

    function editMetode(id, name, value) {
      document.getElementById("metodeId").value = id;
      document.getElementById("name").value = name;
      document.getElementById("value").value = value;
      document.getElementById("submitBtn").textContent = "Perbarui";
    }

    function hapusMetode(id) {
      if (confirm("Yakin ingin menghapus metode ini?")) {
        fetch(`${API_URL}/${id}`, {
            method: "DELETE"
          })
          .then((res) => {
            if (res.ok) {
              alert("Metode berhasil dihapus");
              loadMetode();
            } else {
              res.json().then((data) => alert(data.message || "Gagal menghapus data"));
            }
          })
          .catch(() => alert("Terjadi kesalahan saat menghapus data"));
      }
    }

    function resetForm() {
      document.getElementById("metodeForm").reset();
      document.getElementById("metodeId").value = "";
      document.getElementById("submitBtn").textContent = "Tambah";
    }

    loadMetode();
  </script>
</body>

</html>