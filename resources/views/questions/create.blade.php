@extends('layouts.app')

@section('title', 'Tambah Soal')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Tambah Soal</h1>

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Pertanyaan</label>
            <input type="text" name="question_text" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tipe Soal</label>
            <select name="is_favoritable" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1">
                <option value="1">Favoritable</option>
                <option value="0">Unfavoritable</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <select name="type" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1">
                <option value="visual">Visual</option>
                <option value="auditory">Auditory</option>
                <option value="kinesthetic">Kinesthetic</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Simpan</button>
    </form>
</div>
@endsection
