<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Napcase</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gray-100">
  <div class="flex h-screen">
    <!-- Left Side (Image & Branding) -->
    @php
    $bg = asset('images/bg-img.png');
    @endphp
    <div class="w-1/2 bg-cover bg-center flex flex-col justify-center items-center text-white px-10"
      style="background-image: url('{{ $bg }}');">
      <h1 class=" text-5xl font-bold mb-4">NAPCASE</h1>
      <p class="text-xl font-semibold text-center">Crafted for comfort, styled for souls</p>
      <p class="text-sm text-center mt-2">“NAPCASE offers cases that speak your vibe, quietly bold.”</p>
    </div>

    <!-- Right Side (Form) -->
    <div class="w-1/2 flex items-center justify-center bg-white">
      <div class="w-full max-w-md p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Create an Account</h2>

        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
          @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
          @csrf
          <div>
            <label class="block text-sm font-medium text-gray-700">Your Name</label>
            <input type="text" name="name" required
              class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-600">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" required
              class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-600">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required
              class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-600">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" required
              class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-600">
              <option value="" disabled selected>Pilih Role</option>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <button type="submit"
            class="w-full bg-[#512D2D] text-white py-2 rounded shadow hover:bg-[#3e2323] transition">
            GET STARTED
          </button>
        </form>

        <p class="mt-6 text-sm text-center text-gray-600">
          Already have an account?
          <a href="{{ route('login') }}" class="font-medium text-gray-800 hover:underline">LOGIN HERE</a>
        </p>
      </div>
    </div>
  </div>
</body>

</html>