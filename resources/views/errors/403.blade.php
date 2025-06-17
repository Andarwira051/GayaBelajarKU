<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Forbidden</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col justify-center items-center">
        <!-- 403 Error Container -->
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Error Header -->
            <div class="bg-red-500 p-6">
                <div class="flex justify-center">
                    <svg class="h-24 w-24 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h1 class="mt-4 text-center text-3xl font-extrabold text-white uppercase tracking-wider">
                    403 Forbidden
                </h1>
            </div>
            
            <!-- Error Message -->
            <div class="px-6 py-8">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Akses Ditolak
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                    </p>
                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-red-500 hover:bg-red-600 transition-colors duration-200 text-white font-medium rounded-md">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="text-center text-sm text-gray-500">
                    {{ config('app.name') }} &copy; {{ date('Y') }}
                </div>
            </div>
        </div>
        
        <!-- Error Code -->
        <div class="mt-6 text-center">
            <p class="text-gray-500">Error Code: 403</p>
        </div>
    </div>
</body>
</html>