<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tagihan Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">

    <!-- Judul Form -->
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Tagihan Siswa</h2>

    <!-- Form Tagihan -->
    <form action="{{ route('keuangan.storeTagihan') }}" method="POST" class="space-y-4" autocomplete="off">
        @csrf
        <div>
            <label class="block text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">NIS Siswa</label>
            <input type="text" name="nis" class="w-full border rounded px-3 py-2" placeholder="Contoh: 220103194" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Nama Siswa</label>
            <input type="text" name="siswa" class="w-full border rounded px-3 py-2" placeholder="Contoh: Andika Bagus Saputra" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Deskripsi</label>
            <input type="text" name="deskripsi" class="w-full border rounded px-3 py-2" placeholder="Contoh: SPP Bulan Juli" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" placeholder="Contoh: 500000" required>
        </div>

        <!-- Tombol Batal & Simpan -->
        <div class="flex justify-between items-center mt-6">
            <!-- Tombol Batal -->
            <a href="{{ route('keuangan.tagihan') }}" 
               class="flex items-center bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Batal
            </a>

            <!-- Tombol Simpan -->
            <button type="submit" 
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition duration-200">
                Simpan
            </button>
        </div>
    </form>
</div>

</body>
</html>
