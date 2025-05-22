<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Napcase - Casing Unik & Stylish</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800 font-sans">

  <!-- Hero Section -->
  <section class="relative h-screen bg-cover bg-center"
    style="background-image: url('https://source.unsplash.com/1600x900/?phone,case');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-center px-6">
      <h1 class="text-4xl md:text-6xl font-bold text-white">Selamat Datang di <span
          class="text-yellow-400">Napcase</span></h1>
      <p class="mt-4 text-lg md:text-xl text-white max-w-2xl">Platform jual beli casing unik dan stylish untuk semua
        tipe smartphone. Gaya kamu, casing kamu!</p>
      <div class="mt-6 space-x-4">
        <a href="{{ route('login') }}"
          class="bg-yellow-400 text-black font-semibold py-3 px-6 rounded-lg hover:bg-yellow-500">Login</a>
        <a href="{{ route('register') }}"
          class="border border-white text-white font-semibold py-3 px-6 rounded-lg hover:bg-white hover:text-black">Daftar</a>
      </div>
    </div>
  </section>

  <!-- Tentang Kami -->
  <section class="py-16 px-6 md:px-24 bg-gray-100">
    <h2 class="text-3xl font-bold text-center mb-8">Tentang Napcase</h2>
    <p class="text-lg text-center max-w-3xl mx-auto">Napcase adalah platform e-commerce yang menyediakan casing dengan
      berbagai desain eksklusif dan fungsional. Kami percaya bahwa casing bukan hanya pelindung, tapi juga ekspresi gaya
      personal pengguna smartphone.</p>
  </section>

  <!-- Visi Misi -->
  <section class="py-16 px-6 md:px-24 bg-white">
    <h2 class="text-3xl font-bold text-center mb-8">Visi & Misi</h2>
    <div class="grid md:grid-cols-2 gap-10 max-w-5xl mx-auto">
      <div>
        <h3 class="text-xl font-semibold mb-2">Visi</h3>
        <p>Mewujudkan Napcase sebagai destinasi utama dalam memilih casing berkualitas dan penuh gaya untuk semua
          kalangan.</p>
      </div>
      <div>
        <h3 class="text-xl font-semibold mb-2">Misi</h3>
        <ul class="list-disc pl-5 space-y-2">
          <li>Menyediakan casing berkualitas dan bergaya modern</li>
          <li>Mempermudah proses jual beli casing secara online</li>
          <li>Mendukung kreator lokal melalui desain eksklusif</li>
          <li>Memberikan pengalaman belanja yang cepat, aman, dan nyaman</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-16 px-6 bg-yellow-400 text-center">
    <h2 class="text-3xl font-bold mb-4 text-black">Gabung Sekarang dan Temukan Casing Impianmu!</h2>
    <a href="{{ route('register') }}"
      class="bg-black text-white px-8 py-3 text-lg rounded-lg font-semibold hover:bg-gray-800">Daftar Sekarang</a>
  </section>

  <footer class="text-center py-6 text-sm text-gray-500 bg-white">
    &copy; {{ date('Y') }} Napcase. All rights reserved.
  </footer>

</body>

</html>