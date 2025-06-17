<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JiQuiz - Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-8">
  <div class="bg-white rounded-2xl shadow-lg flex w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2">

    <!-- Left Panel -->
    <div class="w-1/2 bg-indigo-500 text-white p-10 hidden md:flex flex-col rounded-l-2xl">
      <h3 class="text-2xl font-bold">Gaya
        BelajarKU</h3>
      <p class="text-sm">Tes Gaya Belajar Online</p>
      <div class="mt-auto">
        <img src="{{ asset('images/auth.svg') }}" alt="Ilustrasi" />
      </div>
    </div>

    <!-- Right Panel -->
    <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
      <h2 class="text-2xl font-semibold text-gray-800 mb-2">Daftar Akun</h2>
      <p class="text-sm text-gray-600 mb-4">Lengkapi formulir berikut untuk mendaftar.</p>

      <form id="registerForm" method="POST" action="{{ route('register.store') }}" novalidate class="space-y-4">
        @csrf

    <!-- Input Nama -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" id="name" required
        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <p class="text-xs text-red-600 mt-1 hidden" id="nameError">Nama wajib diisi.</p>
    </div>

    <!-- Input Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" required
        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <p class="text-xs text-red-600 mt-1 hidden" id="emailError">Masukkan email yang valid.</p>
    </div>

    <!-- Input Password -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <div class="relative">
        <input type="password" name="password" id="password" required
            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500" onclick="toggleVisibility('password', this)">
            <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S3.732 16.057 2.458 12z" />
            </svg>
        </button>
        </div>
        <p class="text-xs text-red-600 mt-1 hidden" id="passwordError">Password minimal 6 karakter.</p>
    </div>

    <!-- Konfirmasi Password -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <div class="relative">
        <input type="password" name="password_confirmation" id="password_confirmation" required
            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500" onclick="toggleVisibility('password_confirmation', this)">
            <svg id="icon-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S3.732 16.057 2.458 12z" />
            </svg>
        </button>
        </div>
        <p class="text-xs text-red-600 mt-1 hidden" id="confirmError">Konfirmasi password tidak sesuai.</p>
    </div>


        <!-- Submit -->
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md text-sm font-medium">
          Daftar Sekarang
        </button>

        <!-- Link ke login -->
        <p class="text-sm text-center text-gray-600 mt-4">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login di sini</a>
        </p>
      </form>
    </div>
  </div>

  <script>
    function toggleVisibility(fieldId, button) {
      const input = document.getElementById(fieldId);
      const icon = button.querySelector("svg");
      const isPassword = input.type === "password";
      input.type = isPassword ? "text" : "password";
    }

    document.getElementById('registerForm').addEventListener('submit', function(e) {
      let valid = true;

      const name = document.getElementById('name');
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      const confirm = document.getElementById('password_confirmation');

      // Nama
      const nameError = document.getElementById('nameError');
      if (!name.value.trim()) {
        nameError.classList.remove('hidden');
        valid = false;
      } else {
        nameError.classList.add('hidden');
      }

      // Email
      const emailError = document.getElementById('emailError');
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email.value.trim())) {
        emailError.classList.remove('hidden');
        valid = false;
      } else {
        emailError.classList.add('hidden');
      }

      // Password
      const passwordError = document.getElementById('passwordError');
      if (password.value.length < 6) {
        passwordError.classList.remove('hidden');
        valid = false;
      } else {
        passwordError.classList.add('hidden');
      }

      // Konfirmasi Password
      const confirmError = document.getElementById('confirmError');
      if (confirm.value !== password.value || !confirm.value) {
        confirmError.classList.remove('hidden');
        valid = false;
      } else {
        confirmError.classList.add('hidden');
      }

      if (!valid) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
