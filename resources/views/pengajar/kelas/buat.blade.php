@extends('layouts.nav')

@section('title', 'Buat Kelas Baru')

@section('content')
    <div class="bg-white p-6 rounded-xl md:ml-64 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <h1 class="text-xl md:text-2xl font-bold text-blue-500 flex items-center">
                <i data-lucide="plus-circle" class="w-6 h-6 mr-2"></i>
                Buat Kelas Baru
            </h1>
            <a href="{{ route('pengajar.kelas.index') }}" 
               class="flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition-all duration-300 transform hover:scale-105">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2 text-green-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                    <i data-lucide="book-open" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Informasi Kelas
                </h2>
            </div>

            <form action="{{ route('pengajar.kelas.simpan') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-6">
                    <div class="relative">
                        <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="tag" class="w-4 h-4 inline mr-1 text-gray-500"></i>
                            Nama Kelas <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i data-lucide="users" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                            <input type="text" 
                                   name="nama_kelas" 
                                   id="nama_kelas" 
                                   value="{{ old('nama_kelas') }}"
                                   placeholder="Masukkan nama kelas (contoh: Kelas 7A, Matematika Dasar, dll.)"
                                   class="pl-10 pr-4 py-3 w-full border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 {{ $errors->has('nama_kelas') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : '' }}"
                                   required>
                        </div>
                        @error('nama_kelas')
                            <div class="mt-2 flex items-center text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                            Berikan nama yang jelas dan mudah diingat untuk kelas Anda
                        </p>
                    </div>

                    <!-- Token Kelas Info -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i data-lucide="key" class="w-5 h-5 text-gray-500 mr-2"></i>
                            <h3 class="text-sm font-medium text-gray-700">Token Kelas</h3>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">
                            Token kelas akan dibuat secara otomatis setelah kelas berhasil dibuat. 
                            Token ini digunakan untuk siswa bergabung ke dalam kelas.
                        </p>
                        <div class="flex items-center text-xs text-blue-600">
                            <i data-lucide="info" class="w-4 h-4 mr-1"></i>
                            <span>Format: KELAS-XXXXXX (6 karakter acak)</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <button type="submit" 
                            class="flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 focus:ring-4 focus:ring-blue-200">
                        <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                        Buat Kelas
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
            
            // Auto-focus pada input nama kelas
            document.getElementById('nama_kelas').focus();
            
            // Form validation
            const form = document.querySelector('form');
            const namaKelasInput = document.getElementById('nama_kelas');
            
            form.addEventListener('submit', function(e) {
                if (namaKelasInput.value.trim() === '') {
                    e.preventDefault();
                    namaKelasInput.focus();
                    namaKelasInput.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                }
            });
            
            // Remove error styling on input
            namaKelasInput.addEventListener('input', function() {
                this.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            });
        });
    </script>
@endsection