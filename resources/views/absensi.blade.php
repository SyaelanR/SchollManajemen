<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas - Sistem Manajemen Sekolah</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

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

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }

        /* Sidebar transition */
        .sidebar { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-100 antialiased">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar"
        class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-xl fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6 border-b border-gray-200">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6 space-y-2 px-4">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-700 bg-gray-200 rounded-lg font-semibold shadow-sm">
                <i class="fa-solid fa-user-check w-6 h-6 mr-3"></i>
                <span>Input Absensi</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                <span>Manajemen Guru</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                <span>Jadwal Pelajaran</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                <span>Keuangan</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-exclamation-triangle w-6 h-6 mr-3"></i>
                <span>Pelanggaran</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-cog w-6 h-6 mr-3"></i>
                <span>Pengaturan</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6 border-t border-gray-200">
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Header for mobile menu button -->
        <header class="bg-white shadow-md p-4 lg:hidden sticky top-0 z-40">
            <div class="flex items-center justify-between">
                <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800">Daftar Kelas</h1>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-6 md:p-8">
            <h1 class="hidden lg:block text-3xl font-bold text-gray-800 mb-6">Pilih Kelas untuk Absensi</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Kelas 10A -->
                <a href="absen_kelas_10a.html" class="bg-white p-6 rounded-2xl shadow-md flex flex-col items-center text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl mb-4">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Kelas 10A</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        <i class="fa-solid fa-user-group mr-1"></i>
                        30 Siswa
                    </p>
                </a>
                
                <!-- Kelas 10B -->
                <a href="#" class="bg-white p-6 rounded-2xl shadow-md flex flex-col items-center text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl mb-4">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Kelas 10B</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        <i class="fa-solid fa-user-group mr-1"></i>
                        28 Siswa
                    </p>
                </a>
                
                <!-- Tambahkan kartu kelas lainnya di sini... -->
                <a href="#" class="bg-white p-6 rounded-2xl shadow-md flex flex-col items-center text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl mb-4">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Kelas 11A</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        <i class="fa-solid fa-user-group mr-1"></i>
                        32 Siswa
                    </p>
                </a>
                
                <a href="#" class="bg-white p-6 rounded-2xl shadow-md flex flex-col items-center text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl mb-4">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Kelas 11B</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        <i class="fa-solid fa-user-group mr-1"></i>
                        29 Siswa
                    </p>
                </a>
            </div>
        </div>
    </main>
</div>

<!-- JavaScript for mobile sidebar toggle -->
<script>
    const sidebar = document.getElementById('sidebar');
    const mobileMenuButton = document.getElementById('mobile-menu-button');

    mobileMenuButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    // Close sidebar when clicking outside on mobile
    window.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !mobileMenuButton.contains(e.target) && window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
    });
</script>

</body>
</html>
