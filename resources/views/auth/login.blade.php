<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('images/fintory.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet" />
  <style>
    * {
      font-family: 'Geist', sans-serif;
    }
  </style>
</head>
<body class="flex flex-col md:flex-row h-screen">
  <!-- Banner -->
  <div class="hidden md:block md:w-1/2 h-full">
    <img src="{{ asset('images/bannerlogin.png') }}" alt="Banner" class="w-full h-full object-cover" />
  </div>

  <!-- Form Section -->
  <div class="w-full md:w-1/2 flex items-center justify-center px-6 py-12">
    <form method="POST" action="{{ route('login') }}" class="w-full max-w-md space-y-6">
      @csrf
      <h1 class="text-3xl font-semibold text-blue-900">Masuk ke Dashboard</h1>

      {{-- Email --}}
      <div class="space-y-2">
        <label for="email" class="text-sm font-medium text-gray-700">Email</label>
        <input
          type="email"
          name="email"
          id="email"
          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
          placeholder="Email address"
          value="{{ old('email') }}"
          required
        />
        @error('email')
          <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div class="space-y-2">
        <label for="password" class="text-sm font-medium text-gray-700">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
          placeholder="********"
          required
        />
        @error('password')
          <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
      </div>

      {{-- Session Status --}}
      @if (session('status'))
        <p class="text-green-600 text-sm">{{ session('status') }}</p>
      @endif

      <div class="flex items-center justify-between text-sm">
        @if (Route::has('password.request'))
        @endif
      </div>

      <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition">
        Log in
      </button>

      <p class="text-center text-gray-500 text-sm">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-800 hover:underline">Daftar</a>
      </p>
    </form>
  </div>
</body>
</html>
