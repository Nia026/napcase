<!-- resources/views/user/home.blade.php -->

<!DOCTYPE html>
<html>

<head>
  <title>Beranda User - Napcase</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
  <div class="container">
    <h2>Selamat Datang, {{ Auth::user()->name }}</h2>
    <p>Silakan lihat casing yang tersedia dan checkout</p>

    <ul>
      <li><a href="#">Lihat Produk</a></li>
      <li><a href="#">Keranjang</a></li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit">Logout</button>
    </form>
  </div>
</body>

</html>