{{-- resources/views/ekskul/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Ekstrakurikuler')
@section('page-title', 'Manajemen Ekstrakurikuler')

@section('content')
    <!-- Control Panel -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 flex flex-col md:flex-row items-center justify-between">
        <form method="GET" action="{{ route('ekskul.index') }}"
              class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
            <!-- Search -->
            <div class="relative w-full md:w-64">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari ekstrakurikuler..."
                       class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 
                              focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-300">
                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <!-- Filter Kategori -->
            <select name="category"
                    class="w-full md:w-48 py-2 px-4 rounded-lg border border-gray-300 bg-white 
                           focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-300">
                <option value="">Semua Kategori</option>
                <option value="Olahraga" {{ request('category')=='Olahraga'?'selected':'' }}>Olahraga</option>
                <option value="Seni" {{ request('category')=='Seni'?'selected':'' }}>Seni</option>
                <option value="Sains" {{ request('category')=='Sains'?'selected':'' }}>Sains</option>
                <option value="Bahasa" {{ request('category')=='Bahasa'?'selected':'' }}>Bahasa</option>
            </select>
        </form>

        <!-- Tambah Ekstrakurikuler -->
        <a href="{{ route('ekskul.create') }}"
           class="mt-4 md:mt-0 bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md 
                  hover:bg-indigo-700 transition duration-300 w-full md:w-auto">
            <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Ekstrakurikuler
        </a>
    </div>

    <!-- Daftar Ekstrakurikuler -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($ekskul as $item)
            <div class="bg-white p-6 rounded-xl shadow-md flex flex-col justify-between 
                        transform hover:scale-105 transition-transform duration-300">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $item['nama'] }}</h3>
                    <p class="text-sm text-gray-500 mb-2 font-medium">{{ $item['kategori'] ?? '-' }}</p>
                    <p class="text-gray-600 mb-4 text-sm">{{ $item['deskripsi'] ?? 'Belum ada deskripsi.' }}</p>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><i class="fa-solid fa-user-tie text-indigo-500 w-5 mr-2"></i> {{ $item['pembina'] ?? '-' }}</p>
                        <p><i class="fa-solid fa-clock text-indigo-500 w-5 mr-2"></i> {{ $item['jadwal'] }}</p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="grid grid-cols-3 gap-2 mt-4">
                    <!-- Detail -->
                    <a href="{{ route('ekskul.show', $item['id']) }}"
                       class="w-full py-2 px-3 rounded-lg bg-indigo-500 text-white text-sm font-semibold hover:bg-indigo-600 transition duration-300 text-center">
                        <i class="fa-solid fa-eye mr-1"></i> Detail
                    </a>

                    <!-- Edit -->
                    <a href="{{ route('ekskul.edit', $item['id']) }}"
                       class="w-full py-2 px-3 rounded-lg bg-teal-500 text-white text-sm font-semibold hover:bg-teal-600 transition duration-300 text-center">
                        <i class="fa-solid fa-edit mr-1"></i> Edit
                    </a>

                    <!-- Hapus -->
                    <form action="{{ route('ekskul.destroy', $item['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full py-2 px-3 rounded-lg bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition duration-300"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini?')">
                            <i class="fa-solid fa-trash-alt mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center">Belum ada ekstrakurikuler.</p>
        @endforelse
    </div>
@endsection
