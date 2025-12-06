<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Register</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" type="image/png" href="{{ asset('images/fintory.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet" />
        <style>
            * {
                font-family: 'Geist', sans-serif;
            }
        </style>
    </head>

    <body class="h-screen flex flex-col md:flex-row">

        <!-- Image Section -->
        <div class="hidden md:flex md:w-1/2 bg-gray-100 items-center justify-center">
            <img src="{{ asset('images/bannerregister.png') }}" alt="Banner" class="w-full h-screen object-cover" />

        </div>

        <!-- Form Section -->
        <div class="w-full md:w-1/2 flex items-center justify-center px-6 py-12">
            <form method="POST" action="{{ route('register') }}" class="w-full max-w-md space-y-6">
                @csrf

                <div class="text-center mb-4">
                    <h1 class="text-3xl font-semibold text-blue-900">Daftar Akun</h1>
                    <p class="text-sm text-gray-500 mt-2">Silakan isi data Anda untuk mendaftar.</p>
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email address"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required value="{{ old('email') }}" />
                    @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="********"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required />
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="********"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required />
                </div>

                {{-- Optional Referal --}}
                <div>
                    <p class="text-sm text-gray-500">
                    </p>
                </div>

                {{-- Button --}}
                <div>
                    <button type="submit" id="registerBtn"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">

                        <svg id="registerLoader" class="hidden w-5 h-5 animate-spin text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z" />
                        </svg>

                        <span id="registerText">Daftar</span>
                    </button>

                </div>

                {{-- Already have account --}}
                <p class="text-center text-gray-500 text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-800 hover:underline">Masuk</a>
                </p>
            </form>
        </div>

        <script>
            const registerForm = document.querySelector("form");
            const registerBtn = document.getElementById("registerBtn");
            const registerLoader = document.getElementById("registerLoader");
            const registerText = document.getElementById("registerText");

            registerForm.addEventListener("submit", function() {
                registerBtn.disabled = true;
                registerBtn.classList.add("opacity-70", "cursor-not-allowed");

                registerLoader.classList.remove("hidden");
                registerText.textContent = "Mendaftar...";
            });
        </script>

    </body>

</html>
