<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas - Sistem Manajemen Sekolah</title>
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
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .modal {
            transition: opacity 0.3s ease-in-out;
        }
        .custom-checkbox {
            appearance: none;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
            position: relative;
            transition: background-color 0.2s, border-color 0.2s;
        }
        .custom-checkbox:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        .custom-checkbox:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: white;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.75rem;
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
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Daftar Kelas</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Detail Kelas</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User Avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <!-- Action Bar -->
                    <div class="flex flex-col md:flex-row justify-between items-start mb-6 gap-4 border-b pb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Kelas: <span class="text-indigo-600">{{ $infoKelas->nama_kelas ?? 'Belum Ada' }}</span></h2>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-x-6 gap-y-2 mt-2 text-gray-600">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-user-tie mr-2 text-gray-400"></i>
                                    <span>Wali Kelas: <strong>{{$infoKelas->wali_kelas ?? 'Belum Dipilih'}}</strong></span>
                                </div>
                                <div class="flex items-center">
                                     <i class="fa-solid fa-calendar-days mr-2 text-gray-400"></i>
                                     <span>Tahun Ajaran: <strong>{{$infoKelas->angkatan->angkatan ?? 'Belum Dipilih'}}</strong></span>
                                </div>
                                <div class="flex items-center">
                                     <i class="fa-solid fa-users mr-2 text-gray-400"></i>
                                     <span>Total Siswa: <strong>{{$jumlahSiswa ?? '0'}}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 flex-shrink-0">
                             <a href="#" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center whitespace-nowrap">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            <button id="add-student-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap">
                                <i class="fa-solid fa-user-plus mr-2"></i>
                                Tambah Siswa
                            </button>
                        </div>
                    </div>

                     <!-- Search Bar -->
                    <div class="mb-4">
                         <div class="relative w-full md:w-1/2">
                            <input type="text" placeholder="Cari siswa di kelas ini..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Students Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[700px] text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-600">NISN</th>
                                    <th class="p-3 font-semibold text-gray-600">Nama Siswa</th>
                                    <th class="p-3 font-semibold text-gray-600">Jenis Kelamin</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse ($daftarSiswa ?? [] as $siswa)
                                <!-- Sample Row 1 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-700">{{$siswa->nisn_nik}}</td>
                                    <td class="p-3 text-gray-800 font-medium">{{$siswa->name}}</td>
                                    <td class="p-3 text-gray-700">{{$siswa->jenis_kelamin}}</td>
                                    <td class="p-3 text-center">
                                        <button class="text-red-500 hover:text-red-700" title="Keluarkan dari Kelas">
                                            <i class="fa-solid fa-user-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-gray-500">
                                        <div class="text-center py-12">
                                            <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-600 font-semibold text-lg">Belum ada data Siswa.</p>
                                            <p class="text-gray-500 mt-2">Silakan tambahkan Siswa</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Add Student Modal -->
    <div id="add-student-modal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden opacity-0">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-11/12 md:w-2/3 lg:w-1/2 transform transition-transform duration-300 scale-95">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Tambah Siswa ke Kelas <span class="text-indigo-600">{{ $infoKelas->nama_kelas ?? '-' }}</span></h3>
                <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <form action="{{ route('tambahSiswaKeKelas') }}" method="POST">
                @csrf
                <input type="hidden" name="id_kelas" value="{{ $id_kelas ?? '' }}">
                <div class="border rounded-lg max-h-64 overflow-y-auto">
                    <table class="w-full table-fixed">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600 text-left">NISN</th>
                                <th class="p-3 font-semibold text-gray-600 text-left">Nama Siswa</th>
                                <th class="p-3 w-16 text-center">
                                    <input type="checkbox" id="select-all" class="custom-checkbox">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($daftarSiswaBelumPunyaKelas ?? [] as $siswa)
                            <tr>
                                <td class="p-3 text-gray-700">{{ $siswa->nisn_nik }}</td>
                                <td class="p-3 truncate">{{ $siswa->name }}</td>
                                <td class="p-3 text-center"><input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" class="custom-checkbox student-checkbox"></td>
                           </tr>
                           @empty
                            <tr>
                                  <td colspan="3" class="p-3 text-center text-gray-500">
                                        <div class="text-center py-12">
                                         <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                         <p class="text-gray-600 font-semibold text-lg">Semua Siswa sudah memiliki kelas.</p>
                                        </div>
                                  </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" id="cancel-btn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // --- Sidebar Toggle Functionality ---
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        
        // --- Modal Functionality ---
        const addStudentModal = document.getElementById('add-student-modal');
        const modalContent = addStudentModal.querySelector('div');
        const addStudentBtn = document.getElementById('add-student-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        const openModal = () => {
            addStudentModal.classList.remove('hidden');
            setTimeout(() => {
                addStudentModal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        };

        const closeModal = () => {
            addStudentModal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                addStudentModal.classList.add('hidden');
            }, 300);
        };

        addStudentBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        addStudentModal.addEventListener('click', (event) => {
            if (event.target === addStudentModal) {
                closeModal();
            }
        });
        
        // --- Checkbox functionality ---
        const selectAllCheckbox = document.getElementById('select-all');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        
        selectAllCheckbox.addEventListener('change', (event) => {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });

    </script>

</body>
</html>