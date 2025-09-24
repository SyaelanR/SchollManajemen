<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pelanggaran Siswa</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Gaya khusus untuk memastikan tampilan yang lebih baik */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        /* Bilah gulir khusus */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #e5e7eb;
        }
        ::-webkit-scrollbar-thumb {
            background: #9ca3af;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        /* Transisi bilah sisi */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        /* Ukuran layar besar, atur bilah sisi agar selalu terlihat */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0) !important;
            }
            .main-content {
                margin-left: 16rem;
            }
        }
        /* Style untuk modal */
        .modal {
            display: none;
        }
        .modal.active {
            display: flex;
        }
    </style>
</head>
<body class="bg-gray-100 antialiased">

    <!-- Konten Utama -->
    <div class="min-h-screen flex">
        <!-- Overlay untuk menu seluler -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-30 md:hidden hidden"></div>

        <!-- Bilah Sisi (Sidebar) -->
        <aside id="sidebar" class="transform -translate-x-full md:translate-x-0 fixed inset-y-0 left-0 w-64 bg-white shadow-lg p-6 flex flex-col justify-between z-40 transition-transform duration-300 ease-in-out">
            <div>
                <div class="flex items-center mb-10">
                    <img src="https://placehold.co/40x40/4f46e5/ffffff?text=S" alt="Logo Sekolah" class="h-10 w-10 rounded-full mr-3">
                    <h1 class="text-xl font-bold text-gray-800">Sekolahku</h1>
                </div>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                                <i class="fa-solid fa-home mr-3"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                                <i class="fa-solid fa-user-graduate mr-3"></i> Data Siswa
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                                <i class="fa-solid fa-chalkboard-user mr-3"></i> Data Guru
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggaran.index') }}" class="flex items-center p-3 text-white bg-blue-600 rounded-lg font-medium transition duration-300">
                                <i class="fa-solid fa-exclamation-triangle mr-3"></i> Pelanggaran
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                                <i class="fa-solid fa-bell mr-3"></i> Pengumuman
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-3 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition duration-300">
                                <i class="fa-solid fa-cog mr-3"></i> Pengaturan
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Bagian Bawah Bilah Sisi -->
            <div class="mt-6">
                <a href="#" class="flex items-center p-3 text-red-600 bg-red-100 hover:bg-red-200 rounded-lg font-medium transition duration-300">
                    <i class="fa-solid fa-sign-out-alt mr-3"></i> Keluar
                </a>
            </div>
        </aside>

        <!-- Konten Utama Halaman -->
        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out md:ml-64 p-6">
            <header class="flex items-center justify-between bg-white p-4 shadow-md rounded-lg mb-6">
                <div class="flex items-center space-x-4">
                    <button id="menu-button" class="md:hidden p-2 text-gray-600 hover:text-blue-600 transition duration-300 rounded-full">
                        <i class="fa-solid fa-bars fa-lg"></i>
                    </button>
                    <h2 class="text-2xl font-bold text-gray-800">Tabel Pelanggaran Siswa</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 hidden md:block">Halo, Admin!</span>
                    <img src="https://placehold.co/40x40/e5e7eb/4b5563?text=A" alt="Avatar Admin" class="h-10 w-10 rounded-full border-2 border-gray-200">
                </div>
            </header>

            <main class="space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <!-- Header Tabel -->
                    <div class="flex flex-col md:flex-row items-center justify-between mb-4 space-y-4 md:space-y-0">
                        <div class="relative w-full md:w-1/3">
                            <input type="text" id="searchInput" placeholder="Cari siswa atau pelanggaran..." class="w-full pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fa-solid fa-search text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                        </div>
                        <button id="addViolationButton" class="w-full md:w-auto bg-blue-600 text-white font-medium py-2 px-6 rounded-full hover:bg-blue-700 transition duration-300">
                            <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Pelanggaran
                        </button>
                    </div>

                    <!-- Tabel Pelanggaran -->
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Jenis Pelanggaran</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Poin</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody id="violationTableBody" class="divide-y divide-gray-200">
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Pelanggaran -->
    <div id="violationModal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 justify-center items-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 transform transition-all scale-95 duration-300">
            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Tambah Pelanggaran Baru</h3>
                <button id="closeModalButton" class="text-gray-400 hover:text-gray-600 transition duration-300">&times;</button>
            </div>
            <form id="violationForm" class="mt-4 space-y-4">
                <div>
                    <label for="studentName" class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                    <input type="text" id="studentName" name="studentName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label for="studentClass" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <input type="text" id="studentClass" name="studentClass" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label for="violationType" class="block text-sm font-medium text-gray-700">Jenis Pelanggaran</label>
                    <input type="text" id="violationType" name="violationType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label for="violationPoints" class="block text-sm font-medium text-gray-700">Poin Pelanggaran</label>
                    <input type="number" id="violationPoints" name="violationPoints" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-blue-600 text-white font-medium py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const searchInput = document.getElementById('searchInput');
        const violationTableBody = document.getElementById('violationTableBody');
        const addViolationButton = document.getElementById('addViolationButton');
        const violationModal = document.getElementById('violationModal');
        const closeModalButton = document.getElementById('closeModalButton');
        const violationForm = document.getElementById('violationForm');

        // Data dummy untuk tabel
        const violations = [
            { student: "Budi Santoso", class: "X-A", type: "Terlambat masuk sekolah", date: "10/08/2025", points: 10 },
            { student: "Siti Rahayu", class: "XI-B", type: "Tidak memakai seragam lengkap", date: "09/08/2025", points: 5 },
            { student: "Agus Maulana", class: "XII-C", type: "Merusak fasilitas sekolah", date: "08/08/2025", points: 50 },
            { student: "Dewi Lestari", class: "X-A", type: "Menggunakan HP saat pelajaran", date: "07/08/2025", points: 20 },
            { student: "Faisal Amir", class: "XI-D", type: "Tidak mengerjakan tugas", date: "06/08/2025", points: 5 },
        ];

        // Fungsi untuk merender tabel
        const renderTable = (data) => {
            violationTableBody.innerHTML = '';
            data.forEach((violation) => {
                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-50');
                row.innerHTML = `
                    <td class="py-4 px-6 whitespace-nowrap text-gray-800">${violation.student}</td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-600">${violation.class}</td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-600">${violation.type}</td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-600">${violation.date}</td>
                    <td class="py-4 px-6 whitespace-nowrap font-semibold text-red-500">${violation.points}</td>
                    <td class="py-4 px-6 whitespace-nowrap text-gray-600">
                        <button class="text-blue-600 hover:text-blue-800 mr-3"><i class="fa-solid fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-800"><i class="fa-solid fa-trash-alt"></i></button>
                    </td>
                `;
                violationTableBody.appendChild(row);
            });
        };

        // Render tabel saat pertama kali dimuat
        renderTable(violations);

        // Fungsi untuk mengaktifkan/menonaktifkan sidebar
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Event listener untuk tombol menu dan overlay
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Menutup sidebar jika pengguna menekan tombol escape
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                toggleSidebar();
            }
        });

        // Event listener untuk tombol Tambah Pelanggaran
        addViolationButton.addEventListener('click', () => {
            violationModal.classList.add('active');
        });

        // Event listener untuk tombol tutup modal
        closeModalButton.addEventListener('click', () => {
            violationModal.classList.remove('active');
            violationForm.reset();
        });

        // Event listener untuk pengiriman formulir
        violationForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const newViolation = {
                student: document.getElementById('studentName').value,
                class: document.getElementById('studentClass').value,
                type: document.getElementById('violationType').value,
                points: parseInt(document.getElementById('violationPoints').value, 10),
                date: new Date().toLocaleDateString('id-ID'), // Tanggal hari ini
            };
            violations.unshift(newViolation); // Tambahkan ke awal array
            renderTable(violations);
            violationModal.classList.remove('active');
            violationForm.reset();
        });

        // Fungsi untuk mencari data
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const filteredViolations = violations.filter(v =>
                v.student.toLowerCase().includes(searchTerm) ||
                v.class.toLowerCase().includes(searchTerm) ||
                v.type.toLowerCase().includes(searchTerm)
            );
            renderTable(filteredViolations);
        });
    </script>

</body>
</html>
