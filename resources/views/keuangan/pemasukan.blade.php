<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemasukan - Sistem Manajemen Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">
    @include('layouts.sidebar') <!-- Panggil sidebar yang sama -->

    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Tambah Pemasukan</h1>
        </header>

        <!-- Form Pemasukan -->
        <main class="p-6 md:p-8 flex-1">
            <div class="bg-white rounded-xl shadow-md p-6 max-w-lg mx-auto">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Form Pemasukan</h2>
                <form action="{{ route('keuangan.storePemasukan') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Deskripsi</label>
                        <input type="text" name="deskripsi" placeholder="Contoh: SPP Kelas X" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" placeholder="5000000" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    </div>
                    <button type="submit" class="bg-green-600 text-white py-2 px-5 rounded-lg hover:bg-green-700 transition">Simpan</button>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebar = () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    };
    menuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
</script>

</body>
</html>
