<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Siswa - Sistem Manajemen Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-6">
    <h2 class="text-2xl font-bold mb-4">Tagihan Siswa</h2>

    <a href="{{ route('keuangan.createTagihan') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-4 inline-block">Tambah Tagihan</a>

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Deskripsi</th>
                <th class="border px-4 py-2">Jumlah (Rp)</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tagihan as $t)
            <tr>
                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}</td>
                <td class="border px-4 py-2">{{ $t->deskripsi }}</td>
                <td class="border px-4 py-2">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                <td class="border px-4 py-2 space-x-2">
                    <a href="{{ route('keuangan.editTagihan', $t->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('keuangan.destroyTagihan', $t->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus tagihan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 font-bold">Total Tagihan: Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
</div>

</body>
</html>
