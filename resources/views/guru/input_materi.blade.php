<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Materi - Sistem Manajemen Sekolah</title>
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
        .modal-bg {
            transition: opacity 0.3s ease;
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
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Menu untuk Guru -->
                @can('view-guru')
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-book-open-reader mr-3"></i>
                    <span>Manajemen Materi</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
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
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-circle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
                @endcan
                <!-- Menu lain bisa ditambahkan di sini sesuai role -->

            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <form method="POST" action="#"> <!-- {{ route('logout') }} -->
                    @csrf
                    <a href="#"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full">
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
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Materi</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=G" alt="User avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <!-- Breadcrumbs and Action Button -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-6">
                    <div class="text-sm text-gray-500 mb-4 md:mb-0">
                        {{-- <a href="#" class="hover:text-indigo-600">Pilih Kelas</a> --}}
                        {{-- <span class="mx-2">/</span> --}}
                        {{-- <span class="font-semibold text-gray-700">Kelas 10A - Matematika</span> --}}
                    </div>
                    <button id="upload-button" class="bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 w-full md:w-auto">
                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Unggah Materi Baru
                    </button>
                </div>

                <!-- Materials Table -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-semibold mb-6 text-gray-800">Daftar Materi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Materi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Unggah</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse (($daftarMateri ?? []) as $materi)
                                <!-- Example Row 1 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{$materi->judul_materi}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$materi->deskripsi_materi}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$materi->tanggal}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                        <a href="#" class="text-blue-600 hover:text-blue-900" title="Lihat"><i class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="text-yellow-600 hover:text-yellow-900" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="text-red-600 hover:text-red-900" title="Hapus"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <div class="text-gray-500">
                                            <i class="fa-solid fa-folder-open text-4xl mb-3"></i>
                                            <p class="text-lg font-semibold">Belum ada materi</p>
                                            <p class="text-sm">Silakan unggah materi pertama Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                                
                                -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Upload Modal -->
    <div id="upload-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 hidden modal-bg">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0" id="modal-panel">
            <div class="flex items-center justify-between p-5 border-b rounded-t-xl">
                <h3 class="text-xl font-semibold text-gray-900">
                    Unggah Materi Baru
                </h3>
                <button type="button" id="close-modal-button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('storeMateri', [$infoJKA->id_kelas, $infoJKA->id_mapel])}}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                <div>
                    <label for="judul" class="block mb-2 text-sm font-medium text-gray-900">Judul Materi</label>
                    <input type="text" name="judul_materi" id="judul" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" placeholder="Contoh: Bab 1 - Aljabar" required>
                </div>
                 <div>
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi Singkat</label>
                    <textarea name="deskripsi_materi" id="deskripsi" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tulis deskripsi singkat materi di sini..."></textarea>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Pilih file PDF</label>
                    <input name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" id="file_input" type="file" accept=".pdf">
                    <p class="mt-1 text-xs text-gray-500">PDF (MAX. 5MB).</p>
                </div>

                 <!-- Modal footer -->
                <div class="flex items-center justify-end pt-4 border-t border-gray-200 rounded-b-xl">
                    <button type="button" id="cancel-modal-button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 mr-3">Batal</button>
                    <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // --- Sidebar ---
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // --- Modal ---
        const uploadModal = document.getElementById('upload-modal');
        const modalPanel = document.getElementById('modal-panel');
        const uploadButton = document.getElementById('upload-button');
        const closeModalButton = document.getElementById('close-modal-button');
        const cancelModalButton = document.getElementById('cancel-modal-button');

        const openModal = () => {
            uploadModal.classList.remove('hidden');
            setTimeout(() => {
                uploadModal.classList.remove('opacity-0');
                modalPanel.classList.remove('scale-95', 'opacity-0');
            }, 10);
        };
        
        const closeModal = () => {
            modalPanel.classList.add('scale-95', 'opacity-0');
            uploadModal.classList.add('opacity-0');
            setTimeout(() => {
                uploadModal.classList.add('hidden');
            }, 300);
        };

        uploadButton.addEventListener('click', openModal);
        closeModalButton.addEventListener('click', closeModal);
        cancelModalButton.addEventListener('click', closeModal);

        // Close modal if backdrop is clicked
        uploadModal.addEventListener('click', (event) => {
            if (event.target === uploadModal) {
                closeModal();
            }
        });
    </script>

</body>
</html>
