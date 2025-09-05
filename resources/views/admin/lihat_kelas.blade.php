<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas - Sistem Manajemen Sekolah</title>
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
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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
                 <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Daftar Kelas</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
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
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Detail Kelas</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User Avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <!-- Action Bar -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Daftar Siswa Kelas: <span class="text-indigo-600">{{$namaKelas->nama_kelas}}</span></h2>
                            <p class="text-gray-500 mt-1">Total: 32 Siswa</p>
                        </div>
                        <div class="flex items-center gap-4">
                             <a href="#" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center whitespace-nowrap">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            @if ($namaKelas->id_kelas == 0 || $namaKelas->id_angkatan == 0)
                                <a href="#" class="bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed flex items-center whitespace-nowrap" title="Lengkapi data kelas terlebih dahulu">
                                    <i class="fa-solid fa-user-plus mr-2"></i>
                                    Tambah Siswa
                                </a>
                            @else
                                <a href="#" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap">
                                    <i class="fa-solid fa-user-plus mr-2"></i>
                                    Tambah Siswa
                                </a>
                            @endif
                        </div>
                    </div>

                     <!-- Search Bar -->
                    <div class="mb-4">
                         <div class="relative w-full md:w-1/2">
                            <input type="text" placeholder="Cari siswa di kelas ini..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Students Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[700px] text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-600">NISN</th>
                                    <th class="p-3 font-semibold text-gray-600">Nama Siswa</th>
                                    <th class="p-3 font-semibold text-gray-600">Jenis Kelamin</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <!-- Sample Row 1 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-700">2024001</td>
                                    <td class="p-3 text-gray-800 font-medium">Budi Santoso</td>
                                    <td class="p-3 text-gray-700">Laki-laki</td>
                                    <td class="p-3 text-center">
                                        <button class="text-red-500 hover:text-red-700" title="Keluarkan dari Kelas">
                                            <i class="fa-solid fa-user-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Sample Row 2 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-700">2024002</td>
                                    <td class="p-3 text-gray-800 font-medium">Citra Lestari</td>
                                    <td class="p-3 text-gray-700">Perempuan</td>
                                     <td class="p-3 text-center">
                                        <button class="text-red-500 hover:text-red-700" title="Keluarkan dari Kelas">
                                            <i class="fa-solid fa-user-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Sample Row 3 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-700">2024003</td>
                                    <td class="p-3 text-gray-800 font-medium">Doni Firmansyah</td>
                                    <td class="p-3 text-gray-700">Laki-laki</td>
                                     <td class="p-3 text-center">
                                        <button class="text-red-500 hover:text-red-700" title="Keluarkan dari Kelas">
                                            <i class="fa-solid fa-user-minus"></i>
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
        // --- Sidebar Toggle Functionality ---
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
