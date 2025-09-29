<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Guru - Sistem Manajemen Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 for notifications and delete confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom styles */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for better aesthetics */
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
        /* Sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <aside id="sidebar" class="sidebar bg-white w-64 min-h-screen flex-shrink-0 shadow-lg fixed lg:relative z-50 transform -translate-x-full lg:translate-x-0">
        <div class="p-6">
            <a href="#" class="flex items-center space-x-3">
                <i class="fa-solid fa-school text-3xl text-indigo-600"></i>
                <span class="text-2xl font-bold text-gray-800">EduSys</span>
            </a>
        </div>
        <nav class="mt-6">
             <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-tachometer-alt w-6 h-6 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('manajemenAngkatan') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-layer-group w-6 h-6 mr-3"></i>
                <span>Manajemen Angkatan</span>
            </a>
            <a href="{{ route('manajemenSiswa') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200">
                <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                <span>Manajemen Siswa</span>
            </a>
            <a href="{{ route('manajemenGuru') }}" class="flex items-center px-6 py-3 bg-indigo-50 text-indigo-600 font-semibold rounded-r-lg border-l-4 border-indigo-600 transition duration-200">
                <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                <span>Manajemen Guru</span>
            </a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg w-full">
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
            <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Manajemen Data Guru</h1>
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
             <header class="mb-8 bg-indigo-600 p-8 rounded-2xl shadow-lg text-white">
                <h2 class="text-3xl font-bold mb-2">Manajemen Guru</h2>
                <p class="text-indigo-200">Kelola semua data guru dan staf yang terdaftar di sekolah.</p>
            </header>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Guru</h2>
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="relative w-full md:w-64">
                            <input type="text" placeholder="Cari guru..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button onclick="window.location.href = '{{ route('tambahGuru')}}';" id="add-guru-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap shadow-md hover:shadow-lg">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Tambah Guru
                        </button>
                    </div>
                </div>

                <!-- Session Messages Handling -->
                @if(session('success'))
                    <div id="session-success" data-message="{{ session('success') }}" class="hidden"></div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px] text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Nama</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Alamat</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">No Telp</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm">Jabatan</th>
                                <th class="p-3 font-semibold text-gray-600 uppercase text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                        @forelse ($teachers as $teacher)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-gray-800 font-medium">{{ $teacher->name }}</td>
                                <td class="p-3 text-gray-700">{{ $teacher->alamat ?? '-' }}</td>
                                <td class="p-3 text-gray-700">{{ $teacher->no_telp ?? '-' }}</td>
                                <td class="p-3 text-gray-700 capitalize">{{ $teacher->role }}</td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ route('editGuru', $teacher->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('hapusGuru', $teacher->id) }}" method="POST" class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">
                                    <div class="text-center py-12">
                                        <i class="fa-solid fa-chalkboard-user text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada data Guru/Staf.</p>
                                        <p class="text-gray-500 mt-2">Silakan tambahkan data baru.</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };

        menuButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // --- SweetAlert2 Notifications for Success ---
        const successMessage = document.getElementById('session-success');
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage.dataset.message,
                timer: 2500,
                showConfirmButton: false
            });
        }

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data guru yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    });
</script>

</body>
</html>