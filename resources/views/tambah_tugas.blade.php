<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Jenis Nilai</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
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
<body>
    <div class="flex h-screen overflow-hidden bg-gray-50">
        <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-2xl fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="p-6 border-b border-gray-100">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">EduSys</span>
                </a>
            </div>
             <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
             <a href="{{ route('inputnilai') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Input Nilai</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-list-check mr-3"></i>
                    <span>Input Absensi</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-puzzle-piece mr-3"></i>
                    <span>Ekstrakulikuler</span>
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
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

        <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 id="main-header" class="text-xl md:text-2xl font-bold text-gray-800">Atur Jenis Nilai</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <main class="p-6 md:p-8 flex-1">
                <div class="bg-white p-6 rounded-2xl shadow-lg">
                    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                        <h3 class="text-2xl font-bold text-gray-800">Daftar Jenis Nilai</h3>
                        <div class="flex flex-wrap gap-4">
                            <button id="tambah-jenis-nilai-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-indigo-700 transition duration-300">
                                <i class="fa-solid fa-plus mr-2"></i> Tambah
                            </button>
                            <a href="{{ route('inputnilai') }}" class="bg-gray-400 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-gray-500 transition duration-300">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <!-- Isi konten untuk daftar jenis nilai akan ditaruh di sini -->
                    <div class="text-center text-gray-500 py-10">
                        <i class="fa-solid fa-list-ul text-4xl mb-4"></i>
                        <p>Daftar jenis nilai akan muncul di sini.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Modal untuk Tambah Jenis Nilai -->
    <div id="addJenisNilaiModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white transform transition-transform duration-300 scale-95 opacity-0">
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Tambah Jenis Nilai Baru</h3>
                <form action="#" method="POST">
                    <div class="mb-4">
                        <label for="nama_jenis_nilai" class="block text-left text-sm font-medium text-gray-700">Nama Jenis Nilai</label>
                        <input type="text" id="nama_jenis_nilai" name="nama_jenis_nilai" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    </div>
                    <div class="mb-6">
                        <label for="bobot" class="block text-left text-sm font-medium text-gray-700">Bobot (%)</label>
                        <input type="number" id="bobot" name="bobot" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="button" id="closeModalBtn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-gray-300 transition duration-300">
                            Batal
                        </button>
                        <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-indigo-700 transition duration-300">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
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

        // Modal functionality
        const modal = document.getElementById('addJenisNilaiModal');
        const openModalBtn = document.getElementById('tambah-jenis-nilai-btn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalContent = modal.querySelector('.relative');

        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        });

        closeModalBtn.addEventListener('click', () => {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        });

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModalBtn.click();
            }
        });
    </script>
</body>
</html>
