<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Temukan Gaya Belajarmu!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* General container padding */
        .container {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            max-width: 80rem;
        }

        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        html {
            scroll-behavior: smooth;
        }

        .mobile-menu {
            display: none;
        }

        .mobile-menu.active {
            display: block;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 768px) {
            .table-responsive {
                display: block;
                white-space: nowrap;
            }

            .mobile-card {
                display: block;
            }

            .desktop-table {
                display: none;
            }
        }

        @media (min-width: 769px) {
            .mobile-card {
                display: none;
            }

            .desktop-table {
                display: table;
                margin-left: auto;
                margin-right: auto;
                width: 100%;
                max-width: 64rem;
            }
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .badge-visual {
            background-color: #e0f2fe;
            color: #1e40af;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
        }

        .badge-auditory {
            background-color: #dcfce7;
            color: #166534;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
        }

        .badge-kinesthetic {
            background-color: #fed7aa;
            color: #c2410c;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
        }

        .desktop-table table {
            border-collapse: collapse;
            width: 100%;
        }

        .desktop-table th,
        .desktop-table td {
            padding: 1.25rem;
            text-align: left;
            vertical-align: middle;
        }

        .desktop-table th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #4b5563;
            border-bottom: 2px solid #e5e7eb;
        }

        .desktop-table td {
            font-size: 0.875rem;
            color: #1f2937;
            border-bottom: 1px solid #f3f4f6;
        }

        .desktop-table th:nth-child(4),
        .desktop-table td:nth-child(4),
        .desktop-table th:nth-child(5),
        .desktop-table td:nth-child(5) {
            text-align: center;
        }

        .detail-button {
            transition: all 0.2s ease-in-out;
        }

        .detail-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .mobile-card .card {
            transition: all 0.2s ease-in-out;
        }

        .mobile-card .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen">
    <nav id="navbar" class="fixed top-0 left-0 w-full bg-white shadow-md transition-all duration-300 z-50">
        <div class="flex justify-between items-center px-4 sm:px-6 md:px-10 py-4">
            <!-- Kiri: Logo -->
            <div class="w-1/3">
                <h1 class="text-xl sm:text-2xl font-bold text-blue-600">GayaBelajar<span>KU</span></h1>
            </div>

            <!-- Tengah: Menu Beranda & Tentang -->
            <ul class="hidden md:flex justify-center space-x-6 text-gray-600 w-1/3">
                <li><a href="/" class="hover:text-blue-500">Beranda</a></li>
                <li><a href="/" class="hover:text-blue-500">Tentang</a></li>
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
                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'pengajar')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
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
                <li><a href="/" class="block hover:text-blue-500">Beranda</a></li>
                <li><a href="/" class="block hover:text-blue-500">Tentang</a></li>
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

                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'pengajar')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
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

    <div class="pt-20 pb-12">
        <div class="container mx-auto">
            <div class="text-center mb-8" data-aos="fade-up">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Riwayat Tes Gaya Belajar</h1>
                <p class="text-gray-600 text-base md:text-lg">Lihat semua hasil tes yang pernah kamu lakukan</p>
            </div>

            <!-- Desktop Table View -->
            <div class="desktop-table bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up"
                data-aos-delay="100">
                <div class="table-responsive">
                    <table class="w-full">
                        <thead class="bg-gray">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>Tanggal & Waktu</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <span>Kelas</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span>Pengajar</span>
                                    </div>
                                </th>

                                <th
                                    class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">

                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tests as $test)
                                <tr class="table-row-hover transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $test->created_at->format('d F Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $test->created_at->format('H:i') }} WITA
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $test->kelas_info->nama_kelas ?? 'Kelas Tidak Ditemukan' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $test->kelas_info->pengajar->name ?? 'Pengajar Tidak Ditemukan' }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('showDetail', ['id' => $test->id]) }}"
                                            class="detail-button bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-3 rounded-md text-sm">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada riwayat tes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-card space-y-4" data-aos="fade-up" data-aos-delay="200">
                @forelse ($tests as $test)
                    <div class="card bg-white rounded-2xl shadow-lg p-5 border border-gray-100">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 text-base">
                                    {{ $test->kelas_info->nama_kelas ?? 'Kelas Tidak Ditemukan' }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $test->kelas_info->pengajar->name ?? 'Pengajar Tidak Ditemukan' }}</p>
                            </div>

                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">{{ $test->created_at->format('d M Y, H:i') }}</p>
                            <a href="{{ route('showDetail', ['id' => $test->id]) }}"
                                class="detail-button bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-3 rounded-md text-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="card bg-white rounded-2xl shadow-lg p-5 border border-gray-100 text-center">
                        <p class="text-sm text-gray-500">Belum ada riwayat tes.</p>
                    </div>
                @endforelse
            </div>


        </div>
    </div>

    <footer class="bg-white text-black py-8 mt-12 border-t border-gray-100">
        <div class="container mx-auto text-center px-4">
            <p class="text-sm text-gray-600">© 2025 GayaBelajarKU. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });

        document.addEventListener("DOMContentLoaded", function() {
            const dropdownButton = document.getElementById("dropdownButton");
            const dropdownMenu = document.getElementById("dropdownMenu");
            const mobileDropdownButton = document.getElementById("mobileDropdownButton");
            const mobileDropdownMenu = document.getElementById("mobileDropdownMenu");
            const menuButton = document.getElementById("menuButton");
            const mobileMenu = document.getElementById("mobileMenu");

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener("click", function(event) {
                    event.stopPropagation();
                    dropdownMenu.classList.toggle("hidden");
                });
            }

            if (mobileDropdownButton && mobileDropdownMenu) {
                mobileDropdownButton.addEventListener("click", function(event) {
                    event.stopPropagation();
                    mobileDropdownMenu.classList.toggle("hidden");
                });
            }

            if (menuButton && mobileMenu) {
                menuButton.addEventListener("click", function() {
                    mobileMenu.classList.toggle("active");
                });
            }

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

            const mobileMenuLinks = document.querySelectorAll("#mobileMenu a");
            mobileMenuLinks.forEach(link => {
                link.addEventListener("click", function() {
                    if (mobileMenu) {
                        mobileMenu.classList.remove("active");
                    }
                });
            });
        });
    </script>
</body>

</html>
