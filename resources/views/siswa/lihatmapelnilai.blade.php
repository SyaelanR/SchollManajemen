<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Mata Pelajaran - Sistem Nilai</title>
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
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar (Disederhanakan) -->
    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-graduation-cap text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">Sistem Nilai</span>
            </a>
        </div>
        <nav class="mt-6">
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-file-invoice mr-3"></i>
                <span>Daftar Nilai</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <!-- Contoh Logout -->
            <button class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full text-left">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i><span>Logout</span>
            </button>
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
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Daftar Mata Pelajaran</h1>
            <div class="flex items-center space-x-4">
                 <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/38a169/ffffff?text=U" alt="User Avatar">
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            <header class="mb-8 bg-green-600 p-8 rounded-2xl shadow-lg text-white">
                <h2 class="text-3xl font-bold mb-2">Nilai Per Mata Pelajaran</h2>
                <p class="text-green-200">Silakan pilih mata pelajaran untuk melihat dan mengelola detail nilainya.</p>
            </header>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6">Pilih Mata Pelajaran</h2>
                
                @if (isset($mapelList) && $mapelList->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($mapelList as $jadwal)
                    <!-- Card Mata Pelajaran -->
                    <a href="{{ route('lihatNilaiMapel', ['id_mapel' => $jadwal->mapel->id_mapel]) }}" 
                       class="block bg-white border border-gray-200 rounded-xl shadow-lg p-6 relative hover:shadow-xl hover:border-green-500 hover:-translate-y-1 transition-all duration-300 group">
                        
                        <div class="flex flex-col h-full">
                            <div class="flex-grow">
                                <div class="bg-green-100 text-green-600 p-4 rounded-full flex items-center justify-center w-16 h-16 mb-4">
                                    <i class="fa-solid fa-book-open text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 group-hover:text-green-600">{{ $jadwal->mapel->nama_mapel ?? 'N/A' }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Kode: {{ $jadwal->mapel->kode_mapel ?? 'N/A' }}</p>
                            </div>
                            <div class="border-t mt-4 pt-4 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-user-tie w-4 mr-2 text-gray-400"></i>
                                    <!-- Asumsi ada field 'guru' di data mapel -->
                                    <span>Guru Pengampu: {{ $jadwal->mapel->guru->name ?? 'Belum Ditentukan' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <i class="fa-solid fa-boxes-stacked text-5xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 font-semibold text-lg">Belum ada mata pelajaran yang tersedia.</p>
                    <p class="text-gray-500 mt-2">Silakan hubungi administrator untuk penambahan data mapel.</p>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fungsi untuk toggle sidebar (dibuat sederhana karena tidak ada interaksi form)
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if(menuButton && sidebar && overlay) {
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    }
});
</script>
</body>
</html>
