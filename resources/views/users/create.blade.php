@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-6 flex items-center">
        <i data-lucide="user-plus" class="w-6 h-6 mr-2"></i> Tambah Pengguna
    </h1>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block font-bold mb-2">Nama</label>
            <div class="relative">
                <i data-lucide="user" class="absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="name" class="w-full border p-3 pl-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required placeholder="Masukkan nama pengguna">
            </div>
        </div>

        <div>
            <label class="block font-bold mb-2">Email</label>
            <div class="relative">
                <i data-lucide="mail" class="absolute left-3 top-3 text-gray-400"></i>
                <input type="email" name="email" class="w-full border p-3 pl-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required placeholder="Masukkan email">
            </div>
        </div>

        <div>
            <label class="block font-bold mb-2">Password</label>
            <div class="relative">
                <i data-lucide="lock" class="absolute left-3 top-3 text-gray-400"></i>
                <input type="password" name="password" class="w-full border p-3 pl-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required placeholder="Masukkan password">
            </div>
        </div>

        <div>
            <label class="block font-bold mb-2">Role</label>
            <div class="relative">
                <i data-lucide="briefcase" class="absolute left-3 top-3 text-gray-400"></i>
                <select name="role" class="w-full border p-3 pl-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="admin">Admin</option>
                    <option value="pengajar">Pengajar</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>

        <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg shadow hover:bg-green-600 transition flex items-center justify-center">
            <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i> Tambah Pengguna
        </button>
    </form>
</div>

<script>
    lucide.createIcons(); // Inisialisasi ikon
</script>
@endsection
