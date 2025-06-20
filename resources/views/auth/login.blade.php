<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GayaBelajarKU - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white rounded-2xl shadow-lg flex w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2">
        <!-- Left (Description) -->
        <div class="w-1/2 bg-indigo-400 text-white p-10 hidden md:flex flex-col rounded-l-2xl relative">
            <div class="absolute top-8 left-8">
                <h3 class="text-xl font-bold">GayaBelajarKU</h3>
                <p class="text-sm">Tes Gaya Belajar Online</p>
            </div>
            <div class="flex flex-col h-full">
                <div class="w-full h-full flex mt-14">
                    <img src="{{ asset('images/auth.svg') }}" alt="Welcome Image" />
                </div>
            </div>
        </div>

        <!-- Right (Login Form) -->
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white rounded-r-2xl">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Login</h2>
            <h3 class="text-xs font-light text-gray-800 mb-6">Silahkan masukan email dan password anda untuk Login!</h3>

            <!-- Display error messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-md">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6" novalidate>
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <p class="text-xs text-red-600 mt-1 hidden" id="emailError">Masukkan email yang valid.</p>
                </div>

                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 mt-1">
                            <!-- Eye icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-red-600 mt-1 hidden" id="passwordError">Masukan password yang valid.</p>
                </div>

                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition"
                >
                    Login
                </button>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register.form') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Daftar di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("loginForm");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");
        const togglePassword = document.getElementById("togglePassword");
        const eyeIcon = document.getElementById("eyeIcon");

        // Toggle show/hide password
        togglePassword.addEventListener("click", function () {
            if (password.type === "password") {
                password.type = "text";
                // Change icon to eye-off
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.43-4.364M9.88 9.88a3 3 0 104.243 4.243" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 01-6 0 3 3 0 016 0z" />`;
            } else {
                password.type = "password";
                // Change icon back to eye
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        });

        // Form validation on submit
        form.addEventListener("submit", function (e) {
            let valid = true;

            // Email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim()) {
                emailError.textContent = "Email wajib diisi.";
                emailError.classList.remove("hidden");
                valid = false;
            } else if (!emailPattern.test(email.value.trim())) {
                emailError.textContent = "Masukkan email yang valid.";
                emailError.classList.remove("hidden");
                valid = false;
            } else {
                emailError.classList.add("hidden");
            }

            // Password validation
            if (!password.value.trim()) {
                passwordError.textContent = "Password wajib diisi.";
                passwordError.classList.remove("hidden");
                valid = false;
            } else if (password.value.length < 6) {
                passwordError.textContent = "Password minimal 6 karakter.";
                passwordError.classList.remove("hidden");
                valid = false;
            } else {
                passwordError.classList.add("hidden");
            }

            if (!valid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });
    </script>
</body>
</html>
