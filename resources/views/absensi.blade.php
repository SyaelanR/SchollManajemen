<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Absensi - EduSys</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('asset/school-solid-full.png') }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
        .status-select {
            appearance: none; -webkit-appearance: none; -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'%3e%3cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1.5em;
            padding-right: 2.5rem;
            border: none; border-radius: 0.5rem;
            cursor: pointer; font-weight: 600;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-2xl fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0 rounded-r-3xl">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3 mb-8">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
            <div class="border-b border-gray-200"></div>
        </div>
        <nav class="mt-6">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:font-semibold rounded-lg mx-3 transition-colors duration-200">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:font-semibold rounded-lg mx-3 transition-colors duration-200">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i> <span>Manajemen Siswa</span>
            </a>
            <a href="{{ route('manajemenGuru') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:font-semibold rounded-lg mx-3 transition-colors duration-200">
                <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i> <span>Manajemen Guru</span>
            </a>
            <a href="{{ route('manajemenJadwal') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:font-semibold rounded-lg mx-3 transition-colors duration-200">
                <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i> <span>Jadwal Pelajaran</span>
            </a>
            <a href="{{ route('mataPelajaran') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:font-semibold rounded-lg mx-3 transition-colors duration-200">
                <i class="fa-solid fa-book w-6 h-6 mr-3"></i> <span>Mata Pelajaran</span>
            </a>
            <a href="{{ route('absensiSiswa') }}" class="flex items-center px-6 py-3 text-indigo-600 bg-indigo-100 font-semibold rounded-lg mx-3 transition-colors duration-200">
                <i class="fa-solid fa-user-check w-6 h-6 mr-3"></i> <span>Absensi Siswa</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:font-semibold rounded-lg mx-3 transition-colors duration-200">
                <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i> <span>Keuangan</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:font-semibold rounded-lg mx-3 transition-colors duration-200">
                <i class="fa-solid fa-cog w-6 h-6 mr-3"></i> <span>Pengaturan</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
             <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg transition-colors duration-200">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i> <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Overlay mobile -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Absensi</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <i class="fa-solid fa-bell text-xl"></i>
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover shadow-sm" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <!-- Back button + Title -->
                <div class="flex items-center mb-6">
                    <button onclick="history.back()" class="flex items-center px-4 py-2 mr-4 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <i class="fa-solid fa-arrow-left mr-2"></i> <span>Kembali</span>
                    </button>
                    <h3 class="text-xl font-semibold text-gray-800">Data Absensi Siswa</h3>
                </div>

                <!-- Filter -->
                <div class="mb-6 w-full md:w-1/3">
                    <label for="tanggal-filter" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanggal</label>
                    <input type="date" id="tanggal-filter" class="block w-full px-4 py-2 text-base border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-xl shadow-inner border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $siswa)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa['nama'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa['kelas'] ?? 'Kelas 10A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ date('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select name="status[{{ $siswa['id'] }}]" class="status-select px-3 py-1 text-sm rounded-lg" data-initial-status="Hadir">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Save Button -->
                <div class="mt-6 flex justify-end">
                    <button class="px-6 py-2 bg-indigo-600 text-white rounded-md shadow-lg hover:bg-indigo-700 transition duration-300">
                        Simpan Absensi
                    </button>
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

    // Badge style for status select
    const statusSelects = document.querySelectorAll('.status-select');
    const updateStatusStyle = (el) => {
        el.classList.remove(
            'bg-green-100','text-green-800',
            'bg-yellow-100','text-yellow-800',
            'bg-orange-100','text-orange-800',
            'bg-red-100','text-red-800'
        );
        switch (el.value) {
            case 'Hadir': el.classList.add('bg-green-100','text-green-800'); break;
            case 'Izin':  el.classList.add('bg-yellow-100','text-yellow-800'); break;
            case 'Sakit': el.classList.add('bg-orange-100','text-orange-800'); break;
            case 'Alfa':  el.classList.add('bg-red-100','text-red-800'); break;
        }
    };
    statusSelects.forEach(sel => {
        sel.value = sel.dataset.initialStatus;
        updateStatusStyle(sel);
        sel.addEventListener('change', e => updateStatusStyle(e.target));
    });
</script>
</body>
</html>
