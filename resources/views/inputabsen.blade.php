<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Absensi - EduSys</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #eef2ff; }
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236B7280'%3e%3cpath d='M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.5em;
        }
        select::-ms-expand { display: none; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .sidebar { transition: transform 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeOut { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(-20px); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        .animate-fade-out { animation: fadeOut 0.5s ease-in forwards; }
    </style>
</head>
<body class="flex min-h-screen">

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
            <a href="#" class="w-full text-left px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-100 transition duration-200 block">
                <i class="fa-solid fa-sign-out-alt mr-3"></i>Logout
            </a>
        </div>
    </aside>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-lg p-4 flex justify-between items-center sticky top-0 z-30">
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none"><i class="fa-solid fa-bars text-2xl"></i></button>
            <div class="flex items-center">
                <!-- Tombol kembali -->
                <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors mr-4">
                    <i class="fa-solid fa-arrow-left text-2xl"></i>
                </a>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Input Absensi Siswa</h1>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700"><i class="fa-solid fa-bell"></i></button>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover shadow-md" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                    <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <main class="p-6 md:p-8 flex-1">
            <div class="w-full">
                <header class="mb-8">
                    <h1 class="text-4xl font-extrabold text-gray-900">Input Absensi Kelas XI-A</h1>
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
                        <tbody>
                            <!-- Mock data to replace backend loop -->
                            <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3 text-left">Budi Santoso</td>
                                <td class="px-4 py-3">101</td>
                                <td class="px-4 py-3">
                                    <select name="status[101]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">2</td>
                                <td class="px-4 py-3 text-left">Siti Aminah</td>
                                <td class="px-4 py-3">102</td>
                                <td class="px-4 py-3">
                                    <select name="status[102]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                             <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">3</td>
                                <td class="px-4 py-3 text-left">Joko Susilo</td>
                                <td class="px-4 py-3">103</td>
                                <td class="px-4 py-3">
                                    <select name="status[103]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                             <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">4</td>
                                <td class="px-4 py-3 text-left">Dewi Lestari</td>
                                <td class="px-4 py-3">104</td>
                                <td class="px-4 py-3">
                                    <select name="status[104]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                             <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">5</td>
                                <td class="px-4 py-3 text-left">Agus Nugroho</td>
                                <td class="px-4 py-3">105</td>
                                <td class="px-4 py-3">
                                    <select name="status[105]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                             <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">6</td>
                                <td class="px-4 py-3 text-left">Faisal Ramadhan</td>
                                <td class="px-4 py-3">106</td>
                                <td class="px-4 py-3">
                                    <select name="status[106]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                             <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">7</td>
                                <td class="px-4 py-3 text-left">Putri Cahyani</td>
                                <td class="px-4 py-3">107</td>
                                <td class="px-4 py-3">
                                    <select name="status[107]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                             <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">8</td>
                                <td class="px-4 py-3 text-left">Ridwan Prasetyo</td>
                                <td class="px-4 py-3">108</td>
                                <td class="px-4 py-3">
                                    <select name="status[108]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                             <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">9</td>
                                <td class="px-4 py-3 text-left">Lina Wulandari</td>
                                <td class="px-4 py-3">109</td>
                                <td class="px-4 py-3">
                                    <select name="status[109]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                             <tr class="text-center hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">10</td>
                                <td class="px-4 py-3 text-left">Kevin Pratama</td>
                                <td class="px-4 py-3">110</td>
                                <td class="px-4 py-3">
                                    <select name="status[110]" class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="Hadir">Hadir</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alfa">Alfa</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-indigo-600 text-white font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-indigo-700 transform hover:scale-105 transition duration-300">Simpan Absensi</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center p-4 hidden z-50 animate-fade-in">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full text-center transform scale-95 transition-all duration-300 ease-out">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-check-circle text-green-500 text-3xl"></i>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Berhasil!</h2>
            <p class="text-gray-600 mb-6">Data absensi telah berhasil disimpan.</p>
            <button id="close-modal" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">Tutup</button>
        </div>
    </div>

    <script>
        // Sidebar toggle
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Handle form submission
        const attendanceForm = document.getElementById('attendance-form');
        const successModal = document.getElementById('success-modal');
        const closeModalButton = document.getElementById('close-modal');

        attendanceForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent default form submission

            // Here you would collect the data and perform an action
            const formData = new FormData(attendanceForm);
            const attendanceData = {};
            for (const [name, value] of formData.entries()) {
                // Example of how to parse the form data
                const nis = name.match(/\[(.*?)\]/)[1];
                attendanceData[nis] = value;
            }
            console.log("Data absensi yang dikumpulkan:", attendanceData);
            
            // Show the success modal
            successModal.classList.remove('hidden');
        });

        closeModalButton.addEventListener('click', () => {
            successModal.classList.add('hidden');
        });
    </script>
</body>
</html>
