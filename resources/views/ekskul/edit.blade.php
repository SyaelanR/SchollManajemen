@extends('layouts.app')
@section('title', 'Edit Ekskul')
@section('page-title', 'Edit Ekstrakurikuler')

@section('content')
<div class="bg-white rounded-xl p-6">
    <form action="{{ route('ekskul.update', $ekskul['id'] ?? '') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama Ekskul</label>
            <input type="text" name="nama" class="w-full p-3 border rounded-lg"
                   value="{{ $ekskul['nama'] ?? '' }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Pembina</label>
            <input type="text" name="pembina" class="w-full p-3 border rounded-lg"
                   value="{{ $ekskul['pembina'] ?? '' }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Hari & Jam</label>
            <input type="text" name="jadwal" class="w-full p-3 border rounded-lg"
                   value="{{ $ekskul['jadwal'] ?? '' }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Kategori</label>
            <select name="kategori" class="w-full p-3 border rounded-lg">
                <option value="Olahraga" {{ ($ekskul['kategori'] ?? '')=='Olahraga'?'selected':'' }}>Olahraga</option>
                <option value="Seni" {{ ($ekskul['kategori'] ?? '')=='Seni'?'selected':'' }}>Seni</option>
                <option value="Sains" {{ ($ekskul['kategori'] ?? '')=='Sains'?'selected':'' }}>Sains</option>
                <option value="Bahasa" {{ ($ekskul['kategori'] ?? '')=='Bahasa'?'selected':'' }}>Bahasa</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Deskripsi</label>
            <textarea name="deskripsi" class="w-full p-3 border rounded-lg" rows="3">{{ $ekskul['deskripsi'] ?? '' }}</textarea>
        </div>

        <div class="flex space-x-3">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                Update
            </button>
            <a href="{{ route('ekskul.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
