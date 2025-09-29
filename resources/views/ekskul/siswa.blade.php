@extends('layouts.app')

@section('title', 'Daftar Siswa')
@section('page-title', 'Daftar Siswa - ' . ($ekskul['nama'] ?? 'Ekskul'))

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <!-- Tombol Kembali ke Detail -->
    <div class="mb-4">
        <a href="{{ route('ekskul.show', $ekskul['id']) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Detail
        </a>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Siswa Ekskul {{ $ekskul['nama'] }}</h2>

    @if(!empty($ekskul['siswa']))
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg shadow">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-2 border text-center">No</th>
                        <th class="px-4 py-2 border text-left">Nama</th>
                        <th class="px-4 py-2 border text-left">Kelas</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ekskul['siswa'] as $index => $siswa)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border font-medium">{{ $siswa['nama'] }}</td>
                            <td class="px-4 py-2 border">{{ $siswa['kelas'] }}</td>
                            <td class="px-4 py-2 border text-center">
                                <form action="{{ route('ekskul.siswa.destroy', [$ekskul['id'], $index]) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">Belum ada siswa yang terdaftar.</p>
    @endif
</div>
@endsection
