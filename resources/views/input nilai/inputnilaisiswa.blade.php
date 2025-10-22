<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSys - Input Nilai & Absensi</title>
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
<body>

    <div class="flex h-screen overflow-hidden bg-gray-50">
        <!-- Sidebar - Navigasi Samping -->
        <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-2xl fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="p-6 border-b border-gray-100">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">EduSys</span>
                </a>
            </div>
            <nav class="mt-6">
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" id="link-nilai" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Input Nilai</span>
                </a>
                <a href="#" id="link-absensi" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-list-check mr-3"></i>
                    <span>Input Absensi</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-puzzle-piece mr-3"></i>
                    <span>Ekstrakulikuler</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-triangle-exclamation mr-3"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-user-plus mr-3"></i>
                    <span>Tambah Siswa</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <form action="#" method="POST">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                        <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </div>
        </aside>

        <!-- Overlay untuk menu mobile -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Header Halaman -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 id="header-title" class="text-xl md:text-2xl font-bold text-gray-800">Pilih Kelas</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Konten Halaman yang Dapat Berganti Tampilan -->
            <main class="p-6 md:p-8 flex-1">
                <!-- Tampilan "Pilih Kelas" -->
                <div id="class-selection-view">
                    <div class="bg-white rounded-2xl shadow-lg p-8 mb-6 text-gray-800 flex flex-col md:flex-row items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Selamat Datang, Guru</h2>
                            <p id="class-selection-desc" class="text-gray-600">Silakan pilih kelas untuk menginput nilai.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="class-cards">
                        <!-- Kartu Kelas akan dibuat secara dinamis oleh JavaScript -->
                    </div>
                </div>

                <!-- Tampilan "Input Nilai" -->
                <div id="grade-input-view" class="hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                            <h3 id="grade-input-title" class="text-2xl font-bold text-gray-800">Input Nilai - Kelas 10A</h3>
                            <div class="flex flex-wrap gap-4">
                                <a href="#" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-indigo-700 transition duration-300">
                                    <i class="fa-solid fa-list-ul mr-2"></i> Atur Jenis Nilai
                                </a>
                                <button onclick="showClassSelection('nilai')" class="bg-gray-400 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-gray-500 transition duration-300">
                                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                                </button>
                            </div>
                        </div>
                        <form action="#" method="POST">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-100">
                                        <tr class="text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left whitespace-nowrap">No</th>
                                            <th class="py-3 px-6 text-left whitespace-nowrap">Nama Siswa</th>
                                            <th class="py-3 px-6 text-left">Nilai Tugas</th>
                                            <th class="py-3 px-6 text-left">Nilai UTS</th>
                                            <th class="py-3 px-6 text-left">Nilai UAS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="nilai-table-body" class="text-gray-600 text-sm font-light">
                                        <!-- Baris nilai siswa akan dibuat secara dinamis -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:bg-green-700 transition duration-300">
                                    <i class="fa-solid fa-save mr-2"></i> Simpan Nilai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tampilan "Input Absensi" -->
                <div id="attendance-input-view" class="hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                            <h3 id="attendance-input-title" class="text-2xl font-bold text-gray-800">Input Absensi - Kelas 10A</h3>
                            <div class="flex flex-wrap gap-4">
                                <button onclick="showClassSelection('absensi')" class="bg-gray-400 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-gray-500 transition duration-300">
                                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                                </button>
                            </div>
                        </div>
                        <form action="#" method="POST">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-100">
                                        <tr class="text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left whitespace-nowrap">No</th>
                                            <th class="py-3 px-6 text-left whitespace-nowrap">Nama Siswa</th>
                                            <th class="py-3 px-6 text-left">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="absensi-table-body" class="text-gray-600 text-sm font-light">
                                        <!-- Baris absensi siswa akan dibuat secara dinamis -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:bg-green-700 transition duration-300">
                                    <i class="fa-solid fa-save mr-2"></i> Simpan Absensi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Data dummy untuk siswa dan kelas
        const students = {
            '10A': ['Siswa 1', 'Siswa 2', 'Siswa 3', 'Siswa 4', 'Siswa 5'],
            '10B': ['Siswa 6', 'Siswa 7', 'Siswa 8'],
            '11A': ['Siswa 9', 'Siswa 10'],
            '11B': ['Siswa 11', 'Siswa 12', 'Siswa 13', 'Siswa 14'],
        };
        const classes = ['10A', '10B', '11A', '11B'];
        const classCounts = {'10A': 35, '10B': 32, '11A': 30, '11B': 34};
        
        // Ambil elemen HTML
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const classSelectionView = document.getElementById('class-selection-view');
        const classSelectionDesc = document.getElementById('class-selection-desc');
        const classCardsContainer = document.getElementById('class-cards');
        const gradeInputView = document.getElementById('grade-input-view');
        const attendanceInputView = document.getElementById('attendance-input-view');
        const headerTitle = document.getElementById('header-title');
        const gradeInputTitle = document.getElementById('grade-input-title');
        const attendanceInputTitle = document.getElementById('attendance-input-title');
        const gradeTableBody = document.getElementById('nilai-table-body');
        const attendanceTableBody = document.getElementById('absensi-table-body');
        const linkNilai = document.getElementById('link-nilai');
        const linkAbsensi = document.getElementById('link-absensi');

        // Mengubah mode awal menjadi 'nilai'
        let currentMode = 'nilai';

        // Fungsi untuk membuat kartu kelas secara dinamis
        function generateClassCards() {
            classCardsContainer.innerHTML = classes.map(className => `
                <a href="#" onclick="showInputView('${className}')" class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800">Kelas ${className}</h3>
                        <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">Jumlah siswa: ${classCounts[className]}</p>
                </a>
            `).join('');
        }

        // Fungsi untuk menampilkan tampilan input yang sesuai (nilai/absensi)
        function showInputView(className) {
            classSelectionView.classList.add('hidden');
            if (currentMode === 'nilai') {
                gradeInputView.classList.remove('hidden');
                attendanceInputView.classList.add('hidden');
                headerTitle.textContent = `Input Nilai - Kelas ${className}`;
                gradeInputTitle.textContent = `Input Nilai - Kelas ${className}`;
                renderGradeTable(className);
            } else if (currentMode === 'absensi') {
                attendanceInputView.classList.remove('hidden');
                gradeInputView.classList.add('hidden');
                headerTitle.textContent = `Input Absensi - Kelas ${className}`;
                attendanceInputTitle.textContent = `Input Absensi - Kelas ${className}`;
                renderAttendanceTable(className);
            }
        }

        // Fungsi untuk kembali ke tampilan "Pilih Kelas"
        function showClassSelection(mode) {
            currentMode = mode;
            classSelectionView.classList.remove('hidden');
            gradeInputView.classList.add('hidden');
            attendanceInputView.classList.add('hidden');
            headerTitle.textContent = 'Pilih Kelas';
            if (currentMode === 'nilai') {
                classSelectionDesc.textContent = 'Silakan pilih kelas untuk menginput nilai.';
                linkNilai.classList.add('bg-indigo-50', 'text-indigo-600', 'font-semibold', 'rounded-r-lg', 'border-l-4', 'border-indigo-600');
                linkAbsensi.classList.remove('bg-indigo-50', 'text-indigo-600', 'font-semibold', 'rounded-r-lg', 'border-l-4', 'border-indigo-600');
                linkAbsensi.classList.add('text-gray-600');
            } else if (currentMode === 'absensi') {
                classSelectionDesc.textContent = 'Silakan pilih kelas untuk menginput absensi.';
                linkAbsensi.classList.add('bg-indigo-50', 'text-indigo-600', 'font-semibold', 'rounded-r-lg', 'border-l-4', 'border-indigo-600');
                linkNilai.classList.remove('bg-indigo-50', 'text-indigo-600', 'font-semibold', 'rounded-r-lg', 'border-l-4', 'border-indigo-600');
                linkNilai.classList.add('text-gray-600');
            }
        }

        // Fungsi untuk membuat baris tabel nilai
        function renderGradeTable(className) {
            const studentList = students[className] || [];
            gradeTableBody.innerHTML = studentList.map((student, index) => `
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap">${index + 1}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-900">${student}</td>
                    <td class="py-3 px-6"><input type="number" name="nilai_tugas[${index + 1}]" class="w-20 px-2 py-1 text-center rounded-lg border border-gray-300"></td>
                    <td class="py-3 px-6"><input type="number" name="nilai_uts[${index + 1}]" class="w-20 px-2 py-1 text-center rounded-lg border border-gray-300"></td>
                    <td class="py-3 px-6"><input type="number" name="nilai_uas[${index + 1}]" class="w-20 px-2 py-1 text-center rounded-lg border border-gray-300"></td>
                </tr>
            `).join('');
        }

        // Fungsi untuk membuat baris tabel absensi
        function renderAttendanceTable(className) {
            const studentList = students[className] || [];
            attendanceTableBody.innerHTML = studentList.map((student, index) => `
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap">${index + 1}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-900">${student}</td>
                    <td class="py-3 px-6">
                        <select name="keterangan[${index + 1}]" class="w-full px-2 py-1 rounded-lg border border-gray-300">
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                    </td>
                </tr>
            `).join('');
        }

        // Fungsi untuk mengaktifkan/menonaktifkan sidebar pada perangkat mobile
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Tambahkan event listener untuk tombol menu, overlay, dan tautan sidebar
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        linkNilai.addEventListener('click', () => {
            showClassSelection('nilai');
        });
        linkAbsensi.addEventListener('click', () => {
            showClassSelection('absensi');
        });

        // Inisialisasi tampilan awal
        showClassSelection('nilai');
        generateClassCards();
    </script>
</body>
</html>
