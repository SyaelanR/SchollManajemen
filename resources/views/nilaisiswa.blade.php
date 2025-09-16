<!-- resources/views/nilaisiswa.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Halaman Input Nilai Siswa</h1>

    <div class="bg-white p-6 rounded-xl shadow-md">
        <p>Ini halaman untuk menginput nilai siswa. Bisa kamu lanjutkan sesuai kebutuhan.</p>
    </div>

    <a href="{{ url()->previous() }}" class="inline-block mt-6 text-indigo-600 hover:underline">Kembali</a>
</body>
</html>
