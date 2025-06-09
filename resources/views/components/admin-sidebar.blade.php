<div class="sidebar"
  style="width: 250px; background-color: #343a40; color: white; position: fixed; top: 0; bottom: 0; padding: 1.5rem;">
  <h4 class="mb-4">Napcase Admin</h4>

  <nav class="nav flex-column">
    <a href="{{ url('admin/products') }}" class="nav-link-custom">Manajemen Produk</a>
    <a href="{{ url('admin/metode-pembayaran') }}" class="nav-link-custom">Manajemen Metode Pembayaran</a>
    <a href="{{ url('admin/transaksi') }}" class="nav-link-custom">Transaksi</a>
    <hr class="bg-light">
    <a href="#" onclick="return logoutConfirm()" class="nav-link-custom">Logout</a>
  </nav>
</div>

<style>
  .nav-link-custom {
    color: white;
    text-decoration: none;
    padding: 10px 0;
    transition: background-color 0.3s, padding-left 0.3s;
    display: block;
  }

  .nav-link-custom:hover {
    background-color: #495057;
    padding-left: 8px;
    border-radius: 4px;
  }

  .nav-link-custom:active {
    background-color: #6c757d;
    padding-left: 12px;
  }
</style>

<script>
  function logoutConfirm() {
    if (confirm("Yakin ingin logout?")) {
      window.location.href = "/";
    }
    return false;
  }
</script>