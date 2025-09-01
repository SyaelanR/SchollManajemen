<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tagihan Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">

    <!-- Tombol Kembali Panah -->
    <div class="mb-6">
        <a href="{{ route('keuangan.tagihan') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg shadow hover:bg-gray-200 hover:text-gray-900 transition duration-200">
            <!-- Ikon panah kiri -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0L6.586 11l4.707-4.707a1 1 0 011.414 1.414L9.414 11l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Judul Form -->
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Tagihan Siswa</h2>

    <!-- Form Edit Tagihan -->
    <form action="{{ route('keuangan.updateTagihan', $tagihan->id) }}" method="POST" class="space-y-4" autocomplete="off">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border rounded px-3 py-2" value="{{ $tagihan->tanggal }}" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">NIS Siswa</label>
            <input type="text" name="nis" class="w-full border rounded px-3 py-2" value="{{ $tagihan->nis ?? '' }}" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Nama Siswa</label>
            <input type="text" name="siswa" class="w-full border rounded px-3 py-2" value="{{ $tagihan->siswa ?? '' }}" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Deskripsi</label>
            <input type="text" name="deskripsi" class="w-full border rounded px-3 py-2" value="{{ $tagihan->deskripsi }}" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" value="{{ $tagihan->jumlah }}" required>
        </div>

        <!-- Tombol Batal & Simpan -->
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('keuangan.tagihan') }}" class="inline-flex items-center text-gray-500 hover:text-gray-900 hover:underline transition duration-200">
                <!-- Ikon panah kiri kecil -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0L6.586 11l4.707-4.707a1 1 0 011.414 1.414L9.414 11l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Batal
            </a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition duration-200">Simpan</button>
        </div>
    </form>

</div>

</body>
</html>
