<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa - Sistem Manajemen Sekolah</title>
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
        /* Custom select colors */
        .select-status {
            transition: background-color 0.3s, color 0.3s;
        }
        .status-hadir {
            background-color: #dcfce7; /* green-100 */
            color: #166534; /* green-800 */
            border-color: #86efac; /* green-300 */
        }
         .status-izin {
            background-color: #fefce8; /* yellow-100 */
            color: #854d0e; /* yellow-800 */
            border-color: #fde047; /* yellow-300 */
        }
         .status-sakit {
            background-color: #e0f2fe; /* sky-100 */
            color: #075985; /* sky-800 */
            border-color: #7dd3fc; /* sky-300 */
        }
         .status-alfa {
            background-color: #fee2e2; /* red-100 */
            color: #991b1b; /* red-800 */
            border-color: #fca5a5; /* red-300 */
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
                    <i class="fa-solid fa-calendar-check w-6 h-6 mr-3"></i>
                    <span>Input Absen</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-star w-6 h-6 mr-3"></i>
                    <span>Input Nilai</span>
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
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Absensi Siswa</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/667eea/ffffff?text=G" alt="User Avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8 flex-1">
                <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                    <!-- Action Bar -->
                    <form action="{{ route('storeAbsensiSiswa')}}" method="POST">
                        @csrf
                        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Absensi Kelas: <span class="text-indigo-600">{{$infoKelas->kelas->nama_kelas ?? 'N/A'}} - Matematika</span></h2>
                                <p class="text-gray-500 mt-2"><i class="fa-solid fa-calendar-day mr-2"></i>Tanggal: 10 September 2025</p>
                            </div>
                            <a href="#" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center whitespace-nowrap">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                        </div>
                        
                        <div class="flex justify-end mb-4">
                            <button type="button" id="hadir-semua-btn" class="bg-green-100 text-green-700 font-semibold py-2 px-4 rounded-lg hover:bg-green-200 transition duration-300 flex items-center text-sm">
                                <i class="fa-solid fa-users-viewfinder mr-2"></i>
                                Hadir Semua
                            </button>
                        </div>

                        <!-- Students Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[700px] text-left">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-3 font-semibold text-gray-600">NISN</th>
                                        <th class="p-3 font-semibold text-gray-600">Nama Siswa</th>
                                        <th class="p-3 font-semibold text-gray-600">Jenis Kelamin</th>
                                        <th class="p-3 font-semibold text-gray-600 w-48">Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    <!-- Sample Row 1 -->
                                    @forelse ($daftarSiswa ?? [] as $siswa)
                                    @if ($siswa->status == null)                              
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 text-gray-700">{{$siswa->siswa->nisn_nik}}</td>
                                        <td class="p-3 text-gray-800 font-medium">{{$siswa->siswa->name}}</td>
                                        <td class="p-3 text-gray-700">{{$siswa->siswa->jenis_kelamin}}</td>
                                        <td class="p-3">
                                            <select name='status[{{$siswa->id_daftar_absensi_siswa}}]' id='status_{{$siswa->id_daftar_absensi_siswa}}' class="select-status status-hadir w-full p-2 border rounded-lg font-semibold">
                                                <option value=""></option>
                                                <option value="Hadir" class="text-green-800 font-medium">Hadir</option>
                                                <option value="Izin" class="text-yellow-800 font-medium">Izin</option>
                                                <option value="Sakit" class="text-sky-800 font-medium">Sakit</option>
                                                <option value="Alpha" class="text-red-800 font-medium">Alpha</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @endif
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-3 text-center text-gray-500">
                                                <div class="text-center py-12">
                                                    <i class="fa-solid fa-folder-open text-5xl text-gray-400 mb-4"></i>
                                                    <p class="text-gray-600 font-semibold text-lg">Tidak ada daftar siswa.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex justify-end items-center mt-6 border-t pt-6">
                            <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center">
                                <i class="fa-solid fa-save mr-2"></i>
                                Simpan Absensi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Already Absen Table -->
                 <div class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Siswa Sudah Diabsen</h2>
                     <div class="overflow-x-auto">
                        <table class="w-full min-w-[700px] text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-600">NISN</th>
                                    <th class="p-3 font-semibold text-gray-600">Nama Siswa</th>
                                    <th class="p-3 font-semibold text-gray-600">Jenis Kelamin</th>
                                    <th class="p-3 font-semibold text-gray-600">Status Kehadiran</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <!-- Sample Row 1 -->
                                @forelse (($daftarSiswa ?? []) as $siswa)
                                @if ($siswa->status != null)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-gray-700">{{$siswa->siswa->nisn_nik}}</td>
                                    <td class="p-3 text-gray-800 font-medium">{{$siswa->siswa->name}}</td>
                                    <td class="p-3 text-gray-700">{{$siswa->siswa->jenis_kelamin}}</td>
                                    <td class="p-3">
                                        @if ($siswa->status == 'Hadir')
                                        <span class="bg-green-100 text-green-800 font-medium py-1 px-3 rounded-full text-xs">Hadir</span>
                                        @elseif ($siswa->status == 'Izin')
                                        <span class="bg-green-100 text-yellow-800 font-medium py-1 px-3 rounded-full text-xs">Izin</span>
                                        @elseif ($siswa->status == 'Sakit')
                                        <span class="bg-green-100 text-sky-800 font-medium py-1 px-3 rounded-full text-xs">Sakit</span>
                                        @elseif ($siswa->status == 'Alpha')
                                        <span class="bg-green-100 text-red-800 font-medium py-1 px-3 rounded-full text-xs">Alpha</span>
                                        @endif
                                        
                                    </td>
                                    <td class="p-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800" title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                    </td>
                                </tr>
                                @endif
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-3 text-center text-gray-500">
                                            <div class="text-center py-12">
                                                <i class="fa-solid fa-folder-open text-5xl text-gray-400 mb-4"></i>
                                                <p class="text-gray-600 font-semibold text-lg">Tidak ada daftar siswa.</p>
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
        
        // --- Attendance Functionality ---
        const statusSelects = document.querySelectorAll('.select-status');
        const hadirSemuaBtn = document.getElementById('hadir-semua-btn');
        
        const statusColors = {
            hadir: 'status-hadir',
            Izin: 'status-izin',
            Sakit: 'status-sakit',
            Alpha: 'status-alfa'
        };

        function updateSelectColor(selectElement) {
            // Remove all status color classes
            Object.values(statusColors).forEach(className => {
                selectElement.classList.remove(className);
            });
            // Add the correct class based on the selected value
            const selectedStatus = selectElement.value;
            if (selectedStatus === 'Hadir') {
                selectElement.classList.add(statusColors.hadir);
            } else {
                selectElement.classList.add(statusColors[selectedStatus]);
            }
        }

        statusSelects.forEach(select => {
            select.addEventListener('change', (event) => {
                updateSelectColor(event.target);
            });
            // Initial color update on page load
            updateSelectColor(select);
        });
        
        hadirSemuaBtn.addEventListener('click', () => {
            statusSelects.forEach(select => {
                select.value = 'Hadir';
                updateSelectColor(select);
            });
        });

    </script>

</body>
</html>
