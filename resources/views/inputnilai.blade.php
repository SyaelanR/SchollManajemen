<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Siswa</title>
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
            background-color: #f3f4f6;
        }
        /* Custom scrollbar for better aesthetics */
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
        /* Sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>

    <div class="flex h-screen overflow-hidden bg-gray-50">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-2xl fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="p-6 border-b border-gray-100">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">EduSys</span>
                </a>
            </div>
             <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
                    <i class="fa-solid fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
             <a href="{{ route('inputnilai') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                    <i class="fa-solid fa-pen mr-3"></i>
                    <span>Input Nilai</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200 ">
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
            <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 id="main-header" class="text-xl md:text-2xl font-bold text-gray-800">Input Nilai</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <!-- Input Nilai Content Section -->
                <div id="input-nilai-content">
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <!-- Main Title -->
                        <div class="flex justify-between items-center mb-6">
                            <h3 id="main-title" class="text-2xl font-bold text-gray-800">Daftar Kelas</h3>
                            <button id="add-student-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-indigo-700 transition duration-300 hidden">
                                <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Siswa
                            </button>
                        </div>

                        <!-- Search Bar -->
                        <div id="class-search" class="mb-6">
                            <div class="relative">
                                <input id="search-input" type="text" placeholder="Cari nama kelas..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Class Cards Container -->
                        <div id="class-cards-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <!-- Cards will be populated dynamically via JavaScript -->
                        </div>

                        <!-- Grade Input Section -->
                        <div id="grade-input-section" class="hidden mt-8">
                            <div class="flex items-center justify-between mb-4">
                                <h4 id="class-grade-title" class="text-xl font-bold text-gray-800"></h4>
                                <button id="back-to-classes-btn" class="text-indigo-600 hover:text-indigo-800 font-semibold transition-colors duration-200">
                                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Kelas
                                </button>
                            </div>
                            <div id="student-table-container" class="border rounded-2xl overflow-hidden shadow-sm">
                                <!-- Student table will be populated dynamically via JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Modals -->
    <!-- Add/Edit Student Modal -->
    <div id="add-edit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[100]">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white transform transition-all duration-300 scale-95 opacity-0">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title"></h3>
                <div class="mt-2 px-7 py-3">
                    <form id="student-form">
                        <input type="hidden" id="form-mode" value="add">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="nis">
                                NIS
                            </label>
                            <input class="shadow appearance-none border rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nis" name="nis" type="text" placeholder="NIS Siswa" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="name">
                                Nama Siswa
                            </label>
                            <input class="shadow appearance-none border rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" placeholder="Nama Siswa" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="grade">
                                Nilai
                            </label>
                            <input class="shadow appearance-none border rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="grade" name="grade" type="number" placeholder="Nilai Siswa" min="0" max="100" required>
                        </div>
                        <input type="hidden" id="form-class-name">
                        <div class="items-center px-4 py-3 space-y-2">
                            <button id="submit-btn" type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-xl hover:bg-indigo-700 focus:outline-none focus:shadow-outline transition duration-200">
                                Simpan
                            </button>
                            <button type="button" id="close-modal-btn" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[100]">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white transform transition-all duration-300 scale-95 opacity-0">
            <div class="mt-3 text-center">
                <i class="fa-solid fa-trash-alt text-red-600 text-4xl mb-4 animate-bounce"></i>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Siswa</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus siswa ini? Aksi ini tidak dapat dibatalkan.</p>
                </div>
                <div class="items-center px-4 py-3 space-y-2">
                    <button id="confirm-delete-btn" class="w-full px-4 py-2 bg-red-600 text-white text-base font-medium rounded-xl shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                        Hapus
                    </button>
                    <button id="cancel-delete-btn" class="w-full px-4 py-2 bg-white text-base font-medium text-gray-700 rounded-xl border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar logic for mobile
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // =========================================================
        // Student Grade Management Logic
        // =========================================================

        const classesContainer = document.getElementById('class-cards-container');
        const gradeInputSection = document.getElementById('grade-input-section');
        const backToClassesBtn = document.getElementById('back-to-classes-btn');
        const mainTitle = document.getElementById('main-title');
        const classSearch = document.getElementById('class-search');
        const classGradeTitle = document.getElementById('class-grade-title');
        const studentTableContainer = document.getElementById('student-table-container');
        const addStudentBtn = document.getElementById('add-student-btn');
        const addEditModal = document.getElementById('add-edit-modal');
        const deleteModal = document.getElementById('delete-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
        const studentForm = document.getElementById('student-form');
        const modalTitle = document.getElementById('modal-title');
        const formMode = document.getElementById('form-mode');
        const nisInput = document.getElementById('nis');
        const nameInput = document.getElementById('name');
        const gradeInput = document.getElementById('grade');

        let studentsByClass = {};
        let currentClass = null;

        // Function to load data from localStorage or use dummy data
        function loadDataFromLocalStorage() {
            try {
                const storedData = localStorage.getItem('studentsByClass');
                if (storedData) {
                    studentsByClass = JSON.parse(storedData);
                } else {
                    // Dummy data if nothing is in localStorage
                    studentsByClass = {
                        '10A': { count: 6, students: [
                            { nis: 'S-10A001', name: 'Budi Santoso', grade: '90' },
                            { nis: 'S-10A002', name: 'Citra Dewi', grade: '85' },
                            { nis: 'S-10A003', name: 'Dani Pratama', grade: '92' },
                            { nis: 'S-10A004', name: 'Eka Wijaya', grade: '88' },
                            { nis: 'S-10A005', name: 'Fani Lestari', grade: '80' },
                            { nis: 'S-10A006', name: 'Gani Putra', grade: '95' }
                        ]},
                        '10B': { count: 6, students: [
                            { nis: 'S-10B001', name: 'Hanif Rahman', grade: '88' },
                            { nis: 'S-10B002', name: 'Indah Sari', grade: '91' },
                            { nis: 'S-10B003', name: 'Joko Susilo', grade: '84' },
                            { nis: 'S-10B004', name: 'Kartika Dewi', grade: '93' },
                            { nis: 'S-10B005', name: 'Lia Puspita', grade: '87' },
                            { nis: 'S-10B006', name: 'Mega Anggraini', grade: '90' }
                        ]},
                        '11A': { count: 6, students: [
                            { nis: 'S-11A001', name: 'Nina Wulandari', grade: '87' },
                            { nis: 'S-11A002', name: 'Oscar Maulana', grade: '91' },
                            { nis: 'S-11A003', name: 'Putri Ramadhani', grade: '89' },
                            { nis: 'S-11A004', name: 'Rizki Santoso', grade: '92' },
                            { nis: 'S-11A005', name: 'Siti Fatimah', grade: '85' },
                            { nis: 'S-11A006', name: 'Taufik Hidayat', grade: '94' }
                        ]},
                        '11B': { count: 5, students: [
                            { nis: 'S-11B001', name: 'Umar Faruq', grade: '93' },
                            { nis: 'S-11B002', name: 'Vina Pratiwi', grade: '84' },
                            { nis: 'S-11B003', name: 'Wawan Prasetyo', grade: '90' },
                            { nis: 'S-11B004', name: 'Yuni Lestari', grade: '86' },
                            { nis: 'S-11B005', name: 'Zainal Arifin', grade: '95' }
                        ]},
                        '12A': { count: 5, students: [
                            { nis: 'S-12A001', name: 'Agung Purnomo', grade: '86' },
                            { nis: 'S-12A002', name: 'Bambang Sudarsono', grade: '94' },
                            { nis: 'S-12A003', name: 'Cici Paramida', grade: '88' },
                            { nis: 'S-12A004', name: 'Dedy Corbuzier', grade: '91' },
                            { nis: 'S-12A005', name: 'Eko Patrio', grade: '83' }
                        ]},
                        '12B': { count: 6, students: [
                            { nis: 'S-12B001', name: 'Fina Octaviani', grade: '91' },
                            { nis: 'S-12B002', name: 'Gina Novitasari', grade: '83' },
                            { nis: 'S-12B003', name: 'Hadi Prasetyo', grade: '96' },
                            { nis: 'S-12B004', name: 'Ika Puspita', grade: '89' },
                            { nis: 'S-12B005', name: 'Jaya Kusuma', grade: '92' },
                            { nis: 'S-12B006', name: 'Kiki Ramdhani', grade: '87' }
                        ]}
                    };
                    saveDataToLocalStorage();
                }
            } catch (e) {
                console.error("Gagal memuat data dari localStorage.", e);
                studentsByClass = {};
            }
        }

        // Function to save data to localStorage
        function saveDataToLocalStorage() {
            localStorage.setItem('studentsByClass', JSON.stringify(studentsByClass));
        }

        // Function to render class cards
        function renderClassCards() {
            classesContainer.innerHTML = '';
            Object.keys(studentsByClass).forEach(className => {
                const classData = studentsByClass[className];
                const card = document.createElement('div');
                card.classList.add('bg-white', 'rounded-2xl', 'shadow-md', 'p-6', 'cursor-pointer', 'hover:bg-gray-50', 'transition', 'duration-200', 'transform', 'hover:scale-[1.02]', 'hover:shadow-lg');
                card.innerHTML = `
                    <div class="text-4xl text-indigo-500 mb-4">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800">Kelas ${className}</h4>
                    <p class="text-gray-500 mt-2">
                        <i class="fa-solid fa-users mr-2 text-sm"></i> ${classData.count} Siswa
                    </p>
                `;
                card.addEventListener('click', () => showGradeInput(className));
                classesContainer.appendChild(card);
            });
            classesContainer.classList.remove('hidden');
            gradeInputSection.classList.add('hidden');
            mainTitle.innerText = "Daftar Kelas";
            classSearch.classList.remove('hidden');
            addStudentBtn.classList.add('hidden');
        }

        // Function to show grade input table for a specific class
        function showGradeInput(className) {
            currentClass = className;
            classesContainer.classList.add('hidden');
            gradeInputSection.classList.remove('hidden');
            mainTitle.innerText = "Input Nilai Siswa";
            classSearch.classList.add('hidden');
            addStudentBtn.classList.remove('hidden');
            classGradeTitle.innerText = `Input Nilai Kelas ${className}`;

            const students = studentsByClass[className].students;
            let tableHtml = `
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
            `;

            students.forEach(student => {
                tableHtml += `
                    <tr data-nis="${student.nis}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${student.nis}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${student.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${student.grade}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button class="edit-btn text-indigo-600 hover:text-indigo-900 transition-colors duration-200">Edit</button>
                            <button class="delete-btn text-red-600 hover:text-red-900 transition-colors duration-200">Hapus</button>
                        </td>
                    </tr>
                `;
            });

            tableHtml += `
                        </tbody>
                    </table>
                </div>
            `;
            studentTableContainer.innerHTML = tableHtml;
        }

        // Add or Update a student
        function saveStudent(nis, name, grade) {
            let students = studentsByClass[currentClass].students;
            let studentFound = false;
            for (let i = 0; i < students.length; i++) {
                if (students[i].nis === nis) {
                    students[i].name = name;
                    students[i].grade = grade;
                    studentFound = true;
                    break;
                }
            }

            if (!studentFound) {
                // Add new student
                students.push({ nis, name, grade });
                studentsByClass[currentClass].count++;
            }
            saveDataToLocalStorage();
            showGradeInput(currentClass);
        }

        // Delete a student
        function deleteStudent(nis) {
            const index = studentsByClass[currentClass].students.findIndex(s => s.nis === nis);
            if (index > -1) {
                studentsByClass[currentClass].students.splice(index, 1);
                studentsByClass[currentClass].count--;
                saveDataToLocalStorage();
                showGradeInput(currentClass);
            }
        }

        // Open Add/Edit Modal for a new student
        addStudentBtn.addEventListener('click', () => {
            modalTitle.innerText = "Tambah Siswa Baru";
            formMode.value = 'add';
            nisInput.value = '';
            nisInput.readOnly = false;
            nameInput.value = '';
            gradeInput.value = '';
            showModal(addEditModal);
        });

        // Close Modal
        closeModalBtn.addEventListener('click', () => {
            hideModal(addEditModal);
        });
        
        // Handle form submission for Add/Edit
        studentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const nis = nisInput.value;
            const name = nameInput.value;
            const grade = gradeInput.value;
            const mode = formMode.value;

            if (mode === 'add') {
                const existingStudent = studentsByClass[currentClass].students.find(s => s.nis === nis);
                if (existingStudent) {
                    // Using a custom alert message as browser alerts are blocked
                    const modal = document.createElement('div');
                    modal.classList.add('fixed', 'inset-0', 'flex', 'items-center', 'justify-center', 'bg-gray-800', 'bg-opacity-50', 'z-[200]');
                    modal.innerHTML = `
                        <div class="bg-white p-6 rounded-lg shadow-xl text-center">
                            <h3 class="text-xl font-bold mb-4">NIS sudah ada!</h3>
                            <p class="mb-4">NIS ini sudah terdaftar. Mohon gunakan NIS lain.</p>
                            <button class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-xl hover:bg-indigo-700" onclick="this.closest('.fixed').remove()">OK</button>
                        </div>
                    `;
                    document.body.appendChild(modal);
                    return;
                }
            }
            saveStudent(nis, name, grade);
            hideModal(addEditModal);
        });

        // Event listener for the "back" button
        backToClassesBtn.addEventListener('click', renderClassCards);

        // Event delegation for table buttons (Edit and Delete)
        studentTableContainer.addEventListener('click', (e) => {
            const target = e.target;
            const row = target.closest('tr');
            if (!row) return;
            const nis = row.dataset.nis;

            if (target.classList.contains('edit-btn')) {
                // Find student data and populate modal
                const student = studentsByClass[currentClass].students.find(s => s.nis === nis);
                if (student) {
                    modalTitle.innerText = "Edit Siswa";
                    formMode.value = 'edit';
                    nisInput.value = student.nis;
                    nisInput.readOnly = true;
                    nameInput.value = student.name;
                    gradeInput.value = student.grade;
                    showModal(addEditModal);
                }
            } else if (target.classList.contains('delete-btn')) {
                showModal(deleteModal);
                confirmDeleteBtn.onclick = () => {
                    deleteStudent(nis);
                    hideModal(deleteModal);
                };
            }
        });

        // Close Delete Modal
        cancelDeleteBtn.addEventListener('click', () => {
            hideModal(deleteModal);
        });

        // Modal display functions
        function showModal(modalElement) {
            modalElement.classList.remove('hidden');
            setTimeout(() => {
                modalElement.querySelector('.relative').classList.remove('scale-95', 'opacity-0');
                modalElement.querySelector('.relative').classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function hideModal(modalElement) {
            modalElement.querySelector('.relative').classList.remove('scale-100', 'opacity-100');
            modalElement.querySelector('.relative').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modalElement.classList.add('hidden');
            }, 300);
        }
        
        // Initial render of class cards when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            loadDataFromLocalStorage();
            renderClassCards();
        });

        // Search functionality
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('keyup', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const classCards = document.querySelectorAll('#class-cards-container > div');
            classCards.forEach(card => {
                const className = card.querySelector('h4').innerText.toLowerCase();
                if (className.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
