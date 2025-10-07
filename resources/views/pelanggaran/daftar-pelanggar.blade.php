<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggaran Kelas {{ $kelas->nama_kelas ?? 'N/A' }} - EduSys</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Custom styles for a modern look */
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Custom scrollbar for a cleaner look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* gray-300 */
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* gray-400 */
        }
        /* Sidebar transition effect */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .modal {
            transition: opacity 0.3s ease-in-out;
        }
        .modal-content {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
            <div class="p-6 border-b border-gray-200">
                <a href="#" class="flex items-center space-x-3">
                    <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                    <span class="text-2xl font-bold text-gray-800">EduSys</span>
                </a>
            </div>
            <nav class="mt-6">
                <!-- Navigation links, using dynamic styling for active state -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-tachometer-alt mr-3 w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-user-graduate mr-3 w-5 h-5"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="{{ route('manajemenGuru') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-chalkboard-user mr-3 w-5 h-5"></i>
                    <span>Manajemen Guru</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-door-closed mr-3 w-5 h-5"></i>
                    <span>Manajemen Kelas</span>
                </a>
                <a href="{{ route('jadwal') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-calendar-alt mr-3 w-5 h-5"></i>
                    <span>Jadwal Pelajaran</span>
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                    <i class="fa-solid fa-triangle-exclamation mr-3 w-5 h-5"></i>
                    <span>Pelanggaran Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-money-bill-wave mr-3 w-5 h-5"></i>
                    <span>Keuangan</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                    <i class="fa-solid fa-layer-group mr-3 w-5 h-5"></i>
                    <span>Raport</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-lg w-full transition duration-200">
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
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <!-- Mobile Menu Button -->
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Pelanggaran Siswa</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-indigo-600 transition duration-200">
                        <i class="fa-solid fa-bell text-xl"></i>
                    </button>
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-500" src="https://placehold.co/100x100/667eea/ffffff?text=A" alt="User avatar">
                        <span class="absolute right-0 bottom-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 md:p-8 flex-1">
                <!-- Session Messages Handling -->
                @if(session('success'))
                    <div id="session-success" data-message="{{ session('success') }}" class="hidden"></div>
                @endif
                @if ($errors->any())
                    <div id="validation-errors" data-errors='@json($errors->all())' class="hidden"></div>
                @endif

                <div class="bg-white rounded-3xl shadow-xl p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Pelanggaran - Kelas {{ $kelas->nama_kelas ?? 'N/A' }}</h2>
                        <div class="flex items-center space-x-4 flex-wrap">
                            <!-- Tombol kembali yang diperbarui -->
                            <button onclick="window.history.back()" class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-full hover:bg-gray-300 transition duration-300 flex items-center">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                            </button>
                            <!-- Tombol "Tambah Pelanggaran" dengan gradien -->
                            <button id="add-violation-btn" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold py-2 px-6 rounded-full shadow-lg hover:from-indigo-600 hover:to-purple-700 transform hover:scale-105 transition duration-300 flex items-center">
                                <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Pelanggaran
                            </button>
                        </div>
                    </div>
                    
                    <!-- Search section -->
                    <div class="mb-6">
                        <input type="text" placeholder="Cari berdasarkan nama siswa..." class="w-full p-3 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200">
                    </div>

                    <!-- Violations table -->
                    <div class="overflow-x-auto rounded-xl shadow-lg">
                        <table class="min-w-full bg-white">
                            <thead class="bg-indigo-600 text-white">
                                <tr>
                                    <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Nama Siswa</th>
                                    <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Jenis Pelanggaran</th>
                                    <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Tanggal</th>
                                    <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Point</th>
                                    <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($pelanggarans ?? [] as $pelanggaran)
                                    <tr class="hover:bg-gray-50 transition duration-200">
                                        <td class="py-4 px-6 whitespace-nowrap font-medium">{{ $pelanggaran->siswa->name ?? 'Siswa Dihapus' }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap text-gray-600">{{ $pelanggaran->jenis_pelanggaran }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap text-gray-600">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap font-bold text-center text-red-600">{{ $pelanggaran->poin }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                <button class="text-indigo-600 hover:text-indigo-800 transform hover:scale-110 transition duration-200" title="Edit" onclick="showEditModal({{ json_encode($pelanggaran) }})">
                                                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-800 transform hover:scale-110 transition duration-200" title="Hapus" onclick="showDeleteModal({{ $pelanggaran->id_pelanggaran }})">
                                                    <i class="fa-solid fa-trash-alt text-lg"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-12">
                                            <i class="fa-solid fa-shield-halved text-5xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-600 font-semibold text-lg">Belum ada data pelanggaran untuk kelas ini.</p>
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
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        // Function to toggle sidebar for mobile
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        // Event listeners
        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Optional: Close sidebar on resize for desktop view
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
