<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan - Sistem Manajemen Sekolah</title>
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
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="/" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <!-- Ganti sementara route manajemenSiswa jadi '#' -->
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="{{ route('keuangan.index') }}" class="flex items-center px-6 py-3 bg-gray-200 font-semibold text-gray-700">
                <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                <span>Keuangan</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Keuangan</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <main class="p-6 md:p-8 flex-1">
            <div class="bg-indigo-600 rounded-xl shadow-lg p-8 mb-8 text-white">
                <h2 class="text-3xl font-bold mb-2">Modul Keuangan</h2>
                <p class="text-indigo-200">Kelola pemasukan, pengeluaran, dan laporan keuangan sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <a href="#" class="bg-green-100 hover:bg-green-200 p-6 rounded-xl shadow-md flex items-center space-x-4 transition">
                    <i class="fa-solid fa-plus-circle text-3xl text-green-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Pemasukan</h3>
                        <p class="text-gray-500 text-sm">Catat uang masuk</p>
                    </div>
                </a>
                <a href="#" class="bg-red-100 hover:bg-red-200 p-6 rounded-xl shadow-md flex items-center space-x-4 transition">
                    <i class="fa-solid fa-minus-circle text-3xl text-red-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Pengeluaran</h3>
                        <p class="text-gray-500 text-sm">Catat uang keluar</p>
                    </div>
                </a>
                <a href="#" class="bg-blue-100 hover:bg-blue-200 p-6 rounded-xl shadow-md flex items-center space-x-4 transition">
                    <i class="fa-solid fa-chart-line text-3xl text-blue-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Laporan</h3>
                        <p class="text-gray-500 text-sm">Ringkasan saldo & transaksi</p>
                    </div>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Daftar Transaksi</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                        <tr class="bg-gray-100 text-left text-gray-600 text-sm uppercase">
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Jenis</th>
                            <th class="p-3">Deskripsi</th>
                            <th class="p-3">Jumlah</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="border-b">
                            <td class="p-3">01-09-2025</td>
                            <td class="p-3 text-green-600 font-semibold">Pemasukan</td>
                            <td class="p-3">SPP Kelas X</td>
                            <td class="p-3">Rp 5.000.000</td>
                            <td class="p-3">
                                <button class="text-blue-500 hover:underline">Edit</button> |
                                <button class="text-red-500 hover:underline">Hapus</button>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3">02-09-2025</td>
                            <td class="p-3 text-red-600 font-semibold">Pengeluaran</td>
                            <td class="p-3">Beli Alat Tulis</td>
                            <td class="p-3">Rp 500.000</td>
                            <td class="p-3">
                                <button class="text-blue-500 hover:underline">Edit</button> |
                                <button class="text-red-500 hover:underline">Hapus</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
