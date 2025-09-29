@extends('layouts.app')
@section('title', 'Tambah Ekskul')
@section('page-title', 'Tambah Ekstrakurikuler')

@section('content')
<div class="bg-white rounded-xl p-6">
    <form action="{{ route('ekskul.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama Ekskul</label>
            <input type="text" name="nama" class="w-full p-3 border rounded-lg"
                   placeholder="Contoh: Futsal" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Pembina</label>
            <input type="text" name="pembina" class="w-full p-3 border rounded-lg"
                   placeholder="Nama Pembina" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Hari & Jam</label>
            <input type="text" name="jadwal" class="w-full p-3 border rounded-lg"
                   placeholder="Contoh: Selasa, 15:00 - 17:00" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Kategori</label>
            <select name="kategori" class="w-full p-3 border rounded-lg">
                <option value="Olahraga">Olahraga</option>
                <option value="Seni">Seni</option>
                <option value="Sains">Sains</option>
                <option value="Bahasa">Bahasa</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Deskripsi</label>
            <textarea name="deskripsi" class="w-full p-3 border rounded-lg" rows="3"
                      placeholder="Tuliskan deskripsi singkat..."></textarea>
        </div>

        <div class="flex space-x-3">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                Simpan
            </button>
            <a href="{{ route('ekskul.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
