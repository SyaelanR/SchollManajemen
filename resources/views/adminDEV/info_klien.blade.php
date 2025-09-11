<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Klien - Sistem Manajemen Sekolah</title>
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
         /* Modal transition */
        .modal {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
            <div class="p-6">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-shield-halved text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">AdminSys</span>
                </a>
            </div>
            <nav class="mt-6">
                 <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-building-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Klien</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-file-invoice-dollar w-6 h-6 mr-3"></i>
                    <span>Penagihan</span>
                </a>
                 <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-cog w-6 h-6 mr-3"></i>
                    <span>Pengaturan</span>
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Detail Klien Sekolah</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/1e293b/ffffff?text=SA" alt="Super Admin Avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <!-- Client Information Section -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Informasi Klien</h2>
                        <a href="#" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center whitespace-nowrap mt-4 md:mt-0">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Kembali ke Daftar Klien
                        </a>
                    </div>
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center mb-8">
                            <div class="bg-indigo-100 p-4 rounded-full mr-5">
                                <i class="fa-solid fa-school-flag text-3xl text-indigo-600"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{$info_sekolah->nama_sekolah}}</h3>
                                <p class="text-gray-500">ID Klien: {{$info_sekolah->id_sekolah}}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div class="bg-gray-50 p-4 rounded-lg flex items-start space-x-4">
                                <i class="fa-solid fa-envelope text-xl text-gray-400 mt-1"></i>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email</label>
                                    <p class="text-md font-semibold text-gray-800">{{$info_sekolah->email}}</p>
                                </div>
                            </div>
                            <!-- Nomor HP -->
                            <div class="bg-gray-50 p-4 rounded-lg flex items-start space-x-4">
                                <i class="fa-solid fa-phone text-xl text-gray-400 mt-1"></i>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nomor HP</label>
                                    <p class="text-md font-semibold text-gray-800">{{$info_sekolah->no_telp}}</p>
                                </div>
                            </div>
                            <!-- Alamat -->
                            <div class="bg-gray-50 p-4 rounded-lg flex items-start space-x-4 md:col-span-2">
                                <i class="fa-solid fa-map-marker-alt text-xl text-gray-400 mt-1"></i>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Alamat</label>
                                    <p class="text-md font-semibold text-gray-800">{{$info_sekolah->alamat}}</p>
                                </div>
                            </div>
                            <!-- Status Klien -->
                            <div class="bg-gray-50 p-4 rounded-lg flex items-start space-x-4">
                                <i class="fa-solid fa-toggle-on text-xl text-gray-400 mt-1"></i>
                                <div>
                                    <label for="client-status" class="block text-sm font-medium text-gray-500">Status Klien</label>
                                    <select id="client-status" class="mt-1 w-full p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                        <option value="aktif" selected>Aktif</option>
                                        <option value="pending">Pending</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="flex justify-end mt-6 border-t border-gray-200 pt-6">
                        <button class="bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

                <!-- School Admins Section -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                     <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Admin Sekolah {{$id_sekolah}}</h2>
                        <button id="add-admin-btn" type="button" onclick="window.location='{{ route('tambahAdminKlien', ['id_sekolah' => $id_sekolah]) }}'" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap">
                            <i class="fa-solid fa-user-plus mr-2"></i>
                            Tambah Admin
                        </button>
                    </div>
                    <!-- Admins Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px] text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-600">Nama</th>
                                    <th class="p-3 font-semibold text-gray-600">Email</th>
                                    <th class="p-3 font-semibold text-gray-600">NIP</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse ($admin_sekolah as $admin)
                                 <!-- Sample Row 2 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-800 font-medium">{{$admin->name}}</td>
                                    <td class="p-3 text-gray-700">{{$admin->email}}</td>
                                    <td class="p-3 text-gray-700">{{$admin->nisn_nik}}</td>
                                    <td class="p-3 text-center">
                                        <button class="text-red-500 hover:text-red-700" title="Hapus Admin">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-gray-500">
                                        <div class="text-center py-12">
                                            <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-600 font-semibold text-lg">Belum ada data Admin.</p>
                                            <p class="text-gray-500 mt-2">Silakan tambah kan Admin</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
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

        // --- Modal Functionality ---
        

    </script>

</body>
</html>

