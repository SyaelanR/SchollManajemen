<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - Sistem Manajemen Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Custom styles */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for better aesthetics */
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
        /* Sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        /* Table styles */
        .table-auto {
            width: 100%;
        }
        .table-auto th, .table-auto td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        .table-auto th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #4b5563;
        }
        .table-auto tbody tr:hover {
            background-color: #f3f4f6;
        }
        /* Button styles */
        .btn-primary {
            background-color: #4f46e5;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #4338ca;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">
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
                {{-- <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a> --}}
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Guru</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                    <span>Jadwal Pelajaran</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-book w-6 h-6 mr-3"></i>
                    <span>Mata Pelajaran</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                    <span>Keuangan</span>
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

        <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Jadwal Pelajaran</h1>
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
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Kelola Jadwal</h2>
                    <button class="btn-primary flex items-center space-x-2">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>Tambah Jadwal Baru</span>
                    </button>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Filter Jadwal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                            <select id="kelas" name="kelas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2">
                                <option>Semua Kelas</option>
                                <option>Kelas 10A</option>
                                <option>Kelas 10B</option>
                                <option>Kelas 11A</option>
                                <option>Kelas 11B</option>
                            </select>
                        </div>
                        <div>
                            <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                            <select id="hari" name="hari" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2">
                                <option>Semua Hari</option>
                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button class="w-full bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition duration-300">Terapkan Filter</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 overflow-x-auto">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Jadwal Pelajaran Kelas 10A</h3>
                    <table class="table-auto min-w-full">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru Pengajar</th>
                                <th>Ruangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Senin</td>
                                <td>07:30 - 09:00</td>
                                <td>Matematika</td>
                                <td>Budi Santoso</td>
                                <td>Ruang 101</td>
                                <td>
                                    <div class="flex space-x-2">
                                        <button class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-edit"></i></button>
                                        <button class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Senin</td>
                                <td>09:00 - 10:30</td>
                                <td>Bahasa Inggris</td>
                                <td>Siti Rahayu</td>
                                <td>Ruang 102</td>
                                <td>
                                    <div class="flex space-x-2">
                                        <button class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-edit"></i></button>
                                        <button class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                             <tr>
                                <td>Selasa</td>
                                <td>07:30 - 09:00</td>
                                <td>Fisika</td>
                                <td>Agus Sucipto</td>
                                <td>Lab Fisika</td>
                                <td>
                                    <div class="flex space-x-2">
                                        <button class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-edit"></i></button>
                                        <button class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                    
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