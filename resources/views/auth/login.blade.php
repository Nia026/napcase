<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Napcase</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gray-100">
  <div class="flex h-screen">
    <!-- Left Side -->
    @php
    $bg = asset('images/bg-img.png');
    @endphp
    <div class="w-1/2 bg-cover bg-center flex flex-col justify-center items-center text-white px-10"
      style="background-image: url('{{ $bg }}');">
      <h1 class="text-5xl font-bold mb-4">NAPCASE</h1>
      <p class="text-xl font-semibold text-center">Crafted for comfort, styled for souls</p>
      <p class="text-sm text-center mt-2">“NAPCASE offers cases that speak your vibe, quietly bold.”</p>
    </div>

    <!-- Right Side (Form) -->
    <div class="w-1/2 flex justify-center items-center bg-white">
      <div class="w-full max-w-md p-8 rounded-lg shadow-md">
        <h2 class="text-lg font-medium mb-2 text-gray-600 uppercase">Welcome Back</h2>
        <h1 class="text-2xl font-bold mb-6">Log In to your Account</h1>

        @if(session('success'))
        <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="mb-4 text-red-600">
          @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
          @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
          @csrf
          <input type="email" name="email" placeholder="Email"
            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-400"
            required>

          <input type="password" name="password" placeholder="Password"
            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-400"
            required>

          <div class="flex items-center justify-between">
            <label class="flex items-center text-sm">
              <input type="checkbox" class="mr-2"> Remember me
            </label>
            <a href="#" class="text-sm text-gray-500 hover:underline">Forgot Password?</a>
          </div>

          <button type="submit" class="w-full py-2 bg-[#4B1D1D] text-white rounded hover:bg-[#3a1515] transition">
            CONTINUE
          </button>
        </form>

        <p class="mt-6 text-sm text-center text-gray-600">
          New User? <a href="{{ route('register') }}" class="font-semibold text-black hover:underline">SIGN UP HERE</a>
        </p>
      </div>
    </div>
  </div>
</body>

</html>