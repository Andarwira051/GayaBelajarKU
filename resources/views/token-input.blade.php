<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JiQuiz - Instruksi dan Token</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white rounded-2xl shadow-lg flex flex-col md:flex-row w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2">
        <!-- Left Side - Instructions Carousel -->
        <div class="w-full md:w-1/2 p-8 flex flex-col items-center justify-center relative border-b md:border-b-0 md:border-r">
            <h2 class="text-xl font-semibold text-center mb-8">Instruksi Pengerjaan</h2>
            <!-- Carousel Container -->
            <div class="carousel relative w-full max-w-md">
                <!-- Carousel Slides -->
                <div class="carousel-slides relative overflow-hidden">
                    <div class="slide active">
                        <div class="flex flex-col items-center">
                            <div class="border border-blue-200 rounded-lg p-3 mb-6">
                                <img src="{{ asset('images/data1.png') }}" alt="Instruksi 1" class="w-36 h-auto">
                            </div>
                            <p class="text-center px-4">
                                Terdapat beberapa pernyataan dan kamu diminta untuk memilih salah satu dari dua pilihan
                                jawaban yang paling sesuai dengan keadaan kamu saat ini.
                            </p>
                        </div>
                    </div>
                    <div class="slide hidden">
                        <div class="flex flex-col items-center">
                            <div class="border border-blue-200 rounded-lg p-3 mb-6">
                                <img src="{{ asset('images/data1.png') }}" alt="Instruksi 2" class="w-36 h-auto">
                            </div>
                            <p class="text-center px-4">
                                Pilih jawaban dengan jujur sesuai dengan diri kamu. Tidak ada jawaban yang benar atau
                                salah.
                            </p>
                        </div>
                    </div>
                    <div class="slide hidden">
                        <div class="flex flex-col items-center">
                            <div class="border border-blue-200 rounded-lg p-3 mb-6">
                                <img src="{{ asset('images/data1.png') }}" alt="Instruksi 3" class="w-36 h-auto">
                            </div>
                            <p class="text-center px-4">
                                Hasil akan ditampilkan setelah kamu menyelesaikan semua pertanyaan.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Navigation Buttons -->
                <button id="prevBtn"
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 -ml-5 w-10 h-10 bg-indigo-500 text-white rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtn"
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 -mr-5 w-10 h-10 bg-indigo-500 text-white rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div class="flex justify-center mt-8 mb-4 space-x-2">
                <span class="h-2 w-2 bg-indigo-600 rounded-full"></span>
                <span class="h-2 w-2 bg-gray-300 rounded-full"></span>
                <span class="h-2 w-2 bg-gray-300 rounded-full"></span>
            </div>
        </div>

        <!-- Right Side - Token Input / Class Info -->
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white rounded-r-2xl">
            @if (session('token_valid'))
                <!-- Token Valid - Show Class Info -->
                <div class="text-center">
                    <div class="mb-8">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Kelas Ditemukan!</h2>
                            <div class="space-y-3 text-left">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <div>
                                        <span class="text-sm text-gray-600">Nama Kelas:</span>
                                        <p class="font-semibold text-gray-800">{{ session('nama_kelas') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <div>
                                        <span class="text-sm text-gray-600">Pengajar:</span>
                                        <p class="font-semibold text-gray-800">{{ session('nama_pengajar') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Button -->
                    <a href="{{ route('quiz-form') }}"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-block">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-9h10a2 2 0 012 2v8a2 2 0 01-2 2H8a2 2 0 01-2-2V7a2 2 0 012-2z"></path>
                            </svg>
                            Mulai Tes Sekarang
                        </div>
                    </a>

                    <!-- New Token Button -->
                    <form action="{{ route('token.clear') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">
                            Masukkan kode kelas lain
                        </button>
                    </form>
                </div>
            @else
                <!-- Token Input Form -->
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Kode Kelas</h2>
                <h3 class="text-xs font-light text-gray-800 mb-6">Silahkan masukan kode kelas. Mintalah kode kelas kepada pengajarmu!</h3>

                <!-- Menampilkan pesan error -->
                @if ($errors->has('token'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ $errors->first('token') }}</p>
                    </div>
                @endif

                <form action="{{ route('token.submit') }}" method="POST" class="space-y-4 w-full max-w-sm">
                    @csrf
                    <div>
                        <label for="token" class="block text-sm font-medium text-gray-700 mb-2">Kode Kelas</label>
                        <input type="text" id="token" name="token" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Masukkan kode kelas di sini" />
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition">
                        Validasi Token
                    </button>
                </form>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            const indicators = document.querySelectorAll('.flex.justify-center.mt-8 span');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            let currentSlide = 0;

            function showSlide(index) {
                slides.forEach(slide => slide.classList.add('hidden'));
                indicators.forEach(indicator => indicator.classList.remove('bg-indigo-600'));
                indicators.forEach(indicator => indicator.classList.add('bg-gray-300'));
                slides[index].classList.remove('hidden');
                indicators[index].classList.remove('bg-gray-300');
                indicators[index].classList.add('bg-indigo-600');
            }

            nextBtn.addEventListener('click', function() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            });

            prevBtn.addEventListener('click', function() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            });

            showSlide(currentSlide);
        });
    </script>
</body>

</html>
