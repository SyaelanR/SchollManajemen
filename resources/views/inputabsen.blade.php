<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Absensi - EduSys</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #eef2ff; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>');
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1em;
            padding-right: 2.5rem;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeOut { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(-20px); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        .animate-fade-out { animation: fadeOut 0.5s ease-in forwards; }
    </style>
</head>
<body class="flex bg-gray-100 min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar w-64 bg-white shadow-2xl p-6 flex flex-col justify-between fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div>
            <a href="#" class="text-3xl font-bold text-indigo-600 mb-8 flex items-center space-x-2">
                <i class="fa-solid fa-school text-2xl"></i><span>EduSys</span>
            </a>
            <nav class="space-y-4 text-gray-700 font-medium">
                <a href="#" class="block px-4 py-3 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300"><i class="fa-solid fa-tachometer-alt mr-3"></i>Dashboard</a>
                <a href="#" class="block px-4 py-3 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300"><i class="fa-solid fa-pen mr-3"></i>Input Nilai</a>
                <a href="#" class="block px-4 py-3 rounded-xl bg-indigo-100 text-indigo-600 font-semibold border-l-4 border-indigo-600 transition-all duration-300"><i class="fa-solid fa-user-check mr-3"></i>Input Absensi</a>
                <a href="#" class="block px-4 py-3 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300"><i class="fa-solid fa-graduation-cap mr-3"></i>Manajemen Siswa</a>
            </nav>
        </div>
        <div class="mt-8">
            <button class="w-full text-left px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-100 transition duration-200"><i class="fa-solid fa-sign-out-alt mr-3"></i>Logout</button>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-lg p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none"><i class="fa-solid fa-bars text-2xl"></i></button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Input Absensi Siswa</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700"><i class="fa-solid fa-bell"></i></button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover shadow-md" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-1">
            <div class="w-full">
                <header class="mb-8">
                    <h1 class="text-4xl font-extrabold text-gray-900">Input Absensi Kelas IX-A</h1>
                    <p class="text-gray-500 mt-2 text-lg">Silakan tandai kehadiran untuk masing-masing siswa.</p>
                </header>

                <form id="attendance-form" class="bg-white p-6 rounded-2xl shadow-xl">
                    <table class="w-full table-auto rounded-xl overflow-hidden shadow-sm">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold border-b border-gray-300">No</th>
                                <th class="px-4 py-3 text-sm font-semibold border-b border-gray-300 text-left">Nama Siswa</th>
                                <th class="px-4 py-3 text-sm font-semibold border-b border-gray-300">NIS</th>
                                <th class="px-4 py-3 text-sm font-semibold border-b border-gray-300">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody id="student-table-body" class="divide-y divide-gray-200"></tbody>
                    </table>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-indigo-600 text-white font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-indigo-700 transform hover:scale-105 transition duration-300">Simpan Absensi</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Mock student data
        const students = [
            { id: 1, nama: 'Budi Santoso', nis: '12345' },
            { id: 2, nama: 'Citra Dewi', nis: '12346' },
            { id: 3, nama: 'Dedi Kurniawan', nis: '12347' },
            { id: 4, nama: 'Eka Lestari', nis: '12348' },
            { id: 5, nama: 'Fajar Hidayat', nis: '12349' }
        ];

        // DOM Elements
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const tableBody = document.getElementById('student-table-body');
        const attendanceForm = document.getElementById('attendance-form');

        // Render students
        const renderStudents = () => {
            if (students.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="text-center p-4 text-gray-500">Belum ada siswa di kelas ini.</td></tr>`;
                return;
            }
            tableBody.innerHTML = students.map((student, index) => `
                <tr class="text-center hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">${index + 1}</td>
                    <td class="px-4 py-3 text-left">${student.nama}</td>
                    <td class="px-4 py-3">${student.nis}</td>
                    <td class="px-4 py-3">
                        <select name="status-${student.id}" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                    </td>
                </tr>
            `).join('');
        };

        // Sidebar toggle
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Handle form submit
        attendanceForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const attendanceData = {};
            attendanceForm.querySelectorAll('select').forEach(select => {
                const studentId = select.name.split('-')[1];
                attendanceData[studentId] = select.value;
            });
            console.log("Data absensi:", attendanceData);

            // Show success message
            const msg = document.createElement('div');
            msg.className = "fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl animate-fade-in z-[200]";
            msg.textContent = "Absensi berhasil disimpan!";
            document.body.appendChild(msg);
            setTimeout(() => {
                msg.classList.add('animate-fade-out');
                msg.addEventListener('animationend', () => msg.remove());
            }, 3000);
        });

        // Initial render
        renderStudents();
    </script>
</body>
</html>
