<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mata Pelajaran - Sistem Manajemen Sekolah</title>
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
                    <i class="fa-solid fa-book w-6 h-6 mr-3"></i>
                    <span>Manajemen Mapel</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Guru</span>
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Mata Pelajaran</h1>
                <div class="flex items-center space-x-4">
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
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Mata Pelajaran</h2>
                        <button id="add-mapel-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Tambah Mapel
                        </button>
                    </div>

                    <!-- Subjects Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[800px] text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-600">Mapel</th>
                                    <th class="p-3 font-semibold text-gray-600">Kategori</th>
                                    <th class="p-3 font-semibold text-gray-600">SKS</th>
                                    <th class="p-3 font-semibold text-gray-600">Guru</th>
                                    <th class="p-3 font-semibold text-gray-600">Status</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                 @forelse ($mapels as $mapel)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-800 font-medium">{{$mapel->nama_mapel}}</td>
                                    <td class="p-3 text-gray-700">{{$mapel->kategori}}</td>
                                    <td class="p-3 text-gray-700">{{$mapel->sks}}</td>
                                    <td class="p-3 text-gray-700">{{$mapel->nama_guru}}</td>
                                    <td class="p-3">
                                        @if ($mapel->status === 'nonaktif')
                                        <span class="bg-red-100 text-red-700 font-medium py-1 px-3 rounded-full text-xs">Nonaktif</span>
                                        @else
                                        <span class="bg-green-100 text-green-700 font-medium py-1 px-3 rounded-full text-xs">Aktif</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="flex justify-center space-x-3">
                                            <button class="text-blue-600 hover:text-blue-800" title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="text-red-600 hover:text-red-800" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-3 text-center text-gray-500">
                                        <div class="text-center py-12">
                                            <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-600 font-semibold text-lg">Belum ada data Mapel.</p>
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

    <!-- Add Subject Modal -->
    <div id="mapel-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-1/2 lg:w-1/3 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Tambah Mata Pelajaran</h3>
                <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <form actin="{{ route('storeMapel') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nama-mapel" class="block text-gray-700 font-medium mb-2">Nama Mapel</label>
                    <input name="nama_mapel" type="text" id="nama-mapel" placeholder="Contoh: Kimia" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="kode-mapel" class="block text-gray-700 font-medium mb-2">Kode Mapel</label>
                    <input name="kode_mapel" type="text" id="kode-mapel" placeholder="Contoh: STR21" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="kategori-mapel" class="block text-gray-700 font-medium mb-2">Kategori</label>
                        <select name="kategori" id="kategori-mapel" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                            <option value="Umum">Umum</option>
                            <option value="IT">IT</option>
                            <option value="Tahfisz">Tahfidz</option>
                            <option value="Eskul">Eskul</option>
                        </select>
                    </div>
                    <div>
                        <label for="sks-mapel" class="block text-gray-700 font-medium mb-2">SKS</label>
                        <input name="sks" type="number" id="sks-mapel" placeholder="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="guru-pengampu" class="block text-gray-700 font-medium mb-2">Guru Pengampu</label>
                    <select name="guru_pengampu" id="guru-pengampu" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                        <option value="" disabled selected>Pilih Guru</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" id="cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan</button>
                </div>
            </form>
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
        const mapelModal = document.getElementById('mapel-modal');
        const modalContent = mapelModal.querySelector('div');
        const addMapelBtn = document.getElementById('add-mapel-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        const openModal = () => {
            mapelModal.classList.remove('hidden');
            setTimeout(() => {
                mapelModal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        };

        const closeModal = () => {
            mapelModal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                mapelModal.classList.add('hidden');
            }, 300);
        };

        addMapelBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        mapelModal.addEventListener('click', (event) => {
            if (event.target === mapelModal) {
                closeModal();
            }
        });

    </script>

</body>
</html>

