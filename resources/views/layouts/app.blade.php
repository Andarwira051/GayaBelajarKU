    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Admin Panel')</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }

            /* Custom scrollbar */
            .custom-scrollbar::-webkit-scrollbar {
                width: 5px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: rgba(247, 250, 252, 0.8);
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(203, 213, 225, 0.8);
                border-radius: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(148, 163, 184, 0.8);
            }

            /* For Firefox */
            .custom-scrollbar {
                scrollbar-width: thin;
                scrollbar-color: rgba(203, 213, 225, 0.8) rgba(247, 250, 252, 0.8);
            }

            /* Sidebar transitions */
            .sidebar-transition {
                transition: all 0.3s ease-in-out;
            }

            /* Main content transition */
            .content-transition {
                transition: margin-left 0.3s ease-in-out;
            }

            /* Pulse animation for notifications */
            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            .animate-pulse-slow {
                animation: pulse 2s infinite;
            }

            /* Toast notification */
            .toast {
                right: -100%;
                transition: right 0.5s ease-in-out;
            }

            .toast.show {
                right: 1rem;
            }

            /* Dark mode variables will be added here when implementing dark mode */
        </style>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#f0f9ff',
                                100: '#e0f2fe',
                                200: '#bae6fd',
                                300: '#7dd3fc',
                                400: '#38bdf8',
                                500: '#0ea5e9',
                                600: '#0284c7',
                                700: '#0369a1',
                                800: '#075985',
                                900: '#0c4a6e',
                            }
                        },
                        boxShadow: {
                            'card': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                            'sidebar': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                        }
                    }
                }
            }
        </script>
    </head>

    <body class="bg-gray-50 flex flex-col min-h-screen custom-scrollbar">
        <!-- Toast Notification -->
        <div id="toast"
            class="toast fixed z-50 top-4 flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow-lg border-l-4 border-primary-500">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-primary-500 bg-primary-100 rounded-lg">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
            <div class="ml-3 text-sm font-normal">
                <span id="toastMessage">Berhasil menyimpan perubahan!</span>
            </div>
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 inline-flex h-8 w-8"
                onclick="hideToast()">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuButton"
            class="md:hidden fixed top-3 left-4 z-50 bg-primary-600 text-white p-2 rounded-lg shadow-lg">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-64 bg-white text-gray-800 shadow-sidebar sidebar-transition fixed h-full z-40 transform -translate-x-full md:translate-x-0 custom-scrollbar overflow-y-auto">

            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <div class="flex items-center space-x-2">
                    <div class="p-2 bg-primary-100 rounded-lg">
                        <i data-lucide="layout-dashboard" class="w-6 h-6 text-blue-500"></i>
                    </div>
                    <h2 class="text-xm font-bold text-black">Admin Panel</h2>
                </div>
                <button id="closeSidebar" class="md:hidden text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- User Profile Section -->
            <div class="p-4 border-b">
                <div class="flex items-center">
                    <img src="{{ asset('images/visual.png') }}" alt="Profile"
                        class="w-10 h-10 rounded-full border border-gray-200">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="p-4">
                {{-- <p class="text-xs text-gray-500 font-semibold mb-2 uppercase">Menu Utama</p> --}}
                <ul>
                    @if (auth()->user()->role === 'admin')
                        <li class="mb-2">
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-gray-100' }}">
                                <i data-lucide="home"
                                    class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-blue-700' }}"></i>
                                <span class="text-sm">Dashboard</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('users.index') }}"
                                class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-gray-100' }}">
                                <i data-lucide="users"
                                    class="w-5 h-5 mr-3 {{ request()->routeIs('users.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-700' }}"></i>
                                <span class="text-sm">Kelola Pengguna</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('questions.index') }}"
                                class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('questions.*') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-gray-100' }}">
                                <i data-lucide="file-text"
                                    class="w-5 h-5 mr-3 {{ request()->routeIs('questions.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-700' }}"></i>
                                <span class="text-sm">Kelola Soal</span>
                            </a>
                        </li>
                    @endif
                    
                </ul>

                {{-- <p class="text-xs text-gray-500 font-semibold mb-2 mt-6 uppercase">Pengaturan</p> --}}
                <ul>
                    <li class="mb-2">
                        <form action="{{ route('logout') }}" method="POST"
                            class="flex items-center p-2 rounded-lg transition-all duration-200 group hover:bg-red-50 text-red-600">
                            @csrf
                            @method('POST')
                            <button type="submit" class="flex items-center w-full text-left">
                                <i data-lucide="log-out" class="w-5 h-5 mr-3 text-red-500"></i>
                                <span class="text-sm">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>

            </div>

            <!-- Version Info -->
            {{-- <div class="p-4 mt-auto">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500 text-center">v1.0.0</p>
                </div>
            </div> --}}
        </aside>

        <!-- Main Content -->
        <div id="mainContent" class="flex-1 flex flex-col content-transition content-with-sidebar">
            <!-- Header -->
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="flex justify-between items-center p-4">
                    <div class="flex items-center">
                        <h1 class="text-lg font-bold text-gray-800 ml-10 md:ml-64">@yield('', '')</h1>
                        <div class="hidden md:flex ml-4 items-center">
                            <nav class="flex" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="text-sm text-gray-700 hover:text-primary-600">
                                            Home
                                        </a>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                                            <span class="ml-1 text-sm text-gray-500 md:ml-2">@yield('title', 'Dashboard')</span>
                                        </div>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Search -->


                        <!-- Profile -->
                        <div class="flex items-center space-x-2">
                            <div class="hidden md:block text-right">
                                <span
                                    class="block text-gray-700 font-semibold text-sm">{{ auth()->user()->name }}</span>
                                <span class="block text-gray-500 text-xs">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                            <div class="relative">
                                <button id="userMenuButton" type="button"
                                    class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-200">
                                    <img src="{{ asset('images/visual.png') }}" alt="Profile"
                                        class="w-8 h-8 md:w-10 md:h-10 rounded-full border border-gray-300">
                                </button>
                                <!-- User dropdown menu -->
                                <div id="userDropdown"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50">
                                    <div class="p-3 border-b">
                                        <span
                                            class="block text-sm text-gray-900 font-semibold">{{ auth()->user()->name }}</span>
                                        <span
                                            class="block text-sm text-gray-500 truncate">{{ auth()->user()->email }}</span>
                                    </div>
                                    <ul class="py-1">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                class="block py-2 px-4 text-sm text-red-600 hover:bg-gray-100">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 md:p-6 flex-grow">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white py-4 px-6 md:ml-64 border-t">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Admin Panel. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const mobileMenuButton = document.getElementById('mobileMenuButton');
                const closeSidebar = document.getElementById('closeSidebar');

                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });

                closeSidebar.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                });

                // Icon refresh
                lucide.createIcons();
            });

            function hideToast() {
                const toast = document.getElementById("toast");
                toast.classList.remove("show");
            }
        </script>

    </body>

    </html>
