@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Edit Pengguna</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-bold">Nama</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-bold">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-bold">Role</label>
            <select name="role" class="w-full border p-2 rounded">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pengajar" {{ $user->role == 'pengajar' ? 'selected' : '' }}>Pengajar</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
    </form>
</div>
@endsection
