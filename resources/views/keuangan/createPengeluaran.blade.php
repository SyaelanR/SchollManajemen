<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengeluaran - Sistem Manajemen Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pengeluaran</h2>

    <form action="{{ route('keuangan.storePengeluaran') }}" method="POST" class="space-y-4" autocomplete="off">
        @csrf
        <div>
            <label class="block text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border rounded px-3 py-2" required autocomplete="off">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Deskripsi</label>
            <input type="text" name="deskripsi" class="w-full border rounded px-3 py-2" placeholder="Contoh: Listrik Sekolah" required autocomplete="off">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" placeholder="Contoh: 2000000" required autocomplete="off">
        </div>

        <div class="flex justify-between items-center mt-6">
            <!-- Tombol Batal (Merah di kiri) -->
            <a href="{{ route('keuangan.index') }}" 
               class="flex items-center bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Batal
            </a>

            <!-- Tombol Simpan (Hijau di kanan) -->
            <button type="submit" 
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>

</body>
</html>
