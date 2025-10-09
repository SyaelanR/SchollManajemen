<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSys - Pilih Kelas</title>
    <!-- Tailwind CSS CDN untuk styling yang cepat dan responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter untuk tipografi yang bersih -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk ikon-ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Gaya kustom untuk scrollbar dan transisi sidebar */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-pen mr-3"></i>
                <span>Input Nilai</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-list-check mr-3"></i>
                <span>Input Absensi</span>
            </a>
            <a href="{{ route('manajPengumuman') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-bullhorn mr-3"></i>
                <span>Pengumuman</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full text-left">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i><span>Logout</span>
                </button>
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
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Pilih Kelas</h1>
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
            <!-- UPDATED Welcome Header -->
            <header class="mb-8 bg-indigo-600 p-8 rounded-2xl shadow-lg text-white">
                <h2 class="text-3xl font-bold mb-2">Selamat Datang, Guru</h2>
                <p class="text-indigo-200">Silakan pilih kelas untuk melanjutkan proses input Absensi.</p>
            </header>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($daftarkelasYangDiampu ?? [] as $kelas)
                    <a href="{{ route('manajAbsensiDaftar', [$kelas->id_kelas, $kelas->mapel->id_mapel]) }}" class="block bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transform transition-all duration-300 cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Kelas {{ $kelas->kelas->nama_kelas }}</h3>
                            <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                                <i class="fa-solid fa-door-open"></i>
                            </div>
                        </div>
                        <div class="space-y-2 border-t pt-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fa-solid fa-book w-5 mr-2 text-gray-400"></i>
                                <span>Mapel: <strong>{{ $kelas->mapel->nama_mapel ?? 'N/A' }}</strong></span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fa-solid fa-users w-5 mr-2 text-gray-400"></i>
                                <span>Jumlah siswa: <strong>{{ $kelas->jumlah_siswa }}</strong></span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 bg-white p-6 rounded-2xl shadow-lg text-center">
                        <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 font-semibold text-lg">Tidak ada kelas yang tersedia.</p>
                        <p class="text-gray-500 mt-2">Belum ada data kelas yang dapat ditampilkan.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>

<script>
    // Ambil elemen HTML
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    // Fungsi untuk mengaktifkan/menonaktifkan sidebar pada perangkat mobile
    const toggleSidebar = () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    };

    // Tambahkan event listener untuk tombol menu dan overlay
    menuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
</script>
</body>
</html>
