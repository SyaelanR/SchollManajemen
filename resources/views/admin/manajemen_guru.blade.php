<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <!-- Viewport Meta Tag untuk Desain Responsif -->
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
        /* Modal transition */
        .modal {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">
        <!-- 
            Sidebar Responsif:
            - 'transform -translate-x-full': Menyembunyikan sidebar di luar layar secara default (untuk mobile).
            - 'lg:translate-x-0': Menampilkan sidebar kembali di layar besar (large screens) dan di atasnya.
        -->
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
                <a href="manajemen_angkatan.html" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-layer-group w-6 h-6 mr-3"></i>
                    <span>Manajemen Angkatan</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold">
                    <i class="fa-solid fa-user-graduate w-6 h-6 mr-3"></i>
                    <span>Manajemen Siswa</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fa-solid fa-chalkboard-user w-6 h-6 mr-3"></i>
                    <span>Manajemen Guru</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 hover:font-semibold rounded-lg">
                    <i class="fa-solid fa-sign-out-alt w-6 h-6 mr-3"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Overlay for mobile. Tampil saat sidebar terbuka di layar kecil. -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <!-- 
                    Tombol Menu Mobile:
                    - 'lg:hidden': Tombol ini hanya akan muncul di layar kecil (di bawah large).
                -->
                <button id="menu-button" class="lg:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
                <!-- Ukuran Teks Judul Responsif: 'text-xl md:text-2xl' -->
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

            <!-- 
                Padding Konten Responsif:
                - 'p-6': Padding default untuk layar kecil.
                - 'md:p-8': Padding lebih besar untuk layar medium dan di atasnya.
            -->
            <main class="p-6 md:p-8 flex-1">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <!-- 
                        Action Bar Responsif:
                        - 'flex-col': Elemen akan bertumpuk vertikal di layar kecil (mobile-first).
                        - 'md:flex-row': Elemen akan berjajar horizontal di layar medium dan di atasnya.
                    -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Guru</h2>
                        <!-- Grup tombol dan search yang responsif -->
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <!-- Input search dengan lebar responsif: 'w-full md:w-64' -->
                            <div class="relative w-full md:w-64">
                                <input type="text" placeholder="Cari guru..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <button onclick="window.location.href = '{{ route('tambahGuru')}}';" id="add-guru-btn" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center whitespace-nowrap">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Tambah Guru
                            </button>
                        </div>
                    </div>

                    <!-- 
                        Tabel Responsif:
                        - 'overflow-x-auto': Membuat tabel bisa di-scroll secara horizontal di layar kecil jika kontennya terlalu lebar.
                        - 'min-w-[800px]': Menetapkan lebar minimum tabel untuk mencegah kolom menjadi terlalu sempit.
                    -->
                    <div class="overflow-x-auto">
                {{-- Menampilkan pesan sukses dari session --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 rounded-md" role="alert">
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                        <table class="w-full min-w-[800px] text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-600">Nama</th>
                                    <th class="p-3 font-semibold text-gray-600">Alamat</th>
                                    <th class="p-3 font-semibold text-gray-600">No Telp</th>
                                    <th class="p-3 font-semibold text-gray-600">Jabatan</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Aksi</th>
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
                                    <div class="flex justify-center space-x-3">
                                        <a href="{{ route('editGuru', $teacher->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        {{-- Form hapus sekarang mengarah ke rute yang benar --}}
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
                                        <i class="fa-solid fa-exclamation-circle text-5xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 font-semibold text-lg">Belum ada data Guru/Staf.</p>
                                        <p class="text-gray-500 mt-2">Silakan tambahkan data baru</p>
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

    {{-- Modal tidak lagi diperlukan di halaman ini karena kita redirect ke halaman edit --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // --- Functionality for DELETE Confirmation ---
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent direct submission
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data guru yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
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
