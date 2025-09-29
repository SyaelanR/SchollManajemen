@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')
@section('page-title', 'Detail Ekstrakurikuler')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <!-- Tombol Kembali -->
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('ekskul.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>

        @if(!empty($ekskul['siswa']))
            <a href="{{ route('ekskul.siswa.index', $ekskul['id']) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                <i class="fa-solid fa-users mr-2"></i> Lihat Daftar Siswa
            </a>
        @endif
    </div>

    <!-- Info Ekskul -->
    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $ekskul['nama'] }}</h2>
    <p class="text-sm text-gray-500 mb-4">{{ $ekskul['kategori'] ?? '-' }}</p>
    <p class="text-gray-700 mb-6">{{ $ekskul['deskripsi'] ?? 'Belum ada deskripsi.' }}</p>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div>
            <p class="text-sm text-gray-600">
                <i class="fa-solid fa-user-tie text-indigo-500 mr-2"></i>Pembina
            </p>
            <p class="font-medium">{{ $ekskul['pembina'] ?? '-' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">
                <i class="fa-solid fa-clock text-indigo-500 mr-2"></i>Jadwal
            </p>
            <p class="font-medium">{{ $ekskul['jadwal'] ?? '-' }}</p>
        </div>
    </div>

    <!-- Tambah Siswa -->
    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Tambah Siswa</h3>
        <form method="POST" action="{{ route('ekskul.siswa.store', $ekskul['id']) }}" class="grid md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                <input type="text" name="nama" required
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <input type="text" name="kelas" required
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500">
            </div>
            <div class="md:col-span-2">
                <button type="submit"
                        class="w-full md:w-auto px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
