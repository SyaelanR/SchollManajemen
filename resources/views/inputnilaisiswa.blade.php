<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai - EduSys</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-20px); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        .animate-fade-out { animation: fadeOut 0.5s ease-in forwards; }
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
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
        
                <a href="{{ route('inputtugas.index') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Input Nilai</span>
                </a>

                <a href="{{ route('absensi.daftar') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
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
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
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
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Input Nilai Siswa</h1>
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
            <div id="grade-input-page" class="w-full">
                <header class="mb-8 flex items-center justify-between">
                    <div>
                        <a href="{{ route('inputtugas.index') }}" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition duration-300 mb-4">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            <span class="font-semibold">Kembali</span>
                        </a>
                        <h1 class="text-4xl font-extrabold text-gray-900">Input Nilai Kelas IX-A</h1>
                        <p class="text-gray-500 mt-2 text-lg">Silakan input nilai untuk masing-masing siswa.</p>
                    </div>
                </header>

                <form id="nilai-form" class="bg-white p-6 rounded-2xl shadow-xl">
                    <table class="w-full table-auto border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2 text-left">Nama Siswa</th>
                                <th class="border px-4 py-2">NIS</th>
                                <th class="border px-4 py-2">Nilai</th>
                            </tr>
                        </thead>
                        <tbody id="student-table-body">
                            <!-- Student rows will be injected here by JavaScript -->
                        </tbody>
                    </table>
        
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Mock data
        const students = [
            { id: 1, nama: 'Budi Santoso', nis: '12345', nilai: 85 },
            { id: 2, nama: 'Citra Dewi', nis: '12346', nilai: 90 },
            { id: 3, nama: 'Dedi Kurniawan', nis: '12347', nilai: 78 },
            { id: 4, nama: 'Eka Lestari', nis: '12348', nilai: 92 },
            { id: 5, nama: 'Fajar Hidayat', nis: '12349', nilai: null }
        ];

        // DOM Elements
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const tableBody = document.getElementById('student-table-body');
        const nilaiForm = document.getElementById('nilai-form');

        // Functions
        const renderStudents = () => {
            if (students.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="text-center p-4 text-gray-500">Belum ada siswa di kelas ini.</td></tr>`;
                return;
            }
            let htmlContent = '';
            students.forEach((student, index) => {
                const nilaiValue = student.nilai !== null ? student.nilai : '';
                htmlContent += `
                    <tr class="text-center hover:bg-gray-50 transition-colors">
                        <td class="border px-4 py-2">${index + 1}</td>
                        <td class="border px-4 py-2 text-left">${student.nama}</td>
                        <td class="border px-4 py-2">${student.nis}</td>
                        <td class="border px-4 py-2">
                            <input type="number" name="nilai-${student.id}" value="${nilaiValue}" min="0" max="100" class="w-20 text-center px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </td>
                    </tr>
                `;
            });
            tableBody.innerHTML = htmlContent;
        };

        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Event Listeners
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        nilaiForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const nilaiData = {};
            const inputs = nilaiForm.querySelectorAll('input[type="number"]');

            inputs.forEach(input => {
                const studentId = input.name.split('-')[1];
                nilaiData[studentId] = input.value;
            });
            console.log("Nilai yang akan disimpan:", nilaiData);

            const messageBox = document.createElement('div');
            messageBox.className = "fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl animate-fade-in z-[200]";
            messageBox.textContent = "Nilai berhasil disimpan!";
            document.body.appendChild(messageBox);
            setTimeout(() => {
                messageBox.classList.add('animate-fade-out');
                messageBox.addEventListener('animationend', () => messageBox.remove());
            }, 3000);
        });

        // Initial render
        renderStudents();
    </script>
</body>
</html>
