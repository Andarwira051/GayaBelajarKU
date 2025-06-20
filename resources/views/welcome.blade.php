<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Temukan Gaya Belajarmu!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Added custom responsive styles -->
    <style>
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* Mobile menu styles */
        .mobile-menu {
            display: none;
        }

        .mobile-menu.active {
            display: block;
        }

        /* Wave responsiveness fix */
        .wave {
            width: 100%;
            height: auto;
        }

        /* Add this to your <style> section */
        .aspect-w-4 {
            position: relative;
            padding-bottom: 75%;
            /* 4:3 aspect ratio */
        }

        .aspect-h-3 {
            /* This is just for semantic clarity, the padding-bottom in aspect-w-4 controls the ratio */
        }

        /* If you want a more square-like ratio, use this instead */
        .aspect-w-1 {
            position: relative;
            padding-bottom: 100%;
            /* 1:1 aspect ratio (square) */
        }

        .aspect-h-1 {
            /* This is just for semantic clarity */
        }
    </style>
</head>

<body class="bg-white text-gray-900">
    <nav id="navbar" class="fixed top-0 left-0 w-full bg-white shadow-md transition-all duration-300 z-50">
        <div class="flex justify-between items-center px-4 sm:px-6 md:px-10 py-4">
            <!-- Kiri: Logo -->
            <div class="w-1/3">
                <h1 class="text-xl sm:text-2xl font-bold text-blue-600">GayaBelajar<span>KU</span></h1>
            </div>

            <!-- Tengah: Menu Beranda & Tentang -->
            <ul class="hidden md:flex justify-center space-x-6 text-gray-600 w-1/3">
                <li><a href="#beranda" class="hover:text-blue-500">Beranda</a></li>
                <li><a href="#tentang" class="hover:text-blue-500">Tentang</a></li>
                @auth
                    @if (auth()->user()->role === 'user')
                        <li><a href="{{ route('riwayat') }}" class="hover:text-blue-500">Riwayat</a></li>
                    @endif
                @endauth
            </ul>

            <!-- Kanan: Login atau Dropdown + Tombol Hamburger (mobile) -->
            <div class="flex justify-end items-center w-1/3 space-x-4">
                <!-- Desktop login/dropdown -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <!-- Dropdown user -->
                        <div class="relative">
                            <button id="dropdownButton" class="font-semibold text-blue-600">
                                {{ auth()->user()->name }}
                            </button>
                            <div id="dropdownMenu"
                                class="absolute hidden bg-white shadow-md mt-2 right-0 min-w-[150px] rounded-lg overflow-visible">
                                @if (auth()->check())
                                    @if (auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    @elseif (auth()->user()->role === 'pengajar')
                                        <a href="{{ route('pengajar.kelas.index') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    @endif
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="border-2 font-semibold border-blue-600 text-blue-600 px-6 py-1 rounded-2xl transition duration-300 hover:bg-blue-600 hover:text-white">
                            Login
                        </a>
                    @endauth
                </div>


                <!-- Tombol hamburger (hanya tampil di mobile) -->
                <button id="menuButton" class="md:hidden focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu dropdown -->
        <div id="mobileMenu" class="mobile-menu bg-white shadow-md py-4 px-4">
            <ul class="space-y-4 text-gray-600">
                <li><a href="#beranda" class="block hover:text-blue-500">Beranda</a></li>
                <li><a href="#tentang" class="block hover:text-blue-500">Tentang</a></li>
                @auth
                    @if (auth()->user()->role === 'user')
                        <li><a href="{{ route('riwayat') }}" class="hover:text-blue-500">Riwayat</a></li>
                    @endif
                @endauth
                <li>
                    @auth
                        <div class="relative">
                            <button id="mobileDropdownButton" class="font-semibold text-blue-600">
                                {{ auth()->user()->name }}
                            </button>
                            <div id="mobileDropdownMenu" class="hidden bg-gray-50 mt-2 p-2 rounded-lg">
                                @if (auth()->check())
                                    @if (auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    @elseif (auth()->user()->role === 'pengajar')
                                        <a href="{{ route('pengajar.kelas.index') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    @endif
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="block border-2 text-center font-semibold border-blue-600 text-blue-600 px-6 py-1 rounded-2xl transition duration-300 hover:bg-blue-600 hover:text-white">Login</a>
                    @endauth
                </li>
            </ul>
        </div>

    </nav>


    <div id="beranda" class="flex flex-col lg:flex-row items-center px-8 sm:px-6 md:px-10 lg:px-20 pt-32 md:pt-28">
        <div class="lg:w-1/2 mb-10 md:mb-16 text-center lg:text-left" data-aos="fade-right" data-aos-offset="200"
            data-aos-easing="ease-in-sine" data-aos-duration="1000">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Temukan <span class="text-blue-500">
                    Gaya Belajarmu
                    Maksimalkan </span>Potensimu!</h2>
            <p class="text-gray-600 mt-4">Kenali metode belajar yang paling cocok untukmu dan tingkatkan
                efektivitas belajar.</p>
            <a href="{{ route('token.form') }}"
                class="mt-6 inline-block bg-blue-400 text-white px-6 py-3 rounded-3xl hover:bg-blue-600 transition duration-300">Mulai
                Sekarang</a>
        </div>
        <div class="lg:w-1/2 mb-10 md:mb-16 lg:mt-0 ml-8 lg:ml-32" data-aos="fade-left" data-aos-offset="100"
            data-aos-easing="ease-in-sine" data-aos-duration="1000">
            <img src="{{ asset('images/landing-page.png') }}" alt="Quiz Illustration" class="w-[80%] h-[80%]">
        </div>
    </div>

    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#f3f4f6" fill-opacity="1"
            d="M0,192L80,181.3C160,171,320,149,480,144C640,139,800,149,960,138.7C1120,128,1280,96,1360,80L1440,64L1440,320L0,320Z">
        </path>
    </svg>

    <section id="tentang" class="pb-16 md:pb-24 px-4 -mt-16 md:-mt-24 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-20" data-aos="fade-up" data-aos-duration="1000">
            <div class="text-center mb-8 md:mb-12 pt-16 md:pt-20">
                <h2 class="text-2xl md:text-3xl font-bold text-blue-600">Kenali Tipe Gaya Belajarmu</h2>
                <p class="text-gray-600 mt-2">Setiap orang memiliki cara belajar yang berbeda. Temukan mana yang paling
                    sesuai untukmu!</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Visual -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg">
                    <img src="{{ asset('images/visual.png') }}" alt="Visual Learner"
                        class="w-full h-48 sm:h-56 md:h-64 object-cover">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-6 text-white transition-opacity duration-300 group-hover:bg-opacity-70">
                        <h3 class="text-xl font-bold">Visual</h3>
                    </div>
                </div>

                <!-- Auditori -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg">
                    <img src="{{ asset('images/auditori.png') }}" alt="Auditory Learner"
                        class="w-full h-48 sm:h-56 md:h-64 object-cover">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-6 text-white transition-opacity duration-300 group-hover:bg-opacity-70">
                        <h3 class="text-xl font-bold">Auditori</h3>
                    </div>
                </div>

                <!-- Kinestetik -->
                <div class="relative group overflow-hidden rounded-lg shadow-lg">
                    <img src="{{ asset('images/kinestetik.png') }}" alt="Kinesthetic Learner"
                        class="w-full h-48 sm:h-56 md:h-64 object-cover">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-6 text-white transition-opacity duration-300 group-hover:bg-opacity-70">
                        <h3 class="text-xl font-bold">Kinestetik</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 md:py-16 bg-white px-4 ">
        <div class="container mx-auto px-4 sm:px-6 md:px-10 lg:px-20">
            <div class="space-y-10 md:space-y-16">
                <!-- Visual Learner -->
                <div class="flex flex-col lg:flex-row items-center gap-6 md:gap-10" data-aos="fade-right"
                    data-aos-offset="200" data-aos-easing="ease-in-sine" data-aos-duration="1000">
                    <div class="lg:w-1/2">
                        <img src="{{ asset('images/visual.png') }}" alt="Visual Learner"
                            class="w-full h-full  rounded-lg shadow-lg object-cover">
                    </div>
                    <div class="lg:w-1/2 text-left mt-6 lg:mt-0">
                        <h3 class="text-xl md:text-2xl font-bold text-blue-600">Visual</h3>
                        <p class="text-gray-600 mt-4">Pelajar visual lebih memahami informasi melalui gambar, diagram,
                            dan warna. Mereka cenderung mengingat sesuatu yang mereka lihat daripada yang mereka dengar.
                        </p>
                        <ul class="mt-4 text-gray-600 list-disc list-inside">
                            <li>Gunakan mind map atau diagram</li>
                            <li>Gunakan highlight warna untuk teks penting</li>
                            <li>Menonton video edukatif</li>
                        </ul>
                    </div>
                </div>

                <!-- Auditory Learner -->
                <div class="flex flex-col lg:flex-row-reverse items-center gap-6 md:gap-10" data-aos="fade-left"
                    data-aos-offset="200" data-aos-easing="ease-in-sine" data-aos-duration="1000">
                    <div class="lg:w-1/2">
                        <img src="{{ asset('images/auditori.png') }}" alt="Auditory Learner"
                            class="w-full h-full rounded-lg shadow-lg object-cover">
                    </div>
                    <div class="lg:w-1/2 text-left mt-6 lg:mt-0">
                        <h3 class="text-xl md:text-2xl font-bold text-blue-600">Auditori</h3>
                        <p class="text-gray-600 mt-4">Pelajar auditori memahami informasi lebih baik melalui
                            pendengaran. Mereka lebih suka mendengarkan ceramah atau berdiskusi untuk memahami suatu
                            konsep.</p>
                        <ul class="mt-4 text-gray-600 list-disc list-inside">
                            <li>Mendengarkan rekaman atau podcast edukatif</li>
                            <li>Berpartisipasi dalam diskusi atau tanya jawab</li>
                            <li>Mengulang informasi dengan membaca keras</li>
                        </ul>
                    </div>
                </div>

                <!-- Kinesthetic Learner -->
                <div class="flex flex-col lg:flex-row items-center gap-6 md:gap-10" data-aos="fade-right"
                    data-aos-offset="100" data-aos-easing="ease-in-sine" data-aos-duration="1000">
                    <div class="lg:w-1/2">
                        <img src="{{ asset('images/kinestetik.png') }}" alt="Kinesthetic Learner"
                            class="w-full h-full rounded-lg shadow-lg object-cover">
                    </div>
                    <div class="lg:w-1/2 text-left mt-6 lg:mt-0">
                        <h3 class="text-xl md:text-2xl font-bold text-blue-600">Kinestetik</h3>
                        <p class="text-gray-600 mt-4">Pelajar kinestetik lebih memahami konsep melalui praktik
                            langsung. Mereka lebih nyaman belajar dengan melakukan eksperimen atau latihan fisik.</p>
                        <ul class="mt-4 text-gray-600 list-disc list-inside">
                            <li>Belajar dengan praktik langsung</li>
                            <li>Menggunakan alat bantu interaktif</li>
                            <li>Mengajar atau mendemonstrasikan konsep</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-16 bg-blue-500 text-white text-center px-8">
        <h2 class="text-2xl md:text-3xl font-bold">Siap Menemukan Gaya Belajarmu?</h2>
        <p class="mt-2">Ikuti kuis kami sekarang dan temukan metode belajar terbaik untukmu!</p>
        <a href="{{ route('token.form') }}"
            class="mt-6 inline-block bg-white text-blue-500 px-6 py-3 rounded-3xl font-bold hover:bg-gray-200 transition duration-300">
            Mulai Kuis Sekarang
        </a>
    </section>

    <footer class="bg-white text-black py-6">
        <div class="container mx-auto text-center px-4">
            <p class="text-sm">&copy; 2025 GayaBelajarKU. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>


    <script>
        AOS.init();
        document.addEventListener("DOMContentLoaded", function() {
            // Dropdown menu for desktop
            const dropdownButton = document.getElementById("dropdownButton");
            const dropdownMenu = document.getElementById("dropdownMenu");

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener("click", function(event) {
                    event.stopPropagation();
                    dropdownMenu.classList.toggle("hidden");
                });
            }

            // Dropdown menu for mobile
            const mobileDropdownButton = document.getElementById("mobileDropdownButton");
            const mobileDropdownMenu = document.getElementById("mobileDropdownMenu");

            if (mobileDropdownButton && mobileDropdownMenu) {
                mobileDropdownButton.addEventListener("click", function(event) {
                    event.stopPropagation();
                    mobileDropdownMenu.classList.toggle("hidden");
                });
            }

            // Mobile menu toggle
            const menuButton = document.getElementById("menuButton");
            const mobileMenu = document.getElementById("mobileMenu");

            if (menuButton && mobileMenu) {
                menuButton.addEventListener("click", function() {
                    mobileMenu.classList.toggle("active");
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener("click", function(event) {
                if (dropdownButton && dropdownMenu && !dropdownButton.contains(event.target) && !
                    dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add("hidden");
                }

                if (mobileDropdownButton && mobileDropdownMenu && !mobileDropdownButton.contains(event
                        .target) && !mobileDropdownMenu.contains(event.target)) {
                    mobileDropdownMenu.classList.add("hidden");
                }
            });

            // Close mobile menu when clicking on a link
            const mobileMenuLinks = document.querySelectorAll("#mobileMenu a");
            mobileMenuLinks.forEach(link => {
                link.addEventListener("click", function() {
                    if (mobileMenu) {
                        mobileMenu.classList.remove("active");
                    }
                });
            });

            // Shrink navbar on scroll
            // const navbar = document.getElementById("navbar");
            // if (navbar) {
            //     window.addEventListener("scroll", function() {
            //         if (window.scrollY > 50) {
            //             navbar.classList.add("py-2");
            //             navbar.classList.remove("py-4");
            //         } else {
            //             navbar.classList.add("py-4");
            //             navbar.classList.remove("py-2");
            //         }
            //     });
            // }
        });
    </script>
</body>

</html>
