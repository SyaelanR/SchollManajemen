<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran</title>
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
        .modal {
            transition: opacity 0.2s ease-in-out;
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
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-chalkboard-user mr-3"></i>
                    <span>Manajemen Guru</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-solid fa-door-closed mr-3"></i>
                    <span>Manajemen Kelas</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                    <span>Jadwal Pelajaran</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-money-bill-wave mr-3"></i>
                    <span>Keuangan</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-layer-group mr-3"></i>
                    <span>Raport</span>
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
                    <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Lihat Nilai</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-list-check mr-3"></i>
                    <span>Lihat Absensi</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-users w-6 h-6 mr-3"></i>
                    <span>Manajemen Klien</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full">
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Jadwal Pelajaran</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <!-- Main Title Block -->
                <div class="bg-indigo-600 rounded-xl shadow-lg p-8 mb-8 text-white flex flex-col md:flex-row items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Jadwal Pelajaran Kelas</h2>
                        <p class="text-indigo-200">Lihat dan kelola jadwal pelajaran untuk setiap kelas.</p>
                    </div>
                    <button onclick="window.history.back()" class="flex items-center justify-center space-x-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition duration-200 mt-4 md:mt-0">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                        <span>Kembali</span>
                    </button>
                </div>
                
                <!-- Schedule Table Container -->
                <div id="schedule-container" class="bg-indigo-50 p-8 rounded-xl shadow-lg text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="schedule-title" class="text-xl font-semibold text-indigo-800">Jadwal Kelas 12A</h3>
                        <button id="add-schedule-button" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition duration-200">
                            <i class="fa-solid fa-plus mr-2"></i>Tambah Jadwal
                        </button>
                    </div>

                    <!-- Table based on the provided image -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Baris jadwal dari Senin sampai Jumat -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Senin</td>
                                    <td class="px-6 py-4 whitespace-nowrap">08.00-10.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Matematika</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Budi Santoso, S.Pd</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="showEditModal()" class="text-indigo-600 hover:text-indigo-900 mx-1">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button onclick="showDeleteModal()" class="text-red-600 hover:text-red-900 mx-1">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Selasa</td>
                                    <td class="px-6 py-4 whitespace-nowrap">08.00-10.30</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Pemrograman Python</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Pramono, M.Kom</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="showEditModal()" class="text-indigo-600 hover:text-indigo-900 mx-1">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button onclick="showDeleteModal()" class="text-red-600 hover:text-red-900 mx-1">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Rabu</td>
                                    <td class="px-6 py-4 whitespace-nowrap">10.30-13.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Pengantar Internet of Things</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Afu Ihsan Pradana, M.Kom</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="showEditModal()" class="text-indigo-600 hover:text-indigo-900 mx-1">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button onclick="showDeleteModal()" class="text-red-600 hover:text-red-900 mx-1">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Kamis</td>
                                    <td class="px-6 py-4 whitespace-nowrap">09.00-11.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Bahasa Inggris</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Siti Aminah, S.S</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="showEditModal()" class="text-indigo-600 hover:text-indigo-900 mx-1">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button onclick="showDeleteModal()" class="text-red-600 hover:text-red-900 mx-1">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Jumat</td>
                                    <td class="px-6 py-4 whitespace-nowrap">07.30-09.30</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Pendidikan Agama Islam</td>
                                    <td class="px-6 py-4 whitespace-nowrap">H. Ahmad, S.Ag</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="showEditModal()" class="text-indigo-600 hover:text-indigo-900 mx-1">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button onclick="showDeleteModal()" class="text-red-600 hover:text-red-900 mx-1">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal untuk Tambah/Edit Jadwal -->
    <div id="schedule-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden modal opacity-0">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-xl font-semibold text-gray-900" id="modal-title">Tambah Jadwal Baru</h3>
                <button id="close-schedule-modal" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body (Form) -->
            <form id="schedule-form" action="#">
                <div class="mb-4">
                    <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                    <select id="hari" name="hari" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="jam" class="block text-sm font-medium text-gray-700">Jam</label>
                    <input type="text" id="jam" name="jam" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: 08:00-10:00" required>
                </div>
                <div class="mb-4">
                    <label for="mapel" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <select id="mapel" name="mapel" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        <option value="Matematika">Matematika</option>
                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                        <option value="Bahasa Inggris">Bahasa Inggris</option>
                        <option value="Fisika">Fisika</option>
                        <option value="Kimia">Kimia</option>
                        <option value="Biologi">Biologi</option>
                        <option value="Sejarah">Sejarah</option>
                        <option value="Geografi">Geografi</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="guru" class="block text-sm font-medium text-gray-700">Guru</label>
                    <select id="guru" name="guru" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Pilih Guru</option>
                        <option value="Budi Santoso, S.Pd">Budi Santoso, S.Pd</option>
                        <option value="Pramono, M.Kom">Pramono, M.Kom</option>
                        <option value="Afu Ihsan Pradana, M.Kom">Afu Ihsan Pradana, M.Kom</option>
                        <option value="Siti Aminah, S.S">Siti Aminah, S.S</option>
                        <option value="H. Ahmad, S.Ag">H. Ahmad, S.Ag</option>
                    </select>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end pt-2">
                    <button type="button" id="cancel-schedule-modal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden modal opacity-0">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Hapus Jadwal?</h3>
                <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus jadwal ini?</p>
                <div class="flex justify-center space-x-4">
                    <button id="cancel-delete-modal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        const scheduleModal = document.getElementById('schedule-modal');
        const deleteModal = document.getElementById('delete-modal');

        const addScheduleButton = document.getElementById('add-schedule-button');
        const closeScheduleModal = document.getElementById('close-schedule-modal');
        const cancelScheduleModal = document.getElementById('cancel-schedule-modal');
        const cancelDeleteModal = document.getElementById('cancel-delete-modal');

        // Function to toggle sidebar for mobile
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Function to show a modal
        const showModal = (modalType) => {
            if (modalType === 'schedule') {
                scheduleModal.classList.remove('hidden');
                setTimeout(() => {
                    scheduleModal.classList.remove('opacity-0');
                }, 10);
            } else if (modalType === 'delete') {
                deleteModal.classList.remove('hidden');
                setTimeout(() => {
                    deleteModal.classList.remove('opacity-0');
                }, 10);
            }
        };

        // Function to hide a modal
        const hideModal = (modalType) => {
            if (modalType === 'schedule') {
                scheduleModal.classList.add('opacity-0');
                setTimeout(() => {
                    scheduleModal.classList.add('hidden');
                }, 200);
            } else if (modalType === 'delete') {
                deleteModal.classList.add('opacity-0');
                setTimeout(() => {
                    deleteModal.classList.add('hidden');
                }, 200);
            }
        };

        // Event listeners for UI functionality
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        addScheduleButton.addEventListener('click', () => {
            document.getElementById('modal-title').textContent = 'Tambah Jadwal Baru';
            showModal('schedule');
        });

        closeScheduleModal.addEventListener('click', () => hideModal('schedule'));
        cancelScheduleModal.addEventListener('click', () => hideModal('schedule'));

        cancelDeleteModal.addEventListener('click', () => hideModal('delete'));

        // Global functions for buttons in the table
        // These are called from the onclick attribute in the HTML
        window.showEditModal = () => {
            document.getElementById('modal-title').textContent = 'Edit Jadwal';
            showModal('schedule');
        };

        window.showDeleteModal = () => {
            showModal('delete');
        };
    </script>

</body>
</html>
