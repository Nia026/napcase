<!-- resources/views/admin/dashboard.blade.php -->

<!DOCTYPE html>
<html>

<head>
  <title>Dashboard Admin - Napcase</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
  <div class="container">
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, {{ Auth::user()->name }} (Admin)</p>

    <ul>
      <li><a href="#">Tambah Barang</a></li>
      <li><a href="#">Lihat Statistik</a></li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit">Logout</button>
    </form>
  </div>
</body>

</html>