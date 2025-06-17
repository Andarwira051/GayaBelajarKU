@extends('layouts.app')

@section('title', 'Tambah Soal')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Tambah Soal</h1>
    <form action="{{ route('admin.questions.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <input type="file" name="file" required class="border p-2">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Import Soal</button>
    </form>
</div>
@endsection
