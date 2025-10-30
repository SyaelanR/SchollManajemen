<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - Sistem Manajemen Sekolah</title>

    <!-- Tailwind CSS CDN -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                <i class="fa-solid fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>

            @can('view-admin')
            <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-user-graduate mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="{{ route('manajemenGuru') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-chalkboard-user mr-3"></i>
                <span>Manajemen Guru</span>
            </a>
            <a href="{{ route('admin.kelas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-door-closed mr-3"></i>
                <span>Manajemen Kelas</span>
            </a>
            <a href="{{ route('jadwal') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-calendar-alt mr-3 w-5 h-5"></i>
                <span>Jadwal Pelajaran</span>
            </a>
            <a href="{{ route('pelanggaran.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                <span>Pelanggaran Siswa</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-money-bill-wave mr-3"></i>
                <span>Keuangan</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-layer-group mr-3"></i>
                <span>Raport</span>
            </a>
            @endcan

            @can('view-guru')
            <a href="{{ route('inputnilai.kelas') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
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
                   class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
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
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Input Nilai Perkelas</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover"
                         src="https://placehold.co/100x100/667eea/ffffff?text=A"
                         alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 md:gap-0">
                    <h2 class="text-2xl font-semibold text-gray-800">Daftar Kelas</h2>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
                    <input type="text" id="class-search-input" placeholder="Cari nama kelas..."
                           class="w-full md:flex-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div id="class-grid"
                     class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                    <a href="{{ route('inputnilai.tugas', ['kelas' => '10A']) }}" class="block bg-gray-50 rounded-xl shadow-md p-6 relative hover:shadow-lg transition duration-300 cursor-pointer">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-chalkboard text-3xl text-indigo-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Kelas 10A</h3>
                        <div class="flex items-center text-gray-600 mt-4">
                            <i class="fa-solid fa-user-group text-sm mr-2"></i>
                            <span class="text-sm">30 Siswa</span>
                        </div>
                    </a>

                    <a href="{{ route('inputnilai.tugas', ['kelas' => '10B']) }}" class="block bg-gray-50 rounded-xl shadow-md p-6 relative hover:shadow-lg transition duration-300 cursor-pointer">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-chalkboard text-3xl text-indigo-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Kelas 10B</h3>
                        <div class="flex items-center text-gray-600 mt-4">
                            <i class="fa-solid fa-user-group text-sm mr-2"></i>
                            <span class="text-sm">28 Siswa</span>
                        </div>
                    </a>

                    <a href="{{ route('inputnilai.tugas', ['kelas' => '11A']) }}" class="block bg-gray-50 rounded-xl shadow-md p-6 relative hover:shadow-lg transition duration-300 cursor-pointer">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-chalkboard text-3xl text-indigo-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Kelas 11A</h3>
                        <div class="flex items-center text-gray-600 mt-4">
                            <i class="fa-solid fa-user-group text-sm mr-2"></i>
                            <span class="text-sm">29 Siswa</span>
                        </div>
                    </a>

                    <a href="{{ route('inputnilai.tugas', ['kelas' => '11B']) }}" class="block bg-gray-50 rounded-xl shadow-md p-6 relative hover:shadow-lg transition duration-300 cursor-pointer">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-chalkboard text-3xl text-indigo-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Kelas 11B</h3>
                        <div class="flex items-center text-gray-600 mt-4">
                            <i class="fa-solid fa-user-group text-sm mr-2"></i>
                            <span class="text-sm">25 Siswa</span>
                        </div>
                    </a>

                    <a href="{{ route('inputnilai.tugas', ['kelas' => '12A']) }}" class="block bg-gray-50 rounded-xl shadow-md p-6 relative hover:shadow-lg transition duration-300 cursor-pointer">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-chalkboard text-3xl text-indigo-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Kelas 12A</h3>
                        <div class="flex items-center text-gray-600 mt-4">
                            <i class="fa-solid fa-user-group text-sm mr-2"></i>
                            <span class="text-sm">27 Siswa</span>
                        </div>
                    </a>

                    <a href="{{ route('inputnilai.tugas', ['kelas' => '12B']) }}" class="block bg-gray-50 rounded-xl shadow-md p-6 relative hover:shadow-lg transition duration-300 cursor-pointer">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-chalkboard text-3xl text-indigo-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Kelas 12B</h3>
                        <div class="flex items-center text-gray-600 mt-4">
                            <i class="fa-solid fa-user-group text-sm mr-2"></i>
                            <span class="text-sm">35 Siswa</span>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const classSearchInput = document.getElementById('class-search-input');

    const toggleSidebar = () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    };

    classSearchInput.addEventListener('input', () => {
        console.log("Input pencarian kelas...");
    });

    menuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
</script>

</body>
</html>
