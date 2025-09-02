<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggaran - Sistem Manajemen Sekolah</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Gaya khusus */
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
    <aside id="sidebar"
    class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="p-6">
        <a href="#" class="flex items-center space-x-3">
            <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
            <span class="text-2xl font-bold text-gray-800">EduSys</span>
        </a>
    </div>
        <nav class="mt-6">
            <a href="#" id="dashboard-link" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" id="students-link" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="#" id="teachers-link" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                <span>Manajemen Guru</span>
            </a>
            <a href="#" id="schedule-link" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                <span>Jadwal Pelajaran</span>
            </a>
            <a href="#" id="finance-link" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                <span>Keuangan</span>
            </a>
            <a href="#" id="violations-link" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 rounded-lg font-semibold">
                <i class="fa-solid fa-exclamation-triangle w-6 h-6 mr-3"></i>
                <span>Pelanggaran</span>
            </a>
            <a href="#" id="settings-link" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                <i class="fa-solid fa-cog w-6 h-6 mr-3"></i>
                <span>Pengaturan</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <a href="#" id="logout-link" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Overlay untuk seluler -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
            <!-- Tombol Menu Seluler -->
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 id="main-title" class="text-xl md:text-2xl font-semibold text-gray-800">Pelanggaran Perkelas</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover"
                            src="https://placehold.co/100x100/667eea/ffffff?text=A"
                            alt="Avatar Pengguna">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Isi Halaman -->
        <main class="p-6 md:p-8 flex-1">
            <!-- Bagian Daftar Kelas Pelanggaran (Tampilan Awal) -->
            <div id="violations-class-view" class="bg-white rounded-xl shadow-md p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 md:gap-0">
                    <h2 class="text-2xl font-semibold text-gray-800">Daftar Kelas</h2>
                </div>
                <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
                    <input type="text" id="class-search-input" placeholder="Cari nama kelas..."
                            class="w-full md:flex-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div id="class-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <!-- Kartu Kelas akan diisi oleh JavaScript -->
                </div>
            </div>

            <!-- Bagian Daftar Pelanggaran (Tersembunyi Awalnya) -->
            <div id="violations-list-view" class="bg-white rounded-xl shadow-md p-6 hidden">
                <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                    <h2 id="violations-title" class="text-2xl font-semibold text-gray-800"></h2>
                    <div class="flex items-center gap-4">
                        <button id="back-to-classes-btn" class="text-indigo-600 hover:underline flex items-center gap-2">
                            <i class="fa-solid fa-arrow-left text-sm"></i>
                            <span>Kembali</span>
                        </button>
                        <button id="add-violation-btn" class="bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                            <i class="fa-solid fa-plus-circle mr-2"></i>
                            Tambah Pelanggaran
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Jenis Pelanggaran</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Poin</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="violations-table-body" class="divide-y divide-gray-200">
                            <!-- Baris tabel akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bagian Manajemen Siswa (Tersembunyi Awalnya) -->
            <div id="students-view" class="bg-white rounded-xl shadow-md p-6 hidden">
                <!-- Header Halaman -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 md:gap-0">
                    <h2 class="text-2xl font-semibold text-gray-800">Daftar Siswa</h2>
                    <button class="bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                        <i class="fa-solid fa-plus-circle mr-2"></i>
                        Tambah Siswa Baru
                    </button>
                </div>

                <!-- Filter dan Pencarian -->
                <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
                    <input type="text" id="student-search-input" placeholder="Cari nama atau NIS siswa..."
                            class="w-full md:flex-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <select id="student-class-select" class="w-full md:w-auto p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Kelas</option>
                        <option value="10A">Kelas 10A</option>
                        <option value="10B">Kelas 10B</option>
                        <option value="11A">Kelas 11A</option>
                        <option value="11B">Kelas 11B</option>
                        <option value="12A">Kelas 12A</option>
                        <option value="12B">Kelas 12B</option>
                    </select>
                </div>

                <!-- Tabel Daftar Siswa -->
                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">NIS</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Jenis Kelamin</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Poin Pelanggaran</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="students-table-body" class="divide-y divide-gray-200">
                            <!-- Baris tabel akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Tambah Pelanggaran -->
<div id="add-violation-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-1/2 lg:w-1/3">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-semibold text-gray-800">Tambah Pelanggaran</h3>
            <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700 text-xl"><i class="fa-solid fa-times"></i></button>
        </div>
        <form id="add-violation-form">
            <div class="mb-4">
                <label for="violation-student" class="block text-gray-700 font-medium mb-2">Nama Siswa</label>
                <input type="text" id="violation-student" list="student-list" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                <datalist id="student-list">
                    <!-- Opsi akan diisi oleh JavaScript -->
                </datalist>
            </div>
            <div class="mb-4">
                <label for="violation-type" class="block text-gray-700 font-medium mb-2">Jenis Pelanggaran</label>
                <input type="text" id="violation-type" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="violation-date" class="block text-gray-700 font-medium mb-2">Tanggal</label>
                <input type="date" id="violation-date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="mb-6">
                <label for="violation-points" class="block text-gray-700 font-medium mb-2">Poin Pelanggaran</label>
                <select id="violation-points" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                    <!-- Opsi akan diisi oleh JavaScript -->
                </select>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" id="cancel-add-btn" class="bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-300">Batal</button>
                <button type="submit" class="bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Notifikasi -->
<div id="notification-message" class="fixed bottom-5 right-5 z-50 p-4 rounded-lg shadow-xl text-white bg-green-500 opacity-0 transition-opacity duration-300 hidden">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2 text-xl"></i>
        <span>Pelanggaran berhasil ditambahkan!</span>
    </div>
</div>

<script>
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainTitle = document.getElementById('main-title');
    const notificationMessage = document.getElementById('notification-message');

    // Tampilan (Views)
    const allViews = [
        document.getElementById('violations-class-view'),
        document.getElementById('violations-list-view'),
        document.getElementById('students-view')
    ];

    // Link Navigasi
    const studentsLink = document.getElementById('students-link');
    const violationsLink = document.getElementById('violations-link');
    const backToClassesBtn = document.getElementById('back-to-classes-btn');
    
    // Elemen modal
    const addViolationBtn = document.getElementById('add-violation-btn');
    const addViolationModal = document.getElementById('add-violation-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelAddBtn = document.getElementById('cancel-add-btn');
    const addViolationForm = document.getElementById('add-violation-form');
    const violationStudentInput = document.getElementById('violation-student');
    const studentList = document.getElementById('student-list');
    const violationPointsSelect = document.getElementById('violation-points');

    let currentClassName = '';

    // Data dummy
    const classData = [
        { name: 'Kelas 10A', violations: 12, data: [
            { student: 'Budi Santoso', type: 'Terlambat masuk', date: '10/08/2025', points: 10 },
            { student: 'Dewi Lestari', type: 'Menggunakan HP saat pelajaran', date: '07/08/2025', points: 20 },
            { student: 'Samsul Arifin', type: 'Membuat gaduh di kelas', date: '10/08/2025', points: 15 },
        ]},
        { name: 'Kelas 10B', violations: 8, data: [
            { student: 'Rizky Firmansyah', type: 'Merusak buku perpustakaan', date: '08/08/2025', points: 25 },
        ]},
        { name: 'Kelas 11A', violations: 25, data: [
            { student: 'Indah Puspita', type: 'Tidak memakai atribut sekolah', date: '09/08/2025', points: 5 },
            { student: 'Andi Pratama', type: 'Bolos sekolah', date: '11/08/2025', points: 50 },
            { student: 'Siti Rahayu', type: 'Tidak memakai seragam lengkap', date: '09/08/2025', points: 5 },
        ]},
        { name: 'Kelas 11B', violations: 15, data: [
            { student: 'Faisal Amir', type: 'Tidak mengerjakan tugas', date: '06/08/2025', points: 5 },
        ]},
        { name: 'Kelas 12A', violations: 18, data: [
            { student: 'Agus Maulana', type: 'Merusak fasilitas sekolah', date: '08/08/2025', points: 50 },
        ]},
        { name: 'Kelas 12B', violations: 22, data: [
            { student: 'Ayu Kartika', type: 'Terlambat masuk sekolah', date: '01/09/2025', points: 10 },
        ]},
    ];

    const studentData = [
        { nis: '1210101', name: 'Budi Santoso', class: '10A', gender: 'Laki-laki', points: 10 },
        { nis: '1210102', name: 'Dewi Lestari', class: '10A', gender: 'Perempuan', points: 20 },
        { nis: '1210103', name: 'Rizky Firmansyah', class: '10B', gender: 'Laki-laki', points: 25 },
        { nis: '1210104', name: 'Indah Puspita', class: '11A', gender: 'Perempuan', points: 5 },
        { nis: '1210105', name: 'Andi Pratama', class: '11A', gender: 'Laki-laki', points: 50 },
        { nis: '1210106', name: 'Samsul Arifin', class: '10A', gender: 'Laki-laki', points: 15 },
        { nis: '1210107', name: 'Siti Rahayu', class: '11A', gender: 'Perempuan', points: 5 },
        { nis: '1210108', name: 'Faisal Amir', class: '11B', gender: 'Laki-laki', points: 5 },
        { nis: '1210109', name: 'Agus Maulana', class: '12A', gender: 'Laki-laki', points: 50 },
        { nis: '1210110', name: 'Ayu Kartika', class: '12B', gender: 'Perempuan', points: 10 },
    ];

    // Fungsi untuk mengubah tampilan
    const showView = (viewToShow, title) => {
        allViews.forEach(view => {
            view.classList.add('hidden');
        });
        viewToShow.classList.remove('hidden');
        mainTitle.textContent = title;
        toggleActiveLink(viewToShow.id);
    };

    // Fungsi untuk mengaktifkan link di sidebar
    const toggleActiveLink = (viewId) => {
        const links = document.querySelectorAll('nav a');
        links.forEach(link => {
            link.classList.remove('bg-gray-200', 'font-semibold');
            link.classList.add('text-gray-600', 'hover:bg-gray-100', 'font-medium');
        });

        if (viewId === 'students-view') {
            studentsLink.classList.remove('text-gray-600', 'hover:bg-gray-100', 'font-medium');
            studentsLink.classList.add('bg-gray-200', 'font-semibold');
        } else if (viewId === 'violations-class-view' || viewId === 'violations-list-view') {
            violationsLink.classList.remove('text-gray-600', 'hover:bg-gray-100', 'font-medium');
            violationsLink.classList.add('bg-gray-200', 'font-semibold');
        }
    };

    // Fungsi untuk membuat kartu kelas
    const createClassCard = (classItem) => {
        const card = document.createElement('a');
        card.href = '#';
        card.className = 'block bg-gray-50 rounded-xl shadow-md p-6 relative hover:shadow-lg transition duration-300 cursor-pointer';
        card.setAttribute('data-class', classItem.name);
        card.innerHTML = `
            <div class="flex items-center mb-4">
                <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-school text-2xl"></i>
                </div>
            </div>
            <h3 class="text-xl font-semibold text-gray-800">${classItem.name}</h3>
            <div class="flex items-center text-gray-600 mt-4">
                <i class="fa-solid fa-user-xmark text-sm mr-2"></i>
                <span class="text-sm">${classItem.violations} Pelanggaran</span>
            </div>
        `;
        // Menambahkan event listener ke kartu
        card.addEventListener('click', (e) => {
            e.preventDefault();
            showViolations(classItem.name);
        });
        return card;
    };

    // Fungsi untuk menampilkan daftar pelanggaran
    const showViolations = (className) => {
        currentClassName = className;
        const selectedClass = classData.find(c => c.name === className);
        if (!selectedClass) return;

        showView(document.getElementById('violations-list-view'), `Pelanggaran ${className}`);
        document.getElementById('violations-title').textContent = `Pelanggaran ${className}`;

        const violationsTableBody = document.getElementById('violations-table-body');
        violationsTableBody.innerHTML = '';
        if (selectedClass.data.length > 0) {
            selectedClass.data.forEach(violation => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 transition duration-150';
                row.innerHTML = `
                    <td class="py-4 px-6 whitespace-nowrap text-gray-800">${violation.student}</td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-600">${violation.type}</td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-600">${violation.date}</td>
                    <td class="py-4 px-6 whitespace-nowrap font-semibold text-red-500">${violation.points}</td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-600">
                        <a href="#" class="delete-btn text-red-600 hover:text-red-800"><i class="fa-solid fa-trash-alt"></i></a>
                    </td>
                `;
                violationsTableBody.appendChild(row);
            });
        } else {
            const emptyRow = document.createElement('tr');
            emptyRow.innerHTML = `
                <td colspan="5" class="py-4 px-6 text-center text-gray-500">Tidak ada pelanggaran tercatat.</td>
            `;
            violationsTableBody.appendChild(emptyRow);
        }
    };

    // Fungsi untuk menampilkan daftar siswa
    const showStudentsList = () => {
        showView(document.getElementById('students-view'), 'Manajemen Siswa');
        const studentsTableBody = document.getElementById('students-table-body');
        studentsTableBody.innerHTML = '';
        studentData.forEach(student => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition duration-150';
            row.innerHTML = `
                <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-800">${student.nis}</td>
                <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900">${student.name}</td>
                <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-600">${student.class}</td>
                <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-600">${student.gender}</td>
                <td class="py-4 px-6 whitespace-nowrap text-sm font-semibold text-red-500">${student.points}</td>
                <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-600">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900 transition duration-150 mr-3">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <a href="#" class="text-red-600 hover:text-red-900 transition duration-150">
                        <i class="fa-solid fa-trash-alt"></i>
                    </a>
                </td>
            `;
            studentsTableBody.appendChild(row);
        });
    };
    
    // Fungsi untuk mengisi pilihan siswa di modal
    const populateStudentDatalist = (className) => {
        const studentsInClass = studentData.filter(student => student.class === className);
        studentList.innerHTML = '';
        studentsInClass.forEach(student => {
            const option = document.createElement('option');
            option.value = student.name;
            studentList.appendChild(option);
        });
    };

    // Fungsi untuk mengisi pilihan poin pelanggaran di modal
    const populatePointsDropdown = () => {
        violationPointsSelect.innerHTML = '<option value="" disabled selected>Pilih Poin</option>';
        for (let i = 5; i <= 100; i += 5) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            violationPointsSelect.appendChild(option);
        }
    };

    // Fungsi untuk menampilkan modal tambah pelanggaran
    const showAddViolationModal = () => {
        populateStudentDatalist(currentClassName);
        populatePointsDropdown();
        addViolationModal.classList.remove('hidden');
    };

    // Fungsi untuk menyembunyikan modal tambah pelanggaran
    const hideAddViolationModal = () => {
        addViolationModal.classList.add('hidden');
        addViolationForm.reset();
    };

    // Fungsi untuk menampilkan notifikasi
    const showNotification = (message) => {
        notificationMessage.textContent = message;
        notificationMessage.classList.remove('hidden', 'opacity-0');
        notificationMessage.classList.add('opacity-100');
        setTimeout(() => {
            notificationMessage.classList.remove('opacity-100');
            notificationMessage.classList.add('opacity-0');
            setTimeout(() => {
                notificationMessage.classList.add('hidden');
            }, 300);
        }, 3000);
    };

    // Fungsi untuk toggle sidebar di seluler
    const toggleSidebar = () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    };

    // Event listener untuk tombol menu seluler
    menuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Event listeners untuk navigasi
    studentsLink.addEventListener('click', (e) => {
        e.preventDefault();
        showStudentsList();
    });

    violationsLink.addEventListener('click', (e) => {
        e.preventDefault();
        showView(document.getElementById('violations-class-view'), 'Pelanggaran Perkelas');
    });

    backToClassesBtn.addEventListener('click', (e) => {
        e.preventDefault();
        showView(document.getElementById('violations-class-view'), 'Pelanggaran Perkelas');
    });
    
    // Event listener untuk tombol tambah pelanggaran
    addViolationBtn.addEventListener('click', showAddViolationModal);
    
    // Event listeners untuk menutup modal
    closeModalBtn.addEventListener('click', hideAddViolationModal);
    cancelAddBtn.addEventListener('click', hideAddViolationModal);
    
    // Event listener untuk submit formulir
    addViolationForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const selectedClass = classData.find(c => c.name === currentClassName);
        if (!selectedClass) return;

        const newViolation = {
            student: document.getElementById('violation-student').value,
            type: document.getElementById('violation-type').value,
            date: document.getElementById('violation-date').value,
            points: parseInt(violationPointsSelect.value, 10)
        };
        
        selectedClass.data.push(newViolation);
        selectedClass.violations++; // Perbarui total pelanggaran
        
        hideAddViolationModal();
        showViolations(currentClassName); // Perbarui tampilan tabel
        showNotification('Pelanggaran berhasil ditambahkan!');
    });

    // Event listener untuk class search
    const classSearchInput = document.getElementById('class-search-input');
    const classGrid = document.getElementById('class-grid');
    classSearchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const cards = classGrid.querySelectorAll('a');
        cards.forEach(card => {
            const className = card.getAttribute('data-class').toLowerCase();
            if (className.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Inisialisasi: Render kartu kelas dan tabel siswa saat halaman dimuat
    classData.forEach(classItem => {
        const card = createClassCard(classItem);
        classGrid.appendChild(card);
    });

    // Tampilkan tampilan awal (pelanggaran perkelas)
    showView(document.getElementById('violations-class-view'), 'Pelanggaran Perkelas');
</script>

</body>
</html>
