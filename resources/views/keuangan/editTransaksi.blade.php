<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi - Sistem Manajemen Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit {{ ucfirst($transaksi->jenis) }}</h2>

    <form action="{{ route('keuangan.update', $transaksi->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <input type="hidden" name="jenis" value="{{ $transaksi->jenis }}">

        <div>
            <label class="block text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border rounded px-3 py-2" 
                   value="{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('Y-m-d') }}" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Deskripsi</label>
            <input type="text" name="deskripsi" class="w-full border rounded px-3 py-2" 
                   value="{{ $transaksi->deskripsi }}" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" 
                   value="{{ $transaksi->jumlah }}" required>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('keuangan.index') }}" class="text-gray-500 hover:underline">Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
