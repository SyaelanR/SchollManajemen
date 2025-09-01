<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kelas 10B - Sistem Manajemen Sekolah</title>
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

        /* Table styles to ensure proper alignment */
        .table-row {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-cell {
            padding: 1rem 1.5rem;
            min-width: 0;
            flex-grow: 1;
        }

        .table-header .table-cell {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #4b5563;
        }

        .table-cell:nth-child(1) { flex-basis: 5%; }
        .table-cell:nth-child(2) { flex-basis: 15%; }
        .table-cell:nth-child(3) { flex-basis: 15%; }
        .table-cell:nth-child(4) { flex-basis: 25%; }
        .table-cell:nth-child(5) { flex-basis: 25%; }
        .table-cell:nth-child(6) { flex-basis: 15%; }

        .table-header {
            background-color: #e5e7eb;
            border-radius: 0.5rem 0.5rem 0 0;
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Jadwal Kelas 10A</h1>
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
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 md:gap-0">
                        <h2 class="text-2xl font-semibold text-gray-800">Jadwal Kelas</h2>
                        <div class="flex items-center space-x-4">
                            <button id="back-button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition duration-300">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                            </button>
                            <button id="add-schedule-btn" class="bg-indigo-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-300">
                                <i class="fa-solid fa-plus-circle mr-2"></i>Tambah Jadwal
                            </button>
                        </div>
                    </div>

                    <!-- Schedule Table -->
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-inner mb-8">
                        <div class="w-full text-sm text-left text-gray-500">
                            <!-- Table Header -->
                            <div class="table-row table-header rounded-t-lg">
                                <div class="table-cell">No</div>
                                <div class="table-cell">Hari</div>
                                <div class="table-cell">Jam</div>
                                <div class="table-cell"></div>
                                <div class="table-cell">Mata Pelajaran</div>
                                <div class="table-cell">Guru Pengajar</div>
                                <div class="table-cell"></div>
                                <div class="table-cell">Aksi</div>
                            </div>
                            <!-- Table Body -->
                            <div class="bg-white" id="schedule-table-body">
                                <!-- Jadwal akan dirender di sini oleh JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Add/Edit Schedule Modal -->
    <div id="schedule-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[100]">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 id="modal-title" class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Jadwal Baru</h3>
                <form id="schedule-form" class="space-y-4">
                    <input type="hidden" id="schedule-id">
                    <div>
                        <label for="modal-day" class="block text-sm font-medium text-gray-700 text-left">Hari</label>
                        <select id="modal-day" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>
                    <div>
                        <label for="modal-start-time" class="block text-sm font-medium text-gray-700 text-left">Jam Mulai</label>
                        <div class="flex space-x-2 mt-1">
                            <select id="modal-start-hour" class="block w-1/2 p-2 border border-gray-300 rounded-lg" required></select>
                            <select id="modal-start-minute" class="block w-1/2 p-2 border border-gray-300 rounded-lg" required></select>
                        </div>
                    </div>
                    <div>
                        <label for="modal-end-time" class="block text-sm font-medium text-gray-700 text-left">Jam Selesai</label>
                        <div class="flex space-x-2 mt-1">
                            <select id="modal-end-hour" class="block w-1/2 p-2 border border-gray-300 rounded-lg" required></select>
                            <select id="modal-end-minute" class="block w-1/2 p-2 border border-gray-300 rounded-lg" required></select>
                        </div>
                    </div>
                    <div>
                        <label for="modal-subject" class="block text-sm font-medium text-gray-700 text-left">Mata Pelajaran</label>
                        <select id="modal-subject" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div>
                        <label for="modal-teacher" class="block text-sm font-medium text-gray-700 text-left">Guru Pengajar</label>
                        <select id="modal-teacher" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" id="close-modal-btn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Data simulasi untuk dropdown
        const subjects = ["Matematika", "Bahasa Inggris", "Fisika", "Kimia", "Biologi", "Sejarah", "Sosiologi"];
        const teachers = ["Ibu Sri Handayani", "Bapak Rahmat Susanto", "Ibu Siti Nurhayati", "Bapak Budi Santoso", "Ibu Kartika Sari"];

        // Data simulasi jadwal
        let schedules = [
            { id: 1, day: "Senin", time: "08:00 - 09:30", subject: "Matematika", teacher: "Ibu Sri Handayani" },
            { id: 2, day: "Senin", time: "09:30 - 11:00", subject: "Bahasa Inggris", teacher: "Bapak Rahmat Susanto" },
        ];

        const scheduleTableBody = document.getElementById('schedule-table-body');
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const addScheduleBtn = document.getElementById('add-schedule-btn');
        const scheduleModal = document.getElementById('schedule-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const scheduleForm = document.getElementById('schedule-form');
        const modalTitle = document.getElementById('modal-title');
        const scheduleIdInput = document.getElementById('schedule-id');
        const modalDayInput = document.getElementById('modal-day');
        const modalStartHourInput = document.getElementById('modal-start-hour');
        const modalStartMinuteInput = document.getElementById('modal-start-minute');
        const modalEndHourInput = document.getElementById('modal-end-hour');
        const modalEndMinuteInput = document.getElementById('modal-end-minute');
        const modalSubjectInput = document.getElementById('modal-subject');
        const modalTeacherInput = document.getElementById('modal-teacher');
        const backButton = document.getElementById('back-button');

        // Fungsi untuk merender dropdown jam dan menit
        const renderTimeSelectors = () => {
            const createOptions = (start, end, step, format) => {
                let options = '';
                for (let i = start; i <= end; i += step) {
                    const value = i.toString().padStart(2, '0');
                    options += `<option value="${value}">${value}</option>`;
                }
                return options;
            };

            modalStartHourInput.innerHTML = createOptions(0, 23, 1);
            modalStartMinuteInput.innerHTML = createOptions(0, 59, 1);
            modalEndHourInput.innerHTML = createOptions(0, 23, 1);
            modalEndMinuteInput.innerHTML = createOptions(0, 59, 1);
        };
        
        // Fungsi untuk merender dropdown mata pelajaran dan guru
        const renderSubjectAndTeacherDropdowns = () => {
            modalSubjectInput.innerHTML = subjects.map(subject => `<option value="${subject}">${subject}</option>`).join('');
            modalTeacherInput.innerHTML = teachers.map(teacher => `<option value="${teacher}">${teacher}</option>`).join('');
        };

        // Fungsi untuk merender tabel
        const renderTable = () => {
            scheduleTableBody.innerHTML = '';
            schedules.forEach((schedule, index) => {
                const row = document.createElement('div');
                row.className = 'table-row hover:bg-gray-100';
                row.innerHTML = `
                    <div class="table-cell font-medium text-gray-900 whitespace-nowrap">${index + 1}</div>
                    <div class="table-cell">${schedule.day}</div>
                    <div class="table-cell">${schedule.time}</div>
                    <div class="table-cell">${schedule.subject}</div>
                    <div class="table-cell">${schedule.teacher}</div>
                    <div class="table-cell flex justify-center items-center">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-2 edit-btn" data-id="${schedule.id}">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900 delete-btn" data-id="${schedule.id}">
                            <i class="fa-solid fa-trash-alt"></i>
                        </button>
                    </div>
                `;
                scheduleTableBody.appendChild(row);
            });

            // Tambahkan event listener untuk tombol edit dan hapus setelah tabel dirender
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', handleEdit);
            });
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', handleDelete);
            });
        };

        // Fungsi untuk membuka modal tambah jadwal
        const openAddModal = () => {
            modalTitle.textContent = 'Tambah Jadwal Baru';
            scheduleIdInput.value = '';
            scheduleForm.reset();
            scheduleModal.classList.remove('hidden');
        };

        // Fungsi untuk membuka modal edit jadwal
        const handleEdit = (event) => {
            const id = parseInt(event.currentTarget.dataset.id);
            const scheduleToEdit = schedules.find(s => s.id === id);
            
            modalTitle.textContent = 'Edit Jadwal';
            scheduleIdInput.value = scheduleToEdit.id;
            modalDayInput.value = scheduleToEdit.day;

            // Memisahkan jam mulai dan selesai
            const [startTime, endTime] = scheduleToEdit.time.split(' - ');
            const [startHour, startMinute] = startTime.split(':');
            const [endHour, endMinute] = endTime.split(':');

            modalStartHourInput.value = startHour;
            modalStartMinuteInput.value = startMinute;
            modalEndHourInput.value = endHour;
            modalEndMinuteInput.value = endMinute;

            modalSubjectInput.value = scheduleToEdit.subject;
            modalTeacherInput.value = scheduleToEdit.teacher;
            
            scheduleModal.classList.remove('hidden');
        };

        // Fungsi untuk menghapus jadwal
        const handleDelete = (event) => {
            const id = parseInt(event.currentTarget.dataset.id);
            schedules = schedules.filter(s => s.id !== id);
            renderTable();
        };

        // Fungsi untuk menutup modal
        const closeModal = () => {
            scheduleModal.classList.add('hidden');
        };

        // Fungsi untuk menangani submit form
        const handleFormSubmit = (event) => {
            event.preventDefault();
            const id = scheduleIdInput.value ? parseInt(scheduleIdInput.value) : null;
            
            const startHour = modalStartHourInput.value;
            const startMinute = modalStartMinuteInput.value;
            const endHour = modalEndHourInput.value;
            const endMinute = modalEndMinuteInput.value;
            
            const timeString = `${startHour}:${startMinute} - ${endHour}:${endMinute}`;

            const newSchedule = {
                day: modalDayInput.value,
                time: timeString,
                subject: modalSubjectInput.value,
                teacher: modalTeacherInput.value,
            };

            if (id) {
                // Edit jadwal yang ada
                schedules = schedules.map(s => s.id === id ? { ...s, ...newSchedule } : s);
            } else {
                // Tambah jadwal baru
                newSchedule.id = schedules.length > 0 ? Math.max(...schedules.map(s => s.id)) + 1 : 1;
                schedules.push(newSchedule);
            }
            
            renderTable();
            closeModal();
            scheduleForm.reset();
        };
        
        // Fungsi untuk toggle sidebar
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Event Listeners
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        addScheduleBtn.addEventListener('click', openAddModal);
        closeModalBtn.addEventListener('click', closeModal);
        scheduleForm.addEventListener('submit', handleFormSubmit);
        
        // Event listener untuk tombol kembali
        backButton.addEventListener('click', () => {
            window.history.back();
        });

        // Render tabel dan dropdown saat halaman dimuat
        renderTimeSelectors();
        renderSubjectAndTeacherDropdowns();
        renderTable();
    </script>
</body>
</html>
