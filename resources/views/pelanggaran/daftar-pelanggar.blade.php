<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggaran Siswa - EduSys</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Custom styles */
        body {
            font-family: 'Inter', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
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
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>


                @can('view-admin')
                <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="{{ route('manajemenGuru') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-chalkboard-user mr-3"></i>
                    <span>Manajemen Guru</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-solid fa-door-closed mr-3"></i>
                    <span>Manajemen Kelas</span>
                </a>
                <a href="{{ route('jadwal') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-calendar-alt mr-3"></i>
                    <span>Jadwal Pelajaran</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-money-bill-wave mr-3"></i>
                    <span>Keuangan</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-layer-group mr-3"></i>
                    <span>Raport</span>
                </a>
                @endcan

                @can('view-guru')
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Input Nilai</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-list-check mr-3"></i>
                    <span>Input Absensi</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-puzzle-piece mr-3"></i>
                    <span>Ekstrakulikuler</span>
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
                @endcan

                @can('view-siswa')
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Lihat Nilai</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-list-check mr-3"></i>
                    <span>Lihat Absensi</span>
                </a>
                @endcan

                @can('view-adminDev')
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-users w-6 h-6 mr-3"></i>
                    <span>Manajemen Klien</span>
                </a>
                @endcan


            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full">
                        <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Pelanggaran Siswa</h1>
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

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 md:mb-0">Daftar Pelanggaran</h2>
                        <div class="flex items-center space-x-4">
                            <button class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center">
                                <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Pelanggaran
                            </button>
                        </div>
                    </div>
                    
                    <!-- Search section -->
                    <div class="mb-6 flex items-center">
                        <input type="text" placeholder="Cari berdasarkan nama..." class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Violations table -->
                    <div class="overflow-x-auto rounded-lg shadow-sm">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pelanggaran</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Point</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="py-4 px-6 whitespace-nowrap">John Doe</td>
                                    <td class="py-4 px-6 whitespace-nowrap text-red-500">Tidak Mengerjakan PR</td>
                                    <td class="py-4 px-6 whitespace-nowrap">2024-10-26</td>
                                    <td class="py-4 px-6 whitespace-nowrap text-center">10</td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-4">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-6 whitespace-nowrap">Jane Smith</td>
                                    <td class="py-4 px-6 whitespace-nowrap text-red-500">Terlambat Datang</td>
                                    <td class="py-4 px-6 whitespace-nowrap">2024-10-25</td>
                                    <td class="py-4 px-6 whitespace-nowrap text-center">5</td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-4">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-6 whitespace-nowrap">Peter Jones</td>
                                    <td class="py-4 px-6 whitespace-nowrap text-red-500">Tidak Memakai Seragam Lengkap</td>
                                    <td class="py-4 px-6 whitespace-nowrap">2024-10-24</td>
                                    <td class="py-4 px-6 whitespace-nowrap text-center">15</td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-4">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
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

        // Function to toggle sidebar
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Event listeners
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>

</body>
</html>