<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengeluaran - Sistem Manajemen Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        <a href="{{ route('keuangan.index') }}" class="text-gray-500 hover:underline">Kembali</a>
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">Simpan</button>
    </div>
</form>

</div>

</body>
</html>
