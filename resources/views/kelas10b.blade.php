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
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Guru</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-calendar-alt w-6 h-6 mr-3"></i>
                    <span>Jadwal Pelajaran</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-book w-6 h-6 mr-3"></i>
                    <span>Mata Pelajaran</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-money-bill-wave w-6 h-6 mr-3"></i>
                    <span>Keuangan</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-cog w-6 h-6 mr-3"></i>
                    <span>Pengaturan</span>
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Jadwal Pelajaran</h1>
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
                <!-- Main Title Block (unchanged) -->
                <div class="bg-indigo-600 rounded-xl shadow-lg p-8 mb-8 text-white flex flex-col md:flex-row items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Jadwal Pelajaran Kelas</h2>
                        <p class="text-indigo-200">Lihat dan kelola jadwal pelajaran untuk setiap kelas.</p>
                    </div>
                </div>
                
                <!-- Class Selection & Back Button -->
                <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between">
                    <div class="flex-1 mb-4 md:mb-0">
                        <label for="class-select" class="block text-gray-700 font-semibold mb-2">Pilih Kelas:</label>
                        <select id="class-select" class="w-full md:w-1/2 lg:w-1/3 p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200">
                            
                            <option value="10B">Kelas 10B</option>
                            
                        </select>
                    </div>
                    <button onclick="window.history.back()" class="flex items-center justify-center space-x-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition duration-200">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali</span>
                    </button>
                </div>

                <!-- Schedule Table Container - Revised to match the top block's design -->
                <div id="schedule-container" class="bg-indigo-50 p-8 rounded-xl shadow-lg text-gray-900">
                    <!-- Jadwal will be loaded here by JavaScript -->
                    <h3 id="schedule-title" class="text-xl font-semibold mb-4 text-indigo-800">Jadwal Kelas 10A</h3>
                    <div id="schedule-placeholder">
                        <div class="flex justify-center items-center h-48 text-indigo-400">
                           <i class="fa-solid fa-spinner fa-spin-pulse text-4xl"></i>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const classSelect = document.getElementById('class-select');
        const scheduleContainer = document.getElementById('schedule-container');
        const scheduleTitle = document.getElementById('schedule-title');
        const schedulePlaceholder = document.getElementById('schedule-placeholder');

        const daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Data jadwal dalam format yang mudah dikelola
        const schedules = {
            '10A': [
                { time: '07:30 - 08:30', subjects: ['Matematika', 'Bahasa Inggris', 'Fisika', 'Biologi', 'Pendidikan Agama'] },
                { time: '08:30 - 09:30', subjects: ['Bahasa Indonesia', 'Sejarah', 'Matematika', 'Kimia', 'Pendidikan Jasmani'] },
                { time: 'Istirahat', subjects: ['Istirahat', 'Istirahat', 'Istirahat', 'Istirahat', 'Istirahat'] },
                { time: '10:00 - 11:00', subjects: ['Biologi', 'Seni Budaya', 'Bahasa Indonesia', 'Matematika', 'Sosiologi'] },
                { time: '11:00 - 12:00', subjects: ['Kimia', 'Geografi', 'Bahasa Inggris', 'Sejarah', 'Bahasa Jerman'] },
            ],
            '10B': [
                { time: '07:30 - 08:30', subjects: ['Bahasa Inggris', 'Matematika', 'Biologi', 'Kimia', 'Pendidikan Jasmani'] },
                { time: '08:30 - 09:30', subjects: ['Fisika', 'Bahasa Indonesia', 'Sosiologi', 'Bahasa Inggris', 'Pendidikan Agama'] },
                { time: 'Istirahat', subjects: ['Istirahat', 'Istirahat', 'Istirahat', 'Istirahat', 'Istirahat'] },
                { time: '10:00 - 11:00', subjects: ['Geografi', 'Kimia', 'Sejarah', 'Fisika', 'Matematika'] },
                { time: '11:00 - 12:00', subjects: ['Bahasa Indonesia', 'Pendidikan Agama', 'Seni Budaya', 'Geografi', 'Bahasa Perancis'] },
            ],
            '11A': [
                { time: '07:30 - 08:30', subjects: ['Matematika Peminatan', 'Kimia', 'Fisika', 'Biologi', 'Pendidikan Agama'] },
                { time: '08:30 - 09:30', subjects: ['Bahasa Indonesia', 'Ekonomi', 'Sejarah', 'Fisika', 'Matematika Wajib'] },
                { time: 'Istirahat', subjects: ['Istirahat', 'Istirahat', 'Istirahat', 'Istirahat', 'Istirahat'] },
                { time: '10:00 - 11:00', subjects: ['Biologi', 'Sosiologi', 'Matematika Peminatan', 'Bahasa Inggris', 'Pendidikan Jasmani'] },
                { time: '11:00 - 12:00', subjects: ['Bahasa Inggris', 'Kimia', 'Bahasa Jerman', 'Seni Budaya', 'Bahasa Indonesia'] },
            ],
            '11B': [
                { time: '07:30 - 08:30', subjects: ['Fisika', 'Bahasa Inggris', 'Biologi', 'Matematika Wajib', 'Pendidikan Jasmani'] },
                { time: '08:30 - 09:30', subjects: ['Kimia', 'Ekonomi', 'Bahasa Indonesia', 'Biologi', 'Sejarah'] },
                { time: 'Istirahat', subjects: ['Istirahat', 'Istirahat', 'Istirahat', 'Istirahat', 'Istirahat'] },
                { time: '10:00 - 11:00', subjects: ['Matematika Wajib', 'Sejarah', 'Sosiologi', 'Kimia', 'Seni Budaya'] },
                { time: '11:00 - 12:00', subjects: ['Bahasa Indonesia', 'Fisika', 'Bahasa Inggris', 'Pendidikan Agama', 'Bahasa Spanyol'] },
            ],
            '12A': [
                { time: '07:30 - 08:30', subjects: ['Kimia', 'Biologi', 'Matematika Peminatan', 'Bahasa Inggris', 'Pendidikan Agama'] },
                { time: '08:30 - 09:30', subjects: ['Fisika', 'Matematika Wajib', 'Bahasa Indonesia', 'Kimia', 'Sejarah'] },
                { time: 'Istirahat', subjects: ['Istirahat', 'Istirahat', 'Istirahat', 'Istirahat', 'Istirahat'] },
                { time: '10:00 - 11:00', subjects: ['Bahasa Indonesia', 'Sosiologi', 'Ekonomi', 'Bahasa Inggris', 'Seni Budaya'] },
                { time: '11:00 - 12:00', subjects: ['Bahasa Inggris', 'Pendidikan Jasmani', 'Fisika', 'Kimia', 'Geografi'] },
            ],
            '12B': [
                { time: '07:30 - 08:30', subjects: ['Matematika Wajib', 'Bahasa Indonesia', 'Fisika', 'Biologi', 'Sejarah'] },
                { time: '08:30 - 09:30', subjects: ['Bahasa Inggris', 'Kimia', 'Pendidikan Agama', 'Matematika Wajib', 'Geografi'] },
                { time: 'Istirahat', subjects: ['Istirahat', 'Istirahat', 'Istirahat', 'Istirahat', 'Istirahat'] },
                { time: '10:00 - 11:00', subjects: ['Biologi', 'Fisika', 'Bahasa Inggris', 'Sosiologi', 'Ekonomi'] },
                { time: '11:00 - 12:00', subjects: ['Seni Budaya', 'Kimia', 'Bahasa Indonesia', 'Pendidikan Jasmani', 'Pendidikan Agama'] },
            ]
        };

        // Function untuk menghasilkan HTML jadwal yang responsif
        const generateScheduleHTML = (scheduleData) => {
            let desktopHTML = `
                <div class="hidden md:block">
                    <table class="min-w-full divide-y divide-indigo-200">
                        <thead class="bg-indigo-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">Waktu</th>
                                ${daysOfWeek.map(day => `<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-800 uppercase tracking-wider">${day}</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody class="bg-indigo-50 divide-y divide-indigo-200">
                            ${scheduleData.map(period => `
                                <tr class="${period.time === 'Istirahat' ? 'bg-indigo-100 font-semibold' : ''}">
                                    <td class="px-6 py-4 whitespace-nowrap ${period.time === 'Istirahat' ? 'text-center' : ''}">${period.time}</td>
                                    ${period.subjects.map(subject => `<td class="px-6 py-4 whitespace-nowrap">${subject}</td>`).join('')}
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;

            let mobileHTML = `
                <div class="md:hidden space-y-4">
                    ${daysOfWeek.map((day, dayIndex) => `
                        <div class="bg-white rounded-lg shadow p-4">
                            <h4 class="text-sm font-semibold text-indigo-800 mb-2">${day}</h4>
                            <ul class="divide-y divide-gray-200">
                                ${scheduleData.map(period => `
                                    <li class="py-2">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-500">${period.time}</span>
                                            <span class="text-gray-800 font-medium">${period.subjects[dayIndex]}</span>
                                        </div>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    `).join('')}
                </div>
            `;

            return desktopHTML + mobileHTML;
        };

        // Function to toggle sidebar
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Function to load the schedule based on selected class
        const loadSchedule = () => {
            const selectedClass = classSelect.value;
            scheduleTitle.textContent = `Jadwal Kelas ${selectedClass}`;
            const selectedScheduleData = schedules[selectedClass];
            if (selectedScheduleData) {
                schedulePlaceholder.innerHTML = generateScheduleHTML(selectedScheduleData);
            }
        };

        // Event listeners
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        classSelect.addEventListener('change', loadSchedule);

        // Initial load
        window.onload = loadSchedule;
    </script>

</body>
</html>
