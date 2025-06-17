@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="w-full">
    <div class="bg-white rounded-xl md:ml-64 shadow-lg overflow-hidden border border-gray-100">
        <div class="pl-7 pt-5 text-blue-500">
            <h1 class="text-xl md:text-xl font-bold flex items-center">
                Dashboard Admin
            </h1>
            <p class="mt-1 text-black font-light">Selamat datang kembali, {{ auth()->user()->name }}</p>
        </div>

        <div class="p-5 md:p-6">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-blue-50 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="p-5 flex items-center">
                        <div class="bg-blue-500 p-3 rounded-lg mr-4">
                            <i data-lucide="users" class="text-white w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-blue-500 text-sm font-medium">Total Pengguna</p>
                            <h3 class="text-2xl text-blue-500 md:text-3xl font-bold">{{ $userCount }}</h3>
                        </div>
                    </div>
                    <div class="px-5 pb-4">
                        <a href="{{ route('users.index') }}" class="text-sm text-blue-500 hover:text-blue-800 flex items-center">
                            Kelola <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-blue-50 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="p-5 flex items-center">
                        <div class="bg-green-500 p-3 rounded-lg mr-4">
                            <i data-lucide="file-text" class="text-white w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-green-500 text-sm font-medium">Total Soal</p>
                            <h3 class="text-2xl text-green-500 md:text-3xl font-bold">{{ $questionCount }}</h3>
                        </div>
                    </div>
                    <div class="px-5 pb-4">
                        <a href="{{ route('questions.index') }}" class="text-sm text-green-500 hover:text-green-700 flex items-center">
                            Kelola <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Menu Cepat -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <i data-lucide="zap" class="w-5 h-5 mr-2 text-blue-600"></i>
                    Menu Cepat
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-3">
                    <a href="{{ route('users.create') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-blue-50 transition-all duration-300">
                        <div class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                            <i data-lucide="user-plus" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Tambah Pengguna</h3>
                            <p class="text-sm text-gray-500">Daftarkan pengguna baru</p>
                        </div>
                    </a>
                    <a href="{{ route('questions.create') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition-all duration-300">
                        <div class="bg-green-100 text-green-600 p-2 rounded-lg mr-3">
                            <i data-lucide="file-plus" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Tambah Soal</h3>
                            <p class="text-sm text-gray-500">Buat soal baru</p>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
